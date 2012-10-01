<?php
/**
 * Add a style block to the theme for the current primary color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Sundance Modern
 */
function sundancemodern_print_primary_color_style() {
	$options = sundancemodern_get_theme_options();
	$primary_color = $options['primary_color'];

	$default_options = sundancemodern_get_default_theme_options();

	// Don't do anything if the current primary color is the default.
	if ( $default_options['primary_color'] == $primary_color )
		return;
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
add_action( 'wp_head', 'sundancemodern_print_primary_color_style' );
?>
