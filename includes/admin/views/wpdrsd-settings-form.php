<?php

// includes/admin-form/wpdrsd-settings-form

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/** Set variables */
$current = isset( $_GET[ 'tab' ] ) ? sanitize_key( wp_unslash( $_GET[ 'tab' ] ) ) : 'settings';
$tabs    = array(
	'settings' => __( 'Download Settings', 'wpdr-simple-downloads' ),
	'usage'    => __( 'Usage', 'wpdr-simple-downloads' ),
);

?>
<div class="wrap">
	<h2><?php _e( 'WP Document Revisions', 'wpdr-simple-downloads' ); ?> &rsaquo; <?php _e( 'Simple Downloads', 'wpdr-simple-downloads' ); ?></h2>
	<div id="icon-downloads-settings" class="icon32"><br></div>
	<h2 class="nav-tab-wrapper">
	<?php
		foreach ( $tabs as $tab => $name ) {

			$class = ( $tab == $current ) ? ' nav-tab-active' : '';

			echo sprintf(
				'<a class="nav-tab%1$s" href="%2$s">%3$s</a>',
				$class,
				esc_url( admin_url( 'edit.php?post_type=document&page=wpdrsd-settings&tab=' . $tab ) ),
				$name
			);

		}  // end foreach
	?>
	</h2>
	<div id="wpdrsd-panel" class="wpdrsd-panel-<?php echo $current; ?>">
		<?php include( WPDRSD_PLUGIN_DIR . 'includes/admin/views/wpdrsd-' . $current . '-tab.php' ); ?>
	</div><!-- end #wpdrsd-panel .wpdrsd-panel-$current -->
</div><!-- end .wrap -->
