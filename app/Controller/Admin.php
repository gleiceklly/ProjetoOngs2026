<?php

namespace App\Controller;

use Core\Library\ControllerMain;

class Admin extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso(11);
    }

    public function index()
    {
        return $this->view('admin/dashboard', [
            'titulo' => 'Painel Administrativo',
        ]);
    }
}
