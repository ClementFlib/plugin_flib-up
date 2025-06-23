<?php
// Sécurité WordPress
if (!defined('ABSPATH')) exit;

// Header WP admin : inclut le menu gauche et la barre du haut
require_once ABSPATH . 'wp-admin/admin-header.php';

// On récupère le post
$post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
$post = $post_id ? get_post($post_id) : null;

// Gestion des anciennes métas (ou nouvelle)
$flibup_data = $post ? get_post_meta($post_id, '_flibup_data', true) : [];
if (!is_array($flibup_data)) $flibup_data = [];

$title = $post ? $post->post_title : '';
$content = $flibup_data['content'] ?? '';
$centered = $flibup_data['centered'] ?? false;

// Affichage messages WP (en cas de redirection après save)
if (isset($_GET['updated']) && $_GET['updated'] == 1) {
    echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Popup enregistrée avec succès !</p></div>';
}
?>

<div class="wrap flibup-builder">
    <h1>Flib-Up Popup Builder</h1>
    <form id="flibup-builder-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('flibup_save', 'flibup_nonce'); ?>
        <input type="hidden" name="action" value="flibup_save">
        <input type="hidden" name="post_id" value="<?php echo intval($post_id); ?>">
        <div style="display:flex; gap:40px; align-items: flex-start;">
            <!-- Colonne options -->
            <div style="flex:1;max-width:420px;">
                <h2>Paramètres</h2>
                <p>
                    <label for="flibup_title">Titre</label><br>
                    <input type="text" id="flibup_title" name="flibup_title" value="<?php echo esc_attr($title); ?>" style="width:100%;" />
                </p>
                <p>
                    <label for="flibup_content">Contenu</label><br>
                    <textarea id="flibup_content" name="flibup_content" rows="6" style="width:100%;"><?php echo esc_textarea($content); ?></textarea>
                </p>
                <div id="flibup_elements_list"></div>
                <button type="button" id="flibup_add_element" class="button">+ Ajouter un élément</button>
                <input type="hidden" name="flibup_elements" id="flibup_elements" value="">
                <button type="submit" class="button button-primary">Enregistrer</button>
            </div>
            <!-- Colonne preview -->
            <div style="flex:1;">
                <h2 style="text-align: center;">Aperçu de la popup</h2>
                <div id="flibup_preview_frame" class="flibup-preview-frame">
                    <div class="flibup-overlay"></div>
                    <div class="flibup-popup" id="flibup-popup">
                        <button class="flibup-close" type="button" title="Fermer la popup">&times;</button>
                        <h2 id="flibup_preview_title"><?php echo esc_html($title); ?></h2><br>
                        <p id="flibup_preview_content"><?php echo nl2br(esc_html($content)); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="module" src="<?php echo plugins_url('assets/js/flib-up-admin.js', dirname(__FILE__)); ?>"></script>

<?php
// Footer WP admin
require_once ABSPATH . 'wp-admin/admin-footer.php';
?>
