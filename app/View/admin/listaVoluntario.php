<h1 style="padding-top: 55px; padding-bottom: 25px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Voluntários <i class="fa-solid fa-paw"></i></h1>

<?php if (!empty($lista)): ?>

<div class="px-3">
    <table class="table table-sm" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Função</th>
                <th>Cidade</th>
                <th>ONG</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td><?= htmlspecialchars($item['email']) ?></td>
                    <td><?= htmlspecialchars($item['funcao']) ?></td>
                    <td><?= htmlspecialchars($item['cidade']) ?></td>
                    <td><?= htmlspecialchars($item['ong_nome'] ?? '—') ?></td>
                    <td><?= $aStatus[$item['statusRegistro']] ?? $item['statusRegistro'] ?></td>
                    <td>
                        <?= buttons('view',   $item['id']) ?>
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
    <p class="text-muted m-3">Nenhum <?= $titulo ?> encontrado.</p>
<?php endif; ?>

<a href="<?= baseUrl() ?>Admin" class="btn btn-secondary m-3">Voltar ao Painel</a>
