<header class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>Patas do Bem</h1>
            <p>
                Apoie nossas ongs para que continuem com esse trabalho lindo. 
                Seja voluntário e ajude nossos amiguinhos.
            </p>
            <div class="hero-buttons">
                <a href="#voluntario" class="btn btn-teal">
                    Voluntariar-se <i class="fa-solid fa-chevron-right"></i>
                </a>
                <a href="#adocao" class="btn btn-outline-custom">
                    Adote <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="hero-image-container">
        <img src="/assets/img/cachorrinhoLingua.png" class="dog-left" alt="">
        <img src="/assets/img/cachorrinhoFeliz.png" class="dog-right" alt="">
    </div>
</header>

<div class="container service-icon-bar">
    <div class="service-bar-inner">
        <a href="/voluntario" class="service-item"><i class="fa-solid fa-stethoscope"></i> Voluntários <i class="fa-solid fa-chevron-right chevron"></i></a>
        <a href="/Ong" class="service-item"><i class="fa-solid fa-house"></i> Ongs <i class="fa-solid fa-chevron-right chevron"></i></a>
        <a href="/adocao" class="service-item"><i class="fa-solid fa-bone"></i> Adoção <i class="fa-solid fa-chevron-right chevron"></i></a>
        <a href="/doacao" class="service-item"><i class="fa-brands fa-gratipay"></i> Doações <i class="fa-solid fa-chevron-right chevron"></i></a>
    </div>
</div>

<section id="voluntario" class="container split-section">
    <div class="text-content">
        <h2 class="section-title">Seja um Voluntário,<br>ajude os animais</h2>
        <p class="strong-text">Ser voluntário em uma ONG de animais não muda só a vida deles, muda a sua também! Cada cuidado, cada carinho e cada resgate é uma chance real de transformar abandono em amor.</p>
        <p>Doações também são bem-vindas!</p>
        <div class="action-links">
            <a href="/voluntario" class="btn btn-teal">Voluntariar-se<i class="fa-solid fa-chevron-right"></i></a>
            <a href="/doacao" class="text-link">Doações <i class="fa-solid fa-chevron-right"></i></a>
        </div>
    </div>
    <div class="image-content" style="position: relative;">
        <div class="blob-container">
            <img src="/assets/img/cachorinhoCima.png" class="blob-img">
        </div>
    </div>
</section>

<section class="pets-section">
    <div class="section">
        <h2 class="section-title" style="color: #1c718d;"><i class="fa-solid fa-paw"></i> Nossas Ongs <i class="fa-solid fa-paw"></i></h2><br>

        <div class="carousel-wrapper">
            <button class="arrow-btn" id="arrowLeft" onclick="moveCarousel(-1)" aria-label="Anterior"><i class="fa-solid fa-paw"></i></button>

            <div class="pet-cards" id="petCarousel">
                <?php foreach ($ongs as $ong): ?>
                <div class="pet-card">
                    <?php $fotoOng = !empty($ong['foto']) ? '/uploads/ongs/' . $ong['id'] . '/' . $ong['foto'] : '/assets/img/cachorrinhoFeliz.png'; ?>
                    <img src="<?= $fotoOng ?>" alt="<?= $ong['nome'] ?>" class="pet-image" onerror="this.src='/assets/img/cachorrinhoFeliz.png'">
                    <div class="pet-info">
                        <h3 class="pet-name"><?= $ong['nome'] ?></h3>
                        <p class="pet-description"><?= $ong['descricao'] ?></p>
                        <ul class="pet-details">
                            <li><i class="fa-brands fa-instagram"></i><a href="https://www.instagram.com/<?= $ong['instagram'] ?>/" target="_blank"> @<?= $ong['instagram'] ?></a></li>
                        </ul>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="arrow-btn" id="arrowRight" onclick="moveCarousel(1)" aria-label="Próximo"><i class="fa-solid fa-paw"></i></button>
        </div>

        <div class="buttons">
            <a href="/Ong" class="blob-btn" style="text-decoration: none;">
                Ver todas as Ongs
                <span class="blob-btn__inner">
                    <span class="blob-btn__blobs">
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                        <span class="blob-btn__blob"></span>
                    </span>
                </span>
            </a>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
            <defs>
                <filter id="goo">
                <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10"></feGaussianBlur>
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo"></feColorMatrix>
                <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                </filter>
            </defs>
        </svg>
    </div>

    <div class="ticker-wrap">
        <div class="ticker" style="font-weight: bolder;">
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
            <div class="ticker-item"><i class="fa-solid fa-paw"></i> FAÇA UMA DOAÇÃO <i class="fa-solid fa-paw"></i> SALVE OS BICHINHOS <i class="fa-solid fa-paw"></i></div>
        </div>
    </div>
</section>

<section id="adocao" class="container split-section flex-reverse" style="margin-top: -200px;">
    <div class="text-content">
        <h2 class="section-title">Não compre, adote!</h2>
        <p>
            Adoção é um ato de amor e reparação. Antes de comprar, vasculhe nosso site e encontre um amigo esperando por um lar cheio de carinho. Dê a eles uma chance de serem felizes e faça a diferença na vida de um pet abandonado.
        </p>
        <div class="action-links">
            <a href="/Adocao" class="btn-adotar btn--adotar">Adotar</a>
        </div>
    </div>
    <div class="image-content">
        <div class="circle-container">
            <img src="/assets/img/carinhoGatinho.png" class="cover-img" alt="Golden Retriever">
        </div>
    </div>
</section>

<?php if (!empty($animais)): ?>
<script>
(function () {
    var list = <?= json_encode(array_values(array_map(function ($a) {
        return [
            'foto'    => $a['foto']    ?? '',
            'nome'    => $a['nome'],
            'especie' => $a['especie'],
            'sexo'    => $a['sexo'],
            'cidade'  => $a['cidade'],
            'estado'  => $a['estado'],
            'id'      => (int) $a['id'],
        ];
    }, $animais)), JSON_UNESCAPED_UNICODE) ?>;

    var img  = document.getElementById('animal-img');
    var desc = document.getElementById('animal-desc');
    var info = document.getElementById('animal-info');
    if (!img || !list.length) return;

    var idx = 0;
    function show(i) {
        var a = list[i];
        img.src = a.foto || '/assets/img/cachorrinhoFeliz.png';
        img.onerror = function () { this.onerror = null; this.src = '/assets/img/cachorrinhoFeliz.png'; };
        desc.textContent = a.nome + ' — ' + a.especie + ' · ' + a.sexo;
        info.textContent = a.cidade + ', ' + a.estado;
    }
    show(0);

    var prevBtn = document.getElementById('prev');
    var nextBtn = document.getElementById('next');
    if (prevBtn) prevBtn.addEventListener('click', function () { idx = (idx - 1 + list.length) % list.length; show(idx); });
    if (nextBtn) nextBtn.addEventListener('click', function () { idx = (idx + 1) % list.length; show(idx); });

    setInterval(function () { idx = (idx + 1) % list.length; show(idx); }, 5000);
})();
</script>
<?php endif; ?>