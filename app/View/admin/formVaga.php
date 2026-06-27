<h1 style="padding-top: 55px; display: flex; justify-content: center; color: #86c7df"><i class="fa-solid fa-paw"></i> Vagas <i class="fa-solid fa-paw"></i></h1>

<form method="POST" action="<?= baseUrl() ?>Vaga/<?= $action ?>">
    <?= csrfField() ?>
    <input type="hidden" name="id" value="<?= setValue('id', 0) ?>">

    <div class="container-fluid px-4">
        <div class="row g-3 px-5">
            <div class="col-md-3">
                <label for="funcao" class="form-label">Função desejada *</label>
                <input
                    type="text"
                    class="form-control"
                    name="funcao"
                    id="funcao"
                    maxlength="100"
                    required
                    placeholder="Ex: Veterinário(a)"
                    value="<?= setValue('funcao') ?>">
                <?= setMsgFilderError('funcao') ?>
            </div>

            <div class="col-md-3">
                <label for="quantidade" class="form-label">Quantidade de vagas *</label>
                <input
                    type="number"
                    class="form-control"
                    name="quantidade"
                    id="quantidade"
                    min="1"
                    max="999"
                    required
                    value="<?= setValue('quantidade', 1) ?>">
                <?= setMsgFilderError('quantidade') ?>
            </div>

            <div class="col-md-3">
                <label for="ong_id" class="form-label">ONG *</label>
                <select class="form-control" name="ong_id" id="ong_id" required>
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

            <div class="col-md-3">
                <label for="statusRegistro" class="form-label">Status</label>
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

            <div class="col-12">
                <label for="descricao" class="form-label">Descrição da vaga</label>
                <textarea
                    class="form-control"
                    name="descricao"
                    id="descricao"
                    rows="4"
                    placeholder="Descreva as atividades, requisitos e observações da vaga..."><?= setValue('descricao') ?></textarea>
                <?= setMsgFilderError('descricao') ?>
            </div>

            <div class="col-12">
                <?= formButton() ?>
            </div>
        </div>
    </div>
</form>