const ongs = [
    {
        id: 1,
        nome: "Patinhas do Bem",
        cidade: "São Paulo", estado: "SP",
        desc: "Resgatamos animais em situação de risco nas ruas de SP e encontramos famílias amorosas para cada um.",
        animais: 32,
        tags: ["Cães", "Gatos"],
        banner: "https://images.unsplash.com/photo-1548681528-6a5c45b66b42?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1601758174114-e711c0cbaa69?w=100&q=80"
    },
    {
        id: 2,
        nome: "Latido de Esperança",
        cidade: "Rio de Janeiro", estado: "RJ",
        desc: "ONG focada em resgates de cães de médio e grande porte, com programa de adoção responsável.",
        animais: 18,
        tags: ["Cães"],
        banner: "https://images.unsplash.com/photo-1535930891776-0c2dfb7fda1a?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=100&q=80"
    },
    {
        id: 3,
        nome: "Gatil Feliz",
        cidade: "Belo Horizonte", estado: "MG",
        desc: "Especialistas em bem-estar felino, com castrações gratuitas, adoção e apoio pós-adoção para tutores.",
        animais: 54,
        tags: ["Gatos", "Castração"],
        banner: "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1574158622682-e40e69881006?w=100&q=80"
    },
    {
        id: 4,
        nome: "Amigos de 4 Patas",
        cidade: "Curitiba", estado: "PR",
        desc: "Trabalhamos com voluntários apaixonados para resgatar e reabilitar animais maltratados do Paraná.",
        animais: 27,
        tags: ["Cães", "Gatos", "Resgate"],
        banner: "https://images.unsplash.com/photo-1450778869180-41d0601e046e?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1561037404-61cd46aa615b?w=100&q=80"
    },
    {
        id: 5,
        nome: "Patas Sul",
        cidade: "Porto Alegre", estado: "RS",
        desc: "ONG gaúcha com mais de 10 anos de atuação, promovendo adoção consciente e educação sobre posse responsável.",
        animais: 41,
        tags: ["Cães", "Gatos", "Educação"],
        banner: "https://images.unsplash.com/photo-1518715308788-3005759c61d4?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1503256207526-0d5d80fa2f47?w=100&q=80"
    },
    {
        id: 6,
        nome: "Bicho Solto",
        cidade: "Salvador", estado: "BA",
        desc: "Resgatamos animais em situação de abandono na Bahia, oferecendo cuidados veterinários e lar temporário.",
        animais: 15,
        tags: ["Cães", "Resgate"],
        banner: "https://images.unsplash.com/photo-1477884213360-7e9d7dcc1e48?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1517849845537-4d257902454a?w=100&q=80"
    },
    {
        id: 7,
        nome: "Asas da Esperança",
        cidade: "Campinas", estado: "SP",
        desc: "Focados em casos especiais: animais idosos, com necessidades especiais e vítimas de maus-tratos.",
        animais: 9,
        tags: ["Cães", "Gatos", "Especiais"],
        banner: "https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1558788353-f76d92427f16?w=100&q=80"
    },
    {
        id: 8,
        nome: "Focinho Carinhoso",
        cidade: "Florianópolis", estado: "SC",
        desc: "Uma rede de lares temporários que acolhe filhotes e adultos enquanto encontramos famílias permanentes.",
        animais: 22,
        tags: ["Cães", "Gatos", "Lar Temporário"],
        banner: "https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=600&q=80",
        logo:   "https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=100&q=80"
    },
];

const POR_PAGINA = 6;
let paginaAtual = 1;
let ongsFiltradas = [...ongs];

const grid        = document.getElementById('ongGrid');
const pagination  = document.getElementById('pagination');
const countEl     = document.getElementById('countVisible');
const searchInput = document.getElementById('searchInput');
const btnBuscar   = document.getElementById('btnBuscar');

function renderCards(lista) {
    grid.innerHTML = '';
    if (lista.length === 0) {
        grid.innerHTML = `
            <div class="empty-state">
                <i class="fa-solid fa-magnifying-glass"></i>
                <p>Nenhuma ONG encontrada com essa busca.</p>
            </div>`;
        return;
    }
    lista.forEach(o => {
        const card = document.createElement('a');
        card.className = 'ong-card';
        card.href = `Ong.html?id=${o.id}`;
        card.dataset.nome   = o.nome.toLowerCase();
        card.dataset.cidade = o.cidade.toLowerCase();

        const badgesHTML = o.tags.map(t =>
            `<span class="ong-badge"><i class="fa-solid fa-tag"></i>${t}</span>`
        ).join('');

        card.innerHTML = `
            <img class="ong-card-banner" src="${o.banner}" alt="" loading="lazy">
            <div class="ong-card-header">
                <img class="ong-avatar" src="${o.logo}" alt="${o.nome}">
                <div class="ong-name-wrap">
                    <h3>${o.nome}</h3>
                    <div class="ong-location">
                        <i class="fa-solid fa-location-dot"></i>
                        ${o.cidade}, ${o.estado}
                    </div>
                </div>
            </div>
            <div class="ong-card-body">
                <p class="ong-desc">${o.desc}</p>
                <div class="ong-badges">${badgesHTML}</div>
                <div class="ong-card-footer">
                    <span class="ong-animals-count">
                        <i class="fa-solid fa-paw"></i>
                        ${o.animais} animais disponíveis
                    </span>
                    <button class="btn-ver-ong">
                        Ver ONG <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
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
    renderCards(ongsFiltradas.slice(inicio, fim));
    renderPaginacao(ongsFiltradas.length);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function aplicarBusca() {
    const q = searchInput.value.trim().toLowerCase();
    ongsFiltradas = ongs.filter(o =>
        o.nome.toLowerCase().includes(q) ||
        o.cidade.toLowerCase().includes(q) ||
        o.estado.toLowerCase().includes(q)
    );
    paginaAtual = 1;
    countEl.textContent = ongsFiltradas.length;
    irParaPagina(1);
}

btnBuscar.addEventListener('click', aplicarBusca);
searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') aplicarBusca(); });

aplicarBusca();