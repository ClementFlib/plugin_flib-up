<?php
// Récupération des infos du post
$post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
$post = get_post($post_id);

// Données déjà en base (pour préremplir le builder)
$flibup_data = get_post_meta($post_id, '_flibup_data', true);
if (!is_array($flibup_data)) $flibup_data = [];

$title = $post->post_title;
$content = $flibup_data['content'] ?? '';
$centered = $flibup_data['centered'] ?? false;
?>

<div class="wrap flibup-builder">
    <h1>Flib-Up Popup Builder</h1>
    <form id="flibup-builder-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <?php wp_nonce_field('flibup_save', 'flibup_nonce'); ?>
        <div style="display:flex; gap:40px;">
            <!-- Colonne preview -->
            <div style="flex:1;">
                <h2>Aperçu popup</h2>
                <div id="flibup_preview" class="flibup-preview<?php if ($centered) echo ' flibup-centered'; ?>">
                    <strong><?php echo esc_html($title); ?></strong><br>
                    <span><?php echo nl2br(esc_html($content)); ?></span>
                </div>
            </div>
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
                <p>
                    <label>
                        <input type="checkbox" id="flibup_centered" name="flibup_centered" value="1" <?php checked($centered, 1); ?> />
                        Centrer le contenu
                    </label>
                </p>
                <button type="submit" class="button button-primary">Enregistrer</button>
            </div>
        </div>
        <input type="hidden" name="post_id" value="<?php echo intval($post_id); ?>">
        <input type="hidden" name="action" value="flibup_save">
    </form>
</div>

<style>
.flibup-builder { max-width: 1200px; }
.flibup-preview {
    border: 1px solid #ddd;
    min-height: 120px;
    background: #fff;
    padding: 24px;
    margin-bottom: 20px;
    font-size: 18px;
    transition: text-align 0.2s;
}
.flibup-centered { text-align: center; }
</style>

<script>
// JS natif : preview live
document.addEventListener('DOMContentLoaded', function(){
    const titleInput = document.getElementById('flibup_title');
    const contentInput = document.getElementById('flibup_content');
    const centeredInput = document.getElementById('flibup_centered');
    const preview = document.getElementById('flibup_preview');

    function updatePreview() {
        let html = "<strong>" + (titleInput.value || '') + "</strong><br><span>" + (contentInput.value || '').replace(/\n/g, '<br>') + "</span>";
        preview.innerHTML = html;
        preview.classList.toggle('flibup-centered', centeredInput.checked);
    }
    [titleInput, contentInput, centeredInput].forEach(el => {
        if (el) el.addEventListener('input', updatePreview);
        if (el && el.type === "checkbox") el.addEventListener('change', updatePreview);
    });
});
</script>
