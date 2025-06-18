<?php
/*
Plugin Name: Flib-Up Popup Builder
Description: Créez des popups personnalisées avec aperçu en temps réel et shortcode, maj auto via GitHub.
Version: 0.0.1
Author: Clément GUEZOU - Développeur web à l'agence Les Flibustiers
*/

if (!defined('ABSPATH')) exit;

// --- Auto-update (Plugin Update Checker) ---
require_once plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';
$flibupUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/ClementFlib/plugin_flib-up/',  // Remplace avec ton dépôt GitHub
    __FILE__,
    'flib-up'
);

// --- Fichiers du plugin ---
require_once plugin_dir_path(__FILE__).'includes/class-flibup-cpt.php';
require_once plugin_dir_path(__FILE__).'includes/class-flibup-shortcode.php';

// Initialisation CPT et Shortcode
add_action('init', ['FlibUp_CPT', 'init']);
add_action('init', ['FlibUp_Shortcode', 'init']);

// Backend uniquement
if (is_admin()) {
    require_once plugin_dir_path(__FILE__).'admin/flib-up-admin.php';
}
