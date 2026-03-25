const params = new URLSearchParams(window.location.search);
const nome   = params.get('nome')   || 'Animal';
const cidade = params.get('cidade') || 'Cidade';
const estado = params.get('estado') || 'Estado';
const tipo   = params.get('tipo')   || 'Animal';
const img    = params.get('img')    || 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=800&q=80';

document.title = `${nome} – Nome Projeto`;
document.getElementById('breadAnimal').textContent = nome;
document.getElementById('animalNome').childNodes[0].textContent = nome + ' ';
document.getElementById('animalTipo').textContent = `${tipo} · Fêmea · Adulto · Porte médio`;
document.getElementById('animalLoc').textContent = `${cidade}, ${estado}`;
document.getElementById('animalPhoto').src = img;
document.getElementById('animalPhoto').alt = nome;
document.getElementById('storyName').textContent = nome;
document.getElementById('tagsName').textContent = nome;
document.getElementById('storyBox').textContent =
    `Tem um pequeno defeito no andar por ter sofrido maus tratos. ${nome} é muito dócil e está à espera de um lar cheio de amor e paciência. Adote e transforme a vida de um animalzinho abandonado!`;

document.querySelector('.fa-heart').addEventListener('click', function(){
    this.classList.toggle('fa-regular');
    this.classList.toggle('fa-solid');
    this.style.color = this.classList.contains('fa-solid') ? '#e74c3c' : '';
});

const overlay    = document.getElementById('modalOverlay');
const btnAdotar  = document.getElementById('btnAdotar');
const btnCancelar= document.getElementById('btnCancelar');
const modalClose = document.getElementById('modalClose');

function abrirModal()  { overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
function fecharModal() { overlay.classList.remove('open'); document.body.style.overflow = ''; }

btnAdotar.addEventListener('click', abrirModal);
btnCancelar.addEventListener('click', fecharModal);
modalClose.addEventListener('click', fecharModal);
overlay.addEventListener('click', e => { if (e.target === overlay) fecharModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') fecharModal(); });

const outros = [
    { nome:"Bolota",    cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=300&q=80" },
    { nome:"Lobinha",   cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=300&q=80" },
    { nome:"Pix",       cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1574158622682-e40e69881006?w=300&q=80" },
    { nome:"Bia",       cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?w=300&q=80" },
    { nome:"Mel",       cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1550159930-40066082a4fc?w=300&q=80" },
    { nome:"Gaia",      cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=300&q=80" },
    { nome:"Dante",     cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1517849845537-4d257902454a?w=300&q=80" },
    { nome:"Shitzu",    cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?w=300&q=80" },
    { nome:"Thor",      cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1558788353-f76d92427f16?w=300&q=80" },
    { nome:"Filhotinho",cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=300&q=80" },
    { nome:"Pretinha",  cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=300&q=80" },
    { nome:"Galak",     cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=300&q=80" },
    { nome:"Dark",      cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1574158622682-e40e69881006?w=300&q=80" },
    { nome:"Russinho",  cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?w=300&q=80" },
    { nome:"Tamara",    cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1550159930-40066082a4fc?w=300&q=80" },
    { nome:"Chow Chow", cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=300&q=80" },
    { nome:"Basset",    cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1517849845537-4d257902454a?w=300&q=80" },
    { nome:"Spike",     cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?w=300&q=80" },
    { nome:"Princesa",  cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1558788353-f76d92427f16?w=300&q=80" },
    { nome:"Bonzinho",  cidade:"Rio de Janeiro", img:"https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=300&q=80" },
];

const POR_PAGINA = 10; 
let paginaAtual  = 1;

const othersGrid = document.getElementById('othersGrid');
const pagination = document.getElementById('pagination');

function renderOutros(pg) {
    paginaAtual = pg;
    const inicio = (pg - 1) * POR_PAGINA;
    const slice  = outros.slice(inicio, inicio + POR_PAGINA);

    othersGrid.innerHTML = '';
    slice.forEach(a => {
        const card = document.createElement('a');
        card.className = 'other-card';
        card.href = `Animais.html?nome=${encodeURIComponent(a.nome)}&cidade=${encodeURIComponent(a.cidade)}&estado=Rio+de+Janeiro&tipo=Cachorro&img=${encodeURIComponent(a.img)}`;
        card.target = '_blank';
        card.innerHTML = `
            <img src="${a.img}" alt="${a.nome}" loading="lazy">
            <div class="other-card-body">
                <h4>${a.nome}</h4>
                <p>${a.cidade}, RJ</p>
            </div>`;
        othersGrid.appendChild(card);
    });

    renderPagination();
}

function renderPagination() {
    const total  = Math.ceil(outros.length / POR_PAGINA);
    pagination.innerHTML = '';
    if (total <= 1) return;

    const prev = document.createElement('button');
    prev.className = 'page-btn';
    prev.innerHTML = '<i class="fa-solid fa-paw"></i>';
    prev.disabled  = paginaAtual === 1;
    prev.addEventListener('click', () => { renderOutros(paginaAtual - 1); });
    pagination.appendChild(prev);

    for (let i = 1; i <= total; i++) {
        if (total > 7) {
            if (i > 2 && i < paginaAtual - 1) {
                if (i === 3) {
                    const ell = document.createElement('span');
                    ell.className = 'page-ellipsis';
                    ell.textContent = '…';
                    pagination.appendChild(ell);
                }
                continue;
            }
            if (i > paginaAtual + 1 && i < total - 1) {
                if (i === paginaAtual + 2) {
                    const ell = document.createElement('span');
                    ell.className = 'page-ellipsis';
                    ell.textContent = '…';
                    pagination.appendChild(ell);
                }
                continue;
            }
        }
        const btn = document.createElement('button');
        btn.className = 'page-btn' + (i === paginaAtual ? ' active' : '');
        btn.textContent = i;
        btn.addEventListener('click', () => renderOutros(i));
        pagination.appendChild(btn);
    }

    const next = document.createElement('button');
    next.className = 'page-btn';
    next.innerHTML = '<i class="fa-solid fa-paw"></i>';
    next.disabled  = paginaAtual === total;
    next.addEventListener('click', () => renderOutros(paginaAtual + 1));
    pagination.appendChild(next);
}

renderOutros(1);