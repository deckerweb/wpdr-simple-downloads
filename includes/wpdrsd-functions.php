<?php

// includes/wpdrsd-functions

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'register_post_type_args', 'ddw_wpdrsd_post_type_as_downloads', 10, 2 );
/**
 * Tweak the 'document' post type arguments to optimize them for the use as
 *   "Downloads".
 *   - Changes all references of "Documents" in the interface to "Downloads".
 *   - Change "Add new" label in toolbar for "Downloads" ("Downloads File")
 *
 * @since 1.0.0
 * @since 1.2.0 Refactoring (new function, filter etc.).
 *
 * @param array  $args Array of post type arguments.
 * @param string $post_type ID of the post type.
 * @return array Array of modified post type arguments.
 */
function ddw_wpdrsd_post_type_as_downloads( $args, $post_type ) {

	$options = ddw_wpdrsd_get_options();

	if ( ! $options[ 'wpdrsd_downloads_labels' ] ) {
		return;
	}

    if ( 'document' === $post_type ) {
 
	 	$args[ 'labels' ] = array(
			'name'               => _x( 'Downloads', 'Translators: post type general name (plural)', 'wpdr-simple-downloads' ),
			'singular_name'      => _x( 'Download', 'Translators: post type singular name', 'wpdr-simple-downloads' ),
			'add_new'            => _x( 'Add Download', 'Translators: download', 'wpdr-simple-downloads' ),
			'add_new_item'       => __( 'Add New Download', 'wpdr-simple-downloads' ),
			'edit_item'          => __( 'Edit Download', 'wpdr-simple-downloads' ),
			'new_item'           => __( 'New Download', 'wpdr-simple-downloads' ),
			'view_item'          => __( 'View Download', 'wpdr-simple-downloads' ),
			'search_items'       => __( 'Search Downloads', 'wpdr-simple-downloads' ),
			'not_found'          => __( 'No Downloads found', 'wpdr-simple-downloads' ),
			'not_found_in_trash' => __( 'No Downloads found in Trash', 'wpdr-simple-downloads' ), 
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Downloads', 'wpdr-simple-downloads' ),
			'name_admin_bar'     => _x(
				'Download File',
				'Translators: Toolbar, add new item',
				'wpdr-simple-downloads'
			),
		);

		$args[ 'supports' ] = apply_filters(
			'wpdrsd_filter_post_type_supports',
			array( 'title', 'author', 'revisions', 'excerpt', 'custom-fields' )
		);

		$args[ 'menu_icon' ] = sanitize_html_class(
			apply_filters(
				'wpdrsd_filter_admin_menu_icon',
				'dashicons-download'
			)
		);

	}  // end if

    return $args;

}  // end function


add_action( 'admin_init', 'ddw_wpdrsd_default_visibility', 20 );
/** 
 * Default visibility of newly added downloads/ documents.
 *
 * @since 1.0.0
 * @since 1.2.0 Changed hook to 'admin_init' ('admin_head' before).
 *
 * @uses ddw_wpdrsd_get_options()
 */
function ddw_wpdrsd_default_visibility() {

	$options = ddw_wpdrsd_get_options();

	if ( $options[ 'wpdrsd_default_visibility' ] ) {
		add_filter( 'document_to_private', 'ddw_wpdrsd_default_visibility_public', 10, 2 );
	}

}  // end function


/** 
 * Set default visibility of newly added downloads/ documents to 'publish'.
 *
 * @since 1.0.0
 *
 * @global object $post
 *
 * @param object $post
 * @param object $post_pre
 *
 * @return object $post
 */
function ddw_wpdrsd_default_visibility_public( $post, $post_pre ) {

	global $post;

	$post->post_status = $post_pre->post_status;

	return $post;

}  // end function


add_action( 'admin_init', 'wpdrsd_show_downloads_revision_log' );
/** 
 * Add "Revision Log" (= version info) of Downloads/ Documents to post type
 *   table. Content is the latest revision/ version description (= 'excerpt').
 *
 * @since 1.0.0
 *
 * @uses ddw_wpdrsd_get_options()
 */
function wpdrsd_show_downloads_revision_log() {

	$options = ddw_wpdrsd_get_options();

	if ( $options[ 'wpdrsd_show_revision_log' ]
		&& ( empty( $_REQUEST[ 'mode' ] ) || 'list' === $_REQUEST[ 'mode' ] )
	) {

		add_filter( 'manage_edit-document_columns', 'ddw_wpdrsd_do_show_downloads_revision_log' );
		add_action( 'manage_posts_custom_column', 'ddw_wpdrsd_show_downloads_excerpt_custom_columns' );

	}  // end if

}  // end function


/** 
 * Add "Revision Log" (= version info) of Downloads/ Documents to post type table.
 *    Content is the latest revision/ version description (= 'excerpt').
 *
 * @since 1.0.0
 *
 * @param string $columns
 * @return string Columns in post type table.
 */
function ddw_wpdrsd_do_show_downloads_revision_log( $columns ) {

	$column_excerpt = array( 'show_excerpt' => '<span style="cursor: help; border-bottom: 1px dotted #666;" title="' . __( 'Added by WPDR Simple Downloads Plugin', 'wpdr-simple-downloads' ) . '">' . __( 'Rev. Log', 'wpdr-simple-downloads' ) . '</span>' );

	$columns = array_slice( $columns, 0, 2, TRUE ) + $column_excerpt + $columns;

	return $columns;

}  // end function


/** 
 * Show the "Revision Log" (= version info) in the Downloads/ Documents to post
 *   type table.
 *
 * @since 1.0.0
 *
 * @global object $GLOBALS[ 'post' ]
 *
 * @param string $column
 */
function ddw_wpdrsd_show_downloads_excerpt_custom_columns( $column ) {

	if ( 'show_excerpt' === $column ) {

		$excerpt = ( ! empty( $GLOBALS[ 'post' ]->post_excerpt ) ) ? the_excerpt() : '<em>' . __( 'n.a.', 'wpdr-simple-downloads' ) . '</em>';

		echo $excerpt;

	}  // end if

}  // end function
