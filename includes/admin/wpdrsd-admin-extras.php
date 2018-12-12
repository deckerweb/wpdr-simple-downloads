<?php

// includes/wpdrsd-admin-extras

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Add "Settings" link to Plugins page.
 *
 * @since 1.0.0
 * @since 1.2.0 Refactoring
 *
 * @param  array $wpdrsd_links (Default) Array of plugin action links.
 * @return strings $wpdrsd_links Modified plugin action links.
 */
function ddw_wpdrsd_settings_page_link( $wpdrsd_links ) {

	/** WPDR manage downloads link */
	$wpdrsd_downloads_link = sprintf(
		'<a class="dashicons-before dashicons-download" href="%1$s" title="%2$s">%3$s</a>',
		esc_url( admin_url( 'edit.php?post_type=document' ) ),
		esc_html__( 'Manage download files', 'wpdr-simple-downloads' ),
		esc_attr__( 'Downloads', 'wpdr-simple-downloads' )
	);

	/** WPDR Simple Downloads setting page link */
	$wpdrsd_settings_link = sprintf(
		'<a class="dashicons-before dashicons-admin-generic" href="%1$s" title="%2$s">%3$s</a>',
		esc_url( admin_url( 'edit.php?post_type=document&page=wpdrsd-settings' ) ),
		esc_html__( 'Go to the WP Document Revisions Simple Downloads settings page', 'wpdr-simple-downloads' ),
		esc_attr__( 'Settings', 'wpdr-simple-downloads' )
	);

	/** Set the order of the links */
	array_unshift( $wpdrsd_links, $wpdrsd_downloads_link, $wpdrsd_settings_link );

	/** Display plugin settings links */
	return apply_filters(
		'wpdrsd_filter_settings_page_link',
		$wpdrsd_links,
		$wpdrsd_downloads_link,		// additional param
		$wpdrsd_settings_link  		// additional param
	);

}  // end function


add_filter( 'plugin_row_meta', 'ddw_wpdrsd_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page
 *
 * @since 1.0.0
 * @since 1.2.0 Refactoring.
 *
 * @uses ddw_wpdrsd_get_info_link()
 *
 * @param array  $wpdrsd_links (Default) Array of plugin meta links
 * @param string $wpdrsd_file  Path of base plugin file
 * @return array $wpdrsd_links Array of plugin link strings to build HTML markup.
 */
function ddw_wpdrsd_plugin_links( $wpdrsd_links, $wpdrsd_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $wpdrsd_links;
	}

	/** List additional links only for this plugin */
	if ( $wpdrsd_file == WPDRSD_PLUGIN_BASEDIR . 'wpdr-simple-downloads.php' ) {

		?>
			<style type="text/css">
				tr[data-plugin="<?php echo $wpdrsd_file; ?>"] .plugin-version-author-uri a.dashicons-before:before {
					font-size: 17px;
					margin-right: 2px;
					opacity: .85;
					vertical-align: sub;
				}
			</style>
		<?php

		/* translators: Plugins page listing */
		$wpdrsd_links[] = ddw_wpdrsd_get_info_link( 'url_wporg_faq', esc_html_x( 'FAQ', 'Plugins page listing', 'wpdr-simple-downloads' ), 'dashicons-before dashicons-editor-help' );

		/* translators: Plugins page listing */
		$wpdrsd_links[] = ddw_wpdrsd_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Plugins page listing', 'wpdr-simple-downloads' ), 'dashicons-before dashicons-sos' );

		/* translators: Plugins page listing */
		$wpdrsd_links[] = ddw_wpdrsd_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Plugins page listing', 'wpdr-simple-downloads' ), 'dashicons-before dashicons-facebook' );

		/* translators: Plugins page listing */
		$wpdrsd_links[] = ddw_wpdrsd_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Plugins page listing', 'wpdr-simple-downloads' ), 'dashicons-before dashicons-translation' );

		/* translators: Plugins page listing */
		$wpdrsd_links[] = ddw_wpdrsd_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Plugins page listing', 'wpdr-simple-downloads' ), 'button-primary dashicons-before dashicons-thumbs-up' );

	}  // end if

	/** Output the links */
	return apply_filters(
		'wpdrsd_filter_plugin_links',
		$wpdrsd_links
	);

}  // end function


