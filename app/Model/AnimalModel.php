<?php

namespace App\Model;

use Core\Library\ModelMain;

class AnimalModel extends ModelMain
{
    protected $table = "animal";

    public $titulo = 'Animal';

    public $listaStatus = [
        1 => 'Disponível',
        2 => 'Adotado'
    ];

    public $validationRules = [
        "especie"                   => ["label" => "Espécie",                   "rules" => "required|max:20"],
        "nome"                      => ["label" => "Nome",                      "rules" => "required|min:2|max:60"],
        "raca"                      => ["label" => "Raça",                      "rules" => "nullable|max:60"],
        "sexo"                      => ["label" => "Sexo",                      "rules" => "required|max:10"],
        "fase_vida"                 => ["label" => "Fase de vida",              "rules" => "required|max:10"],
        "idade"                     => ["label" => "Idade (número)",            "rules" => "nullable|int"],
        "unidade_idade"             => ["label" => "Unidade da idade",          "rules" => "nullable|max:10"],
        "porte"                     => ["label" => "Porte",                     "rules" => "required|max:10"],
        "pelagem"                   => ["label" => "Pelagem / cor",             "rules" => "nullable|max:60"],
        "historia"                  => ["label" => "História",                  "rules" => "nullable"],
        "caracteristicas_positivas" => ["label" => "Características positivas", "rules" => "nullable"],
        "pontos_atencao"            => ["label" => "Pontos de atenção",         "rules" => "nullable"],
        "compatibilidade"           => ["label" => "Compatibilidade",           "rules" => "nullable"],
        // Booleanos (checkbox): aceitam 0 ou 1. Usamos in:0,1 em vez de int porque a
        // regra int do framework rejeita o valor 0 (!filter_var(0) === true).
        "vacinado"                  => ["label" => "Vacinado",                  "rules" => "nullable|in:0,1"],
        "castrado"                  => ["label" => "Castrado",                  "rules" => "nullable|in:0,1"],
        "necessidade_especial"      => ["label" => "Necessidade especial",      "rules" => "nullable|in:0,1"],
        "em_tratamento"             => ["label" => "Em tratamento",             "rules" => "nullable|in:0,1"],
        "obs_saude"                 => ["label" => "Obs. de saúde",             "rules" => "nullable"],
        "estado"                    => ["label" => "Estado",                    "rules" => "required|max:2"],
        "cidade"                    => ["label" => "Cidade",                    "rules" => "required|max:100"],
        "bairro"                    => ["label" => "Bairro",                    "rules" => "nullable|max:100"],
        "responsavel"               => ["label" => "Responsável / ONG",         "rules" => "required|max:100"],
        "contato"                   => ["label" => "WhatsApp ou e-mail",        "rules" => "required|max:150"],
        "ong_id"                    => ["label" => "ONG",                       "rules" => "required|int"],
        "statusRegistro"            => ["label" => "Status",                    "rules" => "required|int"],
    ];

    // Subquery para buscar o caminho da primeira foto do animal
    private const SEL_FOTO = "(SELECT CONCAT('/uploads/animais/', animal_id, '/', nomearquivo) FROM animalfoto WHERE animal_id = animal.id ORDER BY id LIMIT 1) AS foto";

    public function listaAdmin($ongId = 0, $orderBy = "nome")
    {
        $this->db
            ->select("animal.*, ong.nome AS ong_nome")
            ->join("ong", "animal.ong_id = ong.id", "left");

        // Quando informado, restringe a listagem aos animais de uma única ONG
        if ((int) $ongId > 0) {
            $this->db->where("animal.ong_id", (int) $ongId);
        }

        return $this->db
            ->orderBy($orderBy)
            ->findAll();
    }

    public function lista($filtros = [])
    {
        $this->db
            ->select("animal.*, " . self::SEL_FOTO)
            ->where("statusRegistro", 1);

        if (!empty($filtros['especie'])) {
            $this->db->where("especie", $filtros['especie']);
        }

        if (!empty($filtros['ong_id'])) {
            $this->db->where("ong_id", (int) $filtros['ong_id']);
        }

        return $this->db->orderBy("nome")->findAll();
    }

    public function getById($id)
    {
        if ($id == 0) {
            return [];
        }

        return $this->db
            ->select("animal.*, ong.nome AS ong_nome, ong.email AS ong_email, ong.telefone AS ong_telefone, " . self::SEL_FOTO)
            ->join("ong", "animal.ong_id = ong.id")
            ->where("animal.id", $id)
            ->first();
    }
}
