let animaisFiltrados = [];

const grid        = document.getElementById('animalGrid');
const countEl     = document.getElementById('countVisible');
const btnAplicar  = document.getElementById('btnAplicar');
const btnLimpar   = document.getElementById('btnLimpar');
const filterToggle  = document.getElementById('filterToggle');
const filterSidebar = document.getElementById('filterSidebar');
const filterBadge   = document.getElementById('filterBadge');

function getChecked(name) {
    return [...document.querySelectorAll(`input[name="${name}"]:checked`)].map(i => i.value);
}

function todosOsCards() {
    return [...grid.querySelectorAll('.animal-card')];
}

function aplicarFiltro() {
    const especies = getChecked('especie');
    const sexos    = getChecked('sexo');
    const idades   = getChecked('idade');

    let visiveis = 0;
    const cards  = todosOsCards();

    cards.forEach(card => {
        const okEspecie = especies.length === 0 || especies.includes(card.dataset.tipo);
        const okSexo    = sexos.length    === 0 || sexos.includes(card.dataset.sexo);
        const okIdade   = idades.length   === 0 || idades.includes(card.dataset.idade);

        if (okEspecie && okSexo && okIdade) {
            card.style.display = '';
            visiveis++;
        } else {
            card.style.display = 'none';
        }
    });

    countEl.textContent = visiveis;

    const semBanco = grid.querySelector('.empty-state');
    if (semBanco) semBanco.style.display = visiveis === 0 ? '' : 'none';

    let semFiltro = grid.querySelector('.js-empty-filter');
    if (cards.length > 0 && visiveis === 0) {
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
