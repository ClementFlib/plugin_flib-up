<?php
// Enregistre les réglages pour le menu burger
function burger_flibustiers_settings_init() {
    register_setting('burgerFlibustiers', 'burger_flibustiers_options');
    register_setting('burgerFlibustiers', 'burger_flibustiers_social_links', [
        'sanitize_callback' => 'sanitize_social_links'
    ]);

    add_settings_section(
        'burger_flibustiers_section',
        'Personnalisation du Menu Burger',
        'burger_flibustiers_section_callback',
        'burgerFlibustiers'
    );

    //Couleur de la font
    add_settings_field(
        'burger_flibustiers_color',             // ID du champ
        'Couleur de la police du menu',         // Titre du champ
        'burger_flibustiers_color_render',      // Fonction de rappel pour afficher les champs
        'burgerFlibustiers',                    // Page d'options
        'burger_flibustiers_section'            // Section à laquelle ce champ appartient
    );

    //Couleur de la font
    add_settings_field(
        'burger_flibustiers_active_color',
        'Couleur des liens actifs',
        'burger_flibustiers_active_color_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    );

    // Font family
    add_settings_field(
        'burger_flibustiers_font',
        'Police de caractères',
        'burger_flibustiers_font_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    );

    // Styles des onglets
    add_settings_field(
        'burger_flibustiers_typo_styles',
        'Style de la typo',
        'burger_flibustiers_typo_styles_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    );

    // Couleur de fond du menu
    add_settings_field(
        'burger_flibustiers_bgcolor',
        'Couleur de fond du menu',
        'burger_flibustiers_bgcolor_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    );

    // Couleur de l'icone burger
    add_settings_field(
        'burger_flibustiers_icon_color',
        'Couleur de l\'icone burger',
        'burger_flibustiers_icon_color_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    ); 

    // Animation d'ouverture
    add_settings_field(
        'burger_flibustiers_animation',
        'Animation d\'ouverture',
        'burger_flibustiers_animation_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    );

    // Champ pour les réseaux sociaux
    add_settings_field(
        'burger_flibustiers_social_links',
        'Liens vers les réseaux sociaux',
        'burger_flibustiers_social_links_render',
        'burgerFlibustiers',
        'burger_flibustiers_section'
    );
    
}
add_action('admin_init', 'burger_flibustiers_settings_init');

// Description de la section
function burger_flibustiers_section_callback() {
    echo 'Personnalisez l’apparence de votre menu burger ici.';
}

// Rendu du champ couleur
function burger_flibustiers_color_render() {
    $options = get_option('burger_flibustiers_options');
    ?>
    <input type="text" name="burger_flibustiers_options[burger_flibustiers_color]" value="<?php echo isset($options['burger_flibustiers_color']) ? esc_attr($options['burger_flibustiers_color']) : ''; ?>" />
    <p class="description">Entrez une couleur hexadécimale ou un nom de couleur (par ex. #000000 ou noir)</p>
    <?php
}

// Rendu du champ couleur
function burger_flibustiers_active_color_render() {
    $options = get_option('burger_flibustiers_options');
    ?>
    <input type="text" name="burger_flibustiers_options[burger_flibustiers_active_color]" value="<?php echo isset($options['burger_flibustiers_active_color']) ? esc_attr($options['burger_flibustiers_active_color']) : ''; ?>" />
    <p class="description">Entrez une couleur hexadécimale ou un nom de couleur (par ex. #000000 ou noir)</p>
    <?php
}

// Rendu pour la liste déroulante de la police de caractères
function burger_flibustiers_font_render() {
    $options = get_option('burger_flibustiers_options');
    $selected_font = isset($options['burger_flibustiers_font']) ? $options['burger_flibustiers_font'] : 'default';

    // Liste des polices disponibles
    $fonts = array(
        'default' => 'Défaut (police du thème)',
        'Arial, sans-serif' => 'Arial',
        'Helvetica, sans-serif' => 'Helvetica',
        'Times New Roman, serif' => 'Times New Roman',
        'Georgia, serif' => 'Georgia',
        'Courier New, monospace' => 'Courier New',
        'Verdana, sans-serif' => 'Verdana',
        'Trebuchet MS, sans-serif' => 'Trebuchet MS',
        'Roboto, sans-serif' => 'Roboto (Google)',
        'Open Sans, sans-serif' => 'Open Sans (Google)',
        'Lato, sans-serif' => 'Lato (Google)',
        'Montserrat, sans-serif' => 'Montserrat (Google)',
        'Oswald, sans-serif' => 'Oswald (Google)'
    );
    ?>

    <select name="burger_flibustiers_options[burger_flibustiers_font]">
        <?php foreach ($fonts as $font_value => $font_name): ?>
            <option value="<?php echo esc_attr($font_value); ?>" <?php selected($selected_font, $font_value); ?>>
                <?php echo esc_html($font_name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p class="description">Choisissez une police pour le menu.</p>
    <?php
}

//Style de typo pour les onglets du menu
function burger_flibustiers_typo_styles_render() {
    $options = get_option('burger_flibustiers_options');
    $selected_styles = isset($options['burger_flibustiers_typo_styles']) ? $options['burger_flibustiers_typo_styles'] : [];
    $styles = [
        'uppercase' => 'Majuscules', 
        'bold' => 'Gras', 
        'underline' => 'Souligné', 
        'italic' => 'Italique'
    ];

    foreach ($styles as $key => $label) {
        $checked = in_array($key, $selected_styles) ? 'checked' : '';
        echo '<label><input type="checkbox" name="burger_flibustiers_options[burger_flibustiers_typo_styles][]" value="' . esc_attr($key) . '" ' . $checked . '> ' . esc_html($label) . '</label><br>';
    }
}

// Rendu du champ background color
function burger_flibustiers_bgcolor_render() {
    $options = get_option('burger_flibustiers_options');
    ?>
    <input type="text" name="burger_flibustiers_options[burger_flibustiers_bgcolor]" value="<?php echo isset($options['burger_flibustiers_bgcolor']) ? esc_attr($options['burger_flibustiers_bgcolor']) : ''; ?>" />
    <p class="description">Entrez une couleur hexadécimale ou un nom de couleur (par ex. #000000 ou noir)</p>
    <?php
}

// Rendu du champ icon color
function burger_flibustiers_icon_color_render() {
    $options = get_option('burger_flibustiers_options');
    ?>
    <input type="text" name="burger_flibustiers_options[burger_flibustiers_icon_color]" value="<?php echo isset($options['burger_flibustiers_icon_color']) ? esc_attr($options['burger_flibustiers_icon_color']) : ''; ?>" />
    <p class="description">Entrez une couleur hexadécimale ou un nom de couleur (par ex. #000000 ou noir)</p>
    <?php
}

// Rendu pour la sélection d'animation
function burger_flibustiers_animation_render() {
    $options = get_option('burger_flibustiers_options');
    $selected_animation = isset($options['burger_flibustiers_animation']) ? $options['burger_flibustiers_animation'] : 'burger-slide-right';

    $animations = array(
        'slide-from-top'    => 'Glissement depuis le haut',
        'slide-from-right'  => 'Glissement depuis la droite',
        'slide-from-bottom' => 'Glissement depuis le bas',
        'slide-from-left'   => 'Glissement depuis la gauche',
        'fade-in'           => 'Fondu',
    );
    ?>

    <select name="burger_flibustiers_options[burger_flibustiers_animation]">
        <?php foreach ($animations as $value => $label): ?>
            <option value="<?php echo esc_attr($value); ?>" <?php selected($selected_animation, $value); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p class="description">Choisissez l'animation d'ouverture du menu burger.</p>
    <?php
}

/*************** RESEAUX SOCIAUX *******************/
// Sécurise les liens
function sanitize_social_links($input) {
    $sanitized = [];
    
    foreach ($input as $social) {
        // Vérifie que le réseau social et l'URL ne sont pas vides
        if (!empty($social['network']) && !empty($social['url'])) {
            $sanitized[] = [
                'network' => sanitize_text_field($social['network']),
                'url' => esc_url_raw($social['url'])
            ];
        }
    }
    
    return $sanitized;
}

// Rendu des champs de gestion des liens RS
function burger_flibustiers_social_links_render() {
    $options = get_option('burger_flibustiers_social_links', []);

    $social_networks = [
        'facebook' => 'Facebook',
        'youtube' => 'YouTube',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
    ];

    foreach ($options as $index => $social) {
        ?>
        <div class="social-link">
            <select name="burger_flibustiers_social_links[<?php echo $index; ?>][network]">
                <?php foreach ($social_networks as $key => $label): ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($social['network'], $key); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="url" name="burger_flibustiers_social_links[<?php echo $index; ?>][url]" value="<?php echo esc_url($social['url']); ?>" placeholder="URL du réseau">
            <button type="button" class="remove-social-link button">Supprimer</button>
        </div>
        <?php
    }

    ?>
    <div id="new-social-link-template" style="display:none;">
        <select name="burger_flibustiers_social_links[index_placeholder][network]">
            <?php foreach ($social_networks as $key => $label): ?>
                <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="url" name="burger_flibustiers_social_links[index_placeholder][url]" placeholder="URL du réseau">
        <button type="button" class="remove-social-link button">Supprimer</button>
    </div>
    <button type="button" id="add-social-link" class="button">Ajouter un réseau</button>
    <?php
}