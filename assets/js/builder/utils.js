// Exemple d’utilitaire
export function escapeHtml(text) {
    return text ? text.replace(/[<>"'&]/g, function (c) {
        return ({
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '&': '&amp;'
        })[c];
    }) : '';
}
