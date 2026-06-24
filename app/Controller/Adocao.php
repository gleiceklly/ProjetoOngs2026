<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Raw;

class Adocao extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->model = $this->loadModel('Animal');
    }

    public function index()
    {
        $animais = $this->model->lista();

        return $this->view('adocao/index', [
            'titulo'    => 'Adoção – Patas do Bem',
            'animais'   => $animais,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesAdocao.css">'),
        ]);
    }

    public function show($action, $id = 0)
    {
        $animal = $this->model->getById((int) $id);

        if (empty($animal)) {
            return Redirect::page('Adocao', ['msgError' => 'Animal não encontrado.']);
        }

        $todos   = $this->model->lista();
        $outros  = array_values(array_filter($todos, fn($a) => (int) $a['id'] !== (int) $id));
        $outros  = array_slice($outros, 0, 10);

        return $this->view('adocao/detalhe', [
            'titulo'    => $animal['nome'] . ' – Patas do Bem',
            'animal'    => $animal,
            'outros'    => $outros,
            'extraHead' => new Raw('<link rel="stylesheet" href="/assets/styles/stylesAnimais.css">'),
        ]);
    }
}
