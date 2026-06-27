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

        if ($action === 'update') {
            if (!Session::get('userId')) {
                return Redirect::page('Login');
            }

            $this->validaNivelAcesso(NIVEL_ONG);

            if ((int) $id === 0) {
                $id = (int) Session::get('userOngId');
            }

            return $this->view('ong/form', [
                'titulo'    => $this->model->titulo,
                'data'      => $this->model->getById($id),
                'aStatus'   => $this->model->listaStatus,
                'action'    => $this->action,
                'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesCadastroOngs.css">'),
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
        $post = $this->request->getPost();
        $origem = $post['_tipo'] ?? '';

        \error_log('DEBUG ONG INSERT: origem='.$origem.', t1='.$post['t1'].', t2='.$post['t2'].', t3='.$post['t3']);
        if (empty($post['t1']) || empty($post['t2']) || empty($post['t3'])) {
            if ($origem === 'ong') {
                return Redirect::page(
                    'Login',
                    ['msgError' => 'Você deve aceitar todos os termos para cadastrar a ONG.']
                );
            }
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Você deve aceitar todos os termos para cadastrar a ONG.']
            );
        }

        // login ong  
        $email          = $post['email']          ?? '';
        $senha          = $post['senha']          ?? '';
        $confirmarSenha = $post['confirmarSenha'] ?? '';
        unset($post['senha'], $post['confirmarSenha']);

        //valida login ant de gravar ong  
        $usuarioModel = new UsuarioModel();

        if (empty($senha) || $senha !== $confirmarSenha) {
            if ($origem === 'ong') {
                return Redirect::page(
                    'Login',
                    ['msgError' => 'Informe a senha de acesso e confirme-a corretamente.']
                );
            }
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Informe a senha de acesso e confirme-a corretamente.']
            );
        }

        if (!empty($usuarioModel->getUsuarioEmail($email))) {
            if ($origem === 'ong') {
                return Redirect::page(
                    'Login',
                    ['msgError' => 'Já existe um acesso cadastrado com este e-mail. Faça login ou use outro e-mail.']
                );
            }
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Já existe um acesso cadastrado com este e-mail. Faça login ou use outro e-mail.']
            );
        }

        $post['animais_tipos'] = json_encode($post['animais_tipos'] ?? []);
        $post['atividades']    = json_encode($post['atividades']    ?? []);
        $post['statusRegistro'] = 1;

        unset($post['t1'], $post['t2'], $post['t3'], $post['_tipo']);

        $ong_id = $this->model->insertGetId($post);

        if ($ong_id <= 0) {
            if ($origem === 'ong') {
                return Redirect::page(
                    'Login',
                    ['msgError' => 'Falha ao cadastrar ONG.']
                );
            }

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

            if ($origem === 'ong') {
                return Redirect::page(
                    'Login',
                    ['msgError' => 'Não foi possível criar o acesso da ONG. Verifique a senha (mín. 8 caracteres, com maiúscula, minúscula, número e símbolo).']
                );
            }

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
        if (!Session::get('userId')) {
            return Redirect::page('Login');
        }

        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->request->getPost();

        $ongId = (int) ($post['id'] ?? 0);
        if ($ongId === 0) {
            $ongId = (int) Session::get('userOngId');
        }

        $post[$this->model->primaryKey] = $ongId;

        $ongAtual = $this->model->getById($ongId);
        $post['statusRegistro'] = $ongAtual['statusRegistro'] ?? 1;

        $post['animais_tipos'] = json_encode($post['animais_tipos'] ?? []);
        $post['atividades']    = json_encode($post['atividades']    ?? []);

        unset($post['t1'], $post['t2'], $post['t3']);

        if (!$this->model->update($post)) {
            return Redirect::page(
                $this->controller . '/form/update',
                ['msgError' => 'Falha ao atualizar ONG.']
            );
        }

        $this->processarFoto($ongId);

        return Redirect::page(
            $this->controller . '/form/update',
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
        $ongId = (int) ($post['id'] ?? 0);

        // Exclui o usuário vinculado a ONG antes de excluir a ONG
        $usuarioModel = new UsuarioModel();
        $usuarioModel->db->where('ong_id', $ongId)->delete();

        if ($this->model->delete($post)) {
            return Redirect::page(
                $this->controller . '/admin',
                ['msgSucesso' => 'ONG e usuário vinculado excluídos com sucesso.']
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