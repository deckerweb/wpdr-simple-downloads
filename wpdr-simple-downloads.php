<?php # -*- coding: utf-8 -*-
/**
 * Main plugin file.
 * @package           WP Document Revisions Simple Downloads
 * @author            David Decker
 * @copyright         Copyright (c) 2012-2019, David Decker - DECKERWEB
 * @license           GPL-2.0-or-later
 * @link              https://deckerweb.de/twitter
 * @link              https://www.facebook.com/groups/deckerweb.wordpress.plugins/
 *
 * @wordpress-plugin
 * Plugin Name:       WP Document Revisions Simple Downloads
 * Plugin URI:        http://github.com/deckerweb/wpdr-simple-downloads
 * Description:       Use the WP Document Revisions plugin as very basic & simple download manager with this additional add-on plugin.
 * Version:           1.2.1
 * Author:            David Decker - DECKERWEB
 * Author URI:        https://deckerweb.de/
 * License:           GPL-2.0-or-later
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain:       wpdr-simple-downloads
 * Domain Path:       /languages/
 * Requires WP:       4.7
 * Requires PHP:      5.6
 *
 * Copyright (c) 2012-2019 David Decker - DECKERWEB
 *
 *     This file is part of WP Document Revisions Simple Downloads,
 *     a plugin for WordPress.
 *
 *     WP Document Revisions Simple Downloads is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     WP Document Revisions Simple Downloads is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants
 *
 * @since 1.0.0
 */
/** Set plugin version */
define( 'WPDRSD_VERSION', '1.2.1' );

/** Plugin directory */
define( 'WPDRSD_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'WPDRSD_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


add_action( 'init', 'ddw_wpdrsd_load_translations', 0 );
/**
 * Load the text domain for translation of the plugin.
 *
 * @since 1.0.0
 * @since 1.2.0 Refactoring.
 *
 * @uses get_user_locale()
 * @uses load_textdomain() To load translations first from WP_LANG_DIR sub folder.
 * @uses load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 */
function ddw_wpdrsd_load_translations() {

	/** Set unique textdomain string */
	$wpdrsd_textdomain = 'wpdr-simple-downloads';

	/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
	$locale = esc_attr(
		apply_filters(
			'plugin_locale',
			get_user_locale(),
			$wpdrsd_textdomain
		)
	);

	/**
	 * WordPress languages directory
	 *   Will default to: wp-content/languages/wpdr-simple-downloads/wpdr-simple-downloads-{locale}.mo
	 */
	$wpdrsd_wp_lang_dir = trailingslashit( WP_LANG_DIR ) . trailingslashit( $wpdrsd_textdomain ) . $wpdrsd_textdomain . '-' . $locale . '.mo';

	/** Translations: First, look in WordPress' "languages" folder = custom & update-safe! */
	load_textdomain(
		$wpdrsd_textdomain,
		$wpdrsd_wp_lang_dir
	);

	/** Translations: Secondly, look in 'wp-content/languages/plugins/' for the proper .mo file (= default) */
	load_plugin_textdomain(
		$wpdrsd_textdomain,
		FALSE,
		WPDRSD_PLUGIN_BASEDIR . 'languages'
	);

}  // end function


/** Include global functions */
require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-functions-global.php' );


register_activation_hook( __FILE__, 'ddw_wpdrsd_activation_check' );
/**
 * Checks for activated "WP Document Revision" plugin before allowing
 *    this add-on plugin to activate.
 *
 * @since 1.0.0
 * @since 1.2.0 Refactoring.
 *
 * @uses ddw_wpdrsd_is_wpdr_active()
 * @uses ddw_wpdrsd_load_translations()
 * @uses deactivate_plugins()
 */
function ddw_wpdrsd_activation_check() {

	require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-functions-global.php' );

	/** Check for activated plugin "WP Document Revisions" */
	if ( ! ddw_wpdrsd_is_wpdr_active() ) {

		ddw_wpdrsd_load_translations();

		/** If no WPDR, deactivate ourself */
		deactivate_plugins( plugin_basename( __FILE__ ) );

		/** Message: no WPDR active */
		$wpdrsd_deactivation_message = sprintf(
			/* translators: %1$s - name of plugin, "WP Document Revisions Simple Downloads" / %2$s - opening link markup / %3$s - closing link markup */
			__( 'Sorry, you cannot activate the %1$s plugin unless you have installed the latest version of the %2$sWP Document Revisions%3$s plugin.', 'wpdr-simple-downloads' ),
			__( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ),
			'<a href="https://wordpress.org/plugins/wp-document-revisions/" target="_blank" rel="noopener noreferrer"><strong><em>',
			'</em></strong></a>'
		);

		/** Deactivation message */
		wp_die(
			$wpdrsd_deactivation_message,
			__( 'Plugin', 'wpdr-simple-downloads' ) . ': ' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ),
			array( 'back_link' => TRUE )
		);

	}  // end if

}  // end function


// options


// init (widgets)


add_action( 'plugins_loaded', 'ddw_wpdrsd_setup', 100 );
/**
 * Setup: Register Widget Areas (Note: Has to be early on the "init" hook in order to display translations!)
 *
 * @since 1.0.0
 */
function ddw_wpdrsd_setup() {

	/** Load the admin and frontend functions only when needed */
	if ( is_admin() ) {
		require_once( WPDRSD_PLUGIN_DIR . 'includes/admin/wpdrsd-admin-extras.php' );
		require_once( WPDRSD_PLUGIN_DIR . 'includes/admin/wpdrsd-admin-settings.php' );
		require_once( WPDRSD_PLUGIN_DIR . 'includes/admin/wpdrsd-admin-settings-help.php' );
	}

	/** Include various plugin functions */
	require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-functions.php' );
	require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-download-count.php' );
	require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-download-id.php' );
	require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-taxonomies.php' );
	require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-widgets-init.php' );

	$wpdrsd_options = ddw_wpdrsd_get_options();

	if ( $wpdrsd_options[ 'wpdrsd_remove_date_permalink' ]
		&& ( ddw_wpdrsd_is_wpdr_active() || post_type_exists( 'document' ) )
	) {
		require_once( WPDRSD_PLUGIN_DIR . 'includes/wpdrsd-remove-date-from-permalink.php' );
	}

	/** For Genesis: Adjust post meta info for "Downloads" */
	if ( ! is_admin() && ( 'genesis' === basename( get_template_directory() ) ) ) {
		require_once( WPDRSD_PLUGIN_DIR . 'includes/third-party-compat/wpdrsd-genesis-framework.php' );
		add_filter( 'genesis_post_meta', 'ddw_wpdrsd_genesis_post_meta', 20 );
	}

	/** Add links to Settings and Menu pages to Plugins page */
	if ( ( is_admin() || is_network_admin() )
		&& ( current_user_can( 'edit_theme_options' ) || current_user_can( 'manage_options' ) )
	) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_wpdrsd_settings_page_link'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_wpdrsd_settings_page_link'
		);

	}  // end if

	/**
	 * Define constants and set defaults for removing all or certain sections
	 *   For search widget:
	 */
	if ( ! defined( 'WPDRSD_SEARCH_LABEL_DISPLAY' ) ) {
		define( 'WPDRSD_SEARCH_LABEL_DISPLAY', TRUE );
	}

}  // end function


/**
 * Flush rewrite rules on activation.
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
