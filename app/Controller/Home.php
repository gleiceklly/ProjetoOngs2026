<?php

namespace App\Controller;

use Core\Library\ControllerMain;

class Home extends ControllerMain
{
    public function index ()
    {
        return $this->view('home', [
            'titulo' => 'Patas Do Bem'
        ]);
    }
}