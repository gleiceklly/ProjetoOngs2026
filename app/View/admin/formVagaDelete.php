<?php
$vaga = $data['data'];
?>

<div class="container py-4">

    <div class="alert alert-danger shadow-sm">
        <h5 class="mb-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Confirmar Exclusão
        </h5>

        Tem certeza que deseja excluir esta vaga?

        <br>

        <strong>Esta ação é permanente e não poderá ser desfeita.</strong>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mb-3">
                        <i class="fa-solid fa-briefcase me-2 text-secondary"></i>
                        <?= htmlspecialchars($vaga['funcao'] ?? 'Não informado') ?>
                    </h3>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="180">Função</th>
                            <td><?= htmlspecialchars($vaga['funcao'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Quantidade</th>
                            <td><?= (int)($vaga['quantidade'] ?? 0) ?></td>
                        </tr>
                        <tr>
                            <th>Descrição</th>
                            <td><?= htmlspecialchars($vaga['descricao'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= htmlspecialchars($aStatus[$vaga['statusRegistro']] ?? 'Não informado') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-0 pb-3 px-3">
            <form method="POST" action="<?= baseUrl() ?>Vaga/delete">
                <?= csrfField() ?>
                <input type="hidden" name="id" value="<?= (int)($vaga['id'] ?? 0) ?>">
                <a href="<?= baseUrl() ?>Vaga" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-danger ms-2">Confirmar Exclusão</button>
            </form>
        </div>
    </div>
</div>