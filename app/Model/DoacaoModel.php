<?php

namespace App\Model;

use Core\Library\ModelMain;

class DoacaoModel extends ModelMain
{
    protected $table = "doacao";

    public $titulo = 'Doação';

    public $listaStatus = [
        1 => 'Registrada',
        2 => 'Cancelada'
    ];

    public $validationRules = [
        "cpf" => [
            "label" => "CPF/CNPJ",
            "rules" => "required|min:11|max:20"
        ],
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
        "ong_id" => [
            "label" => "ONG",
            "rules" => "required|int"
        ],
        "valor" => [
            "label" => "Valor da doação",
            "rules" => "required"
        ],
        "plano" => [
            "label" => "Plano",
            "rules" => "required|in:mensal,unica"
        ],
        "forma_pagamento" => [
            "label" => "Forma de pagamento",
            "rules" => "required"
        ]
    ];

    public function lista($orderBy = "nome")
    {
        return $this->db->orderBy($orderBy)->findAll();
    }

    public function listaAdmin($orderBy = "nome")
    {
        return $this->db
            ->select("doacao.*, ong.nome AS ong_nome")
            ->join("ong", "doacao.ong_id = ong.id", "left")
            ->orderBy($orderBy)
            ->findAll();
    }
}
