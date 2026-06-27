<h1 style="padding-top: 55px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Usuários <i class="fa-solid fa-paw"></i></h1>

<div class="d-flex justify-content-end px-4">
    <a href="<?= baseUrl() ?>Usuario/form/insert/0" class="btn" style="background-color: #86c7df;">
        <i class="fa-solid fa-plus"></i> Novo <?= $titulo ?>
    </a>
</div>

<?php if (!empty($lista)): ?>

<div class="px-4">
    <table class="table table-sm" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Nível</th>
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
                    <td><?= $aNiveis[$item['nivel']] ?? $item['nivel'] ?></td>
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

<a href="/" class="btn btn-secondary m-3">Voltar ao Início</a>
