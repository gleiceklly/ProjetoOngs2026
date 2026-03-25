const animais = [
    { id:1,  nome:"Monica",   cidade:"Rio de Janeiro", estado:"Rio de Janeiro", tipo:"Cachorro", sexo:"Fêmea",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400&q=80" },
    { id:2,  nome:"Jurema",   cidade:"São Paulo",      estado:"São Paulo",      tipo:"Cachorro", sexo:"Fêmea",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400&q=80" },
    { id:3,  nome:"Jethro",   cidade:"São Paulo",      estado:"São Paulo",      tipo:"Gato",     sexo:"Macho",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1574158622682-e40e69881006?w=400&q=80" },
    { id:4,  nome:"Pernuda",  cidade:"São Paulo",      estado:"São Paulo",      tipo:"Cachorro", sexo:"Fêmea",  idade:"Filhote", img:"https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=400&q=80" },
    { id:5,  nome:"Thor",     cidade:"São Sebastião",  estado:"Distrito Federal",tipo:"Cachorro",sexo:"Macho",  idade:"Filhote", img:"https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?w=400&q=80" },
    { id:6,  nome:"Domênico", cidade:"São Paulo",      estado:"São Paulo",      tipo:"Cachorro", sexo:"Macho",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1550159930-40066082a4fc?w=400&q=80" },
    { id:7,  nome:"Benjamin", cidade:"São Paulo",      estado:"São Paulo",      tipo:"Cachorro", sexo:"Macho",  idade:"Filhote", img:"https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=400&q=80" },
    { id:8,  nome:"Kiko",     cidade:"São Paulo",      estado:"São Paulo",      tipo:"Cachorro", sexo:"Macho",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1517849845537-4d257902454a?w=400&q=80" },
    { id:9,  nome:"Filó",     cidade:"Belo Horizonte", estado:"Minas Gerais",   tipo:"Cachorro", sexo:"Fêmea",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?w=400&q=80" },
    { id:10, nome:"Levy",     cidade:"São Paulo",      estado:"São Paulo",      tipo:"Cachorro", sexo:"Macho",  idade:"Filhote", img:"https://images.unsplash.com/photo-1558788353-f76d92427f16?w=400&q=80" },
    { id:11, nome:"Luna",     cidade:"Campinas",       estado:"São Paulo",      tipo:"Gato",     sexo:"Fêmea",  idade:"Filhote", img:"https://images.unsplash.com/photo-1503256207526-0d5d80fa2f47?w=400&q=80" },
    { id:12, nome:"Mel",      cidade:"Porto Alegre",   estado:"Rio Grande do Sul",tipo:"Gato",   sexo:"Fêmea",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400&q=80" },
    { id:13, nome:"Rex",      cidade:"Curitiba",       estado:"Paraná",         tipo:"Cachorro", sexo:"Macho",  idade:"Adulto",  img:"https://images.unsplash.com/photo-1561037404-61cd46aa615b?w=400&q=80" },
    { id:14, nome:"Mia",      cidade:"Salvador",       estado:"Bahia",          tipo:"Gato",     sexo:"Fêmea",  idade:"Filhote", img:"https://images.unsplash.com/photo-1555685812-4b943f1cb0eb?w=400&q=80" },
];

const POR_PAGINA = 12; 
let paginaAtual = 1;
let animaisFiltrados = [...animais];

const grid        = document.getElementById('animalGrid');
const pagination  = document.getElementById('pagination');
const countEl     = document.getElementById('countVisible');
const btnAplicar  = document.getElementById('btnAplicar');
const btnLimpar   = document.getElementById('btnLimpar');
const filterToggle= document.getElementById('filterToggle');
const filterSidebar=document.getElementById('filterSidebar');
const filterBadge = document.getElementById('filterBadge');

function getChecked(name) {
    return [...document.querySelectorAll(`input[name="${name}"]:checked`)].map(i => i.value);
}

function iconeAnimal(tipo) {
    return tipo === 'Gato' ? 'cat' : 'dog';
}

function renderCards(lista) {
    grid.innerHTML = '';
    if (lista.length === 0) {
        grid.innerHTML = `
            <div class="empty-state">
                <i class="fa-solid fa-magnifying-glass"></i>
                <p>Nenhum animal encontrado com esses filtros.</p>
            </div>`;
        return;
    }
    lista.forEach(a => {
        const card = document.createElement('a');
        card.className = 'animal-card';
        card.href = `Animais.html?id=${a.id}&nome=${encodeURIComponent(a.nome)}&cidade=${encodeURIComponent(a.cidade)}&estado=${encodeURIComponent(a.estado)}&tipo=${encodeURIComponent(a.tipo)}&img=${encodeURIComponent(a.img)}`;
        card.target = '_blank';
        card.dataset.tipo  = a.tipo;
        card.dataset.sexo  = a.sexo;
        card.dataset.idade = a.idade;
        card.innerHTML = `
            <img src="${a.img}" alt="${a.nome}" loading="lazy">
            <div class="card-body">
                <h3>${a.nome}</h3>
                <p>${a.cidade}, ${a.estado}</p>
                <span class="card-badge">
                    <i class="fa-solid fa-${iconeAnimal(a.tipo)}"></i>
                    ${a.tipo} · ${a.sexo} · ${a.idade}
                </span>
            </div>`;
        grid.appendChild(card);
    });
}

function renderPaginacao(total) {
    const totalPaginas = Math.ceil(total / POR_PAGINA);
    pagination.innerHTML = '';
    if (totalPaginas <= 1) return;

    const prev = document.createElement('button');
    prev.className = 'page-btn';
    prev.innerHTML = '<i class="fa-solid fa-paw"></i>';
    prev.disabled = paginaAtual === 1;
    prev.addEventListener('click', () => irParaPagina(paginaAtual - 1));
    pagination.appendChild(prev);

    // Números
    for (let i = 1; i <= totalPaginas; i++) {
        if (totalPaginas > 7) {
            if (i > 2 && i < paginaAtual - 1) {
                if (i === 3) {
                    const ell = document.createElement('span');
                    ell.className = 'page-ellipsis';
                    ell.textContent = '…';
                    pagination.appendChild(ell);
                }
                continue;
            }
            if (i > paginaAtual + 1 && i < totalPaginas - 1) {
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
        btn.addEventListener('click', () => irParaPagina(i));
        pagination.appendChild(btn);
    }

    const next = document.createElement('button');
    next.className = 'page-btn';
    next.innerHTML = '<i class="fa-solid fa-paw"></i>';
    next.disabled = paginaAtual === totalPaginas;
    next.addEventListener('click', () => irParaPagina(paginaAtual + 1));
    pagination.appendChild(next);
}

function irParaPagina(pg) {
    paginaAtual = pg;
    const inicio = (pg - 1) * POR_PAGINA;
    const fim    = inicio + POR_PAGINA;
    renderCards(animaisFiltrados.slice(inicio, fim));
    renderPaginacao(animaisFiltrados.length);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function aplicarFiltro() {
    const especies = getChecked('especie');
    const sexos    = getChecked('sexo');
    const idades   = getChecked('idade');

    animaisFiltrados = animais.filter(a => {
        const okEspecie = especies.length === 0 || especies.includes(a.tipo);
        const okSexo    = sexos.length    === 0 || sexos.includes(a.sexo);
        const okIdade   = idades.length   === 0 || idades.includes(a.idade);
        return okEspecie && okSexo && okIdade;
    });

    paginaAtual = 1;
    countEl.textContent = animaisFiltrados.length;
    irParaPagina(1);
    atualizarBadge();
}

function limparFiltros() {
    document.querySelectorAll('.filter-sidebar input[type="checkbox"]').forEach(cb => cb.checked = false);
    aplicarFiltro();
}

function atualizarBadge() {
    const total = document.querySelectorAll('.filter-sidebar input[type="checkbox"]:checked').length;
    filterBadge.textContent = total;
    filterBadge.style.display = total > 0 ? 'inline' : 'none';
}

btnAplicar.addEventListener('click', aplicarFiltro);
btnLimpar.addEventListener('click', limparFiltros);

filterToggle.addEventListener('click', () => {
    filterSidebar.classList.toggle('open');
});

document.querySelectorAll('.filter-sidebar input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', atualizarBadge);
});

aplicarFiltro();
