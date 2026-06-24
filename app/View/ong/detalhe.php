<div class="top-bar">
    <a href="<?= baseUrl() ?>Ong" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Voltar às ONGs
    </a>
</div>

<div class="profile-header">
    <div class="profile-header-inner">
        <div class="profile-top">
            <div class="profile-avatar-wrap">
                <div class="profile-avatar"
                     style="display:flex;align-items:center;justify-content:center;background:#0d3a4a;color:white;font-weight:800;font-size:2.5rem;font-family:'Nunito Sans',sans-serif;">
                    <?= mb_strtoupper(mb_substr($ong['nome'], 0, 1)) ?>
                </div>
                <div class="verified-badge"><i class="fa-solid fa-check"></i></div>
            </div>
            <div class="profile-info">
                <div class="profile-location">
                    <i class="fa-solid fa-location-dot"></i>
                    <?= $ong['cidade'] ?>, <?= $ong['estado'] ?>
                </div>
                <h1 class="profile-name"><?= $ong['nome'] ?></h1>
            </div>
        </div>
    </div>

    <div class="profile-tabs">
        <button class="tab-btn active" onclick="switchTab('sobre', this)">Sobre</button>
        <button class="tab-btn" onclick="switchTab('animais', this)">Animais disponíveis</button>
        <button class="tab-btn" onclick="switchTab('voluntariado', this)">Voluntariado</button>
    </div>
</div>

