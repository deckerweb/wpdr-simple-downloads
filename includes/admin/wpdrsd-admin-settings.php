<?php

// includes/wpdrsd-admin-settings

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_menu', 'ddw_wpdrsd_admin_settings' );
/**
 * Registrer plugin's settings submenu panel.
 *    Load the help tab system on plugin's settings page.
 *    Add "Settings updated" message on saving settings page.
 *
 * @since 1.0.0
 *
 * @uses add_submenu_page()
 *
 * @global mixed $wpdrsd_settings_page
 */
function ddw_wpdrsd_admin_settings() {

	global $wpdrsd_settings_page;

	/** Add the submenu panel & settings page */
	$wpdrsd_settings_page = add_submenu_page(
		'edit.php?post_type=document',		// submenu parent hook
		__( 'Download Settings', 'wpdr-simple-downloads' ) . ' &ndash; ' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ),		// title tag
		__( 'Download Settings', 'wpdr-simple-downloads' ),			// menu title
		'manage_options',											// capability
		'wpdrsd-settings',											// settings page slug
		'ddw_wpdrsd_settings_page'									// callback function
	);

	/** Load help tab system on plugin's setting page */
    add_action( 'load-' . $wpdrsd_settings_page, 'ddw_wpdrsd_admin_settings_help' );

	/** Register/ Enqueue CSS styles for settings page */
	//add_action( 'admin_enqueue_scripts', 'ddw_wpdrsd_settings_enqueue_styles' );

	/** Add & display message on saving options */
	if ( isset( $_GET[ 'settings-updated' ] ) ) {
		add_action( 'load-' . $wpdrsd_settings_page, 'ddw_wpdrsd_settings_message' );
	}

}  // end function


add_action( 'admin_init', 'ddw_wpdrsd_admin_init' );
/**
 * Registrer settings for the plugin.
 *
 * @since 1.0.0
 *
 * @uses register_setting()
 */
function ddw_wpdrsd_admin_init() {

	/** Register settings fields group & field */
	register_setting(
		'wpdrsd_options_group',			// settings fields group
		'wpdrsd_options',				// settings field
		'ddw_wpdrsd_options_validate'	// callback function
	);

}  // end function


/**
 * Validation of the options to save.
 *
 * @since 1.0.0
 *
 * @uses ddw_wpdrsd_default_options()
 *
 * @param array $input Raw input of options data.
 * @return array $default Array of valid options data.
 */
function ddw_wpdrsd_options_validate( $input ) {

	$default = ddw_wpdrsd_default_options();

	if ( ! isset( $input[ 'wpdrsd_downloads_labels' ] ) ) {
		$default[ 'wpdrsd_downloads_labels' ] = FALSE;
	}

	if ( ! isset( $input[ 'wpdrsd_tax_file_categories' ] ) ) {
		$default[ 'wpdrsd_tax_file_categories' ] = FALSE;
	}

	if ( ! isset( $input[ 'wpdrsd_tax_file_tags' ] ) ) {
		$default[ 'wpdrsd_tax_file_tags' ] = FALSE;
	}

	if ( ! isset( $input[ 'wpdrsd_downloads_translations' ] ) ) {
		$default[ 'wpdrsd_downloads_translations' ] = FALSE;
	}

	if ( ! isset( $input[ 'wpdrsd_formal_translations' ] ) ) {
		$default[ 'wpdrsd_formal_translations' ] = FALSE;
	}

	if ( ! isset( $input[ 'wpdrsd_remove_date_permalink' ] ) ) {
		$default[ 'wpdrsd_remove_date_permalink' ] = FALSE;
	}

	if ( isset( $input[ 'wpdrsd_default_visibility' ] ) ) {
		$default[ 'wpdrsd_default_visibility' ] = TRUE;
	}

	if ( ! isset( $input[ 'wpdrsd_show_revision_log' ] ) ) {
		$default[ 'wpdrsd_show_revision_log' ] = FALSE;
	}

	return $default;

}  // end function


/**
 * Load the "Settings updated" message when saving options.
 *
 * @since 1.0.0
 */
function ddw_wpdrsd_settings_message() {

	add_action( 'admin_notices', 'ddw_wpdrsd_do_settings_message' );

}  // end function


/**
 * Register & display "Settings updated" message when saving options.
 *
 * @since 1.0.0
 *
 * @uses add_settings_error()
 * @uses settings_errors()
 */
function ddw_wpdrsd_do_settings_message() {

	/** Register "Update" message */
	add_settings_error(
		'wpdrsd-notices',
		'',
		__( 'Settings updated.', 'wpdr-simple-downloads' ),
		'updated'
	);

	/** Display message */
	settings_errors( 'wpdrsd-notices' );

}  // end function


/**
 * Include settings page form code.
 *
 * @since 1.0.0
 */
function ddw_wpdrsd_settings_page() {

	include( WPDRSD_PLUGIN_DIR . 'includes/admin/views/wpdrsd-settings-form.php' );

}  // end function


/** 
 * Enqueue settings CSS styles.
 *
 * @since 1.0.0
 *
 * @uses wp_enqueue_style()
 */
function ddw_wpdrsd_settings_enqueue_styles() {

	/** Enqueue settings CSS styles */
	wp_enqueue_style(
		'wpdrsd-styles',
		plugins_url( '/css/wpdrsd-styles.css', dirname( __FILE__ ) ),
		array(),
		WPDRSD_VERSION
	);

}  // end function
