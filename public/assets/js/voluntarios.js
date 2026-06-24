
const ITEMS_PER_PAGE = 4;
let currentTab = 'vagas';
let vagasPage = 1;
let volsPage  = 1;

function showTab(tab) {
  currentTab = tab;
  document.getElementById('tab-vagas').classList.toggle('active', tab === 'vagas');
  document.getElementById('tab-voluntarios').classList.toggle('active', tab === 'voluntarios');
  document.getElementById('filter-vagas').classList.toggle('hidden', tab !== 'vagas');
  document.getElementById('filter-voluntarios').classList.toggle('hidden', tab !== 'voluntarios');
  if (tab === 'vagas') { vagasPage = 1; renderVagas(); }
  else                 { volsPage  = 1; renderVoluntarios(); }
}

function renderVagas() {
  const selFuncao = document.getElementById('filter-funcao');

  const funcoes = [...new Set(vagas.map(v => v.funcao))].sort();
  const prevFuncao = selFuncao.value;
  selFuncao.innerHTML = '<option value="">Todas as funções</option>'
    + funcoes.map(f => `<option${f === prevFuncao ? ' selected' : ''}>${f}</option>`).join('');

  const q      = document.getElementById('search-vagas').value.toLowerCase();
  const fRole  = selFuncao.value;

  let items = vagas.filter(v =>
    (!q     || v.ong.toLowerCase().includes(q) || v.funcao.toLowerCase().includes(q)) &&
    (!fRole || v.funcao === fRole)
  );

  const total = items.length;
  const pages = Math.ceil(total / ITEMS_PER_PAGE) || 1;
  if (vagasPage > pages) vagasPage = 1;
  const slice = items.slice((vagasPage - 1) * ITEMS_PER_PAGE, vagasPage * ITEMS_PER_PAGE);

  const container = document.getElementById('cards-container');

  if (slice.length === 0) {
    container.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:var(--gray-400);padding:3rem 0">Nenhuma vaga encontrada.</p>';
    document.getElementById('pagination').innerHTML = '';
    return;
  }

  container.innerHTML = slice.map(v => `
    <div class="col-sm-6 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="color: #9bcaff"><i class="fa-solid fa-paw"></i> ${v.ong}</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">${v.funcao}</h6>
          <p class="card-text">${v.descricao || 'Sem descrição disponível.'}</p>
          <p class="card-text">
            <small class="text-body-secondary">
              <i class="fa-solid fa-location-dot"></i> ${v.endereco || 'Localização não informada'}
            </small>
          </p>
          <p class="card-text">
            <small class="text-body-secondary">
              <i class="fa-solid fa-users"></i> ${v.quantidade} vaga${v.quantidade !== 1 ? 's' : ''} disponível${v.quantidade !== 1 ? 'is' : ''}
            </small>
          </p>
          <button class="btn" style="background-color: #9bcaff" onclick="openModal(${v.id})">Participar →</button>
        </div>
      </div>
    </div>
  `).join('');

  renderPagination(pages, vagasPage, (p) => { vagasPage = p; renderVagas(); });
}

function renderVoluntarios() {
  const selOng  = document.getElementById('filter-vol-ong');
  const prevOng = selOng.value;
  const ongNames = [...new Set(volunteers.map(v => v.ong))].sort();
  selOng.innerHTML = '<option value="">Todas as ONGs</option>'
    + ongNames.map(n => `<option${n === prevOng ? ' selected' : ''}>${n}</option>`).join('');

  const q    = document.getElementById('search-vol').value.toLowerCase();
  const fOng = selOng.value;

  let items = volunteers.filter(v =>
    (!q    || (v.nome || '').toLowerCase().includes(q)) &&
    (!fOng || v.ong === fOng)
  );

  const total = items.length;
  const pages = Math.ceil(total / ITEMS_PER_PAGE) || 1;
  if (volsPage > pages) volsPage = 1;
  const slice = items.slice((volsPage - 1) * ITEMS_PER_PAGE, volsPage * ITEMS_PER_PAGE);

  const container = document.getElementById('cards-container');
  
  const isPrivilegiado = USER_NIVEL === 1 || USER_NIVEL === 15; // ONG ou superUser

 container.innerHTML = slice.length === 0
  ? '<p style="grid-column:1/-1;text-align:center;color:var(--gray-400);padding:3rem 0">Nenhum voluntário encontrado.</p>'
  : slice.map(v => `
    <div class="col-sm-6 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="color: #9bcaff">
            <i class="fa-solid fa-paw"></i> ${v.nome || '—'}
          </h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">${v.funcao || '—'}</h6>
          <p class="card-text">
            <small class="text-body-secondary">
              <i class="fa-solid fa-house"></i> ${v.ong || '—'}
            </small>
          </p>
          ${isPrivilegiado ? `
          <p class="card-text">
            <small class="text-body-secondary">
              <i class="fa-solid fa-phone"></i> ${v.telefone || '—'}
            </small>
          </p>
          <p class="card-text">
            <small class="text-body-secondary">
              <i class="fa-solid fa-clock"></i> ${v.disponibilidade || '—'}
            </small>
          </p>
          ${v.mensagem ? `
          <p class="card-text">${v.mensagem}</p>
          ` : ''}
          ` : ''}
        </div>
      </div>
    </div>
  `).join('');

  renderPagination(pages, volsPage, (p) => { volsPage = p; renderVoluntarios(); });
}

function renderPagination(pages, current, cb) {
  const el = document.getElementById('pagination');
  if (pages <= 1) { el.innerHTML = ''; return; }

  let html = `<ul class="pagination justify-content-center mb-0">`;

  html += `
    <li class="page-item ${current === 1 ? 'disabled' : ''}">
      <button class="page-link" onclick="(${cb.toString()})(${current - 1})" ${current === 1 ? 'disabled' : ''}>
        <i class="fa-solid fa-paw fa-flip-horizontal"></i>
      </button>
    </li>`;

  for (let i = 1; i <= pages; i++) {
    html += `
      <li class="page-item ${i === current ? 'active' : ''}">
        <button class="page-link" onclick="(${cb.toString()})(${i})">${i}</button>
      </li>`;
  }

  html += `
    <li class="page-item ${current === pages ? 'disabled' : ''}">
      <button class="page-link" onclick="(${cb.toString()})(${current + 1})" ${current === pages ? 'disabled' : ''}>
        <i class="fa-solid fa-paw"></i>
      </button>
    </li>`;

  html += `</ul>`;
  el.innerHTML = html;
}

/* ---------- MODAL DE INSCRIÇÃO ---------- */

function openModal(vagaId) {
  const vaga = vagas.find(v => v.id === vagaId);
  if (!vaga) return;

  document.getElementById('modal-context').textContent = vaga.ong + '  ·  ' + vaga.funcao;
  document.getElementById('f-funcao').value            = vaga.funcao;
  document.getElementById('ong-id-hidden').value       = vaga.ong_id;

  document.getElementById('modal-form-view').classList.remove('hidden');
  document.getElementById('modal-success-view').classList.add('hidden');

  ['nome', 'email', 'telefone', 'cidade', 'idade', 'mensagem'].forEach(name => {
    const el = document.querySelector(`[name="${name}"]`);
    if (el) el.value = '';
  });

  document.getElementById('modal-overlay').classList.add('open');
}

function closeModal() {
  document.getElementById('modal-overlay').classList.remove('open');
}

function closeModalOutside(e) {
  if (e.target === document.getElementById('modal-overlay')) closeModal();
}

function scrollToVagas() {
  document.getElementById('vagas').scrollIntoView({ behavior: 'smooth' });
}

/* ---------- ANIMAÇÕES ---------- */

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) entry.target.classList.add('show');
  });
}, { threshold: 0.2 });

document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

/* ---------- INIT ---------- */

renderVagas();
