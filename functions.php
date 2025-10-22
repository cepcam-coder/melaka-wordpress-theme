<?php
add_theme_support('post-thumbnails');
function melaka_enqueue_styles() {
    wp_enqueue_style(
        'melaka-style',
        get_stylesheet_uri()
    );
    wp_enqueue_style(
        'melaka-custom',
        get_theme_file_uri('/assets/css/melaka.css'),
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'melaka_enqueue_styles');


/*  For books, and comics, we create a custom type */
function create_livres_cpt() {
    $labels = array(
        'name' => 'Livres',
        'singular_name' => 'Livre',
        'menu_name' => 'Livres',
        'name_admin_bar' => 'Livre',
        'add_new' => 'Ajouter un livre',
        'add_new_item' => 'Ajouter un nouveau livre',
        'edit_item' => 'Modifier le livre',
        'new_item' => 'Nouveau livre',
        'view_item' => 'Voir le livre',
        'search_items' => 'Rechercher un livre',
        'not_found' => 'Aucun livre trouvé',
        'not_found_in_trash' => 'Aucun livre dans la corbeille',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true, 
        'menu_icon' => 'dashicons-book', 
        'supports' => array('title', 'thumbnail', 'custom-fields'),
        'has_archive' => false,
    );

    register_post_type('livres', $args);
}
add_action('init', 'create_livres_cpt');

//  meta for book custom type
function livres_add_custom_box() {
    add_meta_box(
        'livre_link_box',
        'Lien externe (éditeur, achat, etc.)',
        'livres_link_box_html',
        'livres', // Doit être le nom du custom type
        'side'
    );
}
add_action('add_meta_boxes', 'livres_add_custom_box');

function livres_link_box_html($post) {
    $value = get_post_meta($post->ID, '_lien_livre', true);
    ?>
    <label for="livre_link_field">URL :</label><br>
    <input type="url" id="livre_link_field" name="livre_link_field" value="<?php echo esc_attr($value); ?>" style="width:100%;">
    <?php
}

function livres_save_postdata($post_id) {
    if (array_key_exists('livre_link_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_lien_livre',
            esc_url_raw($_POST['livre_link_field'])
        );
    }
}
add_action('save_post', 'livres_save_postdata');

// On garde par la box custom, trop compliquée
function enlever_champs_personnalises_pour_livres() {
    remove_meta_box('postcustom', 'livres', 'normal');
}
add_action('add_meta_boxes', 'enlever_champs_personnalises_pour_livres', 100);


/**
 * Fonction pour afficher la liste des livres
 * dans le thème
 */
function comics_list($count = 5) {
    $args = array(
        'post_type'      => 'livres',
        'posts_per_page' => $count,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $livres = new WP_Query($args);

    if ($livres->have_posts()) {
        echo '<div class="livres-sidebar">';
        while ($livres->have_posts()) {
            $livres->the_post();

            $titre = get_the_title();
            $date  = get_the_date('Y');
            $image = get_the_post_thumbnail(get_the_ID(), 'thumbnail');


            $lien = get_post_meta(get_the_ID(), '_lien_livre', true);
            if (!$lien) $lien = '#'; // fallback

            echo '<div class="livre-item">';
            echo '<a href="' . esc_url($lien) . '" target="_blank">';
            echo $image;
            echo '<div class="livre-meta">';
            echo '<h4>' . esc_html($titre) . '</h4>';
            echo '</div></a></div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>Aucun livre pour l’instant.</p>';
    }
}

/** Dont auto scaled  */
add_filter( 'big_image_size_threshold', '__return_false' );


/** Dont paginate year and month archives */
function show_all_posts_in_date_archives( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {

        if ( $query->is_month() || $query->is_year() ) {
            $query->set( 'posts_per_page', -1 ); 
        }
    }
}
add_action( 'pre_get_posts', 'show_all_posts_in_date_archives' );
