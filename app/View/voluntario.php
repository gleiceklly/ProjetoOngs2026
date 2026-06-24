<?php

use Core\Library\Session;

$formErrors = \Core\Library\Session::getDestroy('formErrors') ?? [];
$prevInput  = \Core\Library\Session::getDestroy('formInputs') ?? [];
?>

<div class="page-header">
    <h1><i class="fa-solid fa-heart" style="color:#ffae00;margin-right:10px;"></i>Seja um <span style="color:#ffae00;">Voluntário</span></h1>
    <br><p>O voluntariado é, acima de tudo, o reconhecimento de que, ao entregar um pouco de si, ganha-se a imensidão do outro.</p>
    <img class="capaDoacao" src="/assets/img/chedar.png">
</div>

<div class="container" style="max-width:700px;padding:0 1rem;">
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
</div>

<section class="vagas-bg" id="vagas">
  <div class="section" style="padding-top:3rem;padding-bottom:3rem">

    <h2 class="section-title"><i class="fa-solid fa-paw"></i>Encontre sua vaga<i class="fa-solid fa-paw"></i></h2>
    <div class="divider"></div>
    <p class="section-subtitle">Escolha uma ONG, descubra a função certa para você e junte-se à causa.</p>

    <div class="view-tabs">
      <button class="view-tab active" id="tab-vagas" onclick="showTab('vagas')">Vagas das ONGs</button>
      <button class="view-tab" id="tab-voluntarios" onclick="showTab('voluntarios')">Voluntários</button>
    </div>

    <div class="filter-bar" id="filter-vagas">
      <input type="text" id="search-vagas" placeholder="Buscar ONG ou função…" oninput="renderVagas()">
      <select id="filter-funcao" onchange="renderVagas()">
        <option value="">Todas as funções</option>
      </select>
    </div>

    <div class="filter-bar hidden" id="filter-voluntarios">
      <input type="text" id="search-vol" placeholder="Buscar pelo nome…" oninput="renderVoluntarios()">
      <select id="filter-vol-ong" onchange="renderVoluntarios()">
        <option value="">Todas as ONGs</option>
      </select>
    </div>

    <div id="cards-container" class="cards-grid"></div>
    <div id="pagination" class="pagination"></div>

  </div>
</section>

<div class="modal-overlay" id="modal-overlay" onclick="closeModalOutside(event)">
  <div class="modal-box" id="modal">
    <div id="modal-form-view">
      <div class="modal-header">
        <h3 id="modal-title">Quero participar!</h3>
        <button class="modal-close" onclick="closeModal()">✕</button>
      </div>
      <div class="modal-context" id="modal-context"></div>
      <form method="POST" action="<?= baseUrl() ?>Voluntario/insert">

        <?= csrfField() ?>
        <input type="hidden" name="ong_id" id="ong-id-hidden" value="">

        <div class="form-row">
          <div class="form-group">
            <label>Nome completo *</label>
            <input type="text" name="nome" required placeholder="Seu nome"
                   value="<?= htmlspecialchars($prevInput['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="form-group">
            <label>E-mail *</label>
            <input type="email" name="email" required placeholder="seu@email.com"
                   value="<?= htmlspecialchars($prevInput['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Telefone *</label>
            <input type="tel" name="telefone" required placeholder="(11) 9 0000-0000"
                   value="<?= htmlspecialchars($prevInput['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="form-group">
            <label>Cidade *</label>
            <input type="text" name="cidade" required placeholder="Sua cidade"
                   value="<?= htmlspecialchars($prevInput['cidade'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Idade</label>
            <input type="text" name="idade" id="f-idade" inputmode="numeric" pattern="[0-9]*" placeholder="Ex: 28"
                   value="<?= htmlspecialchars($prevInput['idade'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="form-group">
            <label>Disponibilidade</label>
            <select name="disponibilidade">
              <?php
              $dispOpts = ['Finais de semana', 'Dias úteis', 'Período integral', 'Flexível'];
              $dispPrev = $prevInput['disponibilidade'] ?? '';
              foreach ($dispOpts as $opt):
              ?>
              <option value="<?= $opt ?>"<?= $dispPrev === $opt ? ' selected' : '' ?>><?= $opt ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Função desejada *</label>
          <input type="text" name="funcao" id="f-funcao" required placeholder="Ex: Cuidador(a)" readonly style="background:#f9fafb"
                 value="<?= htmlspecialchars($prevInput['funcao'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="form-group">
          <label>Mensagem / experiência</label>
          <textarea name="mensagem" placeholder="Conte um pouco sobre você e por que quer ajudar…"><?= htmlspecialchars($prevInput['mensagem'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit" class="btn-submit">Enviar inscrição</button>
      </form>
    </div>
    <div id="modal-success-view" class="success-state hidden">
      <div class="success-icon"></div>
      <h3>Inscrição enviada!</h3>
      <p>Obrigado por se inscrever.<br>A equipe da ONG entrará em contato em breve.</p>
      <button class="btn-submit" style="margin-top:1.5rem;width:auto;padding:.8rem 2.5rem" onclick="closeModal()">Fechar</button>
    </div>
  </div>
</div>

<script>
const USER_NIVEL = <?= (int) Session::get('userNivel') ?>;

const vagas = <?= json_encode(array_values(array_map(function ($v) {
    $cidade   = $v['ong_cidade'] ?? '';
    $estado   = $v['ong_estado'] ?? '';
    $bairro   = $v['ong_bairro'] ?? '';
    $endereco = $cidade . ($estado ? ', ' . $estado : '') . ' - ' . $bairro;
    return [
        'id'         => (int) $v['id'],
        'ong_id'     => (int) $v['ong_id'],
        'ong'        => $v['ong_nome']   ?? '',
        'funcao'     => $v['funcao']     ?? '',
        'quantidade' => (int) $v['quantidade'],
        'endereco'   => $endereco,
        'descricao'  => $v['descricao']  ?? '',
    ];
}, $vagas ?? [])), JSON_UNESCAPED_UNICODE) ?>;
const volunteers = <?= json_encode(array_values(array_map(function ($v) {
    return [
        'nome' => $v['nome']                       ?? '',
        'ong'  => $v['ong_nome']                   ?? '',
        'funcao'        => $v['funcao']            ?? '',
        'telefone'      => $v['telefone']          ?? '',
        'disponibilidade' => $v['disponibilidade'] ?? '',
        'mensagem'      => $v['mensagem']          ?? '',
    ];
}, $voluntarios ?? [])), JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="/assets/js/voluntarios.js"></script>

<?php if (!empty($prevInput)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('modal-overlay').classList.add('open');
    <?php if (!empty($prevInput['ong_id'])): ?>
    document.getElementById('ong-id-hidden').value = '<?= (int) $prevInput['ong_id'] ?>';
    <?php endif; ?>
    <?php if (!empty($prevInput['funcao'])): ?>
    document.getElementById('f-funcao').value = <?= json_encode($prevInput['funcao']) ?>;
    <?php endif; ?>
});
</script>
<?php endif; ?>
