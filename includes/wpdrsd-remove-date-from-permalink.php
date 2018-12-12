<?php

// includes/wpdrsd-remove-date-from-permalink

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'document_permalink', 'ddw_wpdrsd_remove_dates_from_permalink_filter', 10, 2 );
/**
 * Strip the date from permalink.
 *
 * @author Benjamin J. Balter
 * @link   http://ben.balter.com
 *
 * @since 1.0.0
 *
 * @param $link
 * @param $post
 */
function ddw_wpdrsd_remove_dates_from_permalink_filter( $link, $post ) {

	$timestamp = strtotime( $post->post_date );

	return str_replace( '/' . date( 'Y', $timestamp ) . '/' . date( 'm', $timestamp ) . '/', '/', $link );
	
}  // end function


add_filter( 'document_rewrite_rules', 'ddw_wpdrsd_remove_date_from_rewrite_rules' );
/**
 * Strip the date from rewrite rules.
 *
 * @author Benjamin J. Balter
 * @link   http://ben.balter.com
 *
 * @since 1.0.0
 *
 * @global mixed $wpdr
 *
 * @param array $rules
 * @return array Modified array of $rules.
 */
function ddw_wpdrsd_remove_date_from_rewrite_rules( $rules ) {

	global $wpdr;

	$slug = $wpdr->document_slug();

	$rules = array();

	/** Example: documents/foo-revision-1.bar */
	$rules[ $slug . '/([^.]+)-' . _x( 'revision', 'Translators: revisions slug', 'wpdr-simple-downloads' ) . '-([0-9]+)\.[A-Za-z0-9]{3,4}/?$'] = 'index.php?&document=$matches[1]&revision=$matches[2]';

	/** Example: documents/foo.bar/feed/ */
	$rules[ $slug . '/([^.]+)(\.[A-Za-z0-9]{3,4})?/feed/?$' ] = 'index.php?document=$matches[1]&feed=feed';

	/** Example: documents/foo.bar */
	$rules[ $slug . '/([^.]+)\.[A-Za-z0-9]{3,4}/?$' ] = 'index.php?document=$matches[1]';

	/** Example: site.com/documents/ should list all documents that user has access to (private, public) */
	$rules[ $slug . '/?$' ] = 'index.php?post_type=document';
	$rules[ $slug . '/page/?([0-9]{1,})/?$' ] = 'index.php?post_type=document&paged=$matches[1]';

	return $rules;

}  // end function
