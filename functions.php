<?php
/**
 * Sundance Modern functions and definitions
 *
 * @since Sundance Modern 1.0
 */

function sundancemodern_setup() {
    /**
	 * Require Theme Options Files
	 */
    $files = array(
        '/inc/theme-options/theme-options.php',
        '/inc/theme-options/custom-css.php'
    );

    foreach( $files as $file ) {
        require( get_stylesheet_directory() . $file );
    }

    /**
	 * Custom background.
	 */
	$bg_defaults = array(
		'default-color' => 'efe7da',
		'default-image' => get_stylesheet_directory_uri() . '/images/bg.jpg'
	);

    add_theme_support( 'custom-background', $bg_defaults );
}
add_action( 'after_setup_theme', 'sundancemodern_setup' );


function sundancemodern_scripts() {
    wp_enqueue_style( 'open-sans-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700' );
}
add_action( 'wp_enqueue_scripts', 'sundancemodern_scripts' );
?>