<?php
/*
Plugin Name: Flib-Up Popup Builder
Description: Créez des popups personnalisées avec aperçu en temps réel et shortcode, maj auto via GitHub.
Version: 0.0.1
Author: Clément GUEZOU - Développeur web à l'agence Les Flibustiers
*/

if (!defined('ABSPATH')) exit;

// Permet de vérifier la version pour MAJ auto du plugin
require plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';

// Namespace de la librairie de PUC -> plugin pour maj auto
use YahnisElsts\PluginUpdateChecker\v5p6\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/ClementFlib/plugin_flib-up/', // URL du dépôt GitHub
    __FILE__, // Chemin vers le fichier principal du plugin
    'flib-up' // Slug du plugin
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
