export function initPreview() {
    // Génère le HTML de la popup en fonction du tableau d’éléments (JSON)
    // Applique les styles (reçus de styles.js), gère la preview en direct

    const titleInput = document.getElementById('flibup_title');
    const contentInput = document.getElementById('flibup_content');
    const preview = document.getElementById('flibup-popup');

    function updatePreview() {
        let html = "<h2>" + (titleInput.value || '') + "</h2><br><p>" + (contentInput.value || '').replace(/\n/g, '<br>') + "</p>";
        preview.innerHTML = html;
    }
    [titleInput, contentInput].forEach(el => {
        if (el) el.addEventListener('input', updatePreview);
        if (el && el.type === "checkbox") el.addEventListener('change', updatePreview);
    });

    updatePreview();
}