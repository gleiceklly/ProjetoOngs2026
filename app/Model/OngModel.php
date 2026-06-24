<?php

namespace App\Model;

use Core\Library\ModelMain;

class OngModel extends ModelMain
{
    protected $table = "ong";

    public $titulo = 'ONG';

    public $listaStatus = [
        1 => 'Ativa',
        2 => 'Inativa'
    ];

    public $validationRules = [
        "nome"              => ["label" => "Nome",                  "rules" => "required|min:3|max:100"],
        "pix"               => ["label" => "Pix",                   "rules" => "required|max:100"],
        "descricao"         => ["label" => "Descrição / Missão",    "rules" => "required|min:100"],
        "cep"               => ["label" => "CEP",                   "rules" => "required|max:9"],
        "estado"            => ["label" => "Estado",                "rules" => "required|max:2"],
        "cidade"            => ["label" => "Cidade",                "rules" => "required|max:100"],
        "bairro"            => ["label" => "Bairro",                "rules" => "nullable|max:100"],
        "logradouro"        => ["label" => "Logradouro",            "rules" => "nullable|max:255"],
        "numero"            => ["label" => "Número",                "rules" => "nullable|max:20"],
        "complemento"       => ["label" => "Complemento",           "rules" => "nullable|max:100"],
        "area_atuacao"      => ["label" => "Área de atuação",       "rules" => "required|max:50"],
        "animais_tipos"     => ["label" => "Tipos de animais",      "rules" => "nullable"],
        "animais_qtd"       => ["label" => "Qtd. disponíveis",      "rules" => "nullable|int"],
        "atividades"        => ["label" => "Atividades",            "rules" => "nullable"],
        "responsavel_nome"  => ["label" => "Nome do responsável",   "rules" => "required|max:100"],
        "responsavel_cargo" => ["label" => "Cargo / Função",        "rules" => "nullable|max:100"],
        "email"             => ["label" => "E-mail de contato",     "rules" => "required|email"],
        "telefone"          => ["label" => "Telefone / WhatsApp",   "rules" => "required|max:20"],
        "facebook"          => ["label" => "Facebook",              "rules" => "nullable|url"],
        "instagram"         => ["label" => "Instagram",             "rules" => "nullable|url"],
        "site"              => ["label" => "Site",                  "rules" => "nullable|url"],
        "horarios"          => ["label" => "Horários",              "rules" => "nullable|max:255"],
        "statusRegistro"    => ["label" => "Status",                "rules" => "required|int"],
    ];

    public function lista($orderBy = "nome")
    {
        return $this->db
            ->where("statusRegistro", 1)
            ->orderBy($orderBy)
            ->findAll();
    }

    public function buscar($termo)
    {
        return $this->db
            ->where("statusRegistro", 1)
            ->whereLike("nome", $termo)
            ->orderBy("nome")
            ->findAll();
    }

    public function listaAdmin($orderBy = "nome")
    {
        return $this->db->orderBy($orderBy)->findAll();
    }

    public function getById($id)
    {
        if ($id == 0) {
            return [];
        }

        return $this->db
            ->where("id", $id)
            ->first();
    }
}
