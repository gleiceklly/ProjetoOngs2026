<h1 style="padding-top: 55px; padding-bottom: 25px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Doações <i class="fa-solid fa-paw"></i></h1>

<?php if (!empty($lista)): ?>

<div class="px-3">
    <table class="table table-sm" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Valor</th>
                <th>ONG</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['nome'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['email'] ?? '') ?></td>
                    <td>R$ <?= number_format((float)$item['valor'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($item['ong_nome'] ?? '—') ?></td>
                    <td><?= $aStatus[$item['statusRegistro']] ?? $item['statusRegistro'] ?></td>
                    <td>
                        <?= buttons('view',   $item['id']) ?>
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
