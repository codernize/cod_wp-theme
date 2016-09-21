<?php 

if (!class_exists('WC_Widget')) 
	return ;

class COD_Widget_Layered_Nav extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_layered_nav';
		$this->widget_description = __( 'Shows a custom attribute in a widget which lets you narrow down the list of products when viewing product categories.', 'woocommerce' );
		$this->widget_id          = 'cod_woocommerce_layered_nav';
		$this->widget_name        = __( 'WooCommerce Layered Nav All', 'woocommerce' );

		parent::__construct();
	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();

		$instance = $old_instance;

		if ( empty( $this->settings ) ) {
			return $instance;
		}

		foreach ( $this->settings as $key => $setting ) {

			if ( isset( $new_instance[ $key ] ) ) {
				$instance[ $key ] = sanitize_text_field( $new_instance[ $key ] );
				if ( 'checkboxes' === $setting['type'] )
					$instance[ $key ] = serialize($new_instance[ $key ]);
			} elseif ( 'checkbox' === $setting['type'] ) {
				$instance[ $key ] = 0;
			} elseif ( 'checkboxes' === $setting['type'] ) {
				$instance[ $key ] = '';
			}
		}

		$this->flush_widget_cache();
		
		return $instance;
	}

	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 *
	 * @param array $instance
	 */
	public function form( $instance ) {
		$this->init_settings();

		if ( empty( $this->settings ) ) {
			return;
		}

		foreach ( $this->settings as $key => $setting ) {

			$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];

			switch ( $setting['type'] ) {

				case 'text' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
						<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;

				case 'number' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
						<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="number" step="<?php echo esc_attr( $setting['step'] ); ?>" min="<?php echo esc_attr( $setting['min'] ); ?>" max="<?php echo esc_attr( $setting['max'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;

				case 'select' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>">
							<?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;

				case 'checkbox' :
					?>
					<p>
						<input id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="checkbox" value="1" <?php checked( $value, 1 ); ?> />
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
					</p>
					<?php
				break;
				case 'checkboxes' :
					$value = maybe_unserialize($value);
					if (!is_array($value)) {
						$value = (array) $value ;
					}
					?>
					<p>

						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
						<ul>
							
						<?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
							<li>
								<input id="<?php echo $this->get_field_id( $key ); ?>_<?php echo $option_key ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>[]" type="checkbox" value="<?php echo esc_attr( $option_key ); ?>" <?php in_array($option_value, $value)? checked( 1,1 ) : ''; ?> /> <label for="<?php echo $this->get_field_id( $key ); ?>_<?php echo $option_key ?>"><?php echo esc_html( $option_value ); ?></label>
								
							</li>
						<?php endforeach; ?>
						</ul>
					</p>
					<?php
				break;
			}
		}
	}

	/**
	 * Init settings after post types are registered
	 */
	public function init_settings() {
		$attribute_array      = array();
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
		}
		// echo '<pre>';
		// print_r($attribute_array);
		// // die('---end debug---');		
		// echo '</pre>';

		$this->settings = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Filter by', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' )
			),
			'attribute' => array(
				'type'    => 'checkboxes',
				'std'     => '',
				'label'   => __( 'Attribute', 'woocommerce' ),
				'options' => $attribute_array
			),
			'display_type' => array(
				'type'    => 'select',
				'std'     => 'list',
				'label'   => __( 'Display type', 'woocommerce' ),
				'options' => array(
					'list'     => __( 'List', 'woocommerce' ),
					// 'dropdown' => __( 'Dropdown', 'woocommerce' )
				)
			),
			'query_type' => array(
				'type'    => 'select',
				'std'     => 'and',
				'label'   => __( 'Query type', 'woocommerce' ),
				'options' => array(
					'and' => __( 'AND', 'woocommerce' ),
					'or'  => __( 'OR', 'woocommerce' )
				)
			),
		);
	}


	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $_chosen_attributes;

		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		$current_term = is_tax() ? get_queried_object()->term_id : '';
		$current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
		$attribute     = isset( $instance['attribute'] ) ?  maybe_unserialize($instance['attribute'])  : array();
		$query_type   = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
		$display_type = isset( $instance['display_type'] ) ? $instance['display_type'] : $this->settings['display_type']['std'];
		// echo '<pre>';
		// print_r( $attribute );
		// die('---end debug---');		
		// echo '</pre>';
		if (!is_array($attribute)) {
			$attribute = (array)$attribute ;
		}
		$get_terms_args = array( 'hide_empty' => '1' );
		$html = '';
		
		$this->widget_start( $args, $instance );
		$cod_done_filters = array();
		foreach ($attribute as $taxonomy_term) {
			$taxonomy = wc_attribute_taxonomy_name( $taxonomy_term );
			if ( ! taxonomy_exists( $taxonomy ) ) {
				continue;
			}

			$orderby = wc_attribute_orderby( $taxonomy );
			
			switch ( $orderby ) {
				case 'name' :
					$get_terms_args['orderby']    = 'name';
					$get_terms_args['menu_order'] = false;
				break;
				case 'id' :
					$get_terms_args['orderby']    = 'id';
					$get_terms_args['order']      = 'ASC';
					$get_terms_args['menu_order'] = false;
				break;
				case 'menu_order' :
					$get_terms_args['menu_order'] = 'ASC';
				break;
			}
			
			$terms = get_terms( $taxonomy, $get_terms_args );
			
			if ( 0 < count( $terms ) ) {

				$this_term = wc_attribute_label($taxonomy);
				ob_start();

				$found = false;


				// Force found when option is selected - do not force found on taxonomy attributes
				if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
					$found = true;
				}
				echo '<ul>
					<li><strong>'.$this_term.'</strong></li>
					<li>';
				if ( 'dropdown' == $display_type ) {

					// skip when viewing the taxonomy
					if ( $current_tax && $taxonomy == $current_tax ) {

						$found = false;

					} else {

						$taxonomy_filter = str_replace( 'pa_', '', $taxonomy );

						$found = false;

						echo '<select class="dropdown_layered_nav_' . $taxonomy_filter . '">';

						echo '<option value="">' . sprintf( __( 'Any %s', 'woocommerce' ), wc_attribute_label( $taxonomy ) ) . '</option>';

						foreach ( $terms as $term ) {

							// If on a term page, skip that term in widget list
							if ( $term->term_id == $current_term ) {
								continue;
							}

							// Get count based on current view - uses transients
							$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );

							if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

								$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

								set_transient( $transient_name, $_products_in_term, DAY_IN_SECONDS * 30 );
							}

							$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

							// If this is an AND query, only show options with count > 0
							if ( 'and' == $query_type ) {

								$count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

								if ( 0 < $count ) {
									$found = true;
								}

								if ( 0 == $count && ! $option_is_set ) {
									continue;
								}

							// If this is an OR query, show all options so search can be expanded
							} else {

								$count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

								if ( 0 < $count ) {
									$found = true;
								}

							}

							echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( isset( $_GET[ 'filter_' . $taxonomy_filter ] ) ? $_GET[ 'filter_' . $taxonomy_filter ] : '' , $term->term_id, false ) . '>' . esc_html( $term->name ) . '</option>';
						}

						echo '</select>';

						wc_enqueue_js( "
							jQuery( '.dropdown_layered_nav_$taxonomy_filter' ).change( function() {
								var term_id = parseInt( jQuery( this ).val(), 10 );
								location.href = '" . preg_replace( '%\/page\/[0-9]+%', '', str_replace( array( '&amp;', '%2C' ), array( '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 'filter_' . $taxonomy_filter ) ) ) ) ) ) . "&filter_$taxonomy_filter=' + ( isNaN( term_id ) ? '' : term_id );
							});
						" );

					}

				} else {

					// List display
					echo '<ul>';

					foreach ( $terms as $term ) {

						// Get count based on current view - uses transients
						$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );

						if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {

							$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );

							set_transient( $transient_name, $_products_in_term );
						}

						$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

						// skip the term for the current archive
						if ( $current_term == $term->term_id ) {
							continue;
						}

						// If this is an AND query, only show options with count > 0
						if ( 'and' == $query_type ) {

							$count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

							if ( 0 < $count && $current_term !== $term->term_id ) {
								$found = true;
							}

							if ( 0 == $count && ! $option_is_set ) {
								continue;
							}

						// If this is an OR query, show all options so search can be expanded
						} else {

							$count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

							if ( 0 < $count ) {
								$found = true;
							}
						}

						$arg = 'filter_' . sanitize_title( $taxonomy_term );

						$current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();

						if ( ! is_array( $current_filter ) ) {
							$current_filter = array();
						}

						$current_filter = array_map( 'esc_attr', $current_filter );

						if ( ! in_array( $term->term_id, $current_filter ) ) {
							$current_filter[] = $term->term_id;
						}

						// Base Link decided by current page
						if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
							$link = home_url();
						} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
							$link = get_post_type_archive_link( 'product' );
						} else {
							$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
						}

						// All current filters
						if ( $_chosen_attributes ) {
							foreach ( $_chosen_attributes as $name => $data ) {
								if ( $name !== $taxonomy ) {

									// Exclude query arg for current term archive term
									while ( in_array( $current_term, $data['terms'] ) ) {
										$key = array_search( $current_term, $data );
										unset( $data['terms'][$key] );
									}

									// Remove pa_ and sanitize
									$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );

									if ( ! empty( $data['terms'] ) ) {
										$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
									}

									if ( 'or' == $data['query_type'] ) {
										$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
									}
								}
							}
						}

						// Min/Max
						if ( isset( $_GET['min_price'] ) ) {
							$link = add_query_arg( 'min_price', $_GET['min_price'], $link );
						}

						if ( isset( $_GET['max_price'] ) ) {
							$link = add_query_arg( 'max_price', $_GET['max_price'], $link );
						}

						// Orderby
						if ( isset( $_GET['orderby'] ) ) {
							$link = add_query_arg( 'orderby', $_GET['orderby'], $link );
						}

						// Current Filter = this widget
						if ( isset( $_chosen_attributes[ $taxonomy ] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) {

							$class = 'class="chosen"';

							// Remove this term is $current_filter has more than 1 term filtered
							if ( sizeof( $current_filter ) > 1 ) {
								$current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
								$link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
							}

						} else {

							$class = '';
							$link = add_query_arg( $arg, implode( ',', $current_filter ), $link );

						}

						// Search Arg
						if ( get_search_query() ) {
							$link = add_query_arg( 's', get_search_query(), $link );
						}

						// Post Type Arg
						if ( isset( $_GET['post_type'] ) ) {
							$link = add_query_arg( 'post_type', $_GET['post_type'], $link );
						}

						// Query type Arg
						if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) ) {
							$link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );
						}
						if (in_array($term->name, $cod_done_filters)) {
							continue;
						} else {
							$cod_done_filters[] = $term->name ;
						}
						echo '<li ' . $class . '>';

						echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span>';

						echo $term->name;

						echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';

						echo ' <span class="count">(' . $count . ')</span></li>';

					}

					echo '</ul>';

				} // End display type conditional

				
				echo '</li>
				</ul>';
				if ( ! $found ) {
					ob_end_clean();
				} else {
					$html .= ob_get_clean();
				}
			}
		}
		echo $html ;
		$this->widget_end( $args );




	}
}


function cod_register_filter_product_category_widget() {
	
    register_widget( 'COD_Widget_Layered_Nav' );
}
add_action( 'widgets_init', 'cod_register_filter_product_category_widget', 1 );



add_filter('woocommerce_is_layered_nav_active','cod_woocommerce_is_layered_nav_active',10,1);
function cod_woocommerce_is_layered_nav_active($default) {
	return $default || is_active_widget( false, false, 'cod_woocommerce_layered_nav', true ) ;
}

