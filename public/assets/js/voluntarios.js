
const ongs = [
  { id:1, nome:'Amigos do Focinho', endereco:'Rua das Palmeiras, 142 — Recife, PE', funcao:'Cuidador(a)', vagas:3, emoji:'🐕' },
  { id:2, nome:'Patinhas Felizes', endereco:'Av. Brasil, 980 — São Paulo, SP',       funcao:'Veterinário(a)', vagas:1, emoji:'🐈' },
  { id:3, nome:'Lar dos Bigodes',   endereco:'R. das Flores, 55 — Curitiba, PR',     funcao:'Motorista voluntário', vagas:2, emoji:'🦴' },
  { id:4, nome:'SOS Animal',        endereco:'Trav. do Sol, 30 — Salvador, BA',      funcao:'Captação de recursos', vagas:4, emoji:'🐾' },
  { id:5, nome:'Patas Livres',      endereco:'Rua Lima, 200 — Fortaleza, CE',        funcao:'Social media', vagas:2, emoji:'🐶' },
  { id:6, nome:'Refúgio Animal',    endereco:'Al. dos Pinheiros, 88 — BH, MG',      funcao:'Adestrador(a)', vagas:1, emoji:'🐱' },
  { id:7, nome:'Latidos e Miados',  endereco:'Rua Sete, 77 — Manaus, AM',           funcao:'Cuidador(a)', vagas:5, emoji:'🐕' },
  { id:8, nome:'ONG Pet Feliz',     endereco:'Av. Paulista, 1300 — SP, SP',         funcao:'Veterinário(a)', vagas:2, emoji:'🐈' },
  { id:9, nome:'Quatro Patas',      endereco:'R. das Acácias, 14 — Porto Alegre',   funcao:'Social media', vagas:3, emoji:'🦴' },
  { id:10,nome:'Bichinho de Luz',   endereco:'Rua Alta, 50 — Rio de Janeiro, RJ',   funcao:'Captação de recursos', vagas:2, emoji:'🐾' },
  { id:11,nome:'Amigo Fiel',        endereco:'Av. Central, 99 — Goiânia, GO',       funcao:'Motorista voluntário', vagas:1, emoji:'🐶' },
  { id:12,nome:'Casa do Animal',    endereco:'R. dos Ipês, 22 — Florianópolis, SC', funcao:'Adestrador(a)', vagas:3, emoji:'🐱' },
];

let volunteers = [
  { id:1, nome:'Ana Beatriz',  email:'ana@email.com',  tel:'(81) 9 1234-5678', cidade:'Recife', idade:26, disp:'Finais de semana', funcao:'Cuidador(a)',          ong:'Amigos do Focinho', msg:'' },
  { id:2, nome:'Carlos Melo',  email:'cmelo@email.com',tel:'(11) 9 8765-4321', cidade:'São Paulo', idade:32, disp:'Dias úteis', funcao:'Veterinário(a)',         ong:'Patinhas Felizes', msg:'' },
  { id:3, nome:'Larissa Faria',email:'lfa@email.com',  tel:'(41) 9 3333-2222', cidade:'Curitiba', idade:22, disp:'Flexível', funcao:'Motorista voluntário',      ong:'Lar dos Bigodes', msg:'' },
  { id:4, nome:'João Paulo',   email:'jp@email.com',   tel:'(71) 9 9999-1111', cidade:'Salvador', idade:40, disp:'Período integral', funcao:'Captação de recursos', ong:'SOS Animal', msg:'Tenho experiência em marketing.' },
  { id:5, nome:'Fernanda Lima',email:'flima@email.com',tel:'(85) 9 7777-6666', cidade:'Fortaleza', idade:29, disp:'Finais de semana', funcao:'Social media',      ong:'Patas Livres', msg:'Designer gráfica.' },
];
let nextVolId = 6;

const ITEMS_PER_PAGE = 6; 
let currentTab = 'vagas';
let vagasPage = 1;
let volsPage  = 1;
let activeOngId = null;

function showTab(tab) {
  currentTab = tab;
  document.getElementById('tab-vagas').classList.toggle('active', tab==='vagas');
  document.getElementById('tab-voluntarios').classList.toggle('active', tab==='voluntarios');
  document.getElementById('filter-vagas').classList.toggle('hidden', tab!=='vagas');
  document.getElementById('filter-voluntarios').classList.toggle('hidden', tab!=='voluntarios');
  if(tab==='vagas') { vagasPage=1; renderVagas(); }
  else              { volsPage=1;  renderVoluntarios(); }
}

function renderVagas() {
  const q     = document.getElementById('search-vagas').value.toLowerCase();
  const fRole = document.getElementById('filter-funcao').value;
  let items = ongs.filter(o =>
    (!q || o.nome.toLowerCase().includes(q) || o.funcao.toLowerCase().includes(q)) &&
    (!fRole || o.funcao === fRole)
  );
  const total = items.length;
  const pages = Math.ceil(total / ITEMS_PER_PAGE);
  if(vagasPage > pages) vagasPage = 1;
  const slice = items.slice((vagasPage-1)*ITEMS_PER_PAGE, vagasPage*ITEMS_PER_PAGE);

  const container = document.getElementById('cards-container');
  container.innerHTML = slice.map(o => `
    <div class="card">
      <div class="card-top">
        <div class="card-avatar">${o.emoji}</div>
        <div>
          <div class="card-ong-name">${o.nome}</div>
          <span class="card-badge">${o.funcao}</span>
        </div>
      </div>
      <div class="card-info">
        <div class="card-info-row"><span class="icon">📍</span><span>${o.endereco}</span></div>
        <div class="card-info-row"><span class="icon">🪑</span><span>${o.vagas} vaga${o.vagas>1?'s':''} disponível${o.vagas>1?'is':''}</span></div>
      </div>
      <div class="card-footer">
        <button class="btn-participar" onclick="openModal(${o.id})">Participar →</button>
      </div>
    </div>
  `).join('');

  renderPagination(pages, vagasPage, (p)=>{ vagasPage=p; renderVagas(); });
}

