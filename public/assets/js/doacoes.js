let selectedPlano = 'unica';
let selectedCausa = null;
let selectedOngId = null;
let selectedValor = null;
let selectedPayment = 'pix';

function setPlano(plano) {
    selectedPlano = plano;
    document.getElementById('btnMensal').classList.toggle('active', plano === 'mensal');
    document.getElementById('btnUnica').classList.toggle('active', plano === 'unica');
    updateSummary();
}

function selectCard(el) {
    document.querySelectorAll('.donation-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');

    selectedCausa = el.dataset.nome || null;
    selectedOngId = el.dataset.ongId || null;

    const pix = el.dataset.pix;
    const copyBtn = document.querySelector('.copy-btn');

    if (pix) {
        document.getElementById('pixKey').textContent = pix;
        if (copyBtn) copyBtn.style.display = '';
    } else if (selectedOngId) {
        document.getElementById('pixKey').textContent = 'Esta ONG não possui chave PIX cadastrada.';
        if (copyBtn) copyBtn.style.display = 'none';
    }

    updateSummary();
}

function updateSummary() {
    document.getElementById('sumCausa').textContent   = selectedCausa || '—';
    document.getElementById('sumTotal').textContent   = selectedValor ? 'R$ ' + selectedValor.toFixed(2).replace('.', ',') : 'R$ —';
    document.getElementById('sumNome').textContent    = document.getElementById('nome').value.trim()     || '—';
    document.getElementById('sumEmail').textContent   = document.getElementById('email').value.trim()    || '—';
    document.getElementById('sumCpf').textContent     = document.getElementById('cpf').value.trim()      || '—';
    document.getElementById('sumTelefone').textContent = document.getElementById('telefone').value.trim() || '—';
}

function updateCustom(val) {
    const v = parseFloat(val);
    selectedValor = isNaN(v) ? null : v;
    document.getElementById('customPrice').textContent = isNaN(v) ? 'R$ -' : 'R$ ' + v.toFixed(2).replace('.', ',');
    updateSummary();
}

function copyPix() {
    const key = document.getElementById('pixKey').textContent;
    const btn = document.querySelector('.copy-btn');

    // Proteção extra: impede a cópia do placeholder caso o botão fique visível por algum bug de CSS
    if (key.includes('não possui') || key.includes('Entre em contato')) {
        return;
    }

    // Função auxiliar para manter sua lógica de feedback visual unificada
    const showSuccess = () => {
        if (btn) {
            btn.textContent = 'Copiado!';
            setTimeout(() => btn.textContent = 'Copiar', 2000);
        }
    };

    // Tenta a API moderna primeiro (HTTPS / Localhost)
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(key)
            .then(showSuccess)
            .catch(err => console.error('Erro na API Clipboard:', err));
    } else {
        // Fallback para conexões HTTP
        const textArea = document.createElement("textarea");
        textArea.value = key;

        // Estilização para evitar "pulos" na tela quando o textarea receber foco
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showSuccess();
            }
        } catch (err) {
            console.error('Erro no Fallback de cópia:', err);
        }

        document.body.removeChild(textArea);
    }
}

function submitDonation() {
    if (!selectedOngId) { alert('Por favor, selecione uma ONG para doação.'); return; }
    if (!selectedValor || selectedValor <= 0) { alert('Informe um valor para doação.'); return; }

    const nome     = document.getElementById('nome').value.trim();
    const email    = document.getElementById('email').value.trim();
    const cpf      = document.getElementById('cpf').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    if (!nome || !email || !cpf || !telefone) { alert('Por favor, preencha todos os dados pessoais.'); return; }

    document.getElementById('hidden-ong-id').value          = selectedOngId;
    document.getElementById('hidden-valor').value           = selectedValor;
    document.getElementById('hidden-forma-pagamento').value = selectedPayment;  // ← só esses 3

    document.getElementById('formDoacao').submit();
}

function maskCPF(el) {
    let v = el.value.replace(/\D/g, '').slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    el.value = v;
}

function maskPhone(el) {
    let v = el.value.replace(/\D/g, '').slice(0, 11);
    v = v.replace(/^(\d{2})(\d)/, '($1) $2');
    v = v.replace(/(\d{5})(\d)/, '$1-$2');
    el.value = v;
}

function maskCard(el) {
    let v = el.value.replace(/\D/g, '').slice(0, 16);
    v = v.replace(/(\d{4})/g, '$1 ').trim();
    el.value = v;
}

function maskExpiry(el) {
    let v = el.value.replace(/\D/g, '').slice(0, 4);
    if (v.length >= 2) v = v.slice(0,2) + '/' + v.slice(2);
    el.value = v;
}