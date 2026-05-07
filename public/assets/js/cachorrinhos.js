let currentPage = 0;
const itemsPerPage = 4;

function moveCarousel(direction) {
    const cards = document.querySelectorAll('#petCarousel .pet-card');
    const totalPages = Math.ceil(cards.length / itemsPerPage);

    currentPage += direction;
    if (currentPage < 0) currentPage = 0;
    if (currentPage >= totalPages) currentPage = totalPages - 1;

    cards.forEach((card, index) => {
        const start = currentPage * itemsPerPage;
        const end = start + itemsPerPage;
        card.style.display = (index >= start && index < end) ? 'block' : 'none';
    });

    document.getElementById('arrowLeft').disabled  = currentPage === 0;
    document.getElementById('arrowRight').disabled = currentPage === totalPages - 1;
}

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('#petCarousel .pet-card');
    const totalPages = Math.ceil(cards.length / itemsPerPage);
    cards.forEach((card, index) => {
        if (index >= itemsPerPage) card.style.display = 'none';
    });
    document.getElementById('arrowLeft').disabled  = true;
    document.getElementById('arrowRight').disabled = totalPages <= 1;
});

// Simulação de usuários cadastrados
const USUARIOS_CADASTRADOS = [
    { email: 'teste@patadobem.com', senha: '123456' },
    { email: 'admin@patas.com',     senha: 'admin123' }
];

function openModal(tab) {
    document.getElementById('modalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    switchModalTab(tab || 'login');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    document.body.style.overflow = '';
    clearModalErrors();
}

function handleOverlayClick(e) {
    if (e.target === document.getElementById('modalOverlay')) closeModal();
}

// Fecha com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Alterna entre abas login / cadastro
function switchModalTab(tab) {
    clearModalErrors();

    document.getElementById('panelLogin').classList.remove('active');
    document.getElementById('panelCadastro').classList.remove('active');
    document.getElementById('tabLogin').classList.remove('active');
    document.getElementById('tabCadastro').classList.remove('active');

    if (tab === 'login') {
        document.getElementById('panelLogin').classList.add('active');
        document.getElementById('tabLogin').classList.add('active');
    } else {
        document.getElementById('panelCadastro').classList.add('active');
        document.getElementById('tabCadastro').classList.add('active');
    }
}

// Limpa todos os erros e alertas
function clearModalErrors() {
    document.querySelectorAll('.modal-error-msg').forEach(el => el.classList.remove('show'));
    document.querySelectorAll('#modalOverlay input').forEach(el => el.classList.remove('field-error'));
    document.querySelectorAll('.modal-alert, .modal-success').forEach(el => el.classList.remove('show'));
}

// Valida formato de e-mail
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function handleLogin() {
    clearModalErrors();
    const email = document.getElementById('loginEmail').value.trim();
    const senha = document.getElementById('loginSenha').value;
    let valid = true;

    if (!isValidEmail(email)) {
        document.getElementById('loginEmail').classList.add('field-error');
        document.getElementById('errLoginEmail').classList.add('show');
        valid = false;
    }
    if (senha.length < 6) {
        document.getElementById('loginSenha').classList.add('field-error');
        document.getElementById('errLoginSenha').classList.add('show');
        valid = false;
    }
    if (!valid) return;

    // Verifica se o e-mail existe
    const usuarioExistente = USUARIOS_CADASTRADOS.find(u => u.email === email);
    if (!usuarioExistente) {
        // E-mail não encontrado → redireciona para cadastro
        const alert = document.getElementById('alertLogin');
        document.getElementById('alertLoginMsg').textContent =
            'E-mail não encontrado. Redirecionando para o cadastro...';
        alert.classList.add('show');
        document.getElementById('cadEmail').value = email;
        setTimeout(() => switchModalTab('cadastro'), 1800);
        return;
    }

    // E-mail existe mas senha errada
    if (usuarioExistente.senha !== senha) {
        const alert = document.getElementById('alertLogin');
        document.getElementById('alertLoginMsg').textContent =
            'Senha incorreta. Verifique e tente novamente.';
        alert.classList.add('show');
        document.getElementById('loginSenha').classList.add('field-error');
        return;
    }

    // Login OK
    document.getElementById('successLogin').classList.add('show');
    setTimeout(() => closeModal(), 2000);
}

function handleCadastro() {
    clearModalErrors();
    const nome     = document.getElementById('cadNome').value.trim();
    const email    = document.getElementById('cadEmail').value.trim();
    const senha    = document.getElementById('cadSenha').value;
    const conf     = document.getElementById('cadConfSenha').value;
    const termos   = document.getElementById('termos').checked;
    let valid = true;

    if (nome.split(' ').filter(Boolean).length < 2) {
        document.getElementById('cadNome').classList.add('field-error');
        document.getElementById('errCadNome').classList.add('show');
        valid = false;
    }
    if (!isValidEmail(email)) {
        document.getElementById('cadEmail').classList.add('field-error');
        document.getElementById('errCadEmail').classList.add('show');
        valid = false;
    }
    if (senha.length < 6) {
        document.getElementById('cadSenha').classList.add('field-error');
        document.getElementById('errCadSenha').classList.add('show');
        valid = false;
    }
    if (senha !== conf) {
        document.getElementById('cadConfSenha').classList.add('field-error');
        document.getElementById('errCadConf').classList.add('show');
        valid = false;
    }
    if (!termos) {
        document.getElementById('errTermos').style.display = 'block';
        valid = false;
    }
    if (!valid) return;

    // Adiciona usuário na lista local (substituir por POST real)
    USUARIOS_CADASTRADOS.push({ email, senha });

    document.getElementById('successCadastro').classList.add('show');
    setTimeout(() => {
        document.getElementById('loginEmail').value = email;
        switchModalTab('login');
    }, 2000);
}