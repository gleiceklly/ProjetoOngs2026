<h1 style="padding-top: 55px; display: flex; justify-content: center; color: #86c7df">
    <i class="fa-solid fa-paw"></i>
    Usuários
    <i class="fa-solid fa-paw"></i>
</h1>

<div class="m-3">

    <?php if ($action === 'delete'): ?>

        <div class="alert alert-danger">
            <strong>Atenção!</strong> Confirme a exclusão do usuário abaixo. Esta ação não pode ser desfeita.
        </div>

        <div class="card mb-3 shadow-sm border-0" style="max-width: 500px;">
            <div class="card-body">

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div>
                        <h5 class="card-title mb-0"><?= htmlspecialchars(setValue('nome')) ?></h5>
                        <small class="text-muted"><?= htmlspecialchars(setValue('email')) ?></small>
                    </div>
                </div>

                <table class="table table-borderless table-sm mb-0 border-top pt-2">
                    <tr>
                        <th width="140" class="text-muted fw-normal">Nome</th>
                        <td><?= htmlspecialchars(setValue('nome')) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">E-mail</th>
                        <td><?= htmlspecialchars(setValue('email')) ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Nível</th>
                        <td><?= htmlspecialchars($aNiveis[setValue('nivel')] ?? '') ?></td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Status</th>
                        <td><?= htmlspecialchars($aStatus[setValue('statusRegistro', 1)] ?? '') ?></td>
                    </tr>
                </table>

            </div>
        </div>

        <form method="POST" action="<?= baseUrl() ?>Usuario/delete" class="text-center mt-4">

            <?= csrfField() ?>

            <input type="hidden" name="id" value="<?= setValue('id', 0) ?>">

            <a href="<?= baseUrl() ?>Usuario/admin" class="btn btn-secondary">
                Voltar
            </a>

            <button type="submit" class="btn btn-danger ms-2">
                Confirmar Exclusão
            </button>

        </form>

    <?php else: ?>

        <form method="POST"
              action="<?= baseUrl() ?>Usuario/<?= $action ?>"
              class="mx-auto"
              style="max-width: 900px;">

            <?= csrfField() ?>

            <input type="hidden" name="id" id="id" value="<?= setValue('id', 0) ?>">

            <div class="row">
                <div class="col-9">
                    <label for="nome">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nome"
                        id="nome"
                        maxlength="60"
                        placeholder="Nome do usuário"
                        value="<?= setValue('nome') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>
                        autofocus>

                    <?= setMsgFilderError('nome') ?>
                </div>

                <div class="col-3">
                    <label for="statusRegistro">Status</label>

                    <select class="form-control"
                            name="statusRegistro"
                            id="statusRegistro"
                            <?= $action === 'view' ? 'disabled' : '' ?>>

                        <option value="">Selecione...</option>

                        <?php foreach ($aStatus as $key => $value): ?>
                            <option value="<?= $key ?>"
                                <?= $key == setValue('statusRegistro', 1) ? 'selected' : '' ?>>
                                <?= $value ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <?= setMsgFilderError('statusRegistro') ?>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-8">
                    <label for="email">E-mail</label>

                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        maxlength="150"
                        placeholder="E-mail do usuário"
                        value="<?= setValue('email') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>>

                    <?= setMsgFilderError('email') ?>
                </div>

                <div class="col-4">
                    <label for="nivel">Nível</label>

                    <select class="form-control"
                            name="nivel"
                            id="nivel"
                            <?= $action === 'view' ? 'disabled' : '' ?>>

                        <option value="">Selecione...</option>

                        <?php foreach ($aNiveis as $key => $value): ?>
                            <option value="<?= $key ?>"
                                <?= $key == setValue('nivel') ? 'selected' : '' ?>>
                                <?= $value ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <?= setMsgFilderError('nivel') ?>
                </div>

            </div>

            <?php if ($action === 'insert' || $action === 'update'): ?>

                <div class="row mt-3">

                    <div class="col-6">

                        <label for="senha">
                            Senha
                            <?php if ($action === 'update'): ?>
                                <small class="text-muted">(deixe em branco para manter a atual)</small>
                            <?php endif; ?>
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            name="senha"
                            id="senha"
                            maxlength="100"
                            placeholder="Senha"
                            <?= $action === 'insert' ? 'required' : '' ?>>

                        <?= setMsgFilderError('senha') ?>

                    </div>

                    <div class="col-6">

                        <label for="confirmarSenha">Confirmar Senha</label>

                        <input
                            type="password"
                            class="form-control"
                            name="confirmarSenha"
                            id="confirmarSenha"
                            maxlength="100"
                            placeholder="Repita a senha"
                            <?= $action === 'insert' ? 'required' : '' ?>>

                        <?= setMsgFilderError('confirmarSenha') ?>

                    </div>

                </div>

                <?= jsPasswordStrength('senha', 'confirmarSenha', $action === 'insert') ?>

            <?php endif; ?>

            <div class="row mt-3">
                <div class="col-12">
                    <?= formButton() ?>
                </div>
            </div>

        </form>

    <?php endif; ?>

</div>