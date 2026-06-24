<div class="login-split">

    <!-- Painel esquerdo: branding -->
    <div class="login-brand-panel">

        <div class="brand-logo"><i class="fa-solid fa-paw"></i> Patas<span>doBem</span></div>

        <h1 class="brand-headline">Conectando<br>animais e<br>pessoas com amor</h1>

        <p class="brand-description">
            Ajude ONGs, adote um pet, seja voluntário ou faça uma doação.
            Juntos podemos transformar a vida de muitos animais abandonados.
        </p>

        <div class="brand-tags">
            <span class="brand-tag">Adoção</span>
            <span class="brand-tag">Voluntariado</span>
            <span class="brand-tag">Doações</span>
            <span class="brand-tag">ONGs</span>
        </div>

    </div>

    <!-- Painel direito: formulário -->
    <div class="login-form-panel">

        <div class="login-card">

            <h2>Redefinir Senha</h2>
            <p class="login-subtitle">Crie uma nova senha segura para sua conta.</p>

            <?= exibeAlerta() ?>

            <form method="POST" action="<?= baseUrl() ?>Login/salvarNovaSenha">

                <?= csrfField() ?>

                <input type="hidden" name="chave" value="<?= htmlspecialchars($data['chave'] ?? setValue('chave'), ENT_QUOTES) ?>">

                <div class="mb-3">
                    <label for="novaSenha">Nova Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        name="novaSenha"
                        id="novaSenha"
                        placeholder="Mínimo 8 caracteres"
                        maxlength="100"
                        required
                        autofocus>
                    <?= setMsgFilderError('novaSenha') ?>
                </div>

                <div class="mb-3">
                    <label for="confirmacaoSenha">Confirmação da Nova Senha</label>
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

                <div class="mt-4 mb-2">
                    <button type="submit" class="btn-login">Redefinir Senha</button>
                </div>

                <div class="login-footer-links">
                    <a href="<?= baseUrl() ?>Login">← Voltar ao Login</a>
                </div>

            </form>

        </div>

    </div>

</div>
