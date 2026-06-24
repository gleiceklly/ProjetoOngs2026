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

function selectCard(el, causa) {
    document.querySelectorAll('.donation-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedCausa = causa;
    selectedOngId = el.dataset.ongId || null;

    const pix = el.dataset.pix;
    if (pix) {
        document.getElementById('pixKey').textContent = pix;
    } else if (selectedOngId) {
        document.getElementById('pixKey').textContent = 'Entre em contato com a ONG';
    }

    updateSummary();
}

function updateCustom(val) {
    const v = parseFloat(val);
    selectedValor = isNaN(v) ? null : v;
    document.getElementById('customPrice').textContent = isNaN(v) ? 'R$ -' : 'R$ ' + v.toFixed(2).replace('.', ',');
    updateSummary();
}

function updateSummary() {
    const labels = { mensal: 'Mensal', unica: 'Única' };
    const payLabels = { pix: 'Pix' };

    document.getElementById('sumCausa').textContent = selectedCausa || '—';
    document.getElementById('sumPlano').textContent = labels[selectedPlano] || '—';
    document.getElementById('sumPagamento').textContent = selectedPayment ? payLabels[selectedPayment] : '—';
    document.getElementById('sumTotal').textContent = selectedValor ? 'R$ ' + selectedValor.toFixed(2).replace('.', ',') : 'R$ —';
}

function copyPix() {
    const key = document.getElementById('pixKey').textContent;
    navigator.clipboard.writeText(key).then(() => {
        const btn = document.querySelector('.copy-btn');
        btn.textContent = 'Copiado!';
        setTimeout(() => btn.textContent = 'Copiar', 2000);
    });
}

function submitDonation() {
    if (!selectedOngId) { alert('Por favor, selecione uma ONG para doação.'); return; }
    if (!selectedValor || selectedValor <= 0) { alert('Informe um valor para doação.'); return; }

    const nome     = document.getElementById('nome').value.trim();
    const email    = document.getElementById('email').value.trim();
    const cpf      = document.getElementById('cpf').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    if (!nome || !email || !cpf || !telefone) { alert('Por favor, preencha todos os dados pessoais.'); return; }

    document.getElementById('hidden-ong-id').value         = selectedOngId;
    document.getElementById('hidden-valor').value          = selectedValor;
    document.getElementById('hidden-plano').value          = selectedPlano;
    document.getElementById('hidden-forma-pagamento').value = selectedPayment;

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
