<?php
function burger_flibustiers_add_admin_menu() {
    add_menu_page(
        'Réglages du Menu Burger',          // Titre de la page
        'Fliburger',                        // Titre du menu
        'manage_options',                   // Capacité requise
        'fliburger_settings',               // Slug de la page
        'burger_flibustiers_settings_page', // Callback pour afficher le contenu
        'dashicons-menu-alt',               // Icône du menu
    );
}
add_action('admin_menu', 'burger_flibustiers_add_admin_menu');

function burger_flibustiers_settings_page() {
    ?>
    <div class="wrap">
        <h1>Réglages du Menu Burger</h1>
        <p>
            Pour afficher le menu sur une page, vous pouvez utiliser le shortcode <code>[burger_menu]</code>.<br>
            Pour préciser quel menu vous souhaitez afficher dans le burger, utilisez le shortcode <code>[burger_menu menu="nom_du_menu"]</code> ou <code>"nom_du_menu"</code> est le nom sous lequel vous avez enregistré votre menu dans la section Apparences du backoffice.
        </p>
        <form action="options.php" method="post">
            <?php
            settings_fields('burgerFlibustiers');
            do_settings_sections('burgerFlibustiers');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
