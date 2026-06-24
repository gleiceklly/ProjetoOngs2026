<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= \Core\Library\Csrf::getToken() ?>">
    <title><?= $titulo ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/styles/stylesCachorrinhos.css">
    <link rel="stylesheet" href="/assets/styles/stylesDefault.css">
    <?= $extraHead ?? '' ?>
</head>
<body>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="container-navbar">

        <a class="navbar-brand logo" href="/">
            <i class="fa-solid fa-paw"></i> Patas do Bem
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuSite">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuSite">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/voluntario">Voluntários</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/Ong">Ongs</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/adocao">Adoção</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/doacao">Doações</a>
                </li>

                <?php
                $sessNivel  = (int) \Core\Library\Session::get('userNivel');
                $sessLogado = (bool) \Core\Library\Session::get('userId');
                ?>

                <?php if ($sessLogado && $sessNivel <= NIVEL_ADMIN): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuAdmin"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-gauge-high"></i> Administração
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menuAdmin">
                            <li><a class="dropdown-item" href="/Admin">Painel</a></li>
                            <li><a class="dropdown-item" href="/Animal">Animais</a></li>
                            <li><a class="dropdown-item" href="/Vaga">Vagas de Voluntariado</a></li>
                            <li><a class="dropdown-item" href="/Ong/admin">ONGs</a></li>
                            <li><a class="dropdown-item" href="/Voluntario/admin">Voluntários</a></li>
                            <li><a class="dropdown-item" href="/Doacao/admin">Doações</a></li>
                            <?php if ($sessNivel <= NIVEL_SUPER): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/Usuario">Usuários</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php elseif ($sessLogado && $sessNivel === NIVEL_ONG): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-paw"></i> Minha ONG
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/Animal">Meus Animais</a></li>
                            <li><a class="dropdown-item" href="/Vaga">Minhas Vagas</a></li>
                        </ul>
                    </li>
                <?php elseif (!$sessLogado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Ong/form/insert/0">Cadastrar ONG</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex gap-2">

                <?php if (\Core\Library\Session::get('userId')): ?>

                    <span class="btn btn-sm btn-outline-teal disabled">
                        <i class="fa-solid fa-user"></i> <?= htmlspecialchars(\Core\Library\Session::get('userNome')) ?>
                    </span>

                    <a href="/Login/signOut" class="btn btn-teal btn-sm">
                        <i class="fa-solid fa-right-from-bracket"></i> Sair
                    </a>

                <?php else: ?>

                    <a href="/login" class="btn btn-outline-teal btn-sm">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </a>

                    <a href="/Login/cadastro" class="btn btn-teal btn-sm">
                        <i class="fa-solid fa-user-plus"></i> Cadastro
                    </a>

                <?php endif; ?>

            </div>

        </div>
    </div>
</nav>

<main>
    <?= exibeAlerta() ?>
    <?= $content ?>
</main>

<footer class="footer-wave">
    <div class="container">
        <img class="contact-dog" src="/assets/img/afollow.png" alt="AFollow">

        <div class="footer-grid">

            <div class="footer-col">
                <h4>Patas do Bem</h4>
                <p class="section-subtitle">
                    Faculdade Santa Marcelina - Muriaé
                </p>
            </div>

            <div class="footer-col" style="text-align:right;">
                <p>Equipe de Desenvolvimento:</p>
                <h4>Gleicekelly, Silmara, Thaise e Karine</h4>
            </div>

        </div>
    </div>

    <p class="copyright">
        Copyright © 2026. Todos os direitos reservados.
    </p>
</footer>

<script src="/assets/js/cachorrinhos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>