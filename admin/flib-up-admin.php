<?php
// Backend : enqueue CSS/JS pour le builder admin
add_action('admin_enqueue_scripts', function($hook) {
    // On cible l'édition d'un popup seulement
    global $post;
    if (
        isset($post) &&
        $post->post_type === 'flib_popup' &&
        in_array($hook, ['post.php', 'post-new.php'])
    ) {
        wp_enqueue_style('flibup-admin', plugin_dir_url(__FILE__).'../assets/css/flib-up-admin.css');
        // wp_enqueue_script('flibup-admin', plugin_dir_url(__FILE__).'../assets/js/flib-up-admin.js', [], false, true);
    }
});

// On remplace l’écran d’édition standard par notre builder
add_action('load-post.php', 'flibup_replace_editor');
add_action('load-post-new.php', 'flibup_replace_editor');

function flibup_replace_editor() {
    $screen = get_current_screen();
    if ($screen->post_type === 'flib_popup') {
        // Hook pour enlever l’éditeur WP
        add_filter('replace_editor', function($editor, $post) {
            if ($post->post_type === 'flib_popup') {
                // Charge notre page builder custom
                require plugin_dir_path(__FILE__).'flib-up-builder-page.php';
                exit; // On arrête tout ici, seule notre page s’affiche
            }
            return $editor;
        }, 10, 2);
    }
}

add_action('admin_post_flibup_save', function() {
    if (!isset($_POST['flibup_nonce']) || !wp_verify_nonce($_POST['flibup_nonce'], 'flibup_save')) {
        wp_die('Sécurité WordPress : nonce manquant');
    }
    $post_id = intval($_POST['post_id']);
    // Tu peux aussi vérifier l’authorisation ici

    $data = [
        'content'  => sanitize_textarea_field($_POST['flibup_content'] ?? ''),
        'centered' => isset($_POST['flibup_centered']) ? 1 : 0,
    ];
    update_post_meta($post_id, '_flibup_data', $data);

    // On peut aussi modifier le titre du post WP si besoin :
    if (isset($_POST['flibup_title'])) {
        wp_update_post([
            'ID' => $post_id,
            'post_title' => sanitize_text_field($_POST['flibup_title'])
        ]);
    }

    wp_redirect( admin_url('post.php?post='.$post_id.'&action=edit&updated=1') );
    exit;
});