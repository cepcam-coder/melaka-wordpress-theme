<?php
/** 
 * FIXME: clean this
 */
add_theme_support('post-thumbnails');
function melaka_enqueue_styles() {
    wp_enqueue_script('jquery'); 
    
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
    wp_enqueue_script(
        'melaka-script',
        get_theme_file_uri('/assets/js/jquery.parallax.js'),
        array('jquery'), 
        wp_get_theme()->get('Version'),
        true 
    );

    wp_enqueue_script(
        'melaka-parallax',
        get_theme_file_uri('/assets/js/parallax_init.js'),
        array('jquery'), 
        null,
        true 
    );
}
add_action('wp_enqueue_scripts', 'melaka_enqueue_styles');

/** -------------------------------------------------------------
 *  Bandes dessinées
 * 
 **/
function create_books_cpt() {
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

//  meta for book custom type
function books_add_custom_box() {
    add_meta_box(
        'book_link_box',
        'Lien externe (éditeur, achat, etc.)',
        'books_link_box_html',
        'livres', // Doit être le nom du custom type
        'side'
    );
}

function books_link_box_html($post) {
    $value = get_post_meta($post->ID, '_lien_book', true);
    ?>
    <label for="book_link_field">URL :</label><br>
    <input type="url" id="book_link_field" name="book_link_field" value="<?php echo esc_attr($value); ?>" style="width:100%;">
    <?php
}

function books_save_postdata($post_id) {
    if (array_key_exists('book_link_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_lien_book',
            esc_url_raw($_POST['book_link_field'])
        );
    }
}


// On ne garde pas la box custom, trop compliquée
function remove_books_custom_box() {
    remove_meta_box('postcustom', 'livres', 'normal');
}

add_action('add_meta_boxes', 'books_add_custom_box');
add_action('init', 'create_books_cpt');
add_action('save_post', 'books_save_postdata');
add_action('add_meta_boxes', 'remove_books_custom_box', 100);


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
        echo '<div class="book-presentation">';
        while ($livres->have_posts()) {
            $livres->the_post();

            $titre = get_the_title();
            $image = get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'book-cover'));


            $lien = get_post_meta(get_the_ID(), '_lien_livre', true);
            if (!$lien) $lien = '#'; // fallback

   
            echo '<a href="' . esc_url($lien) . '" target="_blank">';
            echo $image;
            echo '<div>';
            echo '<h4>' . esc_html($titre) . '</h4>';
            echo '</div></a>';
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


/** Replace Blogroll */
function cpt_lien_register() {

    $labels = array(
        'name'                  => _x( 'Liens', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Lien', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Liens', 'text_domain' ),
        'name_admin_bar'        => __( 'Lien', 'text_domain' ),
        'add_new_item'          => __( 'Ajouter un nouveau lien', 'text_domain' ),
        'edit_item'             => __( 'Éditer le lien', 'text_domain' ),
        'view_item'             => __( 'Voir le lien', 'text_domain' ),
    );

    $args = array(
        'label'                 => __( 'Lien', 'text_domain' ),
        'labels'                => $labels,
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'supports'              => array( 'title' ),
        'has_archive'           => false,
        'show_in_rest'          => true,
    );

    register_post_type( 'lien', $args );

}
add_action( 'init', 'cpt_lien_register', 0 );

// Ajouter un champ URL personnalisé
function lien_add_custom_meta_box() {
    add_meta_box(
        'lien_url_meta_box',
        'URL du lien',
        'lien_url_meta_box_callback',
        'lien',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'lien_add_custom_meta_box' );

function lien_url_meta_box_callback( $post ) {
    wp_nonce_field( 'lien_save_meta_box_data', 'lien_meta_box_nonce' );
    $value = get_post_meta( $post->ID, '_lien_url', true );
    echo '<label for="lien_url_field">URL :</label> ';
    echo '<input type="url" id="lien_url_field" name="lien_url_field" value="' . esc_attr( $value ) . '" size="50" />';
}

function lien_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['lien_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['lien_meta_box_nonce'], 'lien_save_meta_box_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['lien_url_field'] ) ) {
        update_post_meta( $post_id, '_lien_url', esc_url_raw( $_POST['lien_url_field'] ) );
    }
}
add_action( 'save_post', 'lien_save_meta_box_data' );



