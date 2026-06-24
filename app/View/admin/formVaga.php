<?= formTitulo($titulo) ?>

<div class="m-3">

    <?php if ($action === 'delete'): ?>

        <div class="alert alert-danger">
            <strong>Atenção!</strong> Confirme a exclusão da vaga abaixo. Esta ação não pode ser desfeita.
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($data['funcao'] ?? '') ?></h5>
                <p class="card-text">
                    <strong>Quantidade:</strong> <?= (int) ($data['quantidade'] ?? 0) ?> vaga(s)<br>
                    <?php if (!empty($data['descricao'])): ?>
                    <strong>Descrição:</strong> <?= htmlspecialchars($data['descricao']) ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <form method="POST" action="<?= baseUrl() ?>Vaga/delete">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= (int) ($data['id'] ?? 0) ?>">
            <a href="<?= baseUrl() ?>Vaga" class="btn btn-outline-secondary">Voltar</a>
            <button type="submit" class="btn btn-danger ms-2">Confirmar Exclusão</button>
        </form>

    <?php else: ?>

        <form method="POST" action="<?= baseUrl() ?>Vaga/<?= $action ?>">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= setValue('id', 0) ?>">

            <div class="row">
                <div class="col-8">
                    <label for="funcao">Função desejada *</label>
                    <input type="text" class="form-control" name="funcao" id="funcao"
                           maxlength="100" required
                           placeholder="Ex: Cuidador(a), Veterinário(a), Social media…"
                           value="<?= setValue('funcao') ?>">
                    <?= setMsgFilderError('funcao') ?>
                </div>
                <div class="col-4">
                    <label for="quantidade">Quantidade de vagas *</label>
                    <input type="number" class="form-control" name="quantidade" id="quantidade"
                           min="1" max="999" required
                           value="<?= setValue('quantidade', 1) ?>">
                    <?= setMsgFilderError('quantidade') ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-8">
                    <label for="ong_id">ONG *</label>
                    <select class="form-control" name="ong_id" id="ong_id" required>
                        <option value="">Selecione…</option>
                        <?php foreach ($aOngs as $ong): ?>
                            <option value="<?= $ong['id'] ?>"
                                    <?= $ong['id'] == setValue('ong_id') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ong['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= setMsgFilderError('ong_id') ?>
                </div>
                <div class="col-4">
                    <label for="statusRegistro">Status</label>
                    <select class="form-control" name="statusRegistro" id="statusRegistro">
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
                <div class="col-12">
                    <label for="descricao">Descrição / observações</label>
                    <textarea class="form-control" name="descricao" id="descricao" rows="3"
                              placeholder="Descreva o que o voluntário irá fazer nesta função…"><?= setValue('descricao') ?></textarea>
                    <?= setMsgFilderError('descricao') ?>
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
