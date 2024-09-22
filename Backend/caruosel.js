let currentSlide = 0;
const totalSlides = document.querySelectorAll('.slide').length;
const visibleSlides = 3; // Número de slides visibles, ajusta según necesites

function showSlide(index) {
    const slideWidth = document.querySelector('.slide').offsetWidth;
    const maxIndex = totalSlides - visibleSlides; // El índice máximo que podemos alcanzar sin mostrar espacio vacío
    if (index > maxIndex) {
        currentSlide = maxIndex;
    } else if (index < 0) {
        currentSlide = 0;
    } else {
        currentSlide = index;
    }

    document.querySelector('.carousel').style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}

function moveSlide(direction) {
    showSlide(currentSlide + direction);
}

window.addEventListener('resize', () => showSlide(currentSlide)); // Asegura que el carrusel se ajuste al redimensionar la ventana

showSlide(currentSlide);