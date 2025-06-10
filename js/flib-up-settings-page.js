//Code destiné au backoffice et pas au front du site
function addAndRemoveSocialLinks() {
    console.log('here');

    let index = document.querySelectorAll('.social-link').length;
    const container = document.querySelector('#add-social-link').parentNode;

    // Fonction pour ajouter un nouveau réseau social
    document.querySelector('#add-social-link').addEventListener('click', function () {
        const template = document.querySelector('#new-social-link-template').cloneNode(true);
        template.style.display = 'block';
        template.innerHTML = template.innerHTML.replace(/index_placeholder/g, index++);
        container.insertBefore(template, this);
    });

    // Fonction pour supprimer un réseau social
    container.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-social-link')) {
            event.target.parentNode.remove();
        }
    });
}

// Exécute la fonction une fois le DOM chargé
document.addEventListener('DOMContentLoaded', addAndRemoveSocialLinks);