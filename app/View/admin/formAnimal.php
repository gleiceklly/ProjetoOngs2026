<?php
$animal = $data['data'];
?>

<div class="container py-4">

    <div class="alert alert-danger shadow-sm">
        <h5 class="mb-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Confirmar Exclusão
        </h5>

        Tem certeza que deseja excluir este animal?

        <br>

        <strong>Esta ação é permanente e não poderá ser desfeita.</strong>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <?php if (!empty($animal['foto'])) : ?>
                        <img
                            src="<?= baseUrl() . ltrim($animal['foto'], '/') ?>"
                            class="img-fluid rounded shadow"
                            style="max-height:280px; object-fit:cover;"
                            alt="<?= htmlspecialchars($animal['nome'] ?? 'Não informado') ?>">
                    <?php else : ?>
                        <div class="border rounded p-5 text-muted">
                            <i class="fa-solid fa-paw fa-3x mb-2"></i><br>
                            Sem foto
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-8">
                    <h3 class="mb-3">
                        <?= htmlspecialchars($animal['nome'] ?? 'Não informado') ?>
                    </h3>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="180">Espécie</th>
                            <td><?= ucfirst($animal['especie'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Raça</th>
                            <td><?= htmlspecialchars($animal['raca'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Sexo</th>
                            <td><?= ucfirst($animal['sexo'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Idade</th>
                            <td>
                                <?= $animal['idade'] ?>
                                <?= $animal['unidade_idade'] ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Porte</th>
                            <td><?= ucfirst($animal['porte'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Pelagem</th>
                            <td><?= htmlspecialchars($animal['pelagem'] ?? 'Não informado') ?></td>
                        </tr>
                        <tr>
                            <th>Localização</th>
                            <td>
                                <?= htmlspecialchars($animal['cidade'] ?? 'Não informado') ?>
                                -
                                <?= htmlspecialchars($animal['estado'] ?? 'Não informado') ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Responsável</th>
                            <td><?= htmlspecialchars($animal['responsavel'] ?? 'Não informado') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div style="margin-top: -80px;">
            <form method="POST" action="<?= baseUrl() ?>Animal/delete">
                <?= csrfField() ?>
                <input
                    type="hidden"
                    name="id"
                    value="<?= (int)$animal['id'] ?>"
                >

                <form method="POST" action="<?= baseUrl() ?>Animal/delete">
                    <?= csrfField() ?>
                    <input type="hidden" name="id" value="<?= (int)($data['data']['id'] ?? 0) ?>">
                    <a href="<?= baseUrl() ?>Animal" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-danger ms-2">Confirmar Exclusão</button>
                </form>
            </form>
        </div>
    </div>
</div>