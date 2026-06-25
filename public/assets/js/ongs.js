document.addEventListener('DOMContentLoaded', function () {

    const POR_PAGINA = 4;
    let paginaAtual   = 1;
    let ongsFiltradas = [];

    const grid        = document.getElementById('ongGrid');
    const pagination  = document.getElementById('pagination');
    const countEl     = document.getElementById('countVisible');
    const searchInput = document.getElementById('searchInput');
    const btnBuscar   = document.getElementById('btnBuscar');

    // Seleciona pelo atributo data-nome que está em todos os cards
    const todasOngCards = Array.from(grid.querySelectorAll('[data-nome]'));

    console.log('[ONGs] cards encontrados:', todasOngCards.length);

    function renderCards(lista) {
        todasOngCards.forEach(c => { c.style.display = 'none'; });

        const emptyState = grid.querySelector('.empty-state');
        if (emptyState) emptyState.remove();

        if (lista.length === 0) {
            const div = document.createElement('div');
            div.className = 'empty-state';
            div.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i><p>Nenhuma ONG encontrada com essa busca.</p>';
            grid.appendChild(div);
            return;
        }

        lista.forEach(c => { c.style.display = 'flex'; });
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
        next.className = 'page-btn next-paw';
        next.innerHTML = '<i class="fa-solid fa-paw"></i>';
        next.disabled = paginaAtual === totalPaginas;
        next.addEventListener('click', () => irParaPagina(paginaAtual + 1));
        pagination.appendChild(next);
    }

    function irParaPagina(pg) {
        paginaAtual = pg;
        const inicio = (pg - 1) * POR_PAGINA;
        const fim    = inicio + POR_PAGINA;
        renderCards(ongsFiltradas.slice(inicio, fim));
        renderPaginacao(ongsFiltradas.length);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function aplicarBusca() {
        const q = searchInput.value.trim().toLowerCase();
        ongsFiltradas = todasOngCards.filter(c =>
            c.dataset.nome.includes(q) ||
            (c.dataset.cidade || '').includes(q)
        );
        paginaAtual = 1;
        countEl.textContent = ongsFiltradas.length;
        irParaPagina(1);
    }

    btnBuscar.addEventListener('click', aplicarBusca);
    searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') aplicarBusca(); });

    aplicarBusca();
});