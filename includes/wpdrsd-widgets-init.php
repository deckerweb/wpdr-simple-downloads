<?php

// includes/wpdrsd-widgets-init

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'widgets_init', 'ddw_wpdrsd_register_widgets' );
/**
 * Register all our Widgets classes.
 *
 * @since 1.0.0
 *
 * @uses ddw_wpdrsd_get_options()
 */
function ddw_wpdrsd_register_widgets() {

	/** Search Downloads Widget */
	require_once( WPDRSD_PLUGIN_DIR . 'includes/widgets/wpdrsd-widget-search.php' );
	register_widget( 'DDW_WPDRSD_Search_Downloads_Widget' );

	/** Popular Downloads Widget */
	require_once( WPDRSD_PLUGIN_DIR . 'includes/widgets/wpdrsd-widget-popular-downloads.php' );
	register_widget( 'DDW_WPDRSD_Popular_Downloads_Widget' );

	$options = ddw_wpdrsd_get_options();

	/** Downloads File Categories / Tags Widget */
	if ( $options[ 'wpdrsd_tax_file_categories' ] || $options[ 'wpdrsd_tax_file_tags' ] ) {

		require_once( WPDRSD_PLUGIN_DIR . 'includes/widgets/wpdrsd-widget-taxonomies.php' );
		register_widget( 'DDW_WPDRSD_Downloads_Taxonomies_Widget' );

	}  // end if

}  // end function
