<?php

// includes/wpdrsd-functions-global

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Is WP Document Revisions (free) plugin active or not?
 *
 * @since 1.2.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function ddw_wpdrsd_is_wpdr_active() {

	return class_exists( 'WP_Document_Revisions' );

}  // end function


/**
 * Get default plugin options.
 *
 * @since 1.0.0
 *
 * @return array Array of default options/values.
 */
function ddw_wpdrsd_default_options() {

	return array(
		'wpdrsd_downloads_labels'       => TRUE,
		'wpdrsd_tax_file_categories'    => TRUE,
		'wpdrsd_tax_file_tags'          => TRUE,
		'wpdrsd_downloads_translations' => TRUE,
		'wpdrsd_formal_translations'    => TRUE,
		'wpdrsd_remove_date_permalink'  => TRUE,
		'wpdrsd_default_visibility'     => FALSE,
		'wpdrsd_show_revision_log'      => TRUE,
	);

}  // end function


/**
 * Get current plugin options.
 *
 * @since 1.0.0
 *
 * @uses get_option()
 * @uses ddw_wpdrsd_default_options()
 * @uses wp_parse_args()
 *
 * @return array 
 */
function ddw_wpdrsd_get_options() {

	$from_db = get_option( 'wpdrsd_options' );

	$default = ddw_wpdrsd_default_options();

	return wp_parse_args( $from_db, $default );

}  // end function


/**
 * Get German-based informal locales for re-use.
 *
 * @since  1.2.0
 *
 * @return array Filterable array of German-based informal locales.
 */
function ddw_wpdrsd_get_german_informal_locales() {

	return apply_filters(
		'wpdrsd_filter_german_informal_locales',
		array(
			'de_DE', 'de_DE_informal',
			'de_AT', 'de_AT_informal',
			'de_CH', 'de_CH_informal', 'gsw',
			'de_LU', 'de_LU_informal',
		)
	);

}  // end function


/**
 * Get German-based formal locales for re-use.
 *
 * @since  1.2.0
 *
 * @return array Filterable array of German-based formal locales.
 */
function ddw_wpdrsd_get_german_formal_locales() {

	return apply_filters(
		'wpdrsd_filter_german_formal_locales',
		array(
			'de_DE_formal', 'de_DE_Sie', 'de_DE_sie',
			'de_AT_formal', 'de_AT_Sie', 'de_AT_sie',
			'de_CH_formal', 'de_CH_Sie', 'de_CH_sie',
			'de_LU_formal', 'de_LU_Sie', 'de_LU_sie',
		)
	);

}  // end function


/**
 * Get English-based locales for re-use.
 *
 * @since 1.2.0
 */
function ddw_wpdrsd_get_english_locaes() {

	return apply_filters(
		'wpdrsd_filter_english_locales',
		array( 'en_US', 'en', 'en_CA', 'en_GB', 'en_AU', 'en_NZ', 'en_UK' )
	);

}  // end function


add_action( 'plugins_loaded', 'ddw_wpdrsd_prepare_wpdr_translations', 9 );
/**
 * Prepare our translation tweaks for base plugin "WP Document Revisions" (WPDR).
 *   This is a necessary in-between step to catch the proper loading priority.
 *   WPDR loads its translations at priority 10 on 'plugins_loaded'. We have to
 *   fire earlier.
 *
 * @since 1.2.0
 */
function ddw_wpdrsd_prepare_wpdr_translations() {

	add_filter( 'load_textdomain_mofile', 'ddw_wpdrsd_load_wpdr_translations', 10, 2 );

}  // end function


//add_filter( 'load_textdomain_mofile', 'ddw_wpdrsd_load_wpdr_translations', 100, 2 );	// $mofile, $domain
//add_filter( 'override_load_textdomain', 'ddw_wpdrsd_load_wpdr_translations', 10, 3 );	// $override, $domain, $mofile
/**
 * Optionally unload translations for various plugins. Which plugins, this is
 *   controlled via this plugin's settings, and/or from settings of an active
 *   Add-On plugin.
 *
 *   This works by "disabling" the path to the .mo file for the specified text
 *   domains.
 *
 * @since 1.2.0
 *
 * @uses ddw_wpdrsd_get_german_formal_locales()
 * @uses ddw_wpdrsd_get_german_informal_locales()
 * @uses ddw_wpdrsd_get_english_locaes()
 *
 * @param string $mofile Path to .mo file.
 * @param string $domain Textdomain.
 * @return string|null If our specified domain return default, the path of .mo
 *                     file otherwise.
 */
