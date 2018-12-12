<?php

// includes/admin-form/wpdrsd-settings-tab

/**
 * Prevent direct access to this file.
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Get the options.
 *
 * @since 1.0.0
 */
$options = ddw_wpdrsd_get_options();

/**
 * Set admin URL and settings location name for single & Multisite installs.
 *
 * @since 1.0.0
 */
if ( is_multisite() /* && ! is_plugin_active_for_network( 'plugins/wp-document-revisions/wp-document-revisions.php' ) */ ) {

	$wpdr_admin_url      = esc_url( network_admin_url( 'settings.php#document_settings' ) );
	$wpdr_admin_location = __( 'Network Admin &#x2192; Settings', 'wpdr-simple-downloads' );

} else {

	$wpdr_admin_url      = esc_url( admin_url( 'options-media.php' ) );
	$wpdr_admin_location = __( 'Settings &#x2192; Media', 'wpdr-simple-downloads' );

}  // end-if multisite check

/**
 * WPDR Plugin URL.
 *
 * @since 1.0.0
 */
$wpdr_plugin_url = 'https://wordpress.org/plugins/wp-document-revisions/';

?>
<form id="wpdrsd-settings" method="post" action="options.php">
	<?php settings_fields( 'wpdrsd_options_group' ); ?>

	<table class="form-table">
	<tbody>
		<tr valign="top">
			<td colspan="2">
				<h3><?php _e( 'Basic Settings', 'wpdr-simple-downloads' ); ?></h3>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'File Upload Directory', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'File Upload Directory', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdr_upload_dir">
						<?php echo sprintf(
							__( 'Directory in which to store uploaded documents. The default is in your %1$s folder (or another default uploads folder defined elsewhere). It can also be moved to a folder outside of the %2$s or %3$s folder on your server - all for added security. This is an original, built-in setting of %4$s and to be found on %5$s.', 'wpdr-simple-downloads' ),
							'<code>/wp-content/uploads/</code>',
							'<code>/htdocs/</code>',
							'<code>/public_html/</code>',
							'<a href="' . esc_url_raw( $wpdr_plugin_url ) . '" target="_blank" rel="noopener noreferrer">' . __( 'WP Document Revisions', 'wpdr-simple-downloads' ) . '</a>',
							'<a href="' . $wpdr_admin_url . '"><strong>' . $wpdr_admin_location . '</strong></a>'
						); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Post Type Slug', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Post Type Slug', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdr_cpt_slug">
						<?php echo sprintf(
							__( 'It\'s highly recommended you set the <strong>permalink base slug</strong> for the %1$s (or %2$s) post type to something like %3$s. This is an original, built-in setting of %4$s and to be found on %5$s.', 'wpdr-simple-downloads' ),
							'<em>' . __( 'Downloads', 'wpdr-simple-downloads' ) . '</em>',
							'<em>' . __( 'Documents', 'wpdr-simple-downloads' ) . '</em>',
							'<code>' . _x( 'downloads', 'Translators: slug string', 'wpdr-simple-downloads' ) . '</code>',
							'<a href="' . esc_url_raw( $wpdr_plugin_url ) . '" target="_blank" rel="noopener noreferrer">' . __( 'WP Document Revisions', 'wpdr-simple-downloads' ) . '</a>',
							'<a href="' . $wpdr_admin_url . '"><strong>' . $wpdr_admin_location . '</strong></a>'
						); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<?php if ( post_type_supports( 'document', 'revisions' ) && current_user_can( 'read_document_revisions' ) ) : ?>
			<tr valign="top">
				<th scope="row"><?php _e( 'Revisions Feed Privacy', 'wpdr-simple-downloads' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e( 'Revisions Feed Privacy', 'wpdr-simple-downloads' ); ?></span></legend>
						<label for="wpdr_feed_privacy">
							<?php echo sprintf(
								__( 'Secret Feed Key &mdash; To protect your privacy, you need to append a key to feeds for use in feed readers. This is an original, built-in setting of %1$s and to be found on %2$s.', 'wpdr-simple-downloads' ),
								'<a href="' . esc_url( $wpdr_plugin_url ) . '" target="_blank" rel="noopener noreferrer">' . __( 'WP Document Revisions', 'wpdr-simple-downloads' ) . '</a>',
								'<a href="' . admin_url( 'profile.php' ) . '"><strong>' . __( 'Users &#x2192; Your Profile', 'wpdr-simple-downloads' ) . '</strong></a>'
							); ?>
						</label>
					</fieldset>
				</td>
			</tr>
		<?php endif;  // end-if post type supports & cap check ?>

		<tr valign="top">
			<td colspan="2">
				<h3><?php _e( 'Download Management', 'wpdr-simple-downloads' ); ?></h3>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e( 'Post Type Labels &amp; Icons', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Post Type Labels', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_downloads_labels">
						<input<?php if ( $options[ 'wpdrsd_downloads_labels' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_downloads_labels" name="wpdrsd_options[wpdrsd_downloads_labels]">
						<?php echo sprintf( __( 'Use %1$s as the wording for the post type labels (instead of %2$s), plus, display the %1$s icons (not the %2$s icons)', 'wpdr-simple-downloads' ), '<em>' . __( 'Downloads', 'wpdr-simple-downloads' ) . '</em>', '<em>' . __( 'Documents', 'wpdr-simple-downloads' ) . '</em>' ); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Post Type Taxonomies &amp; Widgets', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Post Type Taxonomies', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_tax_file_categories">
						<input<?php if ( $options[ 'wpdrsd_tax_file_categories' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_tax_file_categories" name="wpdrsd_options[wpdrsd_tax_file_categories]">
						<?php echo sprintf( __( 'Use the additional %1$s taxonomy (hierarchical, like %2$s), plus, the appropriate widget', 'wpdr-simple-downloads' ), '<em>' . __( 'File Categories', 'wpdr-simple-downloads' ) . '</em>', '<em>' . __( 'Post Categories', 'wpdr-simple-downloads' ) . '</em>' ); ?>
					</label><br />
					<label for="wpdrsd_tax_file_tags">
						<input<?php if ( $options[ 'wpdrsd_tax_file_tags' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_tax_file_tags" name="wpdrsd_options[wpdrsd_tax_file_tags]">
						<?php echo sprintf( __( 'Use the additional %1$s taxonomy (not hierarchical, like %2$s), plus, the appropriate widget', 'wpdr-simple-downloads' ), '<em>' . __( 'File Tags', 'wpdr-simple-downloads' ) . '</em>', '<em>' . __( 'Post Tags', 'wpdr-simple-downloads' ) . '</em>' ); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Permalinks', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Permalinks', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_remove_date_permalink">
						<input<?php if ( $options[ 'wpdrsd_remove_date_permalink' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_remove_date_permalink" name="wpdrsd_options[wpdrsd_remove_date_permalink]">
						<?php _e( 'Remove Date (Year, Month) from the Download Permalinks', 'wpdr-simple-downloads' ); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Default Visibility', 'wpdr-simple-downloads' ); ?></th>

			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Default Visibility', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_default_visibility">
						<input<?php if ( $options[ 'wpdrsd_default_visibility' ] ) echo ' checked'; ?> type="checkbox" value="0" id="wpdrsd_default_visibility" name="wpdrsd_options[wpdrsd_default_visibility]">
						<?php echo sprintf( __( 'For newly added downloads/ documents: change default visibility to %1$s (instead of %2$s)', 'wpdr-simple-downloads' ), '<code>' . __( 'publish', 'wpdr-simple-downloads' ) . '</code>', '<code>' . __( 'private', 'wpdr-simple-downloads' ) . '</code>' ); ?>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e( 'Revision Log', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e( 'Revision Log', 'wpdr-simple-downloads' ); ?></span></legend>
					<label for="wpdrsd_show_revision_log">
						<input<?php if ( $options[ 'wpdrsd_show_revision_log' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_show_revision_log" name="wpdrsd_options[wpdrsd_show_revision_log]">
						<?php echo sprintf( __( 'Show excerpt of latest Revision Log (Version Summary) in %spost type table%s', 'wpdr-simple-downloads' ), '<a href="' . admin_url( 'edit.php?post_type=document' ). '">', '</a>' ); ?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<td colspan="2">
				<h3><?php _e( 'Translations', 'wpdr-simple-downloads' ); ?></h3>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e( 'Translation Sets', 'wpdr-simple-downloads' ); ?></th>
			<td>
				<fieldset>
                    <legend class="screen-reader-text"><span><?php _e( 'Translation Sets', 'wpdr-simple-downloads' ); ?></span></legend>
                    <label for="wpdrsd_formal_translations">
                        <input<?php if ( $options[ 'wpdrsd_formal_translations' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_formal_translations" name="wpdrsd_options[wpdrsd_formal_translations]">
                            			<?php _e( 'Use formal translations (default)', 'wpdr-simple-downloads' ); ?>
                    </label><br />
                    <label for="wpdrsd_downloads_translations">
                        <input<?php if ( $options[ 'wpdrsd_downloads_translations' ] ) echo ' checked'; ?> type="checkbox" value="1" id="wpdrsd_downloads_translations" name="wpdrsd_options[wpdrsd_downloads_translations]">
						<?php echo sprintf( __( 'Use translations with %s wording (instead of %s)', 'wpdr-simple-downloads' ), '<em>' . __( 'Downloads', 'wpdr-simple-downloads' ) . '</em>', '<em>' . __( 'Documents', 'wpdr-simple-downloads' ) . '</em>' ); ?>
					</label><br />
				</fieldset>
			</td>
		</tr>
	</tbody>
	</table>

	<?php do_action( 'wpdrsd_settings_tab' );  // Action hook 'wpdrsd_settings_tab' ?>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'wpdr-simple-downloads' ); ?>" />
	</p>
</form>
