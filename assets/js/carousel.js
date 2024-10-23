document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.carousel');
    const items = carousel.querySelectorAll('.carousel-item');
    const prevButton = carousel.querySelector('.carousel-control-prev');
    const nextButton = carousel.querySelector('.carousel-control-next');
    let currentIndex = 0;
    const intervalTime = 5000; // Temps en millisecondes entre chaque slide
    let slideInterval;

    function showItem(index) {
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
    }

    function showNextItem() {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
    }

    function showPrevItem() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showItem(currentIndex);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(showNextItem, intervalTime);
    }

    nextButton.addEventListener('click', () => {
        showNextItem();
        resetInterval();
    });

    prevButton.addEventListener('click', () => {
        showPrevItem();
        resetInterval();
    });

    // Défilement automatique
    slideInterval = setInterval(showNextItem, intervalTime);
});