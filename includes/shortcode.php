<?php
// Utiliser [burger_menu] pour appeler ce shortcode
function burger_menu_shortcode($atts) {
    $options = get_option('burger_flibustiers_options');
    $animation_class = isset($options['burger_flibustiers_animation']) ? $options['burger_flibustiers_animation'] : 'slide-from-right';
    $unique_id = 'menu-burger-' . uniqid() . '-' . mt_rand(1000, 9999); //génère un id unique en cas debesoin de plusieurs instances du menu

    $atts = shortcode_atts(array(
        'menu' => '', // Nom du menu tel qu'enregistré dans WordPress
    ), $atts);

    // Si aucun menu n'est spécifié, utilise le menu principal
    if (empty($atts['menu'])) {
        $locations = get_nav_menu_locations();
        if (isset($locations['primary'])) {
            $menu_object = wp_get_nav_menu_object($locations['primary']);
            $atts['menu'] = $menu_object->name;
        }
    }

    // Récupérer les éléments du menu
    $menu_items = wp_get_nav_menu_items($atts['menu']);
    if (!$menu_items) {
        return '<p>Menu introuvable.</p>';
    }

    // Organiser les éléments du menu par parent
    $menu_tree = [];
    foreach ($menu_items as $item) {
        $parent_id = $item->menu_item_parent;
        if (!isset($menu_tree[$parent_id])) {
            $menu_tree[$parent_id] = [];
        }
        $menu_tree[$parent_id][] = $item;
    }

    // Générer le HTML récursivement
    ob_start();
    ?>
    <div id="<?php echo esc_attr($unique_id).'-icon'; ?>" class="fliburger-icon">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div id="<?php echo esc_attr($unique_id); ?>" class="fliburger-menu <?php echo esc_attr($animation_class); ?>">

        <?php echo generate_menu_html_recursive($menu_tree, 0, $animation_class); 

        $socials = get_option('burger_flibustiers_social_links', []);
        if ($socials) {
            echo '<div class="social-links">';
            foreach ($socials as $social) {
                echo '<a href="' . esc_url($social['url']) . '" target="_blank" class="social-link social-link-' . esc_attr($social['network']) . '">';
                switch ($social['network']) {
                    case 'facebook':
                        echo '<span class="dashicons dashicons-facebook"></span>';
                        break;
                    case 'youtube':
                        echo '<span class="dashicons dashicons-youtube"></span>';
                        break;
                    case 'instagram':
                        echo '<span class="dashicons dashicons-instagram"></span>';
                        break;
                    case 'linkedin':
                        echo '<span class="dashicons dashicons-linkedin"></span>';
                        break;
                }
                echo '</a>';
            }
            echo '</div>';
        }

        ?>

    </div>
    
    <?php
    return ob_get_clean();
}

// Fonction récursive pour générer le HTML
function generate_menu_html_recursive($menu_tree, $parent_id, $class) {
    if (!isset($menu_tree[$parent_id])) {
        return ''; // Aucun enfant pour ce parent
    }

    $output = '<ul class="menu-level burger-menu-list">';
    foreach ($menu_tree[$parent_id] as $item) {
        $has_children = isset($menu_tree[$item->ID]);

        $output .= '<li class="menu-item" data-item-id="' . esc_attr($item->ID) . '">';
        $output .= '<a href="' . esc_url($item->url) . '" class="menu-link">' . esc_html($item->title) . '</a>';

        // Si l'élément a des enfants, appeler la fonction récursive
        if ($has_children) {
            $output .= '<div class="' . $class . ' submenu-container" data-submenu-id="' . esc_attr($item->ID) . '">';
            $output .= '<div class="backdash">Retour</div>';
            $output .= generate_menu_html_recursive($menu_tree, $item->ID, $class);
            $output .= '</div>';
        }

        $output .= '</li>';
    }
    $output .= '</ul>';

    return $output;
}

// Enregistrer le shortcode
add_shortcode('burger_menu', 'burger_menu_shortcode');
