<div class="page-header">
    <h1><i class="fa-solid fa-heart" style="color:#ee7f3f;margin-right:10px;"></i>Cadastre seu <span style="color:#ee7f3f;">Animalzinho</span></h1>
    <img class="capaDoacao" src="/assets/img/catCheddar.png">
</div>
<br>
<div class="d-flex justify-content-center">
    <a href="<?= baseUrl() ?>Animal/form/insert/0" class="btn btn-animal" style="background-color: #ee7f3f;">
        <i class="fa fa-plus"></i> Cadastrar Animal
    </a>
</div>

<?php if (!empty($lista)): ?>

    <table class="table table-sm m-3" id="tbLista">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Porte</th>
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
                    <td><?= htmlspecialchars(ucfirst($item['especie'])) ?></td>
                    <td><?= htmlspecialchars(ucfirst($item['porte'])) ?></td>
                    <td><?= htmlspecialchars($item['cidade']) ?></td>
                    <td><?= htmlspecialchars($item['ong_nome'] ?? '—') ?></td>
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
    <p class="text-muted m-3">Nenhum <?= $titulo ?> encontrado.</p>
<?php endif; ?>

<a href="<?= baseUrl() ?>adocao" class="btn btn-secondary m-3">Ver animais</a>

<style>
    table th:first-child,
    table td:first-child {
        padding-left: 20px;
    }

    .btn-animal {
        background-color: #ee7f3f !important;
        border-color: #ee7f3f !important;
        color: #fff !important;
        transition: all .2s ease;
    }

    .btn-animal:hover,
    .btn-animal:focus,
    .btn-animal:active {
        background-color: #ec5e0c !important;
        border-color: #ec5e0c !important;
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,.15);
    }

    .btn-animal:active {
        transform: translateY(1px) scale(.98);
        box-shadow: 0 2px 4px rgba(0,0,0,.15);
    }
</style>