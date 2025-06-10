<?php
/*
Plugin Name: Flib'up
Description: Le pluginb de popup des Flibustiers
Version: 0.0.1
Author: Clément GUEZOU - Développeur web chez Les Flibustiers
*/

// Permet de vérifier la version pour MAJ auto du plugin
require plugin_dir_path(__FILE__) . 'includes/plugin-update-checker/plugin-update-checker.php';

// Inclut les fichiers nécessaires
include plugin_dir_path(__FILE__) . 'includes/settings-register.php';
include plugin_dir_path(__FILE__) . 'includes/settings-page.php';
include plugin_dir_path(__FILE__) . 'includes/shortcode.php';
include plugin_dir_path(__FILE__) . 'includes/custom-styles.php';

// Ajout des fichiers CSS et JS
function enqueue_flib_up_assets() {
    wp_enqueue_style('flib-up-css', plugin_dir_url(__FILE__) . 'css/flib-up.css');
    wp_enqueue_script('flib-up-js', plugin_dir_url(__FILE__) . 'js/flib-up.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_flib_up_assets');

function enqueue_flib_up_admin_assets($hook) {
    // Le slug de la page de réglages
    if ($hook !== 'toplevel_page_flibup_settings') {
        return;
    }

    // Charge les styles et scripts nécessaires uniquement dans le back-office
    wp_enqueue_script('flib-up-settings-page-js', plugin_dir_url(__FILE__) . 'js/flib-up-settings-page.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_flib_up_admin_assets');

// Charge la bibliothèque dashicons de WP pour les boutons RS
function load_dashicons_front_end() {
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons_front_end');

// Namespace de la librairie de PUC -> plugin pour maj auto
use YahnisElsts\PluginUpdateChecker\v5p4\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/ClementFlib/plugin_flib-up.git', // URL du dépôt GitHub
    __FILE__, // Chemin vers le fichier principal du plugin
    'plugin_flib-up' // Slug du plugin
);

// Définis la branche, ici `master` par défaut.
$updateChecker->setBranch('master');