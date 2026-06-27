<h1 style="padding-top: 55px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Exclusão de Doações <i class="fa-solid fa-paw"></i></h1>

<?php if ($action === 'delete'): ?>

<div class="container py-4">

    <div class="alert alert-danger shadow-sm">
        <h5 class="mb-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Confirmar Exclusão
        </h5>

        Tem certeza que deseja excluir esta doação?

        <br>

        <strong>Esta ação é permanente e não poderá ser desfeita.</strong>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-md-12">

                    <h3 class="mb-3">
                        <?= htmlspecialchars($data['data']['nome'] ?? 'Não informado') ?>
                    </h3>

                    <table class="table table-borderless table-sm">
                        <tr>
                            <th width="220">Nome</th>
                            <td><?= htmlspecialchars($data['data']['nome'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>CPF / CNPJ</th>
                            <td><?= htmlspecialchars($data['data']['cpf'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>E-mail</th>
                            <td><?= htmlspecialchars($data['data']['email'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>Telefone</th>
                            <td><?= htmlspecialchars($data['data']['telefone'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>Valor</th>
                            <td>
                                R$ <?= number_format((float)($data['data']['valor'] ?? 0), 2, ',', '.') ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Forma de Pagamento</th>
                            <td><?= htmlspecialchars($data['data']['forma_pagamento'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td><?= $aStatus[$data['data']['statusRegistro'] ?? 1] ?? '—' ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-0" style="margin-top: -100px;">
            <form method="POST" action="<?= baseUrl() ?>Doacao/delete">
                <?= csrfField() ?>
                <input type="hidden" name="id" value="<?= (int)($data['data']['id'] ?? 0) ?>">

                <a href="<?= baseUrl() ?>Doacao/admin" class="btn btn-secondary">
                    Voltar
                </a>

                <button type="submit" class="btn btn-danger ms-2">
                    Confirmar Exclusão
                </button>
            </form>
        </div>

    </div>

</div>

<?php else: ?>

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h3 class="mb-3">
                <?= htmlspecialchars($data['data']['nome'] ?? 'Não informado') ?>
            </h3>

            <table class="table table-borderless table-sm">
                <tr>
                    <th width="220">Nome</th>
                    <td><?= htmlspecialchars($data['data']['nome'] ?? '') ?></td>
                </tr>

                <tr>
                    <th>CPF / CNPJ</th>
                    <td><?= htmlspecialchars($data['data']['cpf'] ?? '') ?></td>
                </tr>

                <tr>
                    <th>E-mail</th>
                    <td><?= htmlspecialchars($data['data']['email'] ?? '') ?></td>
                </tr>

                <tr>
                    <th>Telefone</th>
                    <td><?= htmlspecialchars($data['data']['telefone'] ?? '') ?></td>
                </tr>

                <tr>
                    <th>Valor</th>
                    <td>
                        R$ <?= number_format((float)($data['data']['valor'] ?? 0), 2, ',', '.') ?>
                    </td>
                </tr>

                <tr>
                    <th>Forma de Pagamento</th>
                    <td><?= htmlspecialchars($data['data']['forma_pagamento'] ?? '') ?></td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td><?= $aStatus[$data['data']['statusRegistro'] ?? 1] ?? '—' ?></td>
                </tr>
            </table>

        </div>

        <div class="card-footer bg-white border-0" style="margin-top: -50px;">
            <a href="<?= baseUrl() ?>Doacao/admin" class="btn btn-secondary">
                Voltar
            </a>
        </div>

    </div>

</div>

<?php endif; ?>