<div class="page-header">
    <a href="<?= baseUrl() ?>" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Voltar ao início
    </a>
</div>

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

    <div class="ong-grid" id="ongGrid">
        <?php foreach ($ongs as $ong): ?>
        <a href="<?= baseUrl() ?>Ong/show/detalhe/<?= $ong['id'] ?>"
           class="ong-card"
           data-nome="<?= strtolower($ong['nome']) ?>"
           data-cidade="<?= strtolower($ong['cidade'] ?? '') ?>">

            <div class="ong-card-banner"
                 style="background:linear-gradient(135deg,#1c718d 0%,#86c7df 100%);height:120px;display:block;width:100%;"></div>

            <div class="ong-card-header">
                <div class="ong-avatar"
                     style="display:flex;align-items:center;justify-content:center;background:#0d3a4a;color:#fff;font-weight:800;font-size:1.2rem;font-family:'Nunito Sans',sans-serif;">
                    <?= mb_strtoupper(mb_substr($ong['nome'], 0, 1)) ?>
                </div>
                <div class="ong-name-wrap">
                    <h3><?= $ong['nome'] ?></h3>
                    <div class="ong-location">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= $ong['cidade'] ?>, <?= $ong['estado'] ?>
                    </div>
                </div>
            </div>

            <div class="ong-card-body">
                <p class="ong-desc"><?= mb_strimwidth($ong['descricao'] ?? '', 0, 130, '…') ?></p>
                <div class="ong-badges"></div>
                <div class="ong-card-footer">
                    <span class="ong-animals-count">
                        <i class="fa-solid fa-paw"></i> Apoie essa causa!
                    </span>
                    <button class="btn-ver-ong">
                        Ver ONG <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="pagination" id="pagination"></div>
</div>

<script src="/assets/js/ongs.js"></script>
