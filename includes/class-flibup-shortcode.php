<?php
class FlibUp_Shortcode {
    public static function init() {
        add_shortcode('flibup', [__CLASS__, 'render_popup']);
    }

    public static function render_popup($atts) {
        $atts = shortcode_atts([
            'id' => '',
        ], $atts);

        $post_id = intval($atts['id']);
        if (!$post_id) return '';

        $popup = get_post($post_id);
        if (!$popup || $popup->post_type !== 'flib_popup') return '';

        $centered = get_post_meta($post_id, '_flibup_centered', true);

        ob_start();
        ?>
        <div class="flibup-popup <?php if ($centered) echo 'flibup-centered'; ?>">
            <div class="flibup-popup-content">
                <?php echo apply_filters('the_content', $popup->post_content); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
