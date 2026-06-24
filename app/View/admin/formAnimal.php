<?= formTitulo($titulo) ?>

<div class="m-3">

    <div class="alert alert-danger">
        <strong>Atenção!</strong> Confirme a exclusão do animal abaixo. Esta ação não pode ser desfeita.
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($data['nome'] ?? '') ?></h5>
            <p class="card-text">
                <strong>Espécie:</strong> <?= htmlspecialchars(ucfirst($data['especie'] ?? '')) ?><br>
                <strong>Porte:</strong> <?= htmlspecialchars(ucfirst($data['porte'] ?? '')) ?><br>
                <strong>Cidade/Estado:</strong>
                <?= htmlspecialchars($data['cidade'] ?? '') ?>, <?= htmlspecialchars($data['estado'] ?? '') ?>
            </p>
        </div>
    </div>

    <form method="POST" action="<?= baseUrl() ?>Animal/delete">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= (int)($data['id'] ?? 0) ?>">
        <a href="<?= baseUrl() ?>Animal" class="btn btn-outline-secondary">Voltar</a>
        <button type="submit" class="btn btn-danger ms-2">Confirmar Exclusão</button>
    </form>

</div>
