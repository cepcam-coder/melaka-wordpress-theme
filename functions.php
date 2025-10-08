<?php
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
