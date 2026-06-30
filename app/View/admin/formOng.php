<h1 style="padding-top: 55px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Exclusão de Ongs <i class="fa-solid fa-paw"></i></h1>

<div class="container py-4">

    <div class="alert alert-danger shadow-sm">
        <h5 class="mb-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Confirmar Exclusão
        </h5>
        Tem certeza que deseja excluir esta ONG?
        <br>
        <strong>Esta ação é permanente e não poderá ser desfeita.</strong>
        <hr>
        <i class="fa-solid fa-circle-exclamation"></i>
        <strong>Atenção:</strong> O usuário de acesso (<?= htmlspecialchars($data['data']['email'] ?? '') ?>) vinculado a esta ONG também será excluído.
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
                            <th>Cidade</th>
                            <td><?= htmlspecialchars($data['data']['cidade'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>Estado</th>
                            <td><?= htmlspecialchars($data['data']['estado'] ?? 'Não informado') ?></td>
                        </tr>

                        <tr>
                            <th>Responsável</th>
                            <td><?= htmlspecialchars($data['data']['responsavel_nome'] ?? 'Não informado') ?></td>
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
                            <th>Endereço</th>
                            <td><?= htmlspecialchars($data['data']['endereco'] ?? 'Não informado') ?></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        <div class="card-footer bg-white border-0" style="margin-top: -100px;">
            <form method="POST" action="<?= baseUrl() ?>Ong/delete">
                <?= csrfField() ?>
                <input type="hidden" name="id" value="<?= (int)($data['data']['id'] ?? 0) ?>">

                <a href="<?= baseUrl() ?>Ong/admin" class="btn btn-secondary">
                    Voltar
                </a>

                <button type="submit" class="btn btn-danger ms-2">
                    Confirmar Exclusão
                </button>
            </form>
        </div>

    </div>

</div>