function blogroll() {
    $args = array(
        'post_type'      => 'lien',
        'posts_per_page' => -1, 
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="blogroll-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $url = get_post_meta(get_the_ID(), '_lien_url', true);
            $title = get_the_title();
            if ($url) {
                echo '<li class="blogroll-item"><a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">' . esc_html($title) . '</a></li>';
            }
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>Aucun lien trouvé.</p>';
    }
}


/** -------------------------------------------------------------
 *  Reseaux sociaux  
 * 
 **/

function create_social_link_cpt() {
    $labels = array(
        'name' => 'Réseaux Sociaux',
        'singular_name' => 'Réseau Social',
        'menu_name' => 'Réseaux Sociaux',
        'name_admin_bar' => 'Réseau social',
        'add_new' => 'Ajouter un réseau social',
        'add_new_item' => 'Ajouter un nouveau réseau social',
        'edit_item' => 'Modifier le réseau social',
        'new_item' => 'Nouveau réseau social',
        'view_item' => 'Voir le réseau social',
        'search_items' => 'Rechercher un réseau social',
        'not_found' => 'Aucun réseau trouvé',
        'not_found_in_trash' => 'Aucun réseau dans la corbeille',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true, 
        'menu_icon' => 'dashicons-share', 
        'supports' => array('title', 'thumbnail', 'custom-fields'),
        'has_archive' => false,
    );

    register_post_type('social_links', $args);
}


function social_links_add_url_box() {
    add_meta_box(
        'social_links_link_box',
        'Lien vers le profil',
        'social_net_input_box',
        'social_links', // Doit être le nom du custom type
        'side'
    );
}

function social_net_input_box($post) {
    $value = get_post_meta($post->ID, '_social_net_link', true);
    ?>
    <label for="socialnet_link_field">URL :</label><br>
    <input type="url" id="socialnet_link_field" name="socialnet_link_field" value="<?php echo esc_attr($value); ?>" style="width:100%;">
    <?php
}

function socialnet_save_postdata($post_id) {
    if (array_key_exists('socialnet_link_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_social_net_link',
            esc_url_raw($_POST['socialnet_link_field'])
        );
    }
}
// On ne garde pas la box custom, trop compliquée
function remove_custom_socialinks() {
    remove_meta_box('postcustom', 'social_links', 'normal');
}

function get_social_links() {
    $args = array(
        'post_type'      => 'social_links',
        'posts_per_page' => -1, 
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="social-links-list flex-row">';
        while ($query->have_posts()) {
            $query->the_post();
            $url = get_post_meta(get_the_ID(), '_social_net_link', true);
            $title = get_the_title();
            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('class' => 'social-link-icon'));

            if ($url) {
                echo '<li class="social-link-item"><a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">';
                if ($thumbnail) {
                    echo $thumbnail;
                }
                echo '</a></li>';
            }
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>Aucun réseau social trouvé.</p>';
    }
}

function get_random_post_link() {
    $random_post = get_posts([
        'orderby'        => 'rand',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ]);
    if ( ! empty( $random_post ) ) {
        return get_permalink( $random_post[0]->ID );
    }
    return home_url(); 
}




function theme_enqueue_seasonal_styles() {

    wp_enqueue_style('theme-style', get_stylesheet_uri());
    $month = date('n'); 
    $season = '';

    if ($month == 12 || $month <= 2) {
        $season = 'winter';
    } elseif ($month >= 3 && $month <= 5) {
        $season = 'spring';
    } elseif ($month >= 6 && $month <= 8) {
        $season = 'summer';
    } else {
        $season = 'autumn';
    }

    $seasonal_css_path = get_template_directory() . "/assets/css/{$season}.css";
    $seasonal_css_uri  = get_template_directory_uri() . "/assets/css/{$season}.css";

    if ( file_exists( $seasonal_css_path ) ) {
        wp_enqueue_style("theme-style-{$season}", $seasonal_css_uri, ['theme-style'], null);
    }
}

add_action('init', 'create_social_link_cpt');
add_action('add_meta_boxes', 'remove_custom_socialinks', 100);
add_action('save_post_social_links', 'socialnet_save_postdata');
add_action('add_meta_boxes', 'social_links_add_url_box');



add_action('wp_enqueue_scripts', 'theme_enqueue_seasonal_styles');
