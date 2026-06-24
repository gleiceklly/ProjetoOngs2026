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

            <h2>Recuperar Senha</h2>
            <p class="login-subtitle">Informe seu e-mail cadastrado para receber o link de recuperação.</p>

            <?= exibeAlerta() ?>

            <form method="POST" action="<?= baseUrl() ?>Login/enviarLinkRecuperacao">

                <?= csrfField() ?>

                <div class="mb-3">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        placeholder="seu@email.com"
                        value="<?= setValue('email') ?>"
                        required
                        autofocus>
                    <?= setMsgFilderError('email') ?>
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn-login">Enviar Link de Recuperação</button>
                </div>

                <div class="login-footer-links">
                    <a href="<?= baseUrl() ?>Login">← Voltar ao Login</a>
                </div>

            </form>

        </div>

    </div>

</div>
