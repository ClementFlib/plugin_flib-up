<?php
function burger_flibustiers_apply_custom_styles() {

    $options        = get_option('burger_flibustiers_options');
    $bgcolor        = !empty($options['burger_flibustiers_bgcolor']) ? esc_attr($options['burger_flibustiers_bgcolor']) : '#6152D3';
    $iconcolor      = !empty($options['burger_flibustiers_icon_color']) ? esc_attr($options['burger_flibustiers_icon_color']) : '#FFF';
    $color          = !empty($options['burger_flibustiers_color']) ? esc_attr($options['burger_flibustiers_color']) : '#FFF';
    $activecolor    = !empty($options['burger_flibustiers_active_color']) ? esc_attr($options['burger_flibustiers_active_color']) : '#FFF';
    $font           = isset($options['burger_flibustiers_font']) && $options['burger_flibustiers_font'] !== 'default' ? esc_attr($options['burger_flibustiers_font']) : false;
    
    // Récupération des styles typographiques sélectionnés (tableau de styles cochés)
    $selected_styles = isset($options['burger_flibustiers_typo_styles']) ? $options['burger_flibustiers_typo_styles'] : [];
    $style_rules = [];
    // Vérifie quels styles ont été sélectionnés et ajoute les règles CSS correspondantes
    if (in_array('uppercase', $selected_styles)) {
        $style_rules[] = 'text-transform: uppercase;';
    }
    if (in_array('bold', $selected_styles)) {
        $style_rules[] = 'font-weight: bold;';
    }
    if (in_array('underline', $selected_styles)) {
        $style_rules[] = 'text-decoration: underline;';
    }
    if (in_array('italic', $selected_styles)) {
        $style_rules[] = 'font-style: italic;';
    }
    // Convertir les règles CSS en une chaîne unique
    $style_inline = implode(' ', $style_rules);
    
    ?>

    <style type="text/css">
        .fliburger-icon span{
            background-color: <?php echo $iconcolor; ?>;
        }
        .fliburger-menu, .submenu-container {
            background-color: <?php echo $bgcolor; ?>;
        }
        .burger-menu-list li a, .backdash {
            color: <?php echo $color; ?>;
            <?php if ($font): ?>
                font-family: <?php echo $font; ?>;
            <?php endif; // Si "default" est sélectionné, on omet cette ligne ?>
        }
        .burger-menu-list li a{
            color: <?php echo $color; ?>;
            <?php if (!empty($style_inline)): ?>
                <?php echo $style_inline; ?>
            <?php endif; ?>
        }
        .burger-menu-list li a.active-page{
            color: <?php echo $activecolor; ?>;
        }
    </style>

    <?php
}
add_action('wp_head', 'burger_flibustiers_apply_custom_styles');