<?php
/**
 * Adds style blocks in <head> for user defined colors.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Sundance Modern
 */
function sundancemodern_print_primary_color_style() {
	$options = sundancemodern_get_theme_options();
	$default_options = sundancemodern_get_default_theme_options();

    $primary_color         = $options['primary_color'];
    $primary_color_default = $default_options['primary_color'];

	// Only override default CSS if the current primary color is not default.
	if ( $primary_color_default !== $primary_color ) {
        ?>
        <style type="text/css" id="custom-primary-color">
            /* Primary color */
            a, h1, h3, .site-title a:hover  {
                color: <?php echo $primary_color; ?>;
            }
            .widget_calendar #wp-calendar tbody td a {
                background: <?php echo $primary_color; ?>;
            }
            blockquote {
                border-color: <?php echo $primary_color; ?>;
            }
        </style>
        <?php
    }

    $ahover_color         = $options['ahover_color'];
    $ahover_color_default = $default_options['ahover_color'];

    // Only override default CSS if the current mouseover color is not default.
    if ( $ahover_color_default !== $ahover_color ) {
        ?>
        <style type="text/css" id="custom-mouse-over-color">
            /* Mouseover Link color */
            a:hover,
            a:active,
            a:focus {
                color: <?php echo $ahover_color; ?>;
            }
        </style>
        <?php
    }

    $entry_title_color = $options['entry_title_color'];

    // Only set a different title color if it is defined at all.
    if ( $entry_title_color ) {
        ?>
        <style type="text/css" id="custom-entry-title-color">
            /* Entry Title color */
            h1.entry-title,
            h1.entry-title a {
                color: <?php echo $entry_title_color; ?>;
            }

            /* Keep the mouse over color */
            h1.entry-title a:hover,
            h1.entry-title a:active,
            h1.entry-title a:focus {
                color: <?php echo $ahover_color; ?>;
            }
        </style>
        <?php
    }


}
add_action( 'wp_head', 'sundancemodern_print_primary_color_style' );
?>
