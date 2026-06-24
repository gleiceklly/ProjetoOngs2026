<?php

namespace App\Model;

use Core\Library\ModelMain;

class VagaModel extends ModelMain
{
    protected $table = "vaga";

    public $titulo = 'Vaga';

    public $listaStatus = [
        1 => 'Ativa',
        2 => 'Inativa',
    ];

    public $validationRules = [
        "ong_id"         => ["label" => "ONG",        "rules" => "required|int"],
        "funcao"         => ["label" => "Função",      "rules" => "required|max:100"],
        "quantidade"     => ["label" => "Quantidade",  "rules" => "required|int"],
        "descricao"      => ["label" => "Descrição",   "rules" => "nullable"],
        "statusRegistro" => ["label" => "Status",      "rules" => "required|int"],
    ];

    public function listaPublica(): array
    {
        return $this->db
            ->select("vaga.*, ong.nome AS ong_nome, ong.cidade AS ong_cidade, ong.estado AS ong_estado, ong.bairro as ong_bairro")
            ->join("ong", "vaga.ong_id = ong.id")
            ->where("vaga.statusRegistro", 1)
            ->where("ong.statusRegistro", 1)
            ->orderBy("ong.nome")
            ->findAll();
    }

    public function listaAdmin(int $ongId = 0): array
    {
        $this->db
            ->select("vaga.*, ong.nome AS ong_nome")
            ->join("ong", "vaga.ong_id = ong.id", "left");

        if ($ongId > 0) {
            $this->db->where("vaga.ong_id", $ongId);
        }

        return $this->db->orderBy("ong.nome")->findAll();
    }
}
