
<h2 style="color: #a4d3ff; padding: 18px;"><i class="fa-solid fa-paw"></i> Minhas vagas <i class="fa-solid fa-paw"></i></h2>
<hr>
<div class="d-flex justify-content-end p-4">
    <a href="<?= baseUrl() ?>Vaga/form/insert" class="btn btn-vaga" style="background-color: #a4d3ff; color: white;">
        <i class="fa fa-plus"></i> Cadastrar Vaga
    </a>
</div>

<?php if (!empty($lista)): ?>

<div class="table-renponsive">
    <table class="table table-sm" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>ONG</th>
                <th>Função</th>
                <th>Vagas</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['ong_nome'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['funcao'] ?? '') ?></td>
                    <td><?= (int) $item['quantidade'] ?></td>
                    <td><?= $aStatus[$item['statusRegistro']] ?? $item['statusRegistro'] ?></td>
                    <td>
                        <?= buttons('update', $item['id']) ?>
                        <?= buttons('delete', $item['id']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <?= datatables("tbLista") ?>

<?php else: ?>
    <p class="text-muted m-3">Nenhuma vaga cadastrada.</p>
<?php endif; ?>

<a href="<?= baseUrl() ?>voluntario" class="btn btn-secondary m-3">Voltar as vagas</a>

<style>
    table th:first-child,
    table td:first-child {
        padding-left: 20px;
    }

    .btn-vaga {
        background-color: #a4d3ff;
        color: white;
        transition: all 0.2s ease;
    }

    .btn-vaga:hover {
        background-color: #2a76b8;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,.15);
    }

    .btn-vaga:active {
        transform: translateY(1px) scale(0.98);
        box-shadow: 0 2px 4px rgba(0,0,0,.15);
    }
</style>