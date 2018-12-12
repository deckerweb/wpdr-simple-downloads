<?php

// includes/admin-form/wpdrsd-usage-tab

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/** Action hook 'wpdrsd_usage_tab_before' */
do_action( 'wpdrsd_usage_tab_before' );

?>
	<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><strong><?php _e( 'Insert Downloads', 'wpdr-simple-downloads' ); ?><strong></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Insert Downloads', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_insert_downloads">
						<?php _e( 'To insert a download file link into a Post, Page or Custom Post Type, use the regular "Insert Link" feature, search for your Download/ Document file (searches for title!) and insert the actual link. Really simple, yeah!', 'wpdr-simple-downloads' ); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e( 'Update Downloads', 'wpdr-simple-downloads' ); ?><strong></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Update Downloads', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_update_downloads">
						<?php echo sprintf(
							/* translators: %s - opening and closing link markup */
							__( 'To update an existing file/ document just %sopen an existing item%s and upload a new version (revision). The file/ document peramlink will always point to the latest revision! Yes, it\'s so easy :)', 'wpdr-simple-downloads' ),
							'<a href="' . esc_url( admin_url( 'edit.php?post_type=document' ) ) . '">',
							'</a>'
						); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e( 'Front End Display Options', 'wpdr-simple-downloads' ); ?><strong></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Front End Display Options', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_downloads_labels">
						<?php echo sprintf(
							/* translators: %1$s - opening link markup / %2$s - closing link markup / %3$s - opening link markup / %4$s - code markup / %5$s - opening link markup */
							__( 'You can also use %1$sthird-party plugins%2$s or %3$sWidgets%2$s that support custom post types to query, display or do anything you want with the %4$s post type, that we use for the download files. %5$sShortcodes%2$s from the base plugin are also available. Pretty simple again, yet very effective and WordPress standards compliant.', 'wpdr-simple-downloads' ),
							'<a href="' . ddw_wpdrsd_get_info_url( 'url_plugin_faq' ) . '" target="_blank" rel="noopener noreferrer">',
							'</a>',
							'<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">',
							'<code>Document</code>',
							'<a href="' . ddw_wpdrsd_get_info_url( 'url_wpdr_faq' ) . '" target="_blank" rel="noopener noreferrer">'
						); ?>
					</label>
				</fieldset>
			</td>
		</tr>
	</tbody>
	</table>
<?php

/** Action hook 'wpdrsd_usage_tab_after' */
do_action( 'wpdrsd_usage_tab_after' );