add_action( 'sidebar_admin_setup', 'ddw_wpdrsd_plugin_help' );
/**
 * Load plugin help tab after core help tabs on Widget admin page.
 *
 * @since 1.0.0
 *
 * @global string $GLOBALS[ 'pagenow' ]
 */
function ddw_wpdrsd_plugin_help() {

	//global $pagenow;

	add_action( 'admin_head-' . $GLOBALS[ 'pagenow' ], 'ddw_wpdrsd_help_tab' );

}  // end function


add_action( 'load-edit.php', 'ddw_wpdrsd_documents_cpt_load_help', 100 );
add_action( 'load-post.php', 'ddw_wpdrsd_documents_cpt_load_help', 100 );
add_action( 'load-post-new.php', 'ddw_wpdrsd_documents_cpt_load_help', 100 );
/**
 * Load plugin help tab on WPDR's CPT pages.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @global mixed $wpdrsd_screen
 */
function ddw_wpdrsd_documents_cpt_load_help() {

	global $wpdrsd_screen;	//, $post;

	$wpdrsd_screen = get_current_screen();

	/** Check for CPT screens */
	if ( ( 'edit' === $wpdrsd_screen->base || 'post' === $wpdrsd_screen->base || 'post-new' === $wpdrsd_screen->base )
		&& 'document' === $wpdrsd_screen->post_type
	) {

		/** Add the help tab */
		$wpdrsd_screen->add_help_tab( array(
			'id'       => 'wpdrsd-documents-help',
			'title'    => __( 'WPDR', 'wpdr-simple-downloads' ) . ' ' . __( 'Simple Downloads', 'wpdr-simple-downloads' ),
			'callback' => 'ddw_wpdrsd_help_content',
		) );

		/** Add help sidebar */
		$wpdrsd_screen->set_help_sidebar( ddw_wpdrsd_help_sidebar_content_extra() . ddw_wpdrsd_help_sidebar_content() );

	}  // end if

}  // end function


/**
 * Create and display plugin help tab.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @global mixed $wpdrsd_screen, $GLOBALS[ 'pagenow' ]
 */
function ddw_wpdrsd_help_tab() {

	global $wpdrsd_screen, $pagenow;

	$wpdrsd_screen = get_current_screen();

	/** Add the help tab */
	$wpdrsd_screen->add_help_tab( array(
		'id'       => 'wpdr-simple-downloads-help',
		'title'    => __( 'WPDR', 'wpdr-simple-downloads' ) . ' ' . __( 'Simple Downloads', 'wpdr-simple-downloads' ),
		'callback' => 'ddw_wpdrsd_help_content',
	) );

	/** Add help sidebar */
	if ( 'widgets.php' !== $GLOBALS[ 'pagenow' ] ) {
		$wpdrsd_screen->set_help_sidebar( ddw_wpdrsd_help_sidebar_content_extra() . ddw_wpdrsd_help_sidebar_content() );
	}

}  // end function


/**
 * Create and display plugin help tab content.
 *
 * @since 1.0.0
 *
 * @global mixed $wpdrsd_screen, $pagenow
 */
function ddw_wpdrsd_help_content() {

	echo '<h3>' . __( 'Plugin', 'wpdr-simple-downloads' ) . ': ' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ) . ' <small>v' . WPDRSD_VERSION . '</small></h3>';

	echo ddw_wpdrsd_plugin_help_content_widgets();

	echo ddw_wpdrsd_plugin_help_content_usage();

	echo ddw_wpdrsd_plugin_help_content_links_copyright();

}  // end function


/**
 * Create and display plugin help tab content for 'Usage' section.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @uses ddw_wpdrsd_get_info_url()
 *
 * @return string HTML help content.
 */
