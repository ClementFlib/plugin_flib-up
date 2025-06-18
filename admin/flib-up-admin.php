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
        wp_enqueue_script('flibup-admin', plugin_dir_url(__FILE__).'../assets/js/flib-up-admin.js', [], false, true);
    }
});
