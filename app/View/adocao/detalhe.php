<?php
    $contato = $animal['contato'] ?? '';

    $isEmail = filter_var($contato, FILTER_VALIDATE_EMAIL);
    $isPhone = !$isEmail && preg_match('/\d{8,}/', preg_replace('/\D/', '', $contato));
?>

<div class="breadcrumb">
    <a href="<?= baseUrl() ?>Adocao">Adoção</a>
    <span>›</span>
    <a href="<?= baseUrl() ?>Adocao">Quero adotar</a>
    <span>›</span>
    <span><?= htmlspecialchars($animal['nome']) ?></span>
</div>

<div class="main-wrap">
    <div class="photo-col">
        <img id="animalPhoto"
             src="<?= htmlspecialchars($animal['foto'] ?? '', ENT_QUOTES) ?>"
             alt="<?= htmlspecialchars($animal['nome'], ENT_QUOTES) ?>"
             onerror="this.style.display='none'">
    </div>

    <div class="info-col">
        <h1 id="animalNome" data-nome="<?= htmlspecialchars($animal['nome'], ENT_QUOTES) ?>">
            <?= htmlspecialchars($animal['nome']) ?>
            <span class="fav-icons">
                <i class="fa-regular fa-share-from-square" title="Compartilhar" id="btnShare"></i>
                <i class="fa-regular fa-heart" title="Favoritar" hidden id="btnFav"></i>
            </span>
        </h1>

        <div class="meta-line">
            <span id="animalTipo">
                <?= htmlspecialchars($animal['especie']) ?> ·
                <?= htmlspecialchars($animal['sexo']) ?> ·
                <?= htmlspecialchars($animal['fase_vida']) ?>
                <?php if (!empty($animal['porte'])): ?> · Porte <?= htmlspecialchars($animal['porte']) ?><?php endif; ?>
            </span>
        </div>
        <div class="meta-line loc">
            <i class="fa-solid fa-location-dot"></i>
            <span id="animalLoc">
                <?= htmlspecialchars($animal['cidade']) ?>, <?= htmlspecialchars($animal['estado']) ?>
                <?php if (!empty($animal['bairro'])): ?> – <?= htmlspecialchars($animal['bairro']) ?><?php endif; ?>
            </span>
        </div>
        <div class="meta-line pub">
            <i class="fa-solid fa-paw"></i>
            <span>Cuidado por <strong><?= htmlspecialchars($animal['ong_nome'] ?? 'ONG Parceira') ?> - <?= htmlspecialchars($animal['responsavel'] ?? '') ?></strong></span>
        </div>

        <p class="section-title-sm">
            <i class="fa-solid fa-book-open"></i> A história de <?= htmlspecialchars($animal['nome']) ?>
        </p>
       <div class="story-box" id="storyBox">
            <?=
                nl2br(htmlspecialchars(
                    !empty($animal['historia'])
                        ? $animal['historia']
                        : 'Este animal está esperando por um lar cheio de amor. Entre em contato com a ONG para saber mais!'
                ))
            ?>
        </div>

        <p class="section-title-sm">
            <i class="fa-solid fa-tags"></i> Mais detalhes sobre <?= htmlspecialchars($animal['nome']) ?>
        </p>
        <div class="tags" id="tagsBox">
            <?php if ($animal['vacinado']): ?>
            <span class="tag">Vacinado</span>
            <?php endif; ?>
            <?php if ($animal['castrado']): ?>
            <span class="tag">Castrado</span>
            <?php endif; ?>
            <?php if ($animal['necessidade_especial']): ?>
            <span class="tag red">Necessidade especial</span>
            <?php endif; ?>
            <?php if ($animal['em_tratamento']): ?>
            <span class="tag red">Em tratamento</span>
            <?php endif; ?>
            <?php if (!$animal['vacinado'] && !$animal['castrado'] && !$animal['necessidade_especial'] && !$animal['em_tratamento']): ?>
            <span class="tag">Aguardando avaliação</span>
            <?php endif; ?>
        </div>

        <?php if (!empty($animal['obs_saude'])): ?>
        <p class="section-title-sm" style="margin-top:16px;">
            <i class="fa-solid fa-stethoscope"></i> Observações de saúde
        </p>
        <div class="story-box">
            <?= nl2br(htmlspecialchars($animal['obs_saude'])) ?>
        </div>
        <?php endif; ?>

        <button class="btn-adopt" id="btnAdotar">
            <i class="fa-solid fa-heart"></i> Quero adotar
        </button>
    </div>
</div>

