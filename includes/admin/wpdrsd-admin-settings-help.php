<?php

// includes/wpdrsd-admin-settings-help

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Add help tab content for WP Document Revisions Simple Downloads Plugin.
 *
 * @since 1.0.0
 *
 * @global mixed $wpdrsd_settings_page
 */
function ddw_wpdrsd_admin_settings_help() {

	/** Get current screen */
 	$wpdrsd_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if ( ! class_exists( 'WP_Screen' ) || ! $wpdrsd_screen ) {
		return;
	}

	/** Add Starting/General help tab */
	$wpdrsd_screen->add_help_tab( array(
		'id'       => 'wpdrsd-plugin-info-help', 
		'title'    => __( 'WPDR', 'wpdr-simple-downloads' ) . ' ' . __( 'Simple Downloads', 'wpdr-simple-downloads' ),
		'callback' => 'ddw_wpdrsd_plugin_info_help',
	) );

	/** Add Additional Widgets help tab */
	$wpdrsd_screen->add_help_tab( array(
		'id'       => 'wpdrsd-additional-widgets-help', 
		'title'    => __( 'Additional Widgets', 'wpdr-simple-downloads' ),
		'callback' => 'ddw_wpdrsd_additional_widgets_help',
	) );

	/** Add Developers help tab */
	$wpdrsd_screen->add_help_tab( array(
		'id'       => 'wpdrsd-plugin-developers-help', 
		'title'    => __( 'Developers', 'wpdr-simple-downloads' ),
		'callback' => 'ddw_wpdrsd_plugin_developers_help',
	) );

	/** Add Translations help tab */
	$wpdrsd_screen->add_help_tab( array(
		'id'       => 'wpdrsd-plugin-translations-help', 
		'title'    => __( 'Translations', 'wpdr-simple-downloads' ),
		'callback' => 'ddw_wpdrsd_plugin_translations_help',
	) );

	/** Add help sidebar */
	$wpdrsd_screen->set_help_sidebar( ddw_wpdrsd_help_sidebar_content_extra() . ddw_wpdrsd_help_sidebar_content() );

}  // end function


/**
 * Add help tab content for WP Document Revisions Simple Downloads Plugin.
 *
 * @since 1.0.0
 */
function ddw_wpdrsd_plugin_info_help() {

	echo '<h3>' . __( 'Plugin', 'wpdr-simple-downloads' ) . ': ' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ) . ' <small>v' . WPDRSD_VERSION . '</small></h3>';

	echo ddw_wpdrsd_plugin_help_content_usage();

	echo ddw_wpdrsd_plugin_help_content_links_copyright();

}  // end function


/**
 * Add help tab content for Additional Widgets.
 *
 * @since 1.0.0
 */
function ddw_wpdrsd_additional_widgets_help() {

	echo '<h3>' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ) . ': ' . __( 'Additional Widgets', 'wpdr-simple-downloads' ) . '</h3>';

	echo ddw_wpdrsd_plugin_help_content_widgets();

}  // end function


/**
 * Add help tab content for Developers.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @uses ddw_wpdrsd_get_info_url()
 */
function ddw_wpdrsd_plugin_developers_help() {

	echo '<h3>' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ) . ': ' . __( 'Developers', 'wpdr-simple-downloads' ) . '</h3>';

	echo '<p>' . __( 'This plugin includes a lot of Action Hooks and Filters', 'wpdr-simple-downloads' ) . ':</p>' .
		'<ul>' .
			'<li>' . sprintf(
				/* translators: %s - opening and closing link markup */
				__( 'You can find them in our %sDocumentation%s as well as on our %sCode Snippets%s page (Gist @ GitHub).', 'wpdr-simple-downloads' ),
				'<a href="' . ddw_wpdrsd_get_info_url( 'url_plugin_docs' ) . '" target="_blank" rel="noopener noreferrer">',
				'</a>',
				'<a href="' . ddw_wpdrsd_get_info_url( 'url_snippets' ) . '" target="_blank" rel="noopener noreferrer">',
				'</a>'
			) . '</li>' .
			'<li><em>' . __( 'Note:', 'wpdr-simple-downloads' ) . '</em> ' . sprintf(
				/* translators: %s - Name of plugin, "WP Document Revisions" */
				__( 'Of course, you can still use all hooks and filters from the base plugin, %s!', 'wpdr-simple-downloads' ),
				'<a href="' . ddw_wpdrsd_get_info_url( 'url_wpdr_plugin' ) . '" target="_blank" rel="noopener noreferrer">' . __( 'WP Document Revisions', 'wpdr-simple-downloads' ) . '</a>'
			) . '</li>' .
		'</ul>';

}  // end function


/**
 * Add help tab content for Plugin Translations.
 *
 * @since 1.0.0
 * @since 1.2.0 Code enhancements.
 *
 * @uses ddw_wpdrsd_get_info_url()
 * @uses get_locale()
 * @uses ddw_wpdrsd_get_german_informal_locales()
 * @uses ddw_wpdrsd_get_german_formal_locales()
 */
function ddw_wpdrsd_plugin_translations_help() {

	echo '<h3>' . __( 'WP Document Revisions Simple Downloads', 'wpdr-simple-downloads' ) . ': ' . __( 'Translations', 'wpdr-simple-downloads' ) . '</h3>';

	echo '<p>' . sprintf(
			/* translators: %s - opening and closing link markup */
			__( 'Please contribute to existing or new translations on %sour free translations platform%s powered by GlotPress.', 'wpdr-simple-downloads' ),
			'<a href="' . ddw_wpdrsd_get_info_url( 'url_translate' ) . '" target="_blank" rel="noopener noreferrer" title="' . __( 'Translations', 'wpdr-simple-downloads' ) . '"><strong>',
			'</strong></a>'
		) . '</p>' .
		'<p><blockquote><strong><em>&mdash; ' . __( 'Thank You!', 'wpdr-simple-downloads' ) . '</em></strong></blockquote></p>';

	if ( /* get_locale() == 'de_DE' || get_locale() == 'de_AT' || get_locale() == 'de_CH' || get_locale() == 'de_LU' */
		in_array( get_locale(), array_merge( ddw_wpdrsd_get_german_informal_locales(), ddw_wpdrsd_get_german_formal_locales() ) )
	) {
		$wpdrsd_language_in_use = '<em> (' . __( 'Currently in use', 'wpdr-simple-downloads' ) . ' :)</em>';
	} else {
		$wpdrsd_language_in_use = '';
	}

	echo '<br /><p><strong>' . __( 'Currently available languages', 'wpdr-simple-downloads' ) . ':</strong></p>' .
		'<ul>' .
			'<li>' . __( 'English (en_US)', 'wpdr-simple-downloads' ) . ' &ndash; ' . __( 'default, always included (by David Decker)', 'wpdr-simple-downloads' ) . '</li>' .
			'<li>' . __( 'German (de_DE): Deutsch', 'wpdr-simple-downloads' ) . ' &ndash; ' . __( 'always included (by David Decker)', 'wpdr-simple-downloads' ) . $wpdrsd_language_in_use . '</li>' .
		'</ul>';

}  // end function
