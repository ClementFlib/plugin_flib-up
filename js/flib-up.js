//Icone ouverture/fermeture/reset menu
document.querySelectorAll('.fliburger-icon').forEach(icon => {
    icon.addEventListener('click', function() {

        const uniqueId = icon.id.replace('-icon', '');

        // Trouver le menu correspondant en utilisant l'ID unique
        const menu = document.getElementById(uniqueId);

        // Toggle l'état ouvert/fermé du menu burger
        if (menu) {
            menu.classList.toggle('open');
        }

        // Fermer tous les sous-menus à l'intérieur de ce conteneur spécifique
        const submenus = menu.querySelectorAll('.submenu-container');
        submenus.forEach(submenu => {
            submenu.classList.remove('open');
        });

        // Toggle la classe active sur l'icône cliquée
        icon.classList.toggle('open');

    });
});

// Ouverture des sous-menus
const menuItems = document.querySelectorAll('.menu-item');

menuItems.forEach(item => {
    item.addEventListener('click', (event) => {
		event.stopPropagation(); // Empêche la propagation de l'événement
        const submenu = item.querySelector('.submenu-container');
        const link = item.querySelector('a');

        // Vérifier si le sous-menu existe ET contient des éléments
        if (submenu) {
            event.preventDefault(); // Bloque la navigation

            // Ouvrir le sous-menu
            submenu.classList.add('open');

            // Gestion du bouton "backdash"
            const backdash = submenu.querySelector('.backdash');
            if (backdash && !backdash.dataset.listenerAdded) {
                backdash.addEventListener('click', (backEvent) => {
                    backEvent.stopPropagation(); // Empêche la propagation
                    submenu.classList.remove('open');
                });

                // Éviter les multiples écouteurs
                backdash.dataset.listenerAdded = "true";
            }
        } else if (link) {
            return; // Permet au navigateur de suivre le lien normalement
        }
    });
});

// Fermer le menu burger si on clique en dehors
document.addEventListener('click', function(event) {
    if (!event.target.closest('.fliburger-icon') && !event.target.closest('.fliburger-menu')) {
        document.querySelectorAll('.fliburger-menu').forEach(menu => {
            menu.classList.remove('open');
        });
        document.querySelectorAll('.fliburger-icon').forEach(icon => {
            icon.classList.remove('open');
        });
    }
});

const currentUrl = window.location.href;
document.querySelectorAll('.burger-menu-list li a').forEach(link => {
    if (link.href === currentUrl) {
        link.classList.add('active-page');
    }
});