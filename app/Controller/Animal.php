<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Files;
use Core\Library\Raw;
use Core\Library\Redirect;
use Core\Library\Session;

class Animal extends ControllerMain
{
    private const PASTA_FOTOS = 'uploads/animais';

    /**
     * Admin global (super/admin) enxerga e gerencia todos os animais.
     */
    private function ehAdmin(): bool
    {
        return (int) Session::get('userNivel') <= NIVEL_ADMIN;
    }

    /**
     * ID da ONG vinculada ao login atual (0 se não for uma ONG).
     */
    private function ongIdSessao(): int
    {
        return (int) (Session::get('userOngId') ?: 0);
    }

    /**
     * Garante que o animal pertence à ONG logada (admin sempre passa).
     * Redireciona e devolve null quando o acesso é negado.
     */
    private function garanteAcessoAnimal(int $id): ?array
    {
        $animal = $this->model->getById($id);

        if (empty($animal)) {
            Redirect::page($this->controller, ['msgError' => 'Animal não encontrado.']);
            return null;
        }

        if (!$this->ehAdmin() && (int) $animal['ong_id'] !== $this->ongIdSessao()) {
            Redirect::page($this->controller, ['msgError' => 'Você só pode gerenciar os animais da sua ONG.']);
            return null;
        }

        return $animal;
    }

    public function index()
    {
        // ONG (15) e admin passam; usuário comum (21) é bloqueado.
        $this->validaNivelAcesso(NIVEL_ONG);

        $lista = $this->ehAdmin()
            ? $this->model->listaAdmin()
            : $this->model->listaAdmin($this->ongIdSessao());

        return $this->view('admin/listaAnimal', [
            'titulo'  => $this->model->titulo,
            'lista'   => $lista,
            'aStatus' => $this->model->listaStatus,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesCadastroAnimal.css">'),
        ]);
    }

    public function form($action, $id = 0)
    {
        if ($action === 'delete') {
            $this->validaNivelAcesso(NIVEL_ONG);

            if (((int) $id) > 0 && $this->garanteAcessoAnimal((int) $id) === null) {
                return;
            }

            return $this->view('admin/formAnimal', [
                'titulo'  => $this->model->titulo,
                'data'    => $this->model->getById((int) $id),
                'action'  => 'delete',
                'aStatus' => $this->model->listaStatus,
            ]);
        }

        $this->validaNivelAcesso(NIVEL_ONG);

        // Em edição, garante que a ONG só abra os próprios animais
        if (((int) $id) > 0 && $this->garanteAcessoAnimal((int) $id) === null) {
            return;
        }

        $modelOng  = $this->loadModel('Ong');
        $modelFoto = $this->loadModel('AnimalFoto');

        // Admin escolhe qualquer ONG; ONG fica restrita à própria.
        $aOngs = $this->ehAdmin()
            ? $modelOng->lista()
            : array_filter([$modelOng->getById($this->ongIdSessao())]);

        return $this->view('animal/form', [
            'titulo'    => $this->model->titulo,
            'data'      => $this->model->getById((int) $id),
            'aStatus'   => $this->model->listaStatus,
            'action'    => $this->action,
            'aOngs'     => $aOngs,
            'aFotos'    => $id > 0 ? $modelFoto->listaPorAnimal((int) $id) : [],
            'animal_id' => (int) $id,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesCadastroAnimal.css">'),
        ]);
    }

    public function insert()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->normalizaPost($this->request->getPost());

        if (!$this->ehAdmin()) {
            $post['ong_id'] = $this->ongIdSessao();
        }

        $post['statusRegistro'] = 1;

        $animal_id = $this->model->insertGetId($post);

        if ($animal_id <= 0) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Falha ao cadastrar animal.']
            );
        }

        $this->processarFotos($animal_id);

        return Redirect::page(
            $this->controller . '/form/update/' . $animal_id,
            ['msgSucesso' => 'Animal cadastrado com sucesso.']
        );
    }

    public function update()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->normalizaPost($this->request->getPost());
        $id   = (int) ($post[$this->model->primaryKey] ?? 0);

        if ($this->garanteAcessoAnimal($id) === null) {
            return;
        }

        // ONG não pode remanejar o animal para outra ONG.
        if (!$this->ehAdmin()) {
            $post['ong_id'] = $this->ongIdSessao();
        }

        if (!$this->model->update($post)) {
            return Redirect::page(
                $this->controller . '/form/update/' . $id,
                ['msgError' => 'Falha ao atualizar animal.']
            );
        }

        $this->processarFotos($id);

        return Redirect::page(
            $this->controller . '/form/update/' . $id,
            ['msgSucesso' => 'Animal atualizado com sucesso.']
        );
    }

    public function delete()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->request->getPost();
        $id   = (int) ($post[$this->model->primaryKey] ?? 0);

        if ($this->garanteAcessoAnimal($id) === null) {
            return;
        }

        if ($this->model->delete($post)) {
            return Redirect::page(
                $this->controller,
                ['msgSucesso' => 'Animal excluído com sucesso.']
            );
        }

        return Redirect::page(
            $this->controller,
            ['msgError' => 'Falha ao excluir animal.']
        );
    }

    /**
     * Normaliza o POST do formulário para o formato das colunas da tabela:
     * checkboxes para 0/1, campos múltiplos para JSON.
     */
    private function normalizaPost(array $post): array
    {
        $post['vacinado']             = isset($post['vacinado'])             ? 1 : 0;
        $post['castrado']             = isset($post['castrado'])             ? 1 : 0;
        $post['necessidade_especial'] = isset($post['necessidade_especial']) ? 1 : 0;
        $post['em_tratamento']        = isset($post['em_tratamento'])        ? 1 : 0;

        $post['caracteristicas_positivas'] = json_encode($post['caracteristicas_positivas'] ?? []);
        $post['pontos_atencao']            = json_encode($post['pontos_atencao']            ?? []);
        $post['compatibilidade']           = json_encode($post['compatibilidade']           ?? []);

        return $post;
    }

    private function processarFotos(int $animal_id): void
    {
        if (empty($_FILES['fotos']['name'][0])) {
            return;
        }

        $modelFoto = $this->loadModel('AnimalFoto');
        $filesLib  = new Files(self::PASTA_FOTOS . DIRECTORY_SEPARATOR);
        $files     = Files::normalizeFiles($_FILES['fotos']);
        $pasta     = (string) $animal_id;
        $enviados  = $filesLib->upload($files, $pasta);

        if (!empty($enviados)) {
            foreach ($enviados as $nomeArquivo) {
                $modelFoto->inserirFoto($animal_id, $nomeArquivo);
            }
        }
    }
}
