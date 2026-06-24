<?php

namespace App\Controller;

use App\Model\UsuarioModel;
use Core\Library\ControllerMain;
use Core\Library\Files;
use Core\Library\Raw;
use Core\Library\Redirect;
use Core\Library\Session;

class Ong extends ControllerMain
{
    private const PASTA_FOTO = 'uploads/ongs';

    public function index()
    {
        $get   = $this->request->getGet();
        $busca = $get['busca'] ?? '';

        $ongs = !empty($busca)
            ? $this->model->buscar($busca)
            : $this->model->lista();

        return $this->view('ong/index', [
            'titulo'    => 'ONGs Parceiras – Patas do Bem',
            'ongs'      => $ongs,
            'busca'     => $busca,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesOngs.css">'),
        ]);
    }

    public function show($action, $id = 0)
    {
        $ong = $this->model->getById((int) $id);

        if (empty($ong)) {
            return Redirect::page('Ong', ['msgError' => 'ONG não encontrada.']);
        }

        $modelAnimal = $this->loadModel('Animal');
        $animais     = $modelAnimal ? $modelAnimal->lista(['ong_id' => (int) $id]) : [];

        return $this->view('ong/detalhe', [
            'titulo'    => $ong['nome'] . ' – Patas do Bem',
            'ong'       => $ong,
            'animais'   => $animais,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesOng.css">'),
        ]);
    }

    public function admin()
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        return $this->view('admin/listaOng', [
            'titulo'  => $this->model->titulo,
            'lista'   => $this->model->listaAdmin(),
            'aStatus' => $this->model->listaStatus,
        ]);
    }

    public function form($action, $id = 0)
    {
        if ($action === 'delete') {
            if (!Session::get('userId')) {
                return Redirect::page('Login');
            }

            $this->validaNivelAcesso(11);

            return $this->view('admin/formOng', [
                'titulo' => $this->model->titulo,
                'data'   => $this->model->getById((int) $id),
                'action' => 'delete',
            ]);
        }

        $this->validaNivelAcesso(99);

        return $this->view('ong/form', [
            'titulo'    => $this->model->titulo,
            'data'      => $this->model->getById((int) $id),
            'aStatus'   => $this->model->listaStatus,
            'action'    => $this->action,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesCadastroOngs.css">'),
        ]);
    }

    public function insert()
    {
        // Cadastro público: visitante (nível 0) passa; usuário comum logado também.
        $this->validaNivelAcesso(99);

        $post = $this->request->getPost();

        if (empty($post['t1']) || empty($post['t2']) || empty($post['t3'])) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Você deve aceitar todos os termos para cadastrar a ONG.']
            );
        }

        // Dados de login da ONG (não são colunas da tabela ong)
        $email          = $post['email']          ?? '';
        $senha          = $post['senha']          ?? '';
        $confirmarSenha = $post['confirmarSenha'] ?? '';
        unset($post['senha'], $post['confirmarSenha']);

        // Pré-validação do login antes de gravar a ONG (evita ONG órfã sem acesso)
        $usuarioModel = new UsuarioModel();

        if (empty($senha) || $senha !== $confirmarSenha) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Informe a senha de acesso e confirme-a corretamente.']
            );
        }

        if (!empty($usuarioModel->getUsuarioEmail($email))) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Já existe um acesso cadastrado com este e-mail. Faça login ou use outro e-mail.']
            );
        }

        $post['animais_tipos'] = json_encode($post['animais_tipos'] ?? []);
        $post['atividades']    = json_encode($post['atividades']    ?? []);
        $post['statusRegistro'] = 1;

        unset($post['t1'], $post['t2'], $post['t3']);

        $ong_id = $this->model->insertGetId($post);

        if ($ong_id <= 0) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Falha ao cadastrar ONG.']
            );
        }

        // Cria o login da ONG vinculado ao registro recém-criado
        $loginCriado = $usuarioModel->insert([
            'nivel'          => NIVEL_ONG,
            'ong_id'         => $ong_id,
            'nome'           => $post['nome'],
            'email'          => $email,
            'senha'          => $senha,
            'confirmarSenha' => $confirmarSenha,
            'statusRegistro' => 1,
        ]);

        if (!$loginCriado) {
            // Desfaz a ONG para não deixar registro sem acesso (ex.: senha fraca)
            $this->model->db->where('id', $ong_id)->delete();

            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Não foi possível criar o acesso da ONG. Verifique a senha (mín. 8 caracteres, com maiúscula, minúscula, número e símbolo).']
            );
        }

        $this->processarFoto($ong_id);

        return Redirect::page(
            'Login',
            ['msgSucesso' => 'ONG cadastrada com sucesso! Faça login com o e-mail e a senha informados para gerenciar seus animais.']
        );
    }

    public function update()
    {
        $this->validaNivelAcesso(99);

        $post = $this->request->getPost();

        $post['animais_tipos'] = json_encode($post['animais_tipos'] ?? []);
        $post['atividades']    = json_encode($post['atividades']    ?? []);

        unset($post['t1'], $post['t2'], $post['t3']);

        if (!$this->model->update($post)) {
            return Redirect::page(
                $this->controller . '/form/update/' . $post[$this->model->primaryKey],
                ['msgError' => 'Falha ao atualizar ONG.']
            );
        }

        $this->processarFoto((int) $post[$this->model->primaryKey]);

        return Redirect::page(
            $this->controller,
            ['msgSucesso' => 'ONG atualizada com sucesso.']
        );
    }

    public function delete()
    {
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(11);

        $post = $this->request->getPost();

        if ($this->model->delete($post)) {
            return Redirect::page(
                $this->controller . '/admin',
                ['msgSucesso' => 'ONG excluída com sucesso.']
            );
        }

        return Redirect::page(
            $this->controller . '/admin',
            ['msgError' => 'Falha ao excluir ONG.']
        );
    }

    private function processarFoto(int $ong_id): void
    {
        if (empty($_FILES['foto']['name']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            return;
        }

        $filesLib = new Files(self::PASTA_FOTO . DIRECTORY_SEPARATOR);
        $pasta    = (string) $ong_id;
        $enviados = $filesLib->upload([$_FILES['foto']], $pasta);

        if (!empty($enviados)) {
            $this->model->db
                ->where('id', $ong_id)
                ->update(['foto' => $enviados[0]]);
        }
    }
}