function ddw_wpdrsd_plugin_help_content_usage() {

	$wpdrsd_usage_content = '<p><strong>' . __( 'Insert Downloads', 'wpdr-simple-downloads' ) . ':</strong>' .

		'<br /><blockquote>' . __( 'To insert a download file link into a Post, Page or Custom Post Type, use the regular "Insert Link" feature, search for your Download/ Document file (searches for title!) and insert the actual link. Really simple, yeah!', 'wpdr-simple-downloads' ) . '</blockquote></p>' .

		'<p><strong>' . __( 'Update Downloads', 'wpdr-simple-downloads' ) . ':</strong>' .

		'<br /><blockquote>' . sprintf( __( 'To update an existing file/ document just %sopen an existing item%s and upload a new version (revision). The file/ document peramlink will always point to the latest revision! Yes, it\'s so easy :)', 'wpdr-simple-downloads' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=document' ) ) . '">', '</a>' ) . '</blockquote></p>' .

		'<p><strong>' . __( 'Front End Display Options', 'wpdr-simple-downloads' ) . ':</strong>' .

		'<br /><blockquote>' . sprintf(
			/* translators: %1$s - opening link markup / %2$s - closing link markup / %3$s - opening link markup / %4$s - code markup / %5$s - opening link markup */
			__( 'You can also use %1$sthird-party plugins%2$s or %3$sWidgets%2$s that support custom post types to query, display or do anything you want with the %4$s post type, that we use for the download files. %5$sShortcodes%2$s from the base plugin are also available. Pretty simple again, yet very effective and WordPress standards compliant.', 'wpdr-simple-downloads' ),
			'<a href="' . ddw_wpdrsd_get_info_url( 'url_plugin_faq' ) . '" target="_blank" rel="noopener noreferrer">',
			'</a>',
			'<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">',
			'<code>Document</code>',
			'<a href="' . ddw_wpdrsd_get_info_url( 'url_wpdr_faq' ) . '" target="_blank" rel="noopener noreferrer">'
		) . '</blockquote></p>';

	return apply_filters(
		'wpdrsd_filter_help_usage_content',
		$wpdrsd_usage_content
	);

}  // end function


/**
 * Create and display plugin help tab content for 'Widgets' section.
 *
 * @since 1.0.0
 *
 * @return string HTML help content.
 */
function ddw_wpdrsd_plugin_help_content_widgets() {

	$wpdrsd_widgets_content = '<p><strong>' . __( 'Included Widgets by the plugin', 'wpdr-simple-downloads' ) . ':</strong></p>' .
		'<ul>' .
			'<li><strong><em>' . __( 'WPDRSD: Popular Downloads', 'wpdr-simple-downloads' ) . '</em></strong> &ndash; ' . esc_html__( 'Displays the most popular/ accessed Downloads.', 'wpdr-simple-downloads' ) . '</li>' .

			'<li><strong><em>' . __( 'WPDRSD: Search Downloads', 'wpdr-simple-downloads' ) . '</em></strong> &ndash; ' . esc_html__( 'Search for Downloads/ Documents by the WP Documents Revision Simple Downloads plugin. Search in downloads only. (No mix up with regular WordPress search!)', 'wpdr-simple-downloads' ) . '</li>' .

			'<li><strong><em>' . __( 'WPDRSD: File Categories / Tags', 'wpdr-simple-downloads' ) . '</em></strong> &ndash; ' . esc_html__( 'Displays File Categories or File Tags for Downloads.', 'wpdr-simple-downloads' ) . '</li>' .
		'</ul>';

	return apply_filters(
		'wpdrsd_filter_help_widgets_content',
		$wpdrsd_widgets_content
	);

}  // end function


/**
 * Create and display plugin help tab content for 'Links' & 'Copyright' sections.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @uses ddw_wpdrsd_get_info_link()
 * @uses ddw_wpdrsd_info_values()
 * @uses ddw_wpdrsd_coding_years()
 *
 * @return string HTML help content.
 */
function ddw_wpdrsd_plugin_help_content_links_copyright() {

	$wpdrsd_info = (array) ddw_wpdrsd_info_values();

	/** Further help content */
	$wpdrsd_links_copyright_content = $wpdrsd_info[ 'space_helper' ] . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'wpdr-simple-downloads' ) . '</h4>' .

		ddw_wpdrsd_get_info_link( 'url_plugin', esc_html__( 'Plugin website', 'wpdr-simple-downloads' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_wpdrsd_get_info_link( 'url_plugin_faq', esc_html_x( 'FAQ', 'Help tab info', 'wpdr-simple-downloads' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_wpdrsd_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Help tab info', 'wpdr-simple-downloads' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_wpdrsd_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Help tab info', 'wpdr-simple-downloads' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_wpdrsd_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Help tab info', 'wpdr-simple-downloads' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_wpdrsd_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Help tab info', 'wpdr-simple-downloads' ), 'button button-primary dashicons-before dashicons-thumbs-up wpdrsd' );

	$wpdrsd_links_copyright_content .= sprintf(
			'<p><a href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">%2$s</a> &#x000A9; %3$s <a href="%4$s" target="_blank" rel="noopener noreferrer" title="%5$s">%5$s</a></p>',
			esc_url( $wpdrsd_info[ 'url_license' ] ),
			esc_attr( $wpdrsd_info[ 'license' ] ),
			ddw_wpdrsd_coding_years(),
			esc_url( $wpdrsd_info[ 'author_uri' ] ),
			esc_html( $wpdrsd_info[ 'author' ] )
		);

	return apply_filters(
		'wpdrsd_filter_help_links_copyright_content',
		$wpdrsd_links_copyright_content
	);

}  // end function


/**
 * Helper function for returning the Help Sidebar content.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @uses ddw_wpdrsd_get_info_url()
 *
 * @return string/HTML of help sidebar content.
 */
function ddw_wpdrsd_help_sidebar_content() {

	$wpdrsd_help_sidebar = '<p><strong>' . __( 'More about the plugin author', 'wpdr-simple-downloads' ) . '</strong></p>';

	$wpdrsd_help_sidebar .=	'<p>' . __( 'Social:', 'wpdr-simple-downloads' ) . '<br /><a href="https://twitter.com/deckerweb" target="_blank" rel="noopener noreferrer" title="@ Twitter">Twitter</a> | <a href="https://www.facebook.com/groups/deckerweb.wordpress.plugins/" target="_blank" rel="noopener noreferrer" title="@ Facebook">Facebook</a> | <a href="https://github.com/deckerweb" target="_blank" rel="noopener noreferrer" title="@ GitHub">GitHub</a> | <a href="' . ddw_wpdrsd_get_info_url( 'author_uri' ) . '" target="_blank" rel="noopener noreferrer" title="@ deckerweb.de">deckerweb</a></p>' .
				'<p><a href="' . ddw_wpdrsd_get_info_url( 'url_wporg_profile' ) . '" target="_blank" rel="noopener noreferrer" title="@ WordPress.org">@ WordPress.org</a></p>';

	return apply_filters(
		'wpdrsd_filter_help_sidebar_content',
		$wpdrsd_help_sidebar
	);

}  // end function


/**
 * Helper function for returning the Help Sidebar content - extra for plugin setting page.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @uses ddw_wpdrsd_get_info_url()
 *
 * @return string Extra HTML content for help sidebar.
 */
function ddw_wpdrsd_help_sidebar_content_extra() {

	$wpdrsd_help_sidebar_content_extra = '<p><strong>' . __( 'Actions', 'wpdr-simple-downloads' ) . ':</strong></p>';

	$wpdrsd_help_sidebar_content_extra .= '<p>&rarr; <a href="' . ddw_wpdrsd_get_info_url( 'url_wporg_forum' ) . '" target="_blank" rel="noopener noreferrer">' . __( 'Support Forum', 'wpdr-simple-downloads' ) . '</a></p>' .
		'<p style="margin-top: -5px;">&rarr; <a href="' . ddw_wpdrsd_get_info_url( 'url_donate' ) . '" target="_blank" rel="noopener noreferrer">' . __( 'Donate', 'wpdr-simple-downloads' ) . '</a></p>';

	return apply_filters( 'wpdrsd_filter_help_sidebar_content_extra', $wpdrsd_help_sidebar_content_extra );

}  // end ofunction


/**
 * Inline CSS fix for Plugins page update messages.
 *
 * @since 1.2.0
 *
 * @see ddw_wpdrsd_plugin_update_message()
 * @see ddw_wpdrsd_multisite_subsite_plugin_update_message()
 */
function ddw_wpdrsd_plugin_update_message_style_tweak() {

	?>
		<style type="text/css">
			.wpdrsd-update-message p:before,
			.update-message.notice p:empty {
				display: none !important;
			}
		</style>
	<?php

}  // end function


add_action( 'in_plugin_update_message-' . WPDRSD_PLUGIN_BASEDIR . 'wpdr-simple-downloads.php', 'ddw_wpdrsd_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for regular single site installs, and for Multisite
 *         installs where the plugin is activated Network-wide.
 *
 * @since  1.2.0
 *
 * @param object $data
 * @param object $response
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_wpdrsd_plugin_update_message( $data, $response ) {

	if ( isset( $data[ 'upgrade_notice' ] ) ) {

		ddw_wpdrsd_plugin_update_message_style_tweak();

		printf(
			'<div class="update-message wpdrsd-update-message">%s</div>',
			wpautop( $data[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


add_action( 'after_plugin_row_wp-' . WPDRSD_PLUGIN_BASEDIR . 'wpdr-simple-downloads.php', 'ddw_wpdrsd_multisite_subsite_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for Multisite installs where the plugin is
 *         activated on a per site basis.
 *
 * @since 1.2.0
 *
 * @param string $file
 * @param object $plugin
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_wpdrsd_multisite_subsite_plugin_update_message( $file, $plugin ) {

	if ( is_multisite() && version_compare( $plugin[ 'Version' ], $plugin[ 'new_version' ], '<' ) ) {

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );

		ddw_wpdrsd_plugin_update_message_style_tweak();

		printf(
			'<tr class="plugin-update-tr"><td colspan="%s" class="plugin-update update-message notice inline notice-warning notice-alt"><div class="update-message wpdrsd-update-message"><h4 style="margin: 0; font-size: 14px;">%s</h4>%s</div></td></tr>',
			$wp_list_table->get_column_count(),
			$plugin[ 'Name' ],
			wpautop( $plugin[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


/**
 * Optionally tweaking Plugin API results to make more useful recommendations to
 *   the user.
 *
 * @since 1.2.0
 */

add_filter( 'ddwlib_plir/filter/plugins', 'ddw_wpdrsd_register_extra_plugin_recommendations' );
/**
 * Register specific plugins for the class "DDWlib Plugin Installer
 *   Recommendations".
 *   Note: The top-level array keys are plugin slugs from the WordPress.org
 *         Plugin Directory.
 *
 * @since 1.2.0
 *
 * @param array $plugins Array holding all plugin recommendations, coming from
 *                        the class and the filter.
 * @return array Filtered array of all plugin recommendations.
 */
function ddw_wpdrsd_register_extra_plugin_recommendations( array $plugins ) {

	/** Remove our own slug when we are already active :) */
	if ( isset( $plugins[ 'wpdr-simple-downloads' ] ) ) {
		$plugins[ 'wpdr-simple-downloads' ] = null;
	}

	/** Merge with the existing recommendations and return */
	return $plugins;
  
}  // end function

/** Optionally add string translations for the library */
if ( ! function_exists( 'ddwlib_plir_strings_plugin_installer' ) ) :

	add_filter( 'ddwlib_plir/filter/strings/plugin_installer', 'ddwlib_plir_strings_plugin_installer' );
	/**
	 * Optionally, make strings translateable for included library "DDWlib Plugin
	 *   Installer Recommendations".
	 *   Strings:
	 *    - "Newest" --> tab in plugin installer toolbar
	 *    - "Version:" --> label in plugin installer plugin card
	 *
	 * @since 1.2.0
	 *
	 * @param array $strings Holds all filterable strings of the library.
	 * @return array Array of tweaked translateable strings.
	 */
	function ddwlib_plir_strings_plugin_installer( $strings ) {

		$strings[ 'newest' ] = _x(
			'Newest',
			'Plugin installer: Tab name in installer toolbar',
			'wpdr-simple-downloads'
		);

		$strings[ 'version' ] = _x(
			'Version:',
			'Plugin card: plugin version',
			'wpdr-simple-downloads'
		);

		return $strings;

	}  // end function

endif;  // function check

/** Include class DDWlib Plugin Installer Recommendations */
require_once( WPDRSD_PLUGIN_DIR . 'includes/admin/ddwlib-plugin-installer-recommendations.php' );
