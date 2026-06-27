<?= formTitulo($titulo) ?>

<div class="m-3">

    <?php if ($action === 'delete'): ?>

        <div class="alert alert-danger">
            <strong>Atenção!</strong> Confirme a exclusão do registro de doação abaixo. Esta ação não pode ser desfeita.
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($data['nome'] ?? '') ?></h5>
                <p class="card-text">
                    <strong>E-mail:</strong> <?= htmlspecialchars($data['email'] ?? '') ?><br>
                    <strong>Valor:</strong>
                    R$ <?= number_format((float)($data['valor'] ?? 0), 2, ',', '.') ?><br>
                </p>
            </div>
        </div>

        <form method="POST" action="<?= baseUrl() ?>Doacao/delete">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= (int)($data['id'] ?? 0) ?>">
            <a href="<?= baseUrl() ?>Doacao/admin" class="btn btn-outline-secondary">Voltar</a>
            <button type="submit" class="btn btn-danger ms-2">Confirmar Exclusão</button>
        </form>

    <?php else: ?>

        <div class="card">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Nome</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($data['nome'] ?? '') ?></dd>

                    <dt class="col-sm-3">CPF / CNPJ</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($data['cpf'] ?? '') ?></dd>

                    <dt class="col-sm-3">E-mail</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($data['email'] ?? '') ?></dd>

                    <dt class="col-sm-3">Telefone</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($data['telefone'] ?? '') ?></dd>

                    <dt class="col-sm-3">Valor</dt>
                    <dd class="col-sm-9">
                        R$ <?= number_format((float)($data['valor'] ?? 0), 2, ',', '.') ?>
                    </dd>

                    <dt class="col-sm-3">Forma de Pagamento</dt>
                    <dd class="col-sm-9">
                        <?= htmlspecialchars($data['forma_pagamento'] ?? '') ?>
                    </dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        <?= $aStatus[$data['statusRegistro'] ?? 1] ?? '—' ?>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="mt-3">
            <a href="<?= baseUrl() ?>Doacao/admin" class="btn btn-outline-secondary">Voltar</a>
        </div>

    <?php endif; ?>

</div>
