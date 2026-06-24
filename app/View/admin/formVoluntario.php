<?= formTitulo($titulo) ?>

<div class="m-3">

    <?php if ($action === 'delete'): ?>

        <div class="alert alert-danger">
            <strong>Atenção!</strong> Confirme a exclusão do voluntário abaixo. Esta ação não pode ser desfeita.
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($data['nome'] ?? '') ?></h5>
                <p class="card-text">
                    <strong>Função:</strong> <?= htmlspecialchars($data['funcao'] ?? '') ?><br>
                    <strong>E-mail:</strong> <?= htmlspecialchars($data['email'] ?? '') ?><br>
                    <strong>Cidade:</strong> <?= htmlspecialchars($data['cidade'] ?? '') ?>
                </p>
            </div>
        </div>

        <form method="POST" action="<?= baseUrl() ?>Voluntario/delete">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= (int)($data['id'] ?? 0) ?>">
            <a href="<?= baseUrl() ?>Voluntario/admin" class="btn btn-outline-secondary">Voltar</a>
            <button type="submit" class="btn btn-danger ms-2">Confirmar Exclusão</button>
        </form>

    <?php else: ?>

        <form method="POST" action="<?= baseUrl() ?>Voluntario/<?= $action ?>">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= setValue('id', 0) ?>">

            <div class="row">
                <div class="col-9">
                    <label for="nome">Nome Completo</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nome"
                        id="nome"
                        maxlength="100"
                        value="<?= setValue('nome') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>
                        autofocus>
                    <?= setMsgFilderError('nome') ?>
                </div>
                <div class="col-3">
                    <label for="statusRegistro">Status</label>
                    <select class="form-control" name="statusRegistro" id="statusRegistro"
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
                <div class="col-6">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        maxlength="150"
                        value="<?= setValue('email') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>>
                    <?= setMsgFilderError('email') ?>
                </div>
                <div class="col-6">
                    <label for="telefone">Telefone</label>
                    <input
                        type="text"
                        class="form-control"
                        name="telefone"
                        id="telefone"
                        maxlength="20"
                        value="<?= setValue('telefone') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>>
                    <?= setMsgFilderError('telefone') ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <label for="cidade">Cidade</label>
                    <input
                        type="text"
                        class="form-control"
                        name="cidade"
                        id="cidade"
                        value="<?= setValue('cidade') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>>
                    <?= setMsgFilderError('cidade') ?>
                </div>
                <div class="col-6">
                    <label for="funcao">Função Desejada</label>
                    <input
                        type="text"
                        class="form-control"
                        name="funcao"
                        id="funcao"
                        value="<?= setValue('funcao') ?>"
                        <?= $action === 'view' ? 'readonly' : 'required' ?>>
                    <?= setMsgFilderError('funcao') ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <label for="disponibilidade">Disponibilidade</label>
                    <select class="form-control" name="disponibilidade" id="disponibilidade"
                            <?= $action === 'view' ? 'disabled' : '' ?>>
                        <option value="">—</option>
                        <?php foreach (['Finais de semana', 'Dias úteis', 'Período integral', 'Flexível'] as $disp): ?>
                            <option value="<?= $disp ?>"
                                    <?= setValue('disponibilidade') === $disp ? 'selected' : '' ?>>
                                <?= $disp ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="ong_id">ONG</label>
                    <select class="form-control" name="ong_id" id="ong_id"
                            <?= $action === 'view' ? 'disabled' : '' ?> <?= $action !== 'view' ? 'required' : '' ?>>
                        <option value="">Selecione...</option>
                        <?php foreach ($aOngs as $ong): ?>
                            <option value="<?= $ong['id'] ?>"
                                    <?= $ong['id'] == setValue('ong_id') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ong['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= setMsgFilderError('ong_id') ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <?= formButton() ?>
                </div>
            </div>

        </form>

    <?php endif; ?>

</div>
