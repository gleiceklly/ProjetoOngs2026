<?php

namespace App\Model;

use Core\Library\ModelMain;

class RecuperaSenhaModel extends ModelMain
{
    protected $table = "usuariorecuperasenha";

    public function gerarToken(int $usuarioId): string
    {
        $token = bin2hex(random_bytes(32));

        $novoId = (int) $this->db->insert([
            'usuario_id'     => $usuarioId,
            'chave'          => $token,
            'statusRegistro' => 1,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        if ($novoId === 0) {
            throw new \RuntimeException('Falha ao persistir token de recuperação de senha.');
        }

        $this->db
            ->where('usuario_id', $usuarioId)
            ->where('statusRegistro', 1)
            ->where('id <>', $novoId)
            ->update(['statusRegistro' => 2, 'updated_at' => date('Y-m-d H:i:s')]);

        return $token;
    }

    public function getTokenAtivo(string $chave): array
    {
        $registro = $this->db
            ->where('chave', $chave)
            ->where('statusRegistro', 1)
            ->first();

        if (empty($registro)) {
            return [];
        }

        if (time() > strtotime($registro['created_at']) + 3600) {
            return [];
        }

        return $registro;
    }

    public function invalidarToken(string $chave): bool
    {
        return $this->db
            ->where('chave', $chave)
            ->update(['statusRegistro' => 2, 'updated_at' => date('Y-m-d H:i:s')]) > 0;
    }
}
