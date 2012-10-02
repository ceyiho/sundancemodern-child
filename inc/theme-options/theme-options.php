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
        'generate_color_input', // Function that renders the settings field
        'theme_options', // Menu slug, used to uniquely identify the page; see sundancemodern_theme_options_add_page()
        'sundancemodern_color', // Settings section. Same as the first argument in the add_settings_section() above,
         array('primary_color', true)
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
 * Generates color options input.
 * 
 * @param array $args Required. $args[0]: field id. $args[1]: true to render "Default color".
 * @since Sundance Modern 1.0
 */
function generate_color_input( $args ) {
    $options         = sundancemodern_get_theme_options();
    $default_options = sundancemodern_get_default_theme_options();
    $id              = $args[0];
    $div_id          = $id . '_div';
    
    ?>
    <div id="<?php echo $div_id; ?>">
        <input type="text" name="sundancemodern_theme_options[<?php echo $id; ?>]" id="<?php echo $id; ?>" value="<?php esc_attr_e( $options[$id] ); ?>" />
        <a href="#" class="pickcolor hide-if-no-js color-sample"></a>
        <input type="button" class="pickcolor hide-if-no-js button" value="<?php esc_attr_e( 'Select a Color', 'sundance' ); ?>" />
        <div class="color-picker" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
        <?php 
            if ( $args[1] ) {
                echo '<br /><span>';
                printf( __( 'Default color: %s', 'sundance' ), '<span class="default-color">' . $default_options[$id] . '</span>' );
                echo '</span>';
            }
        ?>
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
    ?>
    <p><label>
        <input type="checkbox" id="entry_title_color_checkbox" <?php echo entry_title_checked(); ?> />
        <?php _e( 'Specify a different color for entry titles.' ); ?>
    </label></p>
    <?php

     generate_color_input( array('entry_title_color', false) );
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

    foreach ( array_keys($output) as $key ) {
        // Colors must be 3 or 6 hexadecimal characters
        if ( isset( $input[$key] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input[$key] ) ) :
            $output[$key] = '#' . strtolower( ltrim( $input[$key], '#' ) );
        endif;
    }

    return apply_filters( 'sundancemodern_theme_options_validate', $output, $input, $defaults );
}
?>