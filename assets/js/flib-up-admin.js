document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('flibup_centered');
    const preview = document.querySelector('.flibup-preview');
    if (!checkbox || !preview) return;

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            preview.classList.add('flibup-centered');
        } else {
            preview.classList.remove('flibup-centered');
        }
    });

    // Si tu veux gérer d'autres champs/preview dynamiques, ajoute ici
});
