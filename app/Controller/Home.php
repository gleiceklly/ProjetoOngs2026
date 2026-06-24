<?php

namespace App\Controller;

use Core\Library\ControllerMain;

class Home extends ControllerMain
{
    public function index()
    {
        $modelOng    = $this->loadModel('Ong');
        $modelAnimal = $this->loadModel('Animal');

        return $this->view('home', [
            'titulo'  => 'Patas Do Bem',
            'ongs'    => $modelOng    ? $modelOng->lista()    : [],
            'animais' => $modelAnimal ? $modelAnimal->lista() : [],
        ]);
    }

    /**
     * viewErros
     *
     * @return void
     */
    public function viewErros()
    {
        return $this->view("erros", ['titulo' => 'Erro']);
    }
}