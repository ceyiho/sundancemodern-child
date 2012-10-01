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
        '/inc/theme-options/custom-color.php'
    );
    
    foreach( $files as $file ) {
        require( get_stylesheet_directory() . $file );
    }
}
add_action( 'after_setup_theme', 'sundancemodern_setup' );

?>