<?php

namespace App\Model;

use Core\Library\ModelMain;

class VoluntarioModel extends ModelMain
{
    protected $table = "voluntario";

    public $titulo = 'Voluntário';

    public $listaStatus = [
        1 => 'Ativo',
        2 => 'Inativo'
    ];

    public $validationRules = [
        "nome" => [
            "label" => "Nome completo",
            "rules" => "required|min:3|max:100"
        ],
        "email" => [
            "label" => "E-mail",
            "rules" => "required|email"
        ],
        "telefone" => [
            "label" => "Telefone",
            "rules" => "required|min:8|max:20"
        ],
        "cidade" => [
            "label" => "Cidade",
            "rules" => "required"
        ],
        "funcao" => [
            "label" => "Função desejada",
            "rules" => "required"
        ],
        "ong_id" => [
            "label" => "ONG",
            "rules" => "required|int"
        ]
    ];

    public function lista($orderBy = "nome")
    {
        return $this->db->orderBy($orderBy)->findAll();
    }

    public function listaAdmin($orderBy = "nome")
    {
        return $this->db
            ->select("voluntario.*, ong.nome AS ong_nome")
            ->join("ong", "voluntario.ong_id = ong.id", "left")
            ->orderBy($orderBy)
            ->findAll();
    }
}
