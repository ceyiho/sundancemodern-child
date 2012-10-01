<?php
/**
 * Sundance Modern Theme Options
 *
 * @since Sundance Modern 1.0
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since Sundance Modern 1.0
 *
 */
function sundancemodern_admin_enqueue_scripts( $hook_suffix ) {
    // Only load these scripts on Theme Options page.
    if ( $hook_suffix != 'appearance_page_theme_options' )
        return;

	wp_enqueue_style(
        'sundancemodern-theme-options',
        get_stylesheet_directory_uri() . '/inc/theme-options/theme-options.css'
    );

	wp_enqueue_script(
        'sundancemodern-theme-options',
        get_stylesheet_directory_uri() . '/inc/theme-options/theme-options.js',
        array( 'farbtastic' )
    );

	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'sundancemodern_admin_enqueue_scripts' );

/**
 * Register the form setting for our sundancemodern_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, sundancemodern_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since Sundance Modern 1.0
 */
function sundancemodern_theme_options_init() {

    // If we have no options in the database, let's add them now.
    if ( false === sundancemodern_get_theme_options() )
        add_option( 'sundancemodern_theme_options', sundancemodern_get_default_theme_options() );

    register_setting(
        'sundance_options', // Options group, see settings_fields() call in sundancemodern_theme_options_render_page()
        'sundancemodern_theme_options', // Database option, see sundancemodern_get_theme_options()
        'sundancemodern_theme_options_validate' // The sanitization callback, see sundancemodern_theme_options_validate()
    );

    // Register our settings field group
    add_settings_section(
        'sundancemodern_color', // Unique identifier for the settings section
        'Color Options', // Section title
        '__return_false', // Section callback (we don't want anything)
        'theme_options' // Menu slug, used to uniquely identify the page; see sundancemodern_theme_options_add_page()
    );

    // Register our individual settings fields
    add_settings_field(
        'primary_color', // Unique identifier for the field for this section
        __( 'Primary Color', 'sundance' ), // Setting field label
        'sundancemodern_primary_color_input', // Function that renders the settings field
        'theme_options', // Menu slug, used to uniquely identify the page; see sundancemodern_theme_options_add_page()
        'sundancemodern_color' // Settings section. Same as the first argument in the add_settings_section() above
    );
    
    add_settings_field(
        'entry_title_color',
        __( 'Entry Title Color', 'sundance' ),
        'sundancemodern_entry_title_color_input',
        'theme_options',
        'sundancemodern_color'
    );
    
    // A dummy section to render the Title of sundance's default options
    add_settings_section(
        'sundance_general', // Unique identifier for the settings section
        'Social Media Links', // Section title
        'sundance_general_desc', // Section callback
        'theme_options' // Menu slug, used to uniquely identify the page; see sundancemodern_theme_options_add_page()
    );
}
add_action( 'admin_init', 'sundancemodern_theme_options_init' );


/**
 * Returns the default options for Sundance Modern.
 *
 * @since Sundance Modern 1.0
 */
function sundancemodern_get_default_theme_options() {
    $default_theme_options = array(
        'primary_color' => '#2c807f',
        'entry_title_color' => ''
    );

    return apply_filters( 'sundancemodern_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Sundance Modern.
 *
 * @since Sundance Modern 1.0
 */
function sundancemodern_get_theme_options() {
    return get_option( 'sundancemodern_theme_options', sundancemodern_get_default_theme_options() );
}


/**
 * Renders the description of Sundance's default options.
 * 
 * @since Sundance Modern 1.0
 */
function sundance_general_desc() {
    ?>
    <p>Display an icon on the sidebar for each link you set.</p>
    <?php
}

/**
 * Renders the Primary Color setting field.
 *
 * @since Sundance Modern 1.0
 */
function sundancemodern_primary_color_input() {
	$options         = sundancemodern_get_theme_options();
    $default_options = sundancemodern_get_default_theme_options();
	?>
    <div id="primary_color_div">
        <input type="text" name="sundancemodern_theme_options[primary_color]" id="primary_color" value="<?php echo esc_attr( $options['primary_color'] ); ?>" />
        <a href="#" class="pickcolor hide-if-no-js color-sample"></a>
        <input type="button" class="pickcolor hide-if-no-js button" value="<?php esc_attr_e( 'Select a Color', 'sundance' ); ?>" />
        <div class="color-picker" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
        <br />
        <span><?php printf( __( 'Default color: %s', 'sundance' ), '<span class="default-color">' . $default_options[ 'primary_color' ] . '</span>' ); ?></span>
    </div>
    <?php
}


/**
 * Determines if the Entry Title checkbox is checked.
 *
 * @since Sundance Modern 1.0
 */
function entry_title_checked() {
    $options = sundancemodern_get_theme_options();
    return $options['entry_title_color'] ? 'checked="checked"' : '';
}

/**
 * Renders the Entry Title Color setting field.
 *
 * @since Sundance Modern 1.0
 */
function sundancemodern_entry_title_color_input() {
    $options = sundancemodern_get_theme_options();
    ?>
    <p><label>
        <input type="checkbox" id="entry_title_color_checkbox" <?php echo entry_title_checked(); ?> />
        <?php _e( 'Specify a different color for entry titles.' ); ?>
    </label></p>

    <div id="entry_title_color_div">
        <input type="text" name="sundancemodern_theme_options[entry_title_color]" id="entry_title_color"
            value="<?php echo esc_attr( $options['entry_title_color'] ); ?>"
        />
        <a href="#" class="pickcolor hide-if-no-js color-sample"></a>
        <input type="button" class="pickcolor hide-if-no-js button" value="<?php esc_attr_e( 'Select a Color', 'sundance' ); ?>" />
        <div class="color-picker" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
        <br />
        <span><?php
            printf(
                __( 'Default color: %s', 'sundance' ),
                '<span class="default-color">' . $options[ 'primary_color' ] . '</span>'
            );
        ?></span>
    </div>
    <?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see sundancemodern_theme_options_init()
 *
 * @since Sundance Modern 1.0
 */
function sundancemodern_theme_options_validate( $input ) {
    $output = $defaults = sundancemodern_get_default_theme_options();

    // Primary color must be 3 or 6 hexadecimal characters
	if ( isset( $input['primary_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['primary_color'] ) ) :
		$output['primary_color'] = '#' . strtolower( ltrim( $input['primary_color'], '#' ) );
    endif;

    return apply_filters( 'sundancemodern_theme_options_validate', $output, $input, $defaults );
}
?>