<?php

// includes/third-party-compat/wpdrsd-genesis-framework

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/** 
 * Sets the Genesis Post Meta for the "Document" (Downloads) post type,
 *    to use "wpdr-file-categories" and "wpdr-file-tags" taxonomies if they exist.
 *
 * @since 1.0.0
 *
 * @global mixed $post
 *
 * @param string $post_meta
 * @return string Post meta info for "Document" (Downloads) post type taxonomies.
 */
function ddw_wpdrsd_genesis_post_meta( $post_meta ) {
    
	global $post;

	if ( is_page() ) {
		return;
	}

	$terms_file_categories = wp_get_object_terms( $post->ID, 'wpdr-file-categories' );
	$terms_file_tags       = wp_get_object_terms( $post->ID, 'wpdr-file-tags' );

	if ( 'document' === get_post_type() /* post_type_exists( 'document' ) */ ) {

		if ( ( count( $terms_file_categories ) > 0 ) && ( count( $terms_file_tags ) > 0 ) ) {

			$post_meta = do_shortcode( '[post_terms taxonomy="wpdr-file-categories"] <span class="post-meta-sep">' . _x( '&#x00B7;', 'Translators: Taxonomy separator for Genesis child themes (default: &#x00B7; = &middot;)', 'wpdr-simple-downloads' ) . '</span> [post_terms before="' . __( 'Tagged:', 'wpdr-simple-downloads' ) . ' " taxonomy="wpdr-file-tags"]<br /><br />' );

		} elseif ( ( count( $terms_file_categories ) > 0 ) && ! $terms_file_tags ) {

			$post_meta = do_shortcode( '[post_terms taxonomy="wpdr-file-categories"]<br /><br />' );

		} elseif ( ! $terms_cat && ( count( $terms_file_tags ) > 0 ) ) {

			$post_meta = do_shortcode( '[post_terms before="' . __( 'Tagged:', 'wpdr-simple-downloads' ) . ' " taxonomy="wpdr-file-tags"]<br /><br />' );

		} elseif ( ! $terms_file_categories && ! $terms_file_tags ) {

			$post_meta = '';

		}  // end if taxonomy checks

	}  // end if post type check
    
	return $post_meta;

}  // end function
