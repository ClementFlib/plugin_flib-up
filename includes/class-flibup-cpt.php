<?php
class FlibUp_CPT {
    public static function init() {
        self::register_post_type();
        add_action('add_meta_boxes', [__CLASS__, 'add_meta_boxes']);
        add_action('save_post', [__CLASS__, 'save_popup_meta']);
    }

    public static function register_post_type() {
        register_post_type('flib_popup', [
            'label' => 'Popups',
            'public' => false,
            'show_ui' => true,
            'supports' => ['title', 'editor'],
            'menu_icon' => 'dashicons-external',
        ]);
    }

    public static function add_meta_boxes() {
        add_meta_box(
            'flibup_popup_options',
            'Options de la popup',
            [__CLASS__, 'render_meta_box'],
            'flib_popup',
            'normal',
            'high'
        );
    }

    public static function render_meta_box($post) {
        // Simple exemple, à étoffer avec tes options de styles/animations
        ?>
        <p>
            <label for="flibup_centered">
                <input type="checkbox" name="flibup_centered" id="flibup_centered" value="1" <?php checked(get_post_meta($post->ID, '_flibup_centered', true), 1); ?> />
                Centrer le contenu ?
            </label>
        </p>
        <?php
    }

    public static function save_popup_meta($post_id) {
        if (isset($_POST['flibup_centered'])) {
            update_post_meta($post_id, '_flibup_centered', 1);
        } else {
            update_post_meta($post_id, '_flibup_centered', 0);
        }
    }
}
