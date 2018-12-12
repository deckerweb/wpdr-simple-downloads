<?php

// includes/widgets/wpdrsd-widget-popular-downloads


/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Display Popular Downloads Widget class.
 *
 * @since 1.0.0
 */
class DDW_WPDRSD_Popular_Downloads_Widget extends WP_Widget {

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
			'classname'   => 'wpdrsd-widget-popular-downloads',
			'description' => esc_html__( 'Displays the most popular/ accessed Downloads.', 'wpdr-simple-downloads' )
		);

		/** Create the widget */
		parent::__construct(
			'wpdrsd-widget-popular-downloads',
			__( 'WPDRSD: Popular Downloads', 'wpdr-simple-downloads' ),
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
			'outro_text' => $instance[ 'outro_text' ]
		);

                /** Set the Downloads item limit */
                $items_limit = isset( $instance[ 'items_limit' ] ) ? absint( $instance[ 'items_limit' ] ) : 3;

		/** Get the IDs of excluded Downloads items */
		$items_exclude = $instance[ 'items_exclude' ];

		if ( $items_exclude ) {
			$items_exclude = explode( ',', $items_exclude );
		}

		/** Parse args */
		$instance = wp_parse_args( (array) $instance, array(
			'title'               => '',
			'items_limit'         => $items_limit,
			'show_download_count' => 0,
			'items_exclude'       => $items_exclude
		) );

		/** Set initial values for variables */
		$output = '';
		$count = '';

                /** Set the query arguments */
		$query_args = array( 
			'post_type'      => 'document',
			'posts_per_page' => $items_limit,
			'post_status'    => 'publish',
			'meta_key'       => '_wpdrsd_download_count',
			'orderby'        => 'meta_value_num',
			'exclude'        => $items_exclude,
		);

                /** Get the most popular downloads */
                $popular_downloads = get_posts( $query_args );

		/** Popular Downloads logic/ check */
		if ( is_null( $popular_downloads ) || empty( $popular_downloads ) ) {

			/** Return early if there are no popular Downloads */
			return;
           
		} else {

			/** Begin Downloads listing output */
			$output .= '<ul class="wpdrsd-widget-popular-downloads">';

			/** Loop trough all the Downloads */
			foreach ( $popular_downloads as $download ) {

				/** Get the Download's title */
				$download_title = apply_filters( 'wpdrsd_filter_widget_popular_download_title', $download->post_title, $download->ID );

				/** Get the Download counter */
				$count = get_post_meta( $download->ID, '_wpdrsd_download_count', true );

				/** Display the Download's count */
				if ( $instance[ 'show_download_count' ] ) {
					$download_count = sprintf( ' <span class="wpdrsd-widget-download-count">(%s)</span>', $count );
				} else {
					$download_count = '';
				}

				/** Append the Download's title */
				$output .= sprintf( '<li><a href="%s" title="%s" class="%s" rel="bookmark">%s</a>%s</li>', get_permalink( $download->ID ), esc_attr( $download_title ), 'wpdrsd-widget-popular-download-title', $download_title, $download_count );

			}  // end foreach

			/** End of the Downloads listing */
			$output .= '</ul>';

		}  // end if/else downloads logic

		/** Display the before widget HTML */
		echo $before_widget;

		/** Display the widget title */
		if ( $instance[ 'title' ] ) {

			echo $before_title . apply_filters( 'widget_title', $instance[ 'title' ] ) . $after_title;

		}  // end-if title

		/** Action hook 'wpdrsd_before_popular_downloads_widget' */
		do_action( 'wpdrsd_before_popular_downloads_widget' );

		/** Display widget intro text if it exists */
		if ( ! empty( $instance[ 'intro_text' ] ) ) {

			echo '<div class="wpdrsd-intro"><p class="' . $this->id . '-intro-text wpdrsd-popular-downloads-intro-text">' . $instance[ 'intro_text' ] . '</p></div>';

		}  // end-if optional intro

		/** Display main widget content: Downloads count list */
		echo apply_filters( 'wpdrsd_filter_widget_popular_downloads_content', $output );

		/** Display widget outro text if it exists */
		if ( ! empty( $instance[ 'outro_text' ] ) ) {

			echo '<div class="wpdrsd-outro"><p class="' . $this->id . '-outro_text wpdrsd-popular-downloads-outro-text">' . $instance[ 'outro_text' ] . '</p></div>';

		}  // end-if optional outro

		/** Action hook 'wpdrsd_after_popular_downloads_widget' */
		do_action( 'wpdrsd_after_popular_downloads_widget' );

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
		$instance[ 'title' ]               = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'items_limit' ]          = strip_tags( $new_instance[ 'items_limit' ] );
		$instance[ 'show_download_count' ] = strip_tags( $new_instance[ 'show_download_count' ] );
		$instance[ 'items_exclude' ]       = strip_tags( $new_instance[ 'items_exclude' ] );
		$instance[ 'intro_text' ]          = $new_instance[ 'intro_text' ];
		$instance[ 'outro_text' ]          = $new_instance[ 'outro_text' ];

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
		$defaults = apply_filters( 'wpdrsd_filter_widget_popular_downloads_defaults', array(
			'title'               => __( 'Popular Downloads', 'wpdr-simple-downloads' ),
			'items_limit'         => 3,
			'show_download_count' => 0,
			'items_exclude'       => ''
		) );

		/** Get the values from the instance */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/** Get the values from the instance */
		$intro_text = ( isset( $instance[ 'intro_text' ] ) ) ? esc_textarea( $instance[ 'intro_text' ] ) : null;
		$outro_text = ( isset( $instance[ 'outro_text' ] ) ) ? esc_textarea( $instance[ 'outro_text' ] ) : null;

		/** Begin form code */
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
			<?php _e( 'Title:', 'wpdr-simple-downloads' ); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" />
		</p>

		<p>
			<label for="<?php /** Optional intro text */ echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Optional intro text:', 'wpdr-simple-downloads' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'wpdr-simple-downloads' ), __( 'Popular Downloads', 'wpdr-simple-downloads' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="2" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'items_limit' ); ?>"><?php _e( 'Number of Downloads to show:', 'wpdr-simple-downloads' ); ?></label>
        		<input id="<?php echo $this->get_field_id( 'items_limit' ); ?>" name="<?php echo $this->get_field_name( 'items_limit' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'items_limit' ] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_download_count' ); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_download_count' ); ?>" name="<?php echo $this->get_field_name( 'show_download_count' ); ?>"<?php checked( (bool) $instance[ 'show_download_count' ], true ); ?> />
				<?php _e( 'Show Download count', 'wpdr-simple-downloads' ); ?>
			</label>
		</p>

		<p>
          		<label for="<?php echo $this->get_field_id( 'items_exclude' ); ?>"><?php _e( 'Download IDs to exclude, separated by comma:', 'wpdr-simple-downloads' ); ?></label>
          		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'items_exclude' ); ?>" name="<?php echo $this->get_field_name( 'items_exclude' ); ?>" value="<?php echo esc_attr( $instance[ 'items_exclude' ] ); ?>" />
        	</p>

		<p>
			<label for="<?php /** Optional outro text */ echo $this->get_field_id( 'outro_text' ); ?>"><?php _e( 'Optional outro text:', 'wpdr-simple-downloads' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'wpdr-simple-downloads' ), __( 'Popular Downloads', 'wpdr-simple-downloads' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="2" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>

		<?php
		/** ^End form code */

	}  // end method

}  // end of class
