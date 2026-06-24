<div class="login-split">
    <div class="login-brand-panel">
        <div class="brand-logo"><i class="fa-solid fa-paw"></i> Patas<span>doBem</span></div>

        <h1 class="brand-headline">Conectando<br>animais e<br>pessoas com amor</h1>

        <p class="brand-description">
            Ajude ONGs, adote um pet, seja voluntário ou faça uma doação.
            Juntos podemos transformar a vida de muitos animais abandonados.
        </p>
    </div>

    <div class="login-form-panel">

        <div class="login-card">

            <h2>Bem-vindo de volta!</h2>
            <p class="login-subtitle">Preencha seus dados de acesso para entrar.</p>

            <?= exibeAlerta() ?>

            <form method="POST" action="<?= baseUrl() ?>Login/signIn">

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

                <div class="mb-4">
                    <label for="senha">Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        name="senha"
                        id="senha"
                        placeholder="Sua senha"
                        required>
                    <?= setMsgFilderError('senha') ?>
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn-login">Entrar</button>
                </div>

                <div class="login-footer-links">
                    <a href="<?= baseUrl() ?>">← Voltar ao site</a>
                    <a href="<?= baseUrl() ?>Login/esqueciASenha">Esqueci minha senha</a>
                </div>

                <div class="text-center mt-4" style="font-size:0.88rem;color:#6c757d;">
                    Ainda não tem conta?
                    <a href="<?= baseUrl() ?>Login/cadastro" style="color:#1c718d;font-weight:600;">Criar conta</a>
                </div>

            </form>

        </div>

    </div>

</div>
