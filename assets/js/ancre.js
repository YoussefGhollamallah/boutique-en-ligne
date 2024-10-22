window.addEventListener('scroll', function () {
    const ancre = document.querySelector('.ancre');
    if (window.scrollY > 1500) {
        ancre.style.opacity = '1';
        ancre.style.pointerEvents = 'auto';  // Pour activer le clic
    } else {
        ancre.style.opacity = '0';
        ancre.style.pointerEvents = 'none';  // Désactive le clic quand l'ancre est invisible
    }
});

document.querySelector('.ancre').addEventListener('click', function (e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien

    const targetId = this.getAttribute('href'); // Récupère l'ID de la cible
    const targetElement = document.querySelector(targetId); // Sélectionne l'élément cible

    if (targetElement) {
        targetElement.scrollIntoView({
            behavior: 'smooth' 
        });
    }
});
