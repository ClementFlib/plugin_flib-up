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
        $centered = get_post_meta($post->ID, '_flibup_centered', true);
        ?>
        <p>
            <label>
                <input type="checkbox" name="flibup_centered" id="flibup_centered" value="1" <?php checked($centered, 1); ?>>
                Centrer le contenu de la popup
            </label>
        </p>
        <h4>Aperçu (statique)</h4>
        <div class="flibup-preview<?php if ($centered) echo ' flibup-centered'; ?>">
            <?php echo wpautop( esc_html( $post->post_content ) ); ?>
        </div>
        <?php
    }

    public static function save_popup_meta($post_id) {
        if (array_key_exists('flibup_centered', $_POST)) {
            update_post_meta($post_id, '_flibup_centered', 1);
        } else {
            update_post_meta($post_id, '_flibup_centered', 0);
        }
    }
}
