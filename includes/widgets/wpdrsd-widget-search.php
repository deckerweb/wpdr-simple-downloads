<?php

// includes/widgets/wpdrsd-widget-search


/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Display Search Downloads Widget class.
 *
 * @since 1.0.0
 */
class DDW_WPDRSD_Search_Downloads_Widget extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		/** Set up the widget options. */
		$widget_options = array(
			'classname'   => 'wpdrsd-widget-search',
			'description' => esc_html__( 'Search for Downloads/ Documents by the WP Documents Revision Simple Downloads plugin. Search in downloads only. (No mix up with regular WordPress search!)', 'wpdr-simple-downloads' )
		);

		/** Create the widget */
		parent::__construct(
			'wpdrsd-widget-search',
			__( 'WPDRSD: Search Downloads', 'wpdr-simple-downloads' ),
			$widget_options
		);

	}  // end method


	/**
	 * Display the widget, based on the parameters/ arguments set through the widget options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
	
		/** Extract the widget arguments */
		extract( $args );

		/** Set up the arguments */
		$args = array(
			'intro_text' => $instance[ 'intro_text' ],
			'outro_text' => $instance[ 'outro_text' ],
		);

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'            => '',
				'label_text'       => '',	//__( 'Search download files for:', 'wpdr-simple-downloads' ),
				'placeholder_text' => '',	//__( 'Search downloads', 'wpdr-simple-downloads' ),
				'button_text'      => '',	//__( 'Search', 'wpdr-simple-downloads' )
			)
		);

		/** Display the before widget HTML */
		echo $before_widget;

		/** Display the widget title */
		if ( $instance[ 'title' ] ) {
			echo $before_title . apply_filters( 'widget_title', $instance[ 'title' ] ) . $after_title;
		}

		/** Action hook 'wpdrsd_before_search_widget' */
		do_action( 'wpdrsd_before_search_widget' );

		/** Display widget intro text if it exists */
		if ( ! empty( $instance[ 'intro_text' ] ) ) {
			echo '<div class="wpdrsd-intro"><p class="' . $this->id . '-intro-text wpdrsd-search-intro-text">' . $instance[ 'intro_text' ] . '</p></div>';
		}

		/** Set filters for various strings */
		$wpdrsd_label_string = apply_filters( 'wpdrsd_filter_widget_label_string', $instance[ 'label_text' ] );
		$wpdrsd_placeholder_string = apply_filters( 'wpdrsd_filter_widget_placeholder_string', $instance[ 'placeholder_text' ] );
		$wpdrsd_search_string = apply_filters( 'wpdrsd_filter_widget_search_string', $instance[ 'button_text' ] );

		/** Construct the search form */
		$form = '<div id="wpdrsd-form-wrapper"><form role="search" method="get" id="searchform" class="searchform wpdrsd-search-form" action="' . home_url() . '">';
		$form .= '<div class="wpdrsd-form-container">';

			if ( WPDRSD_SEARCH_LABEL_DISPLAY ) {
				$form .= '<label class="screen-reader-text wpdrsd-label" for="s">' . esc_attr__( $wpdrsd_label_string ) . '</label>';
				$form .= '<br />';
			}

			$form .= '<input type="hidden" name="post_type" value="document" />';
			$form .= '<input type="text" value="' . get_search_query() . '" name="s" id="s" class="s wpdrsd-search-field" placeholder="' . esc_attr__( $wpdrsd_placeholder_string ) . '" />';
			$form .= '<input type="submit" id="searchsubmit" class="searchsubmit wpdrsd-search-submit" value="' . esc_attr__( $wpdrsd_search_string ) . '" />';

		$form .= '</div>';
		$form .= '</form></div>';

		/** Apply filter to allow for additional fields */
		echo apply_filters( 'wpdrsd_filter_widget_search_form', $form, $instance, $this->id_base );

		/** Display widget outro text if it exists */
		if ( ! empty( $instance[ 'outro_text' ] ) ) {
			echo '<div class="wpdrsd-outro"><p class="' . $this->id . '-outro_text wpdrsd-search-outro-text">' . $instance[ 'outro_text' ] . '</p></div>';
		}

		/** Action hook 'wpdrsd_after_search_widget' */
		do_action( 'wpdrsd_after_search_widget' );

		/** Display the closing widget wrapper */
		echo $after_widget;

	}  // end method


	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 1.0.0
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 *
	 * @return array Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/** Set the instance to the new instance. */
		$instance = $new_instance;

		/** Strip tags from elements that don't need them */
		$instance[ 'title' ]            = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
		$instance[ 'intro_text' ]       = $new_instance[ 'intro_text' ];
		$instance[ 'outro_text' ]       = $new_instance[ 'outro_text' ];
		$instance[ 'label_text' ]       = strip_tags( stripslashes( $new_instance[ 'label_text' ] ) );
		$instance[ 'placeholder_text' ] = strip_tags( stripslashes( $new_instance[ 'placeholder_text' ] ) );
		$instance[ 'button_text' ]      = strip_tags( stripslashes( $new_instance[ 'button_text' ] ) );

		return $instance;

	}  // end method


	/**
	 * Displays the widget options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings
	 */
	public function form( $instance ) {

		/** Setup defaults parameters */
		$defaults = apply_filters(
			'wpdrsd_filter_widget_search_downloads_defaults',
			array(
				'title'            => __( 'Search Downloads', 'wpdr-simple-downloads' ),
				'label_text'       => __( 'Search download files for:', 'wpdr-simple-downloads' ),
				'placeholder_text' => __( 'Search Downloads&#x2026;', 'wpdr-simple-downloads' ),
				'button_text'      => __( 'Search', 'wpdr-simple-downloads' ),
			)
		);

		/** Get the values from the instance */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/** Get the values from instance */
		$title      = ( isset( $instance[ 'title' ] ) ) ? esc_attr( $instance[ 'title' ] ) : null;
		$intro_text = ( isset( $instance[ 'intro_text' ] ) ) ? esc_textarea( $instance[ 'intro_text' ] ) : null;
		$outro_text = ( isset( $instance[ 'outro_text' ] ) ) ? esc_textarea( $instance[ 'outro_text' ] ) : null;

		/** Begin form code */
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
			<?php _e( 'Title:', 'wpdr-simple-downloads' ); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php /** Optional intro text */ echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Optional intro text:', 'wpdr-simple-downloads' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'wpdr-simple-downloads' ), __( 'Search', 'wpdr-simple-downloads' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="2" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'label_text' ); ?>">
			<?php _e( 'Label string before search input field:', 'wpdr-simple-downloads' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'label_text' ); ?>" name="<?php echo $this->get_field_name( 'label_text' ); ?>" value="<?php echo esc_attr( $instance[ 'label_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'wpdr-simple-downloads' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'placeholder_text' ); ?>">
			<?php _e( 'Placeholder string for search input field:', 'wpdr-simple-downloads' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'placeholder_text' ); ?>" name="<?php echo $this->get_field_name( 'placeholder_text' ); ?>" value="<?php echo esc_attr( $instance[ 'placeholder_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'wpdr-simple-downloads' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>">
			<?php _e( 'Search button string:', 'wpdr-simple-downloads' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $instance[ 'button_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Displaying may depend on your theme settings/ styles.', 'wpdr-simple-downloads' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php /** Optional outro text */ echo $this->get_field_id( 'outro_text' ); ?>"><?php _e( 'Optional outro text:', 'wpdr-simple-downloads' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'wpdr-simple-downloads' ), __( 'Search', 'wpdr-simple-downloads' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="2" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>

		<?php
		/** ^End form code */

	}  // end method

}  // end of class
