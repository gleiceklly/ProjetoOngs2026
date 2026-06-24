<div class="container py-5" style="max-width:520px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-family:'Merriweather',serif;color:#0d3a4a;">Trocar Senha</h2>
        <a href="<?= baseUrl() ?>" class="btn btn-outline-secondary btn-sm">← Voltar</a>
    </div>

    <?= exibeAlerta() ?>

    <p class="text-muted mb-4">
        Alterando senha de <strong><?= htmlspecialchars($_SESSION['userNome'] ?? '') ?></strong>
    </p>

    <form method="POST" action="<?= baseUrl() ?>Login/atualizarSenha">

        <?= csrfField() ?>

        <div class="mb-3">
            <label for="senhaAtual" class="form-label fw-semibold">Senha Atual</label>
            <input
                type="password"
                class="form-control"
                name="senhaAtual"
                id="senhaAtual"
                placeholder="Digite sua senha atual"
                maxlength="100"
                required
                autofocus>
            <?= setMsgFilderError('senhaAtual') ?>
        </div>

        <div class="mb-3">
            <label for="novaSenha" class="form-label fw-semibold">Nova Senha</label>
            <input
                type="password"
                class="form-control"
                name="novaSenha"
                id="novaSenha"
                placeholder="Mínimo 8 caracteres"
                maxlength="100"
                required>
            <?= setMsgFilderError('novaSenha') ?>
        </div>

        <div class="mb-3">
            <label for="confirmacaoSenha" class="form-label fw-semibold">Confirmação da Nova Senha</label>
            <input
                type="password"
                class="form-control"
                name="confirmacaoSenha"
                id="confirmacaoSenha"
                placeholder="Repita a nova senha"
                maxlength="100"
                required>
            <?= setMsgFilderError('confirmacaoSenha') ?>
        </div>

        <?= jsPasswordStrength('novaSenha', 'confirmacaoSenha', true) ?>

        <div class="mt-4 d-flex gap-2">
            <a href="<?= baseUrl() ?>" class="btn btn-outline-secondary flex-fill">Cancelar</a>
            <button type="submit" class="btn flex-fill" style="background:#1c718d;color:#fff;border-radius:30px;font-weight:600;">Alterar Senha</button>
        </div>

    </form>

</div>
