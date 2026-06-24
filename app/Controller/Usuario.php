<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

class Usuario extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso(1);
    }

    public function index()
    {
        return $this->view(
            'admin/listaUsuario',
            [
                'titulo'  => $this->model->titulo,
                'lista'   => $this->model->lista(),
                'aStatus' => $this->model->listaStatus,
                'aNiveis' => $this->model->listaNivel,
            ]
        );
    }

    public function form($action, $id = 0)
    {
        return $this->view(
            'admin/formUsuario',
            [
                'titulo'  => $this->model->titulo,
                'data'    => $this->model->getById($id),
                'aStatus' => $this->model->listaStatus,
                'aNiveis' => $this->model->listaNivel,
                'action'  => $this->action,
            ]
        );
    }

    public function insert()
    {
        $post = $this->request->getPost();

        if (!$this->model->insert($post)) {
            return Redirect::page(
                $this->controller . '/form/insert/0',
                ['msgError' => 'Falha ao inserir usuário. Verifique os campos obrigatórios.']
            );
        }

        return Redirect::page(
            $this->controller,
            ['msgSucesso' => 'Usuário inserido com sucesso.']
        );
    }

    public function update()
    {
        $post = $this->request->getPost();

        if (!$this->model->update($post)) {
            return Redirect::page(
                $this->controller . '/form/update/' . $post[$this->model->primaryKey],
                ['msgError' => 'Falha ao atualizar usuário.']
            );
        }

        return Redirect::page(
            $this->controller,
            ['msgSucesso' => 'Usuário atualizado com sucesso.']
        );
    }

    public function delete()
    {
        $post = $this->request->getPost();

        if ($this->model->delete($post)) {
            return Redirect::page(
                $this->controller,
                ['msgSucesso' => 'Usuário excluído com sucesso.']
            );
        }

        return Redirect::page(
            $this->controller,
            ['msgError' => 'Falha ao excluir usuário.']
        );
    }
}
