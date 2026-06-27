<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Vaga extends ControllerMain
{
    private function ehAdmin(): bool
    {
        return (int) Session::get('userNivel') <= NIVEL_ADMIN;
    }

    private function ongIdSessao(): int
    {
        return (int) (Session::get('userOngId') ?: 0);
    }

    private function garanteAcessoVaga(int $id): ?array
    {
        $vaga = $this->model->getById($id);

        if (empty($vaga)) {
            Redirect::page($this->controller, ['msgError' => 'Vaga não encontrada.']);
            return null;
        }

        if (!$this->ehAdmin() && (int) $vaga['ong_id'] !== $this->ongIdSessao()) {
            Redirect::page($this->controller, ['msgError' => 'Você só pode gerenciar as vagas da sua ONG.']);
            return null;
        }

        return $vaga;
    }

    public function index()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $lista = $this->ehAdmin()
            ? $this->model->listaAdmin()
            : $this->model->listaAdmin($this->ongIdSessao());

        return $this->view('admin/listaVaga', [
            'titulo'  => $this->model->titulo,
            'lista'   => $lista,
            'aStatus' => $this->model->listaStatus,
        ]);
    }

    public function form($action, $id = 0)
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        if ($action === 'delete') {
            if ((int) $id > 0 && $this->garanteAcessoVaga((int) $id) === null) {
                return;
            }

            return $this->view('admin/formVagaDelete', [
                'titulo'  => $this->model->titulo,
                'data'    => $this->model->getById((int) $id),
                'action'  => 'delete',
                'aStatus' => $this->model->listaStatus,
                'aOngs'   => [],
            ]);
        }

        if ((int) $id > 0 && $this->garanteAcessoVaga((int) $id) === null) {
            return;
        }

        $modelOng = $this->loadModel('Ong');
        $aOngs = $this->ehAdmin()
            ? $modelOng->lista()
            : array_filter([$modelOng->getById($this->ongIdSessao())]);

        return $this->view('admin/formVaga', [
            'titulo'  => $this->model->titulo,
            'data'    => $this->model->getById((int) $id),
            'aStatus' => $this->model->listaStatus,
            'action'  => $this->action,
            'aOngs'   => $aOngs,
        ]);
    }

    public function insert()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->request->getPost();

        if (!$this->ehAdmin()) {
            $post['ong_id'] = $this->ongIdSessao();
        }

        $post['statusRegistro'] = 1;

        if (!$this->model->insert($post)) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Falha ao cadastrar vaga. Verifique os campos obrigatórios.']
            );
        }

        return Redirect::page($this->controller, ['msgSucesso' => 'Vaga cadastrada com sucesso.']);
    }

    public function update()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->request->getPost();
        $id   = (int) ($post[$this->model->primaryKey] ?? 0);

        if ($this->garanteAcessoVaga($id) === null) {
            return;
        }

        if (!$this->ehAdmin()) {
            $post['ong_id'] = $this->ongIdSessao();
        }

        if (!$this->model->update($post)) {
            return Redirect::page(
                $this->controller . '/form/update/' . $id,
                ['msgError' => 'Falha ao atualizar vaga.']
            );
        }

        return Redirect::page($this->controller, ['msgSucesso' => 'Vaga atualizada com sucesso.']);
    }

    public function delete()
    {
        $this->validaNivelAcesso(NIVEL_ONG);

        $post = $this->request->getPost();
        $id   = (int) ($post[$this->model->primaryKey] ?? 0);

        if ($this->garanteAcessoVaga($id) === null) {
            return;
        }

        if ($this->model->delete($post)) {
            return Redirect::page($this->controller, ['msgSucesso' => 'Vaga excluída com sucesso.']);
        }

        return Redirect::page($this->controller, ['msgError' => 'Falha ao excluir vaga.']);
    }
}
