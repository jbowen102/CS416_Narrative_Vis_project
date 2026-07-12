<?php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'coral-dark-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'coral-dark-child-style',
        get_stylesheet_uri(),
        array( 'coral-dark-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );
} );
