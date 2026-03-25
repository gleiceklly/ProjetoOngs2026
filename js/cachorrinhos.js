const items = document.querySelectorAll('.glass-navbar li');

items.forEach(item => {
    item.addEventListener('click', (e) => {
        
        e.preventDefault();
        
        items.forEach(i => i.classList.remove('active'));
        
        item.classList.add('active');
    });
});

const animais = [
    {
        img: "https://images.unsplash.com/photo-1583511655857-d19b40a7a54e",
        desc: "Muito dócil e adora brincar!",
        info: "Rex, Rottweiler<br>12 anos"
    },
    {
        img: "https://images.unsplash.com/photo-1517849845537-4d257902454a",
        desc: "Carinhoso e companheiro.",
        info: "Luna, Vira-lata<br>3 anos"
    },
    {
        img: "https://images.unsplash.com/photo-1537151625747-768eb6cf92b2",
        desc: "Cheio de energia!",
        info: "Thor, Labrador<br>2 anos"
    }
];

let index = 0;

const img = document.getElementById("animal-img");
const desc = document.getElementById("animal-desc");
const info = document.getElementById("animal-info");

function mostrarAnimal(i) {
    img.src = animais[i].img;
    desc.innerText = `"${animais[i].desc}"`;
    info.innerHTML = animais[i].info;
}

document.getElementById("next").onclick = () => {
    index = (index + 1) % animais.length;
    mostrarAnimal(index);
};

document.getElementById("prev").onclick = () => {
    index = (index - 1 + animais.length) % animais.length;
    mostrarAnimal(index);
};

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