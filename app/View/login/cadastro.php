<div class="login-split">

    <!-- Painel esquerdo: branding -->
    <div class="login-brand-panel">

        <div class="brand-logo"><i class="fa-solid fa-paw"></i> Patas<span>doBem</span></div>

        <h1 class="brand-headline">Crie sua<br>conta e faça<br>a diferença</h1>

        <p class="brand-description">
            Com uma conta no Patas do Bem você pode acompanhar adoções,
            se inscrever como voluntário e ajudar ONGs de animais da sua cidade.
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

            <h2>Criar conta</h2>
            <p class="login-subtitle">Preencha os campos abaixo para se cadastrar.</p>

            <?= exibeAlerta() ?>

            <form method="POST" action="<?= baseUrl() ?>Login/cadastrar">

                <?= csrfField() ?>

                <div class="mb-3">
                    <label for="nome">Nome completo</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nome"
                        id="nome"
                        placeholder="Seu nome completo"
                        value="<?= setValue('nome') ?>"
                        minlength="3"
                        maxlength="60"
                        required
                        autofocus>
                    <?= setMsgFilderError('nome') ?>
                </div>

                <div class="mb-3">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        placeholder="seu@email.com"
                        value="<?= setValue('email') ?>"
                        maxlength="150"
                        required>
                    <?= setMsgFilderError('email') ?>
                </div>

                <div class="mb-3">
                    <label for="senha">Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        name="senha"
                        id="senha"
                        placeholder="Mínimo 8 caracteres"
                        maxlength="100"
                        required>
                    <?= setMsgFilderError('senha') ?>
                </div>

                <div class="mb-3">
                    <label for="confirmarSenha">Confirmar senha</label>
                    <input
                        type="password"
                        class="form-control"
                        name="confirmarSenha"
                        id="confirmarSenha"
                        placeholder="Repita a senha"
                        maxlength="100"
                        required>
                    <?= setMsgFilderError('confirmarSenha') ?>
                </div>

                <?= jsPasswordStrength('senha', 'confirmarSenha', true) ?>

                <div class="mt-4 mb-2">
                    <button type="submit" class="btn-login">Criar conta</button>
                </div>

                <div class="login-footer-links">
                    <a href="<?= baseUrl() ?>">← Voltar ao site</a>
                    <a href="<?= baseUrl() ?>Login">Já tenho conta</a>
                </div>

            </form>

        </div>

    </div>

</div>
