<h1 style="padding-top: 55px; padding-bottom: 25px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Ongs <i class="fa-solid fa-paw"></i></h1>

<?php if (!empty($lista)): ?>

<div class="px-4">
    <table class="table table-responsive table-sm" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Responsável</th>
                <th>E-mail</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['nome'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['cidade'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['estado'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['responsavel_nome'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['email'] ?? '') ?></td>
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
    <p class="text-muted m-3">Nenhuma <?= $titulo ?> encontrada.</p>
<?php endif; ?>

<a href="<?= baseUrl() ?>Admin" class="btn btn-secondary m-3">Voltar ao Painel</a>
