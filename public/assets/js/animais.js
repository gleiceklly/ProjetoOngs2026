const nomeAnimal = document.getElementById('animalNome')?.dataset.nome || document.title.split(' –')[0];

const overlay     = document.getElementById('modalOverlay');
const btnAdotar   = document.getElementById('btnAdotar');
const btnCancelar = document.getElementById('btnCancelar');
const modalClose  = document.getElementById('modalClose');

function abrirModal()  { overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
function fecharModal() { overlay.classList.remove('open'); document.body.style.overflow = ''; }

btnAdotar.addEventListener('click', abrirModal);
btnCancelar.addEventListener('click', fecharModal);
modalClose.addEventListener('click', fecharModal);
overlay.addEventListener('click', e => { if (e.target === overlay) fecharModal(); });

let toastTimer;
function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
}

const shareOverlay   = document.getElementById('shareOverlay');
const shareClose     = document.getElementById('shareClose');
const btnShare       = document.getElementById('btnShare');
const shareLinkInput = document.getElementById('shareLinkInput');
const btnCopy        = document.getElementById('btnCopy');

const pageUrl   = window.location.href;
const shareText = `Olha esse pet que precisa de um lar: ${nomeAnimal}! Ajude a encontrar uma família para ele.`;

function buildShareOptions() {
    const encodedUrl  = encodeURIComponent(pageUrl);
    const encodedText = encodeURIComponent(shareText);

    const options = [
        {
            label: 'WhatsApp',
            cls: 'whatsapp',
            icon: 'fa-brands fa-whatsapp',
            href: `https://wa.me/?text=${encodeURIComponent(shareText + '\n' + pageUrl)}`
        },
        {
            label: 'Facebook',
            cls: 'facebook',
            icon: 'fa-brands fa-facebook-f',
            href: `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`
        },
        {
            label: 'X / Twitter',
            cls: 'twitter',
            icon: 'fa-brands fa-twitter',
            href: `https://twitter.com/intent/tweet?text=${encodedText}&url=${encodedUrl}`
        },
        {
            label: 'Telegram',
            cls: 'telegram',
            icon: 'fa-brands fa-telegram',
            href: `https://t.me/share/url?url=${encodedUrl}&text=${encodedText}`
        },
        {
            label: 'E-mail',
            cls: 'email',
            icon: 'fa-solid fa-envelope',
            href: `mailto:?subject=${encodeURIComponent('Conheça ' + nomeAnimal + ' – adote!')}&body=${encodeURIComponent(shareText + '\n\n' + pageUrl)}`
        }
    ];

    if (navigator.share) {
        options.push({
            label: 'Mais opções',
            cls: 'native',
            icon: 'fa-solid fa-ellipsis',
            native: true
        });
    }

    const container = document.getElementById('shareOptions');
    container.innerHTML = '';
    options.forEach(opt => {
        const btn = document.createElement(opt.native ? 'button' : 'a');
        btn.className = 'share-btn';
        if (!opt.native) {
            btn.href   = opt.href;
            btn.target = '_blank';
            btn.rel    = 'noopener noreferrer';
        } else {
            btn.type = 'button';
            btn.addEventListener('click', async () => {
                try { await navigator.share({ title: nomeAnimal, text: shareText, url: pageUrl }); } catch (e) {}
            });
        }
        btn.innerHTML = `<div class="share-icon ${opt.cls}"><i class="${opt.icon}"></i></div>${opt.label}`;
        container.appendChild(btn);
    });
}

function abrirShare() {
    shareLinkInput.value = pageUrl;
    buildShareOptions();
    shareOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function fecharShare() {
    shareOverlay.classList.remove('open');
    document.body.style.overflow = '';
}

btnShare.addEventListener('click', () => {
    if (navigator.share && window.innerWidth <= 700) {
        navigator.share({ title: nomeAnimal, text: shareText, url: pageUrl }).catch(() => {});
    } else {
        abrirShare();
    }
});

shareClose.addEventListener('click', fecharShare);
shareOverlay.addEventListener('click', e => { if (e.target === shareOverlay) fecharShare(); });

btnCopy.addEventListener('click', async () => {
    try {
        await navigator.clipboard.writeText(pageUrl);
    } catch {
        shareLinkInput.select();
        document.execCommand('copy');
    }
    btnCopy.classList.add('copied');
    btnCopy.innerHTML = '<i class="fa-solid fa-check"></i> Copiado!';
    showToast('Link copiado para a área de transferência.');
    setTimeout(() => {
        btnCopy.classList.remove('copied');
        btnCopy.innerHTML = '<i class="fa-regular fa-copy"></i> Copiar';
    }, 2500);
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { fecharModal(); fecharShare(); }
});

(function () {
    const grid    = document.getElementById('othersGrid');
    const wrap    = document.querySelector('.others-wrap');
    if (!grid || !wrap) return;

    const cards   = Array.from(grid.children);
    const PER_PAG = 5;
    const total   = cards.length;
    const pages   = Math.ceil(total / PER_PAG);
    if (pages <= 1) return;        

    let cur = 1;

    function showPage(p) {
        cur = p;
        cards.forEach((c, i) => {
            c.style.display = (i >= (p - 1) * PER_PAG && i < p * PER_PAG) ? '' : 'none';
        });
        renderPag();
    }

    function renderPag() {
        let el = document.getElementById('othersPag');
        if (!el) {
            el = document.createElement('div');
            el.id = 'othersPag';
            el.className = 'pagination';
            wrap.appendChild(el);
        }
        el.innerHTML = '';

        const prev = document.createElement('button');
        prev.className = 'page-btn';
        prev.disabled  = cur === 1;
        prev.innerHTML = '<i class="fa-solid fa-paw" style="transform:scaleX(-1)"></i>';
        prev.addEventListener('click', () => showPage(cur - 1));
        el.appendChild(prev);

        const range = [...new Set(
            [1, pages, cur, cur - 1, cur + 1].filter(p => p >= 1 && p <= pages)
        )].sort((a, b) => a - b);

        let last = 0;
        range.forEach(p => {
            if (p - last > 1) {
                const sp = document.createElement('span');
                sp.className   = 'page-ellipsis';
                sp.textContent = '…';
                el.appendChild(sp);
            }
            const btn = document.createElement('button');
            btn.className   = 'page-btn' + (p === cur ? ' active' : '');
            btn.textContent = p;
            btn.addEventListener('click', () => showPage(p));
            el.appendChild(btn);
            last = p;
        });

        const next = document.createElement('button');
        next.className = 'page-btn';
        next.disabled  = cur === pages;
        next.innerHTML = '<i class="fa-solid fa-paw"></i>';
        next.addEventListener('click', () => showPage(cur + 1));
        el.appendChild(next);
    }

    showPage(1);
})();