function ddw_wpdrsd_load_wpdr_translations( $mofile, $domain ) {

	if ( 'wp-document-revisions' === $domain ) {

		$german_locales = array_merge( ddw_wpdrsd_get_german_informal_locales(), ddw_wpdrsd_get_german_formal_locales() );

		$options = ddw_wpdrsd_get_options();

		/** a) Use "Download" variant: */
		if ( $options[ 'wpdrsd_downloads_translations' ] ) {

			/** 1) German, formal */
			if ( $options[ 'wpdrsd_formal_translations' ]
				&& in_array( get_locale(), $german_locales )
			) {
				$mofile = WPDRSD_PLUGIN_DIR . 'wpdr-pomo/downloads-variant/wp-document-revisions-de_DE_formal.mo';
			}

			/** 2) German, informal */
			elseif ( ! $options[ 'wpdrsd_formal_translations' ]
				&& in_array( get_locale(), $german_locales )
			) {
				$mofile = WPDRSD_PLUGIN_DIR . 'wpdr-pomo/downloads-variant/wp-document-revisions-de_DE.mo';
			}

			/** 3) English */
			if ( in_array( get_locale(), ddw_wpdrsd_get_english_locaes() ) ) {
				$mofile = WPDRSD_PLUGIN_DIR . 'wpdr-pomo/downloads-variant/wp-document-revisions-en_US.mo';
			}

		}

		/** b) Use "Document" variant: */
		elseif ( ! $options[ 'wpdrsd_downloads_translations' ] ) {

			/** 1) German, formal */
			if ( $options[ 'wpdrsd_formal_translations' ]
				&& in_array( get_locale(), ddw_wpdrsd_get_german_formal_locales() )
			) {
				$mofile = WPDRSD_PLUGIN_DIR . 'wpdr-pomo/documents-variant/wp-document-revisions-de_DE_formal.mo';
			}

			/** 2) German, informal */
			elseif ( ! $options[ 'wpdrsd_formal_translations' ]
				&& in_array( get_locale(), ddw_wpdrsd_get_german_informal_locales() )
			) {
				$mofile = WPDRSD_PLUGIN_DIR . 'wpdr-pomo/documents-variant/wp-document-revisions-de_DE.mo';
			}

			/** 3) English */
			if ( in_array( get_locale(), ddw_wpdrsd_get_english_locaes() ) ) {
				$mofile = WPDRSD_PLUGIN_DIR . 'wpdr-pomo/documents-variant/wp-document-revisions-en_US.mo';
			}

		}  // end if option check

	}  // end if text domain check
  
	/** Return the current .mo file */
	return $mofile;
  
}  // end function


add_filter( 'load_textdomain_mofile', 'ddw_wpdrsd_maybe_load_formal_translations', 10, 2 );
/**
 * Load formal German translations for this plugin if Formal translations are
 *   set in plugin's settings, and, the current locale (via get_locale()) is not
 *   'de_DE_formal'.
 *   Note I: The default is only for locale 'de_DE_formal', but with the
 *           included filter this could be extended to any locale that is wanted
 *           (filter accepts an array of locales).
 *   Note II: Also the loaded .mo file is filterable, you need to provide a
 *            proper .mo file path.
 *
 * @since 1.2.0
 *
 * @uses ddw_wpdrsd_get_options()
 * @uses get_locale()
 *
 * @param string $mofile Path to .mo file.
 * @param string $domain Textdomain.
 * @return string|null If our specified domain return default, the path of .mo
 *                     file otherwise.
 */
function ddw_wpdrsd_maybe_load_formal_translations( $mofile, $domain ) {

	/** Get our options */
	$options = ddw_wpdrsd_get_options();

	/** Bail early if formal setting & current locale are not matching */
	if ( ! $options[ 'wpdrsd_formal_translations' ] || 'de_DE_formal' === get_locale() ) {
		return $mofile;
	}

	/** Filterable array of locales */
	$locales_load_formal = apply_filters(
		'wpdrsd_filter_locales_load_formal',
		array( 'de_DE', 'de_AT' )
	);

	/**
	 * If proper formal setting is set and text domain is from our plugin, and,
	 *   the locale is within the array of allowed locales, then load the formal
	 *   German translations (or any other .mo file provided by the filter).
	 */
	if ( $options[ 'wpdrsd_formal_translations' ]
		&& 'wpdr-simple-downloads' === $domain
		&& in_array( get_locale(), $locales_load_formal )
	) {

		$mofile = apply_filters(
			'wpdrsd_filter_mofile_load_formal',
			WPDRSD_PLUGIN_DIR . 'languages/wpdr-simple-downloads-de_DE_formal.mo'
		);

	}  // end if

	/** Return the tweaked .mo file */
	return $mofile;

}  // end function


/**
 * Setting internal plugin helper values.
 *
 * @since 1.2.0
 *
 * @return array $wpdrsd_info Array of info values.
 */