<div class="main-content">
    <div class="left-col">
        <div id="tab-sobre" class="tab-content active">
            <div class="card">
                <div class="card-title"><i class="fa-solid fa-circle-info"></i> Sobre a Associação</div>
                <div class="about-text">
                    <?php if (!empty($ong['descricao'])): ?>
                        <?php foreach (explode("\n", $ong['descricao']) as $paragrafo): ?>
                            <?php if (trim($paragrafo) !== ''): ?>
                                <p><?= trim($paragrafo) ?></p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Descrição em breve.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-title"><i class="fa-solid fa-paw"></i> Alguns animais disponíveis</div>
                <?php $preview = array_slice($animais, 0, 4); ?>
                <?php if (!empty($preview)): ?>
                <div class="animals-mini-grid">
                    <?php foreach ($preview as $a): ?>
                    <a class="animal-mini-card" href="<?= baseUrl() ?>Adocao/show/detalhe/<?= $a['id'] ?>">
                        <?php if (!empty($a['foto'])): ?>
                        <img src="<?= $a['foto'] ?>" alt="<?= $a['nome'] ?>" loading="lazy" onerror="this.style.display='none'">
                        <?php else: ?>
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#1c718d,#86c7df);display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-paw" style="color:rgba(255,255,255,0.4);font-size:2rem;"></i>
                        </div>
                        <?php endif; ?>
                        <div class="animal-mini-overlay">
                            <span class="animal-mini-name"><?= $a['nome'] ?></span>
                            <span class="animal-mini-sub"><?= $a['especie'] ?> · <?= $a['sexo'] ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                    <?php if (count($animais) > 4): ?>
                    <a class="see-all-animals" href="javascript:void(0)"
                       onclick="document.querySelectorAll('.tab-btn')[1].click()">
                        Ver todos os <?= count($animais) ?> animais →
                    </a>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <p style="font-size:0.85rem;color:var(--muted);">Nenhum animal cadastrado ainda.</p>
                <?php endif; ?>
            </div>
        </div>

        <div id="tab-animais" class="tab-content">
            <div class="card">
                <div class="card-title"><i class="fa-solid fa-paw"></i> Animais disponíveis para adoção</div>
                <?php if (!empty($animais)): ?>
                <div class="animals-mini-grid"
                     style="grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:14px;margin-top:12px;">
                    <?php foreach ($animais as $a): ?>
                    <a class="animal-mini-card" href="<?= baseUrl() ?>Adocao/show/detalhe/<?= $a['id'] ?>">
                        <?php if (!empty($a['foto'])): ?>
                        <img src="<?= $a['foto'] ?>" alt="<?= $a['nome'] ?>" loading="lazy" onerror="this.style.display='none'">
                        <?php else: ?>
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#1c718d,#86c7df);display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-paw" style="color:rgba(255,255,255,0.4);font-size:2rem;"></i>
                        </div>
                        <?php endif; ?>
                        <div class="animal-mini-overlay">
                            <span class="animal-mini-name"><?= $a['nome'] ?></span>
                            <span class="animal-mini-sub"><?= $a['especie'] ?> · <?= $a['sexo'] ?> · <?= $a['cidade'] ?></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p style="font-size:0.85rem;color:var(--muted);margin-top:8px;">Esta ONG não tem animais disponíveis no momento.</p>
                <?php endif; ?>
            </div>
        </div>

        <div id="tab-voluntariado" class="tab-content">
            <div class="card">
                <div class="card-title"><i class="fa-solid fa-hands-helping"></i> Vagas de voluntariado</div>
                <p style="font-size:0.85rem;color:var(--muted);">Em breve, vagas disponíveis.</p>
            </div>
        </div>
    </div>

    <div class="right-col">
        <div class="card">
            <div class="card-title"><i class="fa-solid fa-address-book"></i> Contato</div>
            <ul class="contact-list">
                <li class="contact-item">
                    <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <span class="contact-label">Localização</span>
                        <span class="contact-value"><?= $ong['cidade'] ?>, <?= $ong['estado'] ?></span>
                    </div>
                </li>
                <?php if (!empty($ong['email'])): ?>
                <li class="contact-item">
                    <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div>
                        <span class="contact-label">Email de contato</span>
                        <span class="contact-value">
                            <a href="mailto:<?= $ong['email'] ?>"><?= $ong['email'] ?></a>
                        </span>
                    </div>
                </li>
                <?php endif; ?>
                <?php if (!empty($ong['telefone'])): ?>
                <li class="contact-item">
                    <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <span class="contact-label">Telefone</span>
                        <span class="contact-value"><?= $ong['telefone'] ?></span>
                    </div>
                </li>
                <?php endif; ?>
                <?php if (!empty($ong['site'])): ?>
                <li class="contact-item">
                    <div class="contact-icon"><i class="fa-solid fa-globe"></i></div>
                    <div>
                        <span class="contact-label">Site</span>
                        <span class="contact-value">
                            <a href="<?= $ong['site'] ?>" target="_blank" rel="noopener"><?= $ong['site'] ?></a>
                        </span>
                    </div>
                </li>
                <?php endif; ?>
            </ul>

            <div class="divider"></div>

            <div class="card-title" style="margin-bottom:12px;"><i class="fa-solid fa-share-nodes"></i> Redes sociais</div>
            <div class="social-row">
                <p style="font-size:0.8rem;color:var(--muted);">Em breve.</p>
            </div>
        </div>

        <?php if (!empty($ong['email'])): ?>
        <div class="card" style="background:var(--teal);text-align:center;padding:28px 20px;">
            <i class="fa-solid fa-heart" style="color:rgba(255,255,255,0.5);font-size:1.8rem;display:block;margin-bottom:10px;"></i>
            <h3 style="font-family:'Nunito Sans',sans-serif;font-weight:800;color:white;font-size:1rem;margin-bottom:8px;">Quer adotar um animal?</h3>
            <p style="font-size:0.8rem;color:rgba(255,255,255,0.8);line-height:1.5;margin-bottom:16px;">Entre em contato com a ONG e inicie o processo de adoção responsável.</p>
            <button class="btn-primary" onclick="openAdoptModal()" style="margin:0 auto;background:var(--yellow);color:var(--teal-dark);font-size:0.85rem;">
                <i class="fa-solid fa-paw"></i> Quero adotar
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal-overlay" id="adoptModal" onclick="handleOverlayClick(event)">
    <div class="modal-box">
        <div class="modal-header">
            <button class="modal-close" onclick="closeAdoptModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="modal-header-paw">
                <i class="fa-solid fa-paw"></i>
            </div>
            <h2>Entre em contato para adotar!</h2>
            <p>Escolha como prefere falar com a equipe de <?= $ong['nome'] ?></p>
        </div>

        <div class="modal-body">
            <p class="modal-label">Canais de contato</p>

            <?php if (!empty($ong['email'])): ?>
            <a href="mailto:<?= $ong['email'] ?>" class="contact-btn">
                <div class="contact-btn-icon email">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="contact-btn-info">
                    <span class="contact-btn-name">E-mail</span>
                    <span class="contact-btn-detail"><?= $ong['email'] ?></span>
                </div>
                <i class="fa-solid fa-arrow-right contact-btn-arrow"></i>
            </a>
            <?php endif; ?>

            <?php if (!empty($ong['site'])): ?>
            <a href="<?= $ong['site'] ?>" target="_blank" rel="noopener" class="contact-btn">
                <div class="contact-btn-icon" style="background:#555;">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <div class="contact-btn-info">
                    <span class="contact-btn-name">Site</span>
                    <span class="contact-btn-detail"><?= $ong['site'] ?></span>
                </div>
                <i class="fa-solid fa-arrow-right contact-btn-arrow"></i>
            </a>
            <?php endif; ?>

            <p class="modal-note">
                <i class="fa-solid fa-circle-info" style="color:var(--teal-light);"></i>
                A adoção é responsável e gratuita. A ONG irá orientar todo o processo.
            </p>
        </div>
    </div>
</div>

<script src="/assets/js/ong.js"></script>
