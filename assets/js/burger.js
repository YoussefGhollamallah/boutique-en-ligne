document.addEventListener('DOMContentLoaded', function() {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');

    burger.addEventListener('click', function() {
        nav.classList.toggle('nav-active');
        burger.classList.toggle('toggle');
    });

    function disableNavOnDesktop() {
        if (window.innerWidth > 768) {
            nav.classList.remove('nav-active');
            burger.classList.remove('toggle');
        }
    }

    window.addEventListener('resize', disableNavOnDesktop);
    disableNavOnDesktop(); // Initial check
});