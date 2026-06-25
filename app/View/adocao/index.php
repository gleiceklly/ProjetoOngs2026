<div class="page-header">
    <div class="textos">
        <h1>
            <i class="fa-solid fa-heart" style="color:var(--teal);margin-right:10px;"></i>
            <span style="color:var(--teal); font-weight: bolder;">Amigos</span><br>
            não se compram
        </h1>
        <p><b>Seu novo melhor amigo(a) está esperando por você!</b></p>
    </div>
    <img class="animalzinho-capa-right" src="/assets/img/amigosnCompra.png">
</div>

<div class="hero-text">
    <h1>Encontre seu mais novo(a) amigo(a)</h1>
    <p>Nosso site está cheio de animaiszinhos ansiosos por uma família.<br>Vem ver!</p>
</div>

<div class="content-wrapper">

    <aside class="filter-sidebar" id="filterSidebar">
        <h2><i class="fa-solid fa-sliders"></i> Filtrar</h2>
        <div class="filter-group">
            <div class="filter-group-label">Espécie</div>
            <div class="filter-options">
                <label class="filter-option">
                    <input type="checkbox" name="especie" value="Gato" id="f-gato">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-cat"></i></span>
                    <span class="filter-option-label">Gato</span>
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="especie" value="Cachorro" id="f-cachorro">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-dog"></i></span>
                    <span class="filter-option-label">Cachorro</span>
                </label>
            </div>
        </div>

        <hr class="filter-divider">

        <div class="filter-group">
            <div class="filter-group-label">Sexo</div>
            <div class="filter-options">
                <label class="filter-option">
                    <input type="checkbox" name="sexo" value="Macho" id="f-macho">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-mars"></i></span>
                    <span class="filter-option-label">Macho</span>
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="sexo" value="Fêmea" id="f-femea">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-venus"></i></span>
                    <span class="filter-option-label">Fêmea</span>
                </label>
            </div>
        </div>

        <hr class="filter-divider">

        <div class="filter-group">
            <div class="filter-group-label">Idade</div>
            <div class="filter-options">
                <label class="filter-option">
                    <input type="checkbox" name="idade" value="Filhote" id="f-filhote">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-star"></i></span>
                    <span class="filter-option-label">Filhote</span>
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="idade" value="Adulto" id="f-adulto">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-circle-dot"></i></span>
                    <span class="filter-option-label">Adulto</span>
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="idade" value="Idoso" id="f-idoso">
                    <span class="filter-checkbox-custom"><i class="fa-solid fa-check"></i></span>
                    <span class="filter-option-icon"><i class="fa-solid fa-heart"></i></span>
                    <span class="filter-option-label">Idoso</span>
                </label>
            </div>
        </div>

        <div class="filter-actions">
            <button class="btn-limpar" id="btnLimpar">
                <i class="fa-solid fa-xmark" style="margin-right:6px;"></i>Limpar filtros
            </button>
            <div id="btnAplicar" hidden></div>
        </div>
    </aside>

    <section class="results-area">

        <button class="filter-toggle-btn" id="filterToggle">
            <i class="fa-solid fa-sliders"></i>
            Filtrar
            <span class="filter-badge-count" id="filterBadge">0</span>
        </button>

        <p class="results-info" id="resultsInfo">
            Mostrando <span id="countVisible">0</span> animais
        </p>

        <div class="animal-grid" id="animalGrid">
            <?php foreach ($animais as $animal): ?>
            <a href="<?= baseUrl() ?>Adocao/show/detalhe/<?= $animal['id'] ?>"
               class="animal-card"
               data-tipo="<?= htmlspecialchars($animal['especie'], ENT_QUOTES) ?>"
               data-sexo="<?= htmlspecialchars($animal['sexo'], ENT_QUOTES) ?>"
               data-idade="<?= htmlspecialchars($animal['fase_vida'], ENT_QUOTES) ?>"
               data-nome="<?= htmlspecialchars($animal['nome'], ENT_QUOTES) ?>">
                <img src="<?= htmlspecialchars($animal['foto'] ?? '', ENT_QUOTES) ?>"
                     alt="<?= htmlspecialchars($animal['nome'], ENT_QUOTES) ?>"
                     loading="lazy"
                     onerror="this.style.display='none'">
                <div class="card-body">
                    <h3><?= htmlspecialchars($animal['nome']) ?></h3>
                    <p><?= htmlspecialchars($animal['cidade']) ?>, <?= htmlspecialchars($animal['estado']) ?></p>
                    <span class="card-badge">
                        <i class="fa-solid fa-<?= $animal['especie'] === 'Gato' ? 'cat' : 'dog' ?>"></i>
                        <?= htmlspecialchars($animal['especie']) ?> · <?= htmlspecialchars($animal['sexo']) ?> · <?= htmlspecialchars($animal['fase_vida']) ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>

            <?php if (empty($animais)): ?>
            <div class="empty-state">
                <i class="fa-solid fa-paw"></i>
                <p>Nenhum animal disponível no momento. Volte em breve!</p>
            </div>
            <?php endif; ?>
        </div>

    </section>
</div>

<script src="/assets/js/adocao.js"></script>
