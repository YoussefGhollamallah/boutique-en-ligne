document.querySelector('.ancre').addEventListener('click', function (e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien

    const targetId = this.getAttribute('href'); // Récupère l'ID de la cible
    const targetElement = document.querySelector(targetId); // Sélectionne l'élément cible

    if (targetElement) {
        targetElement.scrollIntoView({
            behavior: 'smooth' // Ajoute l'effet smooth scrolling
        });
    }
});
