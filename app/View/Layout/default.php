<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/styles/stylesCachorrinhos.css">
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
                    <a class="nav-link" href="/voluntarios">Voluntários</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/ongs">Ongs</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/adocao">Adoção</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/doacoes">Doações</a>
                </li>
            </ul>

            <div class="d-flex gap-2">

                <a href="/login" class="btn btn-outline-teal btn-sm">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>

                <a href="/cadastro" class="btn btn-teal btn-sm">
                    <i class="fa-solid fa-user-plus"></i> Cadastro
                </a>

            </div>

        </div>
    </div>
</nav>

<main>
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