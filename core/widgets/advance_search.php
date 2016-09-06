<?php 

class Advanced_Search_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'advanced-search-widget', // Base ID
			'Advanced Search Widget', // Name
			array( 'description' => __( 'Advanced search widget', 'advanced-search-widget' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$s = get_search_query();
		$placeholder = isset($instance['placeholder'] )  ? esc_attr($instance['placeholder'] ) : 'Search';
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
        $form = '<form role="search" method="get" id="'.$widget_id.'-searchform" action="' . esc_url( home_url( '/' ) ) . '" >
    	<div class="widget_search">
        <input type="text" value="'.($s? esc_attr($s) : '').'" name="s" id="'.$widget_id.'-s" placeholder="'.$placeholder.'" />
	<input type="hidden" name="post_type" value="' .$instance['posttype']. '" />
	
    	
    	<button type="submit"  id="'.$widget_id.'-searchsubmit">'. esc_attr__('Search') .'</button>
        </div>
    	</form>';
		echo $form;
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posttype'] = strip_tags( $new_instance['posttype'] );
		$instance['placeholder'] = strip_tags( $new_instance['placeholder'] );
		// $instance['searchtitle'] = (empty($new_instance['searchtitle']) ? '0' : strip_tags( $new_instance['searchtitle'] ));
		// $instance['searchcontent'] = (empty($new_instance['searchcontent']) ? '0' : strip_tags( $new_instance['searchcontent'] ));
		// $instance['searchtags'] = (empty($new_instance['searchtags']) ? '0' : strip_tags( $new_instance['searchtags'] ));
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'codernize' );
		}
		if ( isset( $instance[ 'placeholder' ] ) ) {
			$placeholder = $instance[ 'placeholder' ];
		}
		else {
			$placeholder = __( 'Search', 'codernize' );
		}
		/*if (isset($instance['searchtitle'])) {
			$searchtitle = ($instance['searchtitle'] == 1 ? ' checked="checked"' : '');
		} else {
			$searchtitle = ' checked="checked"';
		}*/
		/*if (isset($instance['searchcontent'])) {
			$searchcontent = ($instance['searchcontent'] == 1 ? ' checked="checked"' : '');
		} else {
			$searchcontent = ' checked="checked"';
		}
		if (isset($instance['searchtags'])) {
			$searchtags = ($instance['searchtags'] == 1 ? ' checked="checked"' : '');
		} else {
			$searchtags = '';
		}*/

		$custom_post_types = get_post_types( array('exclude_from_search' => false) );	
		#array_unshift($custom_post_types,'any');
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'placeholder' ); ?>"><?php _e( 'Placeholder:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'placeholder' ); ?>" name="<?php echo $this->get_field_name( 'placeholder' ); ?>" type="text" value="<?php echo esc_attr( $placeholder ); ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id( 'posttype' ); ?>"><?php _e( 'Post Type:' ); ?></label>
		<select class='widefat' id="<?php echo $this->get_field_id( 'posttype' ); ?>" name="<?php echo $this->get_field_name( 'posttype' ); ?>">";
        		<?php foreach ($custom_post_types as $t) {
				$selected = '';
				if (isset($instance['posttype']) && $instance['posttype'] == $t) $selected = ' selected="selected"';
				echo "<option{$selected}>$t</option>";
			}?>
		</select>
		</p>
		<?php /* ?><p><?php _e('Search using the following fields:','advanced-search-widget'); ?></p> <?php */ ?>
		<?php /* ?><p>
		<input id="<?php echo $this->get_field_id( 'searchtitle' ); ?>" name="<?php echo $this->get_field_name( 'searchtitle' ); ?>"<?php echo $searchtitle; ?> type="checkbox" value="1" />
		<label for="<?php echo $this->get_field_id( 'searchtitle' ); ?>"><?php _e( 'Title' ); ?></label> 
		</p> <?php */ ?>
		<?php /* ?><p>
		<input id="<?php echo $this->get_field_id( 'searchcontent' ); ?>" name="<?php echo $this->get_field_name( 'searchcontent' ); ?>"<?php echo $searchcontent; ?> type="checkbox" value="1" />
		<label for="<?php echo $this->get_field_id( 'searchcontent' ); ?>"><?php _e( 'Content' ); ?></label> 
		</p> <?php */ ?>
		<?php /* ?><p>
		<input id="<?php echo $this->get_field_id( 'searchtags' ); ?>" name="<?php echo $this->get_field_name( 'searchtags' ); ?>"<?php echo $searchtags; ?> type="checkbox" value="1" />
		<label for="<?php echo $this->get_field_id( 'searchtags' ); ?>"><?php _e( 'Tags' ); ?></label> 
		</p> <?php */ ?>
		<?php 
	}

} // class Foo_Widget

// register advanced search widget
add_action( 'widgets_init', create_function( '', 'register_widget( "advanced_search_widget" );' ) );
