<?php

// includes/widgets/wpdrsd-widget-taxonomies


/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Display Downloads File Categories / Tags Widget class.
 *
 * @since 1.0.0
 */
class DDW_WPDRSD_Downloads_Taxonomies_Widget extends WP_Widget {

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
			'classname'   => 'wpdrsd-widget-taxonomies',
			'description' => esc_html__( 'Displays File Categories or File Tags for Downloads.', 'wpdr-simple-downloads' )
		);

		/** Create the widget */
		parent::__construct(
			'wpdrsd-widget-taxonomies',
			__( 'WPDRSD: File Categories / Tags', 'wpdr-simple-downloads' ),
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
	 *
	 * @global mixed $post
	 */
	public function widget( $args, $instance ) {

		/** Set global */
		global $post;

		/** Set initial values for variables */
		$terms_limit = '';
		$terms_exclude = '';
		$terms_include = '';
		$sort_by = '';
		$sort_order = '';

		/** Extract the widget arguments */
		extract( $args );

		/** Set up the arguments */
		$args = array(
			'intro_text' => $instance[ 'intro_text' ],
			'outro_text' => $instance[ 'outro_text' ],
		);

		/** Parse args */
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'          => '',
				'terms_limit'    => $terms_limit,
				'terms_exclude'  => $terms_exclude,
				'terms_include'  => $terms_include,
				'sort_by'        => $sort_by,
				'asc_sort_order' => $sort_order,
			)
		);

        /** Set the Downloads item limit */
        $terms_limit = isset( $instance[ 'terms_limit' ] ) ? absint( $instance[ 'terms_limit' ] ) : '';

		/** Get the IDs of excluded "File Category" or "File Tags" taxonomy items */
		$terms_exclude = $instance[ 'terms_exclude' ];

		if ( $terms_exclude ) {
			$terms_exclude = explode( ',', $terms_exclude );
		}

		/** Get the IDs of included "File Category" or "File Tags" taxonomy items */
		$terms_include = $instance[ 'terms_include' ];

		if ( $terms_include ) {
			$terms_include = explode( ',', $terms_include );
		}

		/** Default sort orders */
		$default_sort_orders = array(
			'id',
			'count',
			'name',
			'slug',
			'term_group'
		);

		/** Sort order logic */
		if ( in_array( $instance[ 'sort_by' ], $default_sort_orders ) ) {
		
			$sort_by = $instance[ 'sort_by' ];
		
			$sort_order = (bool) $instance[ 'asc_sort_order' ] ? 'DESC' : 'ASC';
		
		} else {
		
			/** By default, display by name */
			$sort_by = 'name';
			$sort_order = 'ASC';
		
		}  // end if

		/** Get the taxonomy from the instance */
		$tax = $instance[ 'taxonomy' ];

        /** Set the query arguments */
		$term_args = array( 
			'number'  => $terms_limit,
			'exclude' => $terms_exclude,
			'include' => $terms_include,
			'orderby' => $sort_by,
			'order'   => $sort_order
		);

		/** Display the before widget HTML */
		echo $before_widget;

		/** Display the widget title */
		if ( $instance[ 'title' ] ) {
			echo $before_title . apply_filters( 'widget_title', $instance[ 'title' ] ) . $after_title;
		}

		/** Action hook 'wpdrsd_before_taxonomy_widget' */
		do_action( 'wpdrsd_before_taxonomy_widget' );

		/** Display widget intro text if it exists */
		if ( ! empty( $instance[ 'intro_text' ] ) ) {
			echo '<div class="wpdrsd-intro"><p class="' . $this->id . '-intro-text wpdrsd-taxonomy-intro-text">' . $instance[ 'intro_text' ] . '</p></div>';
		}

		/** Get Terms for the set Taxonomy */
		$terms = get_terms( $tax, $term_args );

			/** Display the taxonomy */
			if ( is_wp_error( $terms ) ) {

				return;

			} else {

				echo '<ul class="wpdrsd-taxonomy-widget">';

				foreach ( $terms as $term ) {

					echo '<li><a href="' . get_term_link( $term ) . '" title="' . esc_attr( $term->name ) . '" rel="bookmark">' . $term->name . '</a></li>';

				}  // end foreach

				echo '</ul>';

			}  // end if

		/** Display widget outro text if it exists */
		if ( ! empty( $instance[ 'outro_text' ] ) ) {
			echo '<div class="wpdrsd-outro"><p class="' . $this->id . '-outro_text wpdrsd-taxonomy-outro-text">' . $instance[ 'outro_text' ] . '</p></div>';
		}

		/** Action hook 'wpdrsd_after_taxonomy_widget' */
		do_action( 'wpdrsd_after_taxonomy_widget' );

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
	 * @return array Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/** Set the instance to the new instance. */
		$instance = $new_instance;

		/** Strip tags from elements that don't need them */
		$instance[ 'title' ]          = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'intro_text' ]     = $new_instance[ 'intro_text' ];
		$instance[ 'outro_text' ]     = $new_instance[ 'outro_text' ];
		$instance[ 'taxonomy' ]       = strip_tags( $new_instance[ 'taxonomy' ] );
		$instance[ 'terms_limit' ]    = strip_tags( $new_instance[ 'terms_limit' ] );
		$instance[ 'terms_exclude' ]  = strip_tags( $new_instance[ 'terms_exclude' ] );
		$instance[ 'terms_include' ]  = strip_tags( $new_instance[ 'terms_include' ] );
		$instance[ 'sort_by' ]        = strip_tags( $new_instance[ 'sort_by' ] );
		$instance[ 'asc_sort_order' ] = strip_tags( $new_instance[ 'asc_sort_order' ] );

		return $instance;

	}  // end method


	/**
	 * Displays the widget options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 *
	 * @uses ddw_wpdrsd_get_options()
	 *
	 * @param array $instance Current settings
	 */
	public function form( $instance ) {

		/** Get options from plugin settings */
		$options = ddw_wpdrsd_get_options();

		/** Setup defaults parameters */
		$defaults = apply_filters( 'wpdrsd_filter_widget_taxonomies_defaults', array(
			'title'          => '',
			'terms_limit'    => '',
			'terms_exclude'  => '',
			'terms_include'  => '',
			'sort_by'        => 'name',
			'asc_sort_order' => true
		) );

		/** Get the values from the instance */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/** Get the values from the instance */
		//$title      = ( isset( $instance[ 'title' ] ) ) ? esc_attr( $instance[ 'title' ] ) : '';
		$intro_text = ( isset( $instance[ 'intro_text' ] ) ) ? esc_textarea( $instance[ 'intro_text' ] ) : null;
		$outro_text = ( isset( $instance[ 'outro_text' ] ) ) ? esc_textarea( $instance[ 'outro_text' ] ) : null;

		/** Set taxonomy drop-down values depending on plugin settings */
		if ( $options[ 'wpdrsd_tax_file_categories' ] && $options[ 'wpdrsd_tax_file_tags' ] ) {
			$taxonomy = ( isset( $instance[ 'taxonomy' ] ) ) ? esc_attr( $instance[ 'taxonomy' ] ) : 'wpdr-file-categories';
		} elseif ( $options[ 'wpdrsd_tax_file_categories' ] && ! $options[ 'wpdrsd_tax_file_tags' ] ) {
			$taxonomy = 'wpdr-file-categories';
		} elseif ( ! $options[ 'wpdrsd_tax_file_categories' ] && $options[ 'wpdrsd_tax_file_tags' ] ) {
			$taxonomy = 'wpdr-file-tags';
		}

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
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'wpdr-simple-downloads' ), __( 'Taxonomy', 'wpdr-simple-downloads' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="2" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Taxonomy:', 'wpdr-simple-downloads' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>">
				<?php if ( $options[ 'wpdrsd_tax_file_categories' ] ) : ?>
					<option value="wpdr-file-categories" <?php selected( 'wpdr-file-categories', $taxonomy ); ?>><?php _e( 'File Categories', 'wpdr-simple-downloads' ); ?></option>
				<?php endif; ?>
				<?php if ( $options[ 'wpdrsd_tax_file_tags' ] ) : ?>
					<option value="wpdr-file-tags" <?php selected( 'wpdr-file-tags', $taxonomy ); ?>><?php _e( 'File Tags', 'wpdr-simple-downloads' ); ?></option>
				<?php endif; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'terms_limit' ); ?>"><?php _e( 'Number of Taxonomy Terms to show:', 'wpdr-simple-downloads' ); ?></label>
        		<input id="<?php echo $this->get_field_id( 'terms_limit' ); ?>" name="<?php echo $this->get_field_name( 'terms_limit' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'terms_limit' ] ); ?>" size="3" />
		</p>

		<p>
        		<label for="<?php echo $this->get_field_id( 'sort_by' ); ?>">
				<?php _e( 'Sort by:', 'wpdr-simple-downloads' ); ?>
				<select class="widefat" id="<?php echo $this->get_field_id( 'sort_by' ); ?>" name="<?php echo $this->get_field_name( 'sort_by' ); ?>">        
					<?php
						printf( '<option value="name" %s>%s</option>', selected( 'name', $instance[ 'sort_by' ], 0 ), __( 'Term name', 'wpdr-simple-downloads' ) );
						printf( '<option value="count" %s>%s</option>', selected( 'count', $instance[ 'sort_by' ], 0 ), __( 'Term count', 'wpdr-simple-downloads' ) );
						printf( '<option value="id" %s>%s</option>', selected( 'id', $instance[ 'sort_by' ], 0 ), __( 'Term ID', 'wpdr-simple-downloads' ) );
						printf( '<option value="slug" %s>%s</option>', selected( 'slug', $instance[ 'sort_by' ], 0 ), __( 'Term slug', 'wpdr-simple-downloads' ) );
						printf( '<option value="term_group" %s>%s</option>', selected( 'term_group', $instance[ 'sort_by' ], 0 ), __( 'Term group', 'wpdr-simple-downloads' ) );
					?>
				</select>
            		</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'asc_sort_order' ); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'asc_sort_order' ); ?>" name="<?php echo $this->get_field_name( 'asc_sort_order' ); ?>" <?php checked( (bool) $instance[ 'asc_sort_order' ], true ); ?> />
				<?php _e( 'Reverse sort order (to descending)', 'wpdr-simple-downloads' ); ?> <small>(<?php _e( 'Default is ascending', 'wpdr-simple-downloads' ); ?>)</small>
			</label>
		</p>

		<p>
          		<label for="<?php echo $this->get_field_id( 'terms_exclude' ); ?>"><?php _e( 'Taxonomy Term IDs to exclude, separated by comma:', 'wpdr-simple-downloads' ); ?></label>
          		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'terms_exclude' ); ?>" name="<?php echo $this->get_field_name( 'terms_exclude' ); ?>" value="<?php echo esc_attr( $instance[ 'terms_exclude' ] ); ?>" />
				<small><?php echo sprintf( __( 'Please, use only one or the other alternative, %s or %s!', 'wpdr-simple-downloads' ), '<em>' . __( 'Exclude', 'wpdr-simple-downloads' ) . '</em>', '<em>' . __( 'Include', 'wpdr-simple-downloads' ) . '</em>' ); ?></small>
        	</p>

		<p>
          		<label for="<?php echo $this->get_field_id( 'terms_include' ); ?>"><?php _e( 'Taxonomy Term IDs to include, separated by comma:', 'wpdr-simple-downloads' ); ?></label>
          		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'terms_include' ); ?>" name="<?php echo $this->get_field_name( 'terms_include' ); ?>" value="<?php echo esc_attr( $instance[ 'terms_include' ] ); ?>" />
				<small><?php echo sprintf( __( 'Please, use only one or the other alternative, %s or %s!', 'wpdr-simple-downloads' ), '<em>' . __( 'Include', 'wpdr-simple-downloads' ) . '</em>', '<em>' . __( 'Exclude', 'wpdr-simple-downloads' ) . '</em>' ); ?></small>
        	</p>

		<p>
			<label for="<?php /** Optional outro text */ echo $this->get_field_id( 'outro_text' ); ?>"><?php _e( 'Optional outro text:', 'wpdr-simple-downloads' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'wpdr-simple-downloads' ), __( 'Taxonomy', 'wpdr-simple-downloads' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="2" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>

		<?php
		/** ^End form code */

	}  // end method

}  // end of class
