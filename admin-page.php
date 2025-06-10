<?php
global $wpdb;
$table = $wpdb->prefix . 'flibup_popups';

// AJOUT/MODIF
if (isset($_POST['flibup_save'])) {
    $id = intval($_POST['flibup_id']);
    $data = [
        'title' => sanitize_text_field($_POST['flibup_title']),
        'content' => wp_kses_post($_POST['flibup_content']),
        'options' => maybe_serialize(['bg_color' => sanitize_hex_color($_POST['flibup_bg_color'])]),
        'active' => intval(isset($_POST['flibup_active'])),
    ];
    if ($id) {
        $wpdb->update($table, $data, ['id' => $id]);
        echo '<div class="notice notice-success"><p>Popup modifiée.</p></div>';
    } else {
        $wpdb->insert($table, $data);
        echo '<div class="notice notice-success"><p>Popup ajoutée.</p></div>';
    }
}
// SUPPRESSION
if (isset($_GET['action']) && $_GET['action'] == 'delete' && $_GET['id']) {
    $wpdb->delete($table, ['id' => intval($_GET['id'])]);
    echo '<div class="notice notice-success"><p>Popup supprimée.</p></div>';
}

// EDIT/AJOUT FORM
if ((isset($_GET['action']) && $_GET['action'] == 'edit' && $_GET['id']) || (isset($_GET['action']) && $_GET['action'] == 'add')) {
    $row = ['id'=>0,'title'=>'','content'=>'','options'=>'','active'=>1];
    if (isset($_GET['id'])) {
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", intval($_GET['id'])), ARRAY_A);
        $opts = maybe_unserialize($row['options']);
    } else {
        $opts = [];
    }
    ?>
    <div class="wrap">
        <h2><?php echo $row['id'] ? 'Modifier' : 'Ajouter'; ?> une popup</h2>
        <form method="post">
            <input type="hidden" name="flibup_id" value="<?php echo esc_attr($row['id']); ?>">
            <table class="form-table">
                <tr><th>Titre</th><td><input type="text" name="flibup_title" value="<?php echo esc_attr($row['title']); ?>" required></td></tr>
                <tr><th>Contenu</th><td>
                    <textarea name="flibup_content" rows="6" style="width:100%"><?php echo esc_textarea($row['content']); ?></textarea>
                </td></tr>
                <tr><th>Couleur de fond</th><td>
                    <input type="color" name="flibup_bg_color" value="<?php echo esc_attr($opts['bg_color'] ?? '#ffffff'); ?>">
                </td></tr>
                <tr><th>Active</th><td>
                    <input type="checkbox" name="flibup_active" value="1" <?php checked($row['active'],1); ?>> Afficher cette popup
                </td></tr>
            </table>
            <p><input type="submit" class="button-primary" name="flibup_save" value="Enregistrer"></p>
        </form>
        <p><a href="?page=flibup_popups">&larr; Retour à la liste</a></p>
    </div>
    <?php
    return;
}

// LISTING
$rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
?>
<div class="wrap">
    <h1>Popups <a href="?page=flibup_popups&action=add" class="page-title-action">Ajouter</a></h1>
    <table class="widefat striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Shortcode</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo $row->id; ?></td>
            <td><?php echo esc_html($row->title); ?></td>
            <td>[popup id="<?php echo $row->id; ?>"]</td>
            <td><?php echo $row->active ? 'Oui' : 'Non'; ?></td>
            <td>
                <a href="?page=flibup_popups&action=edit&id=<?php echo $row->id; ?>">Modifier</a> |
                <a href="?page=flibup_popups&action=delete&id=<?php echo $row->id; ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
