const POR_PAGINA = 6;

const grid          = document.getElementById('animalGrid');
const countEl       = document.getElementById('countVisible');
const btnAplicar    = document.getElementById('btnAplicar');
const btnLimpar     = document.getElementById('btnLimpar');
const filterToggle  = document.getElementById('filterToggle');
const filterSidebar = document.getElementById('filterSidebar');
const filterBadge   = document.getElementById('filterBadge');
const searchInput   = document.getElementById('searchInput');

const todosOsCards = [...grid.querySelectorAll('.animal-card')];

let animaisFiltrados = [];
let paginaAtual      = 1;

function getChecked(name) {
    return [...document.querySelectorAll(`input[name="${name}"]:checked`)].map(i => i.value);
}

function normalizar(str) {
    return (str || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

function renderizarPagina() {
    const inicio = (paginaAtual - 1) * POR_PAGINA;
    const fim    = inicio + POR_PAGINA;

    todosOsCards.forEach(card => card.style.display = 'none');
    animaisFiltrados.slice(inicio, fim).forEach(card => card.style.display = '');

    countEl.textContent = animaisFiltrados.length;

    let semFiltro = grid.querySelector('.js-empty-filter');
    if (animaisFiltrados.length === 0 && todosOsCards.length > 0) {
        if (!semFiltro) {
            semFiltro = document.createElement('div');
            semFiltro.className = 'empty-state js-empty-filter';
            semFiltro.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i><p>Nenhum animal encontrado com esses filtros.</p>';
            grid.appendChild(semFiltro);
        }
        semFiltro.style.display = '';
    } else if (semFiltro) {
        semFiltro.style.display = 'none';
    }

    renderizarPaginacao();
}

function aplicarFiltro() {
    const especies = getChecked('especie');
    const sexos    = getChecked('sexo');
    const idades   = getChecked('idade');
    const busca    = normalizar(searchInput ? searchInput.value.trim() : '');

    animaisFiltrados = todosOsCards.filter(card => {
        const okEspecie = especies.length === 0 || especies.includes(card.dataset.tipo);
        const okSexo    = sexos.length    === 0 || sexos.includes(card.dataset.sexo);
        const okIdade   = idades.length   === 0 || idades.includes(card.dataset.idade);
        const okBusca   = busca === '' || normalizar(card.dataset.nome || card.querySelector('h3')?.textContent || '').includes(busca);

        return okEspecie && okSexo && okIdade && okBusca;
    });

    paginaAtual = 1;
    renderizarPagina();
    atualizarBadge();
}

function limparFiltros() {
    document.querySelectorAll('.filter-sidebar input[type="checkbox"]').forEach(cb => cb.checked = false);
    if (searchInput) searchInput.value = '';
    aplicarFiltro();
}

function atualizarBadge() {
    const total = document.querySelectorAll('.filter-sidebar input[type="checkbox"]:checked').length;
    filterBadge.textContent = total;
    filterBadge.style.display = total > 0 ? 'inline' : 'none';
}

function renderizarPaginacao() {
    let pag = document.getElementById('paginacao');
    if (!pag) {
        pag = document.createElement('div');
        pag.id = 'paginacao';
        pag.className = 'paginacao';
        grid.parentElement.appendChild(pag);
    }

    const totalPaginas = Math.ceil(animaisFiltrados.length / POR_PAGINA);

    if (totalPaginas <= 1) {
        pag.innerHTML = '';
        return;
    }

    pag.innerHTML = `
        <button class="pag-btn" id="pagAnterior" ${paginaAtual === 1 ? 'disabled' : ''}>
            <i class="fa-solid fa-paw"></i>
        </button>
        <span class="pag-info">Página ${paginaAtual} de ${totalPaginas}</span>
        <button class="pag-btn" id="pagProximo" ${paginaAtual === totalPaginas ? 'disabled' : ''}>
            <i class="fa-solid fa-paw"></i>
        </button>
    `;

    document.getElementById('pagAnterior').addEventListener('click', () => {
        if (paginaAtual > 1) { paginaAtual--; renderizarPagina(); scrollToGrid(); }
    });
    document.getElementById('pagProximo').addEventListener('click', () => {
        if (paginaAtual < totalPaginas) { paginaAtual++; renderizarPagina(); scrollToGrid(); }
    });
}

function scrollToGrid() {
    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ─── Eventos ─────────────────────────────────────────────────
btnAplicar.addEventListener('click', aplicarFiltro);
btnLimpar.addEventListener('click', limparFiltros);

filterToggle.addEventListener('click', () => {
    filterSidebar.classList.toggle('open');
});

document.querySelectorAll('.filter-sidebar input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', () => {
        atualizarBadge();
        aplicarFiltro(); // filtra em tempo real ao marcar
    });
});

if (searchInput) {
    searchInput.addEventListener('input', aplicarFiltro);
}

const style = document.createElement('style');
style.textContent = `
.paginacao {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 24px 0 8px;
}
.pag-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border: 2px solid var(--teal, #2a9d8f);
    background: transparent;
    color: var(--teal, #2a9d8f);
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, color .2s;
}
.pag-btn:hover:not(:disabled) {
    background: var(--teal, #2a9d8f);
    color: #fff;
}
.pag-btn:disabled {
    opacity: 0.35;
    cursor: not-allowed;
}
.pag-info {
    font-size: 0.9rem;
    color: var(--muted, #666);
}
`;
document.head.appendChild(style);

// ─── Init ─────────────────────────────────────────────────────
aplicarFiltro();