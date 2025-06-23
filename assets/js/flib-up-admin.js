document.addEventListener('DOMContentLoaded', function() {
    const centeredCheckbox = document.getElementById('flibup_centered');
    const preview = document.getElementById('flibup_preview');
    const contentEditor = document.getElementById('content'); // l’ID du textarea WP de l’éditeur classique

    // Centrage live
    if (centeredCheckbox && preview) {
        centeredCheckbox.addEventListener('change', function() {
            preview.classList.toggle('flibup-centered', this.checked);
        });
    }

    // Modification live du contenu (éditeur classique)
    if (contentEditor && preview) {
        contentEditor.addEventListener('input', function() {
            // Rendu HTML simple (pas de shortcodes WP ni de <p>)
            preview.innerHTML = this.value.replace(/\n/g, "<br>");
        });
    }

    // À compléter plus tard pour Gutenberg (éditeur visuel)
});