<?= formTitulo($titulo) ?>

<?php if (!empty($lista)): ?>

    <table class="table table-sm m-3" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Valor</th>
                <th>Plano</th>
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
                    <td><?= $item['plano'] === 'mensal' ? 'Mensal' : 'Única' ?></td>
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

    <?= datatables("tbLista") ?>

<?php else: ?>
    <p class="text-muted m-3">Nenhuma <?= $titulo ?> encontrada.</p>
<?php endif; ?>

<a href="<?= baseUrl() ?>Admin" class="btn btn-secondary m-3">Voltar ao Painel</a>