function renderVoluntarios() {
  const selOng = document.getElementById('filter-vol-ong');
  const prevOng = selOng.value;
  const ongNames = [...new Set(volunteers.map(v=>v.ong))].sort();
  selOng.innerHTML = `<option value="">Todas as ONGs</option>` + ongNames.map(n=>`<option${n===prevOng?' selected':''}>${n}</option>`).join('');

  const q     = document.getElementById('search-vol').value.toLowerCase();
  const fRole = document.getElementById('filter-vol-funcao').value;
  const fOng  = document.getElementById('filter-vol-ong').value;
  let items = volunteers.filter(v =>
    (!q || v.nome.toLowerCase().includes(q) || v.funcao.toLowerCase().includes(q)) &&
    (!fRole || v.funcao === fRole) &&
    (!fOng  || v.ong === fOng)
  );
  const total = items.length;
  const pages = Math.ceil(total / ITEMS_PER_PAGE) || 1;
  if(volsPage > pages) volsPage = 1;
  const slice = items.slice((volsPage-1)*ITEMS_PER_PAGE, volsPage*ITEMS_PER_PAGE);

  const container = document.getElementById('cards-container');
  container.innerHTML = slice.length === 0
    ? `<p style="grid-column:1/-1;text-align:center;color:var(--gray-400);padding:3rem 0">Nenhum voluntário encontrado.</p>`
    : slice.map(v => `
    <div class="vol-card">
      <div class="vol-card-header">
        <div class="vol-avatar">${v.nome.charAt(0)}</div>
        <div>
          <div class="vol-name">${v.nome}</div>
          <span class="vol-role">${v.funcao}</span>
        </div>
      </div>
      <div class="vol-info" style="margin-top:.5rem">
        <div class="vol-info-row">📧 ${v.email}</div>
        <div class="vol-info-row">📞 ${v.tel}</div>
        <div class="vol-info-row">📍 ${v.cidade}</div>
        <div class="vol-info-row">🕐 ${v.disp}</div>
        ${v.idade ? `<div class="vol-info-row">🎂 ${v.idade} anos</div>` : ''}
        ${v.msg ? `<div class="vol-info-row" style="margin-top:.3rem;font-style:italic">"${v.msg}"</div>` : ''}
      </div>
      <span class="vol-ong-tag">🏠 ${v.ong}</span>
    </div>
  `).join('');

  renderPagination(pages, volsPage, (p)=>{ volsPage=p; renderVoluntarios(); });
}

function renderPagination(pages, current, cb) {
  const el = document.getElementById('pagination');
  if(pages <= 1) { el.innerHTML=''; return; }
  let html = `<button class="page-btn" ${current===1?'disabled':''} onclick="(${cb.toString()})(${current-1})"><i class="fa-solid fa-paw"></i></button>`;
  for(let i=1;i<=pages;i++){
    html += `<button class="page-btn${i===current?' active':''}" onclick="(${cb.toString()})(${i})">${i}</button>`;
  }
  html += `<button class="page-btn" ${current===pages?'disabled':''} onclick="(${cb.toString()})(${current+1})"><i class="fa-solid fa-paw"></i></button>`;
  el.innerHTML = html;
}

function openModal(ongId) {
  const ong = ongs.find(o=>o.id===ongId);
  activeOngId = ongId;
  document.getElementById('modal-context').textContent = `🏠 ${ong.nome}  ·  🔧 ${ong.funcao}`;
  document.getElementById('f-funcao').value = ong.funcao;
  document.getElementById('modal-form-view').classList.remove('hidden');
  document.getElementById('modal-success-view').classList.add('hidden');
  ['f-nome','f-email','f-tel','f-cidade','f-idade','f-msg'].forEach(id=>{ document.getElementById(id).value=''; });
  document.getElementById('modal-overlay').classList.add('open');
}
function closeModal() {
  document.getElementById('modal-overlay').classList.remove('open');
}
function closeModalOutside(e) {
  if(e.target === document.getElementById('modal-overlay')) closeModal();
}
function submitForm(e) {
  e.preventDefault();
  const ong = ongs.find(o=>o.id===activeOngId);
  const vol = {
    id: nextVolId++,
    nome:  document.getElementById('f-nome').value,
    email: document.getElementById('f-email').value,
    tel:   document.getElementById('f-tel').value,
    cidade:document.getElementById('f-cidade').value,
    idade: document.getElementById('f-idade').value,
    disp:  document.getElementById('f-disp').value,
    funcao:document.getElementById('f-funcao').value,
    ong:   ong.nome,
    msg:   document.getElementById('f-msg').value,
  };
  volunteers.push(vol);
  document.getElementById('modal-form-view').classList.add('hidden');
  document.getElementById('modal-success-view').classList.remove('hidden');
}

function scrollToVagas() {
  document.getElementById('vagas').scrollIntoView({behavior:'smooth'});
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    }
  });
}, {
  threshold: 0.2
});

document.querySelectorAll('.animate-on-scroll').forEach(el => {
  observer.observe(el);
});

renderVagas();