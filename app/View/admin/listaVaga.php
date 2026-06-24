<?= formTitulo($titulo, true) ?>

<?php if (!empty($lista)): ?>

    <table class="table table-sm m-3" id="tbLista">
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

    <?= datatables("tbLista") ?>

<?php else: ?>
    <p class="text-muted m-3">Nenhuma vaga cadastrada.</p>
<?php endif; ?>

<a href="<?= baseUrl() ?>Admin" class="btn btn-secondary m-3">Voltar ao Painel</a>
