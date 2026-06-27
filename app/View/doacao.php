<?php
$formErrors = \Core\Library\Session::getDestroy('formErrors') ?? [];
$prevInput  = \Core\Library\Session::getDestroy('formInputs') ?? [];
?>

<div class="page-header">
    <h1><i class="fa-solid fa-heart" style="color:#fcd444;margin-right:10px;"></i>Faça uma Doação</h1>
    <p>Sua contribuição transforma vidas. Escolha uma causa e ajude a fazer a diferença.</p>
    <img class="capaDoacao" src="/assets/img/capaDoacao.png">
</div>

<div class="container">
    <?= exibeAlerta() ?>
    <?php if (!empty($formErrors)): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach ($formErrors as $erro): ?>
            <li><?= $erro ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?= baseUrl() ?>Doacao/insert" id="formDoacao">

        <?= csrfField() ?>
        <input type="hidden" name="ong_id"          id="hidden-ong-id"          value="">
        <input type="hidden" name="valor"            id="hidden-valor"            value="">
        <input type="hidden" name="forma_pagamento"  id="hidden-forma-pagamento"  value="pix">

        <div class="section">
            <div class="section-label-plano"><i class="fa-solid fa-paw"></i> Área de Doações</div>

            <div class="donation-list" id="donationList">

                <?php if (empty($ongs)): ?>
                <p style="color:var(--text-muted);text-align:center;padding:2rem 0;">Nenhuma ONG disponível no momento.</p>
                <?php else: ?>
                <?php foreach ($ongs as $ong): ?>
                <div class="donation-card"
                    data-ong-id="<?= (int) $ong['id'] ?>"
                    data-pix="<?= htmlspecialchars($ong['pix'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    data-nome="<?= htmlspecialchars($ong['nome'], ENT_QUOTES, 'UTF-8') ?>"
                    onclick="selectCard(this)">
                    <img class="donation-card__img"
                         src="<?= htmlspecialchars(!empty($ong['foto']) ? '/assets/img/ongs/' . $ong['foto'] : '/assets/img/linguinha.png', ENT_QUOTES, 'UTF-8') ?>"
                         alt="<?= htmlspecialchars($ong['nome'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="donation-card__body">
                        <div class="donation-card__title"><?= htmlspecialchars($ong['nome'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="donation-card__desc"><?= htmlspecialchars(mb_substr($ong['descricao'] ?? '', 0, 120), ENT_QUOTES, 'UTF-8') ?><?= mb_strlen($ong['descricao'] ?? '') > 120 ? '…' : '' ?></div>
                         <button type="button" class="donation-card__btn" style="margin-bottom: 50px;"
                                onclick="event.stopPropagation(); selectCard(this.closest('.donation-card'))">
                            Escolher
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>

                <div class="donation-card-custom donation-card--custom" id="customCard">
                    <div class="donation-card__body">
                        <div class="donation-card__title">Valor da doação</div>
                        <div class="donation-card__desc">Informe o valor que deseja doar (mínimo R$ 1,00).</div>
                        <div class="custom-input-wrap">
                            <span>R$</span>
                            <input type="number" class="custom-input" id="customValue" placeholder="0,00" min="1" step="0.01" onclick="event.stopPropagation();" oninput="updateCustom(this.value)"
                                   value="<?= !empty($prevInput['valor']) ? htmlspecialchars($prevInput['valor'], ENT_QUOTES, 'UTF-8') : '' ?>">
                        </div>
                    </div>
                    <div class="donation-card__price" id="customPrice">R$ -</div>
                </div>

            </div>
        </div>

        <hr class="divider">

        <div class="section-label"><i class="fa-solid fa-user"></i> Dados Pessoais</div>

        <div class="form-group">
            <label>CPF/CNPJ</label>
            <i class="fa-solid fa-id-card input-icon"></i>
            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" oninput="maskCPF(this); updateSummary();"
                   value="<?= htmlspecialchars($prevInput['cpf'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label>Nome completo</label>
            <i class="fa-solid fa-user input-icon"></i>
            <input type="text" id="nome" name="nome" placeholder="Seu nome" oninput="updateSummary()"
                   value="<?= htmlspecialchars($prevInput['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label>E-mail</label>
            <i class="fa-solid fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" oninput="updateSummary()"
                   value="<?= htmlspecialchars($prevInput['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
            <label>Telefone</label>
            <i class="fa-solid fa-phone input-icon"></i>
            <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" oninput="maskPhone(this); updateSummary();"
                   value="<?= htmlspecialchars($prevInput['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <hr class="divider">

        <div class="section-label"><i class="fa-solid fa-credit-card"></i> Forma de Pagamento</div>

        <div class="payment-options">
            <div class="payment-option selected" id="opt-pix">
                <div class="payment-option__left">
                    <i class="fa-brands fa-pix"></i> PIX
                </div>
                <div class="radio-circle"></div>
            </div>

            <div class="pix-details show" id="pix-details">
                <p style="color:var(--text-muted);font-size:0.9rem;">
                    Use a chave PIX abaixo para realizar sua doação:
                </p>
                <div class="pix-key-box">
                    <i class="fa-brands fa-pix" style="font-size:1.4rem;"></i>
                    <span id="pixKey">Selecione uma ONG acima</span>
                    <button type="button" class="copy-btn" onclick="copyPix()">Copiar</button>
                </div>
                <p style="color:var(--text-muted);font-size:0.82rem;">
                    Após realizar o PIX, envie o comprovante para o e-mail da ONG.
                </p>
            </div>
        </div>

        <div class="summary-box" id="summaryBox">
            <h3><i class="fa-solid fa-receipt" style="margin-right:8px;color:var(--blob-green);"></i>Resumo da Doação</h3>
            <div class="summary-row">
                <span>ONG selecionada</span>
                <span id="sumCausa">—</span>
            </div>
            <div class="summary-row">
                <span>Nome</span>
                <span id="sumNome">—</span>
            </div>
            <div class="summary-row">
                <span>E-mail</span>
                <span id="sumEmail">—</span>
            </div>
            <div class="summary-row">
                <span>CPF/CNPJ</span>
                <span id="sumCpf">—</span>
            </div>
            <div class="summary-row">
                <span>Telefone</span>
                <span id="sumTelefone">—</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="sumTotal">R$ —</span>
            </div>
        </div>

        <div class="submit-section">
            <button type="button" class="btn-donate" onclick="submitDonation()">
                <i class="fa-solid fa-heart"></i> Concluir Doação
            </button>
            <div class="secure-note">
                <i class="fa-solid fa-lock"></i> Pagamento seguro e criptografado
            </div>
        </div>

    </form>
</div>

<script src="/assets/js/doacoes.js"></script>

<?php if (!empty($prevInput) && !empty($prevInput['valor'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const v = parseFloat('<?= (float) $prevInput['valor'] ?>');
    if (!isNaN(v)) {
        document.getElementById('customPrice').textContent = 'R$ ' + v.toFixed(2).replace('.', ',');
    }
});
</script>
<?php endif; ?>