function ddw_wpdrsd_info_values() {

	$wpdrsd_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/wpdr-simple-downloads',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/wpdr-simple-downloads/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/wpdr-simple-downloads',
		'url_wporg_review'  => 'https://wordpress.org/support/plugin/wpdr-simple-downloads/reviews/?filter=5/#new-post',
		'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
		'url_fb_group'      => 'https://www.facebook.com/groups/deckerweb.wordpress.plugins/',
		'url_snippets'      => 'https://github.com/deckerweb/wpdr-simple-downloads/wiki/Code-Snippets',		// https://gist.github.com/4395899
		'author'            => __( 'David Decker - DECKERWEB', 'wpdr-simple-downloads' ),
		'author_uri'        => 'https://deckerweb.de/',
		'license'           => 'GPL-2.0-or-later',
		'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
		'first_code'        => '2012',
		'url_donate'        => 'https://www.paypal.me/deckerweb',
		'url_plugin'        => 'https://github.com/deckerweb/wpdr-simple-downloads',
		'url_plugin_docs'   => 'https://github.com/deckerweb/wpdr-simple-downloads/wiki',	// https://gist.github.com/4395899
		'url_plugin_faq'    => 'https://wordpress.org/plugins/wpdr-simple-downloads/#faq',
		'url_github'        => 'https://github.com/deckerweb/wpdr-simple-downloads',
		'url_github_issues' => 'https://github.com/deckerweb/wpdr-simple-downloads/issues',
		'url_twitter'       => 'https://twitter.com/deckerweb',
		'url_github_follow' => 'https://github.com/deckerweb',
		'video_bulk_add'    => 'https://www.youtube.com/watch?v=KyCY-cGAB9o',
		'video_bulk_add_tb' => '//www.youtube-nocookie.com/embed/KyCY-cGAB9o?rel=0&TB_iframe=true&width=1024&height=576',	// for Thickbox, embed version, no cookies!
		'url_wpdr_faq'      => 'https://ben.balter.com/wp-document-revisions/frequently-asked-questions/',
		'url_wpdr_plugin'   => 'https://wordpress.org/plugins/wp-document-revisions/',
		'space_helper'      => '<div style="height: 10px;"></div>',

	);  // end of array

	return $wpdrsd_info;

}  // end function


/**
 * Get URL of specific WPDRSD info value.
 *
 * @since 1.2.0
 *
 * @uses ddw_wpdrsd_info_values()
 *
 * @param string $url_key String of value key from array of ddw_wpdrsd_info_values()
 * @param bool   $raw     If raw escaping or regular escaping of URL gets used
 * @return string URL for info value.
 */
function ddw_wpdrsd_get_info_url( $url_key = '', $raw = FALSE ) {

	$wpdrsd_info = (array) ddw_wpdrsd_info_values();

	$output = esc_url( $wpdrsd_info[ sanitize_key( $url_key ) ] );

	if ( TRUE === $raw ) {
		$output = esc_url_raw( $wpdrsd_info[ esc_attr( $url_key ) ] );
	}

	return $output;

}  // end function


/**
 * Get link with complete markup for a specific BTC info value.
 *
 * @since 1.2.0
 *
 * @uses ddw_wpdrsd_get_info_url()
 *
 * @param string $url_key String of value key
 * @param string $text    String of text and link attribute
 * @param string $class   String of CSS class
 * @return string HTML markup for linked URL.
 */
function ddw_wpdrsd_get_info_link( $url_key = '', $text = '', $class = '' ) {

	$link = sprintf(
		'<a class="%1$s" href="%2$s" target="_blank" rel="nofollow noopener noreferrer" title="%3$s">%3$s</a>',
		strtolower( esc_attr( $class ) ),	//sanitize_html_class( $class ),
		ddw_wpdrsd_get_info_url( $url_key ),
		esc_html( $text )
	);

	return $link;

}  // end function


/**
 * Get timespan of coding years for this plugin.
 *
 * @since 1.2.0
 *
 * @uses ddw_wpdrsd_info_values()
 *
 * @param int $first_year Integer number of first year
 * @return string Timespan of years.
 */
function ddw_wpdrsd_coding_years( $first_year = '' ) {

	$wpdrsd_info = (array) ddw_wpdrsd_info_values();

	$first_year = ( empty( $first_year ) ) ? absint( $wpdrsd_info[ 'first_code' ] ) : absint( $first_year );

	/** Set year of first released code */
	$code_first_year = ( date( 'Y' ) == $first_year || 0 === $first_year ) ? '' : $first_year . '&#x02013;';

	return $code_first_year . date( 'Y' );

}  // end function
