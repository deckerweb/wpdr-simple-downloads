<?php

// includes/wpdrsd-taxonimies

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'init', 'ddw_wpdrsd_register_taxonomies' );
/**
 * Register the Filetype taxonomy.
 *
 * @since 1.0.0
 *
 * @uses  ddw_wpdrsd_get_options()
 * @uses  register_taxonomy()
 */
function ddw_wpdrsd_register_taxonomies() {

	$options = ddw_wpdrsd_get_options();

	/** Register additional tax "File Categories" */
	if ( $options[ 'wpdrsd_tax_file_categories' ] ) {

		$wpdrsd_file_category_labels = array(
			'name'              => _x( 'File Categories', 'Translators: taxonomy general name', 'wpdr-simple-downloads' ),
			'singular_name'     => _x( 'File Category', 'Translators: taxonomy singular name', 'wpdr-simple-downloads' ),
			'search_items'      => __( 'Search File Categories', 'wpdr-simple-downloads' ),
			'all_items'         => __( 'All File Categories', 'wpdr-simple-downloads' ),
			'parent_item'       => __( 'Parent File Category', 'wpdr-simple-downloads' ),
			'parent_item_colon' => __( 'Parent File Category:', 'wpdr-simple-downloads' ),
			'edit_item'         => __( 'Edit File Category', 'wpdr-simple-downloads' ), 
			'update_item'       => __( 'Update File Category', 'wpdr-simple-downloads' ),
			'add_new_item'      => __( 'Add New File Category', 'wpdr-simple-downloads' ),
			'new_item_name'     => __( 'New File Category Name', 'wpdr-simple-downloads' ),
			'menu_name'         => __( 'File Categories', 'wpdr-simple-downloads' ),
		); 	

		register_taxonomy( 'wpdr-file-categories', array( 'document' ), array(
			'hierarchical'      => true,
			'labels'            => apply_filters( 'wpdrsd_filter_file_category_labels', $wpdrsd_file_category_labels ),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => 'wpdr-file-categories',
			'rewrite'           => apply_filters( 'wpdrsd_filter_file_category_rewrite', array( 'slug' => 'file-category' ) )
		) );

		add_filter( 'manage_edit-document_columns', 'ddw_wpdrsd_rename_file_categories_column' );

	}  // end if

	/** Register additional tax "File Categories" */
	if ( $options[ 'wpdrsd_tax_file_tags' ] ) {

		$wpdrsd_file_tag_labels = array(
			'name'              => _x( 'File Tags', 'Translators: taxonomy general name', 'wpdr-simple-downloads' ),
			'singular_name'     => _x( 'File Tag', 'Translators: taxonomy singular name', 'wpdr-simple-downloads' ),
			'search_items'      => __( 'Search File Tags', 'wpdr-simple-downloads' ),
			'all_items'         => __( 'All File Tags', 'wpdr-simple-downloads' ),
			'parent_item'       => __( 'Parent File Tag', 'wpdr-simple-downloads' ),
			'parent_item_colon' => __( 'Parent File Tag:', 'wpdr-simple-downloads' ),
			'edit_item'         => __( 'Edit File Tag', 'wpdr-simple-downloads' ), 
			'update_item'       => __( 'Update File Tag', 'wpdr-simple-downloads' ),
			'add_new_item'      => __( 'Add New File Tag', 'wpdr-simple-downloads' ),
			'new_item_name'     => __( 'New File Tag Name', 'wpdr-simple-downloads' ),
			'menu_name'         => __( 'File Tags', 'wpdr-simple-downloads' ),
		); 

		register_taxonomy( 'wpdr-file-tags', array( 'document' ), array(
			'hierarchical'      => false,
			'labels'            => apply_filters( 'wpdrsd_filter_file_tag_labels', $wpdrsd_file_tag_labels ),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => 'wpdr-file-tags',
			'rewrite'           => apply_filters( 'wpdrsd_filter_file_tag_rewrite', array( 'slug' => 'file-tag' ) )
		) );

		add_filter( 'manage_edit-document_columns', 'ddw_wpdrsd_rename_file_tags_column' );

	}  // end if

}  // end function


//add_action( 'save_post', 'ddw_wpdrsd_update_file_categories', 10, 1 );
/**
 * Update the post terms with "File Category" taxonmy data.
 *
 * @since 1.0.0
 *
 * @uses wp_set_post_terms()
 *
 * @param int $post_id
 */
function ddw_wpdrsd_update_file_categories( $post_id ) {

	$wpdr = WP_Document_Revisions::$instance;
	
	if ( ! $wpdr->verify_post_type( $post_id ) && ! taxonomy_exists( 'wpdr-file-categories' ) ) {
		return;
	}
		
	wp_set_post_terms(
		$post_id,
		array( $wpdr->get_extension( $post_id ) ),
		'wpdr-file-categories',
		TRUE
	);

}  // end function


//add_action( 'save_post', 'ddw_wpdrsd_update_file_tags', 10, 1 );
/**
 * Update the post terms with "File Tag" taxonmy data.
 *
 * @since 1.0.0
 *
 * @uses wp_set_post_terms()
 *
 * @param int $post_id
 */
function ddw_wpdrsd_update_file_tags( $post_id ) {

	$wpdr = WP_Document_Revisions::$instance;
	
	if ( ! $wpdr->verify_post_type( $post_id ) && ! taxonomy_exists( 'wpdr-file-tags' ) ) {
		return;
	}
		
	wp_set_post_terms(
		$post_id,
		array( $wpdr->get_extension( $post_id ) ),
		'wpdr-file-tags',
		TRUE
	);

}  // end function


//add_action( 'restrict_manage_posts', 'ddw_wpdrsd_add_taxonomy_filters', 100 );
/**
 * Add "Document" (Downloads) post type filters on admin list for added
 *   taxonomies.
 *   Add taxonomy drop down filters for Downloads ('document').
 *
 * @since 1.0.0
 *
 * @global string $GLOBALS[ 'typenow' ]
*/
function ddw_wpdrsd_add_taxonomy_filters() {

	//global $typenow;
	
	/** Check, if the current post type is 'document' */
	if ( 'document' === $GLOBALS[ 'typenow' ] ) {

		/** Check for "File Categories" taxonomy */
		$terms = get_terms( 'wpdr-file-categories' );

		if ( taxonomy_exists( 'wpdr-file-categories' ) && ( count( $terms ) > 0 ) ) {

			echo '<select name="wpdr-file-categories" id="wpdr-file-categories" class="postform">';

				echo '<option value="">' . __( 'Show all categories', 'wpdr-simple-downloads' ) . '</option>';

				foreach ( $terms as $term ) {

					$selected = isset( $_GET[ 'wpdr-file-categories' ] ) && sanitize_key( wp_unslash( $_GET[ 'wpdr-file-categories' ] ) ) == $term->slug ? ' selected="selected"' : '';

					echo '<option value="' . esc_attr( $term->slug ) . '"' . $selected . '>' . esc_html( $term->name ) . ' (' . $term->count . ')</option>';

				}  // end foreach

			echo '</select>';

		}  // end if

		/** Check for "File Tags" taxonomy */
		$terms = get_terms( 'wpdr-file-tags' );

		if ( taxonomy_exists( 'wpdr-file-tags' ) && count( $terms ) > 0 ) {

			echo '<select name="wpdr-file-tags" id="wpdr-file-tags" class="postform">';

				echo '<option value="">' . __( 'Show all tags', 'wpdr-simple-downloads' ) . '</option>';

				foreach ( $terms as $term ) {

					$selected = isset( $_GET[ 'wpdr-file-tags' ] ) && sanitize_key( wp_unslash( $_GET[ 'wpdr-file-tags' ] ) ) == $term->slug ? ' selected="selected"' : '';

					echo '<option value="' . esc_attr( $term->slug ) . '"' . $selected . '>' . esc_html( $term->name ) . ' (' . $term->count . ')</option>';

				}  // end foreach

			echo '</select>';

		}  // end if
		
	}  // end if

}  // end function


/**
 * Renames "File Categories" post type tax column on admin list to just
 *   "Categories".
 *
 * @since  1.0.0
 *
 * @param  array $defaults the default column labels
 *
 * @return array The modified column labels.
 */
function ddw_wpdrsd_rename_file_categories_column( $defaults ) {

	if ( isset( $defaults[ 'taxonomy-wpdr-file-categories' ] ) ) {

		$defaults[ 'taxonomy-wpdr-file-categories' ] = apply_filters(
			'wpdrsd_filter_file_category_column_title',
			_x( 'Categories', 'Translators: Downloads admin column title', 'wpdr-simple-downloads' )
		);

	}  // end if

	return $defaults;

}  // end function


/**
 * Renames "File Tags" post type tax column on admin list to just "Tags".
 *
 * @since 1.0.0
 *
 * @param array $defaults the default column labels
 *
 * @return array The modified column labels.
 */
function ddw_wpdrsd_rename_file_tags_column( $defaults ) {

	if ( isset( $defaults[ 'taxonomy-wpdr-file-tags' ] ) ) {

		$defaults[ 'taxonomy-wpdr-file-tags' ] = apply_filters(
			'wpdrsd_filter_file_tag_column_title',
			_x( 'Tags', 'Translators: Downloads admin column title', 'wpdr-simple-downloads' )
		);

	}  // end if

	return $defaults;

}  // end function