<?php if (!empty($outros)): ?>
<div class="others-wrap">
    <h2><i class="fa-solid fa-paw"></i> Outros peludos esperando seu clique</h2>
    <div class="others-grid" id="othersGrid">
        <?php foreach ($outros as $outro): ?>
        <a class="other-card" href="<?= baseUrl() ?>Adocao/show/detalhe/<?= $outro['id'] ?>">
            <img src="<?= htmlspecialchars($outro['foto'] ?? '', ENT_QUOTES) ?>"
                 alt="<?= htmlspecialchars($outro['nome'], ENT_QUOTES) ?>"
                 loading="lazy"
                 onerror="this.style.display='none'">
            <div class="other-card-body">
                <h4><?= htmlspecialchars($outro['nome']) ?></h4>
                <p><?= htmlspecialchars($outro['cidade']) ?>, <?= htmlspecialchars($outro['estado']) ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <button class="modal-close" id="modalClose" aria-label="Fechar">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-icon-wrap">
            <i class="fa-solid fa-paw"></i>
        </div>

        <h2 id="modalTitle" style="align-items: center; text-align: center;">Adotar é salvar, proteger e amar.</h2><br>

        <p class="modal-contact-label">Entre em contato com o protetor - Contato do responsável</p>

        <div class="modal-contact-list">
            <?php if ($isEmail): ?>
                <a class="modal-contact-item"
                href="mailto:<?= htmlspecialchars($contato, ENT_QUOTES) ?>">
                    <div class="contact-icon email"><i class="fa-solid fa-envelope"></i></div>
                    <div class="contact-info">
                        <small>E-mail</small>
                        <span><?= htmlspecialchars($contato) ?></span>
                    </div>
                </a>
            <?php endif; ?>

            <?php if ($isPhone): ?>
                <?php $phone = preg_replace('/\D/', '', $contato); ?>
                <a class="modal-contact-item"
                href="https://wa.me/55<?= $phone ?>"
                target="_blank" rel="noopener noreferrer">
                    <div class="contact-icon whatsapp"><i class="fa-brands fa-whatsapp"></i></div>
                    <div class="contact-info">
                        <small>WhatsApp</small>
                        <span><?= htmlspecialchars($contato) ?></span>
                    </div>
                </a>
            <?php endif; ?>

            <?php if (empty($isEmail) && empty($isPhone)): ?>
                <p style="color:var(--muted);font-size:0.9rem;text-align:center;padding:12px 0;">
                    Entre em contato com a ONG <strong><?= htmlspecialchars($animal['ong_nome'] ?? '') ?></strong> para mais informações.
                </p>
            <?php endif; ?>
        </div>

        <br> <hr> <br>

        <p class="modal-contact-label">Contato da Ong</p>

        <div class="modal-contact-list">
            <?php if (!empty($animal['ong_email'])): ?>
            <a class="modal-contact-item" href="mailto:<?= htmlspecialchars($animal['ong_email'], ENT_QUOTES) ?>">
                <div class="contact-icon email"><i class="fa-solid fa-envelope"></i></div>
                <div class="contact-info">
                    <small>E-mail</small>
                    <span><?= htmlspecialchars($animal['ong_email']) ?></span>
                </div>
            </a>
            <?php endif; ?>
            <?php if (!empty($animal['ong_telefone'])): ?>
            <a class="modal-contact-item"
               href="https://wa.me/55<?= preg_replace('/\D/', '', $animal['ong_telefone']) ?>"
               target="_blank" rel="noopener noreferrer">
                <div class="contact-icon whatsapp"><i class="fa-brands fa-whatsapp"></i></div>
                <div class="contact-info">
                    <small>WhatsApp</small>
                    <span><?= htmlspecialchars($animal['ong_telefone']) ?></span>
                </div>
            </a>
            <?php endif; ?>
            <?php if (empty($animal['ong_email']) && empty($animal['ong_telefone'])): ?>
            <p style="color:var(--muted);font-size:0.9rem;text-align:center;padding:12px 0;">
                Entre em contato com a ONG <strong><?= htmlspecialchars($animal['ong_nome'] ?? '') ?></strong> para mais informações.
            </p>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <button class="btn-cancelar" id="btnCancelar">Cancelar</button>
        </div>
    </div>
</div>

<div class="share-overlay" id="shareOverlay">
    <div class="share-card" role="dialog" aria-modal="true" aria-label="Compartilhar animal">
        <button class="modal-close" id="shareClose" aria-label="Fechar">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-icon-wrap">
            <i class="fa-solid fa-share-nodes"></i>
        </div>

        <h2>Compartilhe e ajude!</h2>
        <p>Quanto mais pessoas virem, mais chances de adoção</p>

        <div class="share-options" id="shareOptions"></div>

        <div class="share-divider">ou copie o link</div>

        <div class="share-link-row">
            <input type="text" class="share-link-input" id="shareLinkInput" readonly>
            <button class="btn-copy" id="btnCopy">
                <i class="fa-regular fa-copy"></i> Copiar
            </button>
        </div>
    </div>
</div>

<div class="toast" id="toast">
    <i class="fa-solid fa-check"></i>
    <span id="toastMsg">Link copiado!</span>
</div>

<script src="/assets/js/animais.js"></script>
