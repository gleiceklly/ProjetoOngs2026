<section class="why-section">
    <div class="why-text">
        <div class="why-label">
            <i class="fa-solid fa-paw"></i> Por que apoiar ONGs?
        </div>
        <h2>O trabalho das ONGs <span>salva vidas</span> todos os dias</h2>
        <p>
            No Brasil, estima-se que mais de <strong>30 milhões de animais</strong> vivem em situação de abandono nas ruas. Cães e gatos enfrentam fome, doenças, maus-tratos e acidentes sem nenhuma proteção.
        </p>
        <p>
            As ONGs de proteção animal são a linha de frente nessa luta. São voluntários que resgatam, veterinários que tratam sem cobrar, lares temporários que acolhem e famílias que se tornam eternas. Sem elas, esses animais simplesmente não teriam chance.
        </p>
        <p>
            Ao adotar por meio de uma ONG parceira, você não apenas dá um lar, você libera espaço para que outro animal seja salvo. É uma corrente de amor que não para.
        </p>
    </div>
    <div class="blob-container">
        <div class="circle-container">
            <img src="/assets/img/doguinhoAdotado.png" alt="Voluntária cuidando de animais resgatados">
        </div>
    </div>
</section>

<div class="search-area">
    <div class="search-bar-wrap">
        <div class="search-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="search-input" id="searchInput"
                   placeholder="Buscar ONG por nome ou cidade…"
                   value="<?= $busca ?>">
        </div>
        <button class="btn-buscar" id="btnBuscar">
            <i class="fa-solid fa-magnifying-glass"></i> Buscar
        </button>
    </div>
</div>

<div class="hero-text">
    <h1>ONGs Parceiras</h1>
    <p>Organizações dedicadas a resgatar, cuidar e encontrar um lar para animais.<br>Conheça, apoie e ajude a espalhar amor!</p>
</div>

<div class="content-wrapper">
    <p class="results-info">
        Mostrando <span id="countVisible">0</span> ONGs
    </p>

    <div class="pet-cards" id="ongGrid">
    <?php foreach ($ongs as $ong): ?>
        <a href="<?= baseUrl() ?>Ong/show/detalhe/<?= $ong['id'] ?>"
            class="pet-card"
            data-nome="<?= strtolower($ong['nome']) ?>"
            data-cidade="<?= strtolower($ong['cidade'] ?? '') ?>">

            <?php
            $fotoOng = !empty($ong['foto'])
                ? '/uploads/ongs/' . $ong['id'] . '/' . $ong['foto']
                : '/assets/img/cachorrinhoFeliz.png';
            ?>

            <img src="<?= $fotoOng ?>"
                alt="<?= $ong['nome'] ?>"
                class="pet-image"
                onerror="this.src='/assets/img/cachorrinhoFeliz.png'">

            <div class="pet-info">
                <h3 class="pet-name"><?= $ong['nome'] ?></h3>

                <p class="pet-location">
                    <i class="fa-solid fa-location-dot"></i>
                    <?= $ong['cidade'] ?>, <?= $ong['estado'] ?>
                </p>

                <p class="pet-description">
                    <?= mb_strimwidth($ong['descricao'] ?? '', 0, 130, '...') ?>
                </p>

                <div class="pet-footer">
                    <span>
                        <i class="fa-solid fa-paw"></i>
                        Apoie essa causa!
                    </span>

                    <span class="btn-ver-ong">
                        Ver ONG <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </div>
            </div>

        </a>
    <?php endforeach; ?>
</div>

    <div class="pagination" id="pagination"></div>
</div>

<script src="/assets/js/ongs.js"></script>
