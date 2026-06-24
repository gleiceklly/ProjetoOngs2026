<?php

namespace App\Model;

use Core\Library\ModelMain;

class AnimalFotoModel extends ModelMain
{
    protected $table = "animalfoto";

    public function listaPorAnimal(int $animal_id): array
    {
        return $this->db
            ->where("animal_id", $animal_id)
            ->orderBy("id")
            ->findAll();
    }

    public function inserirFoto(int $animal_id, string $nomearquivo): int
    {
        return $this->db->insert([
            'animal_id' => $animal_id,
            'nomearquivo'   => $nomearquivo,
        ]);
    }

    public function excluirFoto(int $id): bool
    {
        return $this->db->where('id', $id)->delete() > 0;
    }
}
