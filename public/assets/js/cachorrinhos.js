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
    const arrowLeft  = document.getElementById('arrowLeft');
    const arrowRight = document.getElementById('arrowRight');
    if (!arrowLeft || !arrowRight) return;

    const cards = document.querySelectorAll('#petCarousel .pet-card');
    const totalPages = Math.ceil(cards.length / itemsPerPage);
    cards.forEach((card, index) => {
        if (index >= itemsPerPage) card.style.display = 'none';
    });
    arrowLeft.disabled  = true;
    arrowRight.disabled = totalPages <= 1;
});

