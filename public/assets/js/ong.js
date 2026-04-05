function switchTab(name, el) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    el.classList.add('active');
}

function openAdoptModal() {
    document.getElementById('adoptModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeAdoptModal() {
    document.getElementById('adoptModal').classList.remove('open');
    document.body.style.overflow = '';
}

function handleOverlayClick(e) {
    if (e.target === document.getElementById('adoptModal')) {
        closeAdoptModal();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAdoptModal();
});