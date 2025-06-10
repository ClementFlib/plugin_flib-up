<?php
/*
Plugin Name: Flib'up
Description: Plugin de création de popups personnalisées avec shortcode, update checker inclus.
Version: 0.0.1
Author: Clément GUEZOU - Développeur web chez Les Flibustiers
*/

if (!defined('ABSPATH')) exit;

define('FLIBUP_VERSION', '1.0.0');
define('FLIBUP_DIR', plugin_dir_path(__FILE__));
define('FLIBUP_URL', plugin_dir_url(__FILE__));

//Créer la table à l’activation
register_activation_hook(__FILE__, 'flibup_create_table');
function flibup_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'flibup_popups';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
      id INT NOT NULL AUTO_INCREMENT,
      title VARCHAR(255) NOT NULL,
      content LONGTEXT NOT NULL,
      options TEXT NULL,
      active TINYINT(1) DEFAULT 1,
      PRIMARY KEY (id)
    ) $charset;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

//Ajouter le menu admin
add_action('admin_menu', function() {
    add_menu_page(
        'Flib-Up Popups',
        'Popups',
        'manage_options',
        'flibup_popups',
        'flibup_admin_page',
        'dashicons-external',
        30
    );
    // assets CSS/JS admin
    add_action('admin_enqueue_scripts', function($hook) {
        if ($hook == 'toplevel_page_flibup_popups') {
            wp_enqueue_style('flibup-admin', FLIBUP_URL . 'assets/flibup-admin.css');
            wp_enqueue_script('flibup-admin', FLIBUP_URL . 'assets/flibup-admin.js', ['jquery'], FLIBUP_VERSION, true);
        }
    });
});

//Page d’admin CRUD (listing + ajout + edit + delete)
function flibup_admin_page() {
    require FLIBUP_DIR . 'admin-page.php';
}

//Shortcode front
add_shortcode('popup', 'flibup_popup_shortcode');
function flibup_popup_shortcode($atts) {
    global $wpdb;
    $atts = shortcode_atts(['id' => 0], $atts);
    $id = (int)$atts['id'];
    if (!$id) return '';
    $table = $wpdb->prefix . 'flibup_popups';
    $popup = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$popup || !$popup->active) return '';
    $options = $popup->options ? json_decode($popup->options, true) : [];
    ob_start(); ?>
    <div class="flibup-popup" style="background:<?php echo esc_attr($options['bg_color'] ?? '#fff'); ?>">
        <div class="flibup-popup-content">
            <?php echo wpautop($popup->content); ?>
            <button class="flibup-close">Fermer</button>
        </div>
    </div>
    <?php
    wp_enqueue_style('flibup-popup', FLIBUP_URL . 'assets/flibup-popup.css', [], FLIBUP_VERSION);
    wp_enqueue_script('flibup-popup', FLIBUP_URL . 'assets/flibup-popup.js', [], FLIBUP_VERSION, true);
    return ob_get_clean();
}

require FLIBUP_DIR . 'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/ClementFlib/plugin_flib-up',
    __FILE__,
    'flib-up'
);