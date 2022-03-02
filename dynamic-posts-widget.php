<?php

/* 
 * Plugin Name: Dynamic Posts Widget
 * Plugin URI: http://glowing-tips.com
 * Description: This Plugin Would Show the Dynamic Posts From Any Post Types
 * Version: 1.0
 * Author: Glowing Tips
 * Text Domain: dynamic_posts_widget
 */

class Dynamic_Posts_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'dynamic_posts_widget', // Base ID
			esc_html__( 'Dynamic Posts Widget', 'dynamic_posts_widget' ), // Name
			array( 'description' => esc_html__( 'Will Show Dynamic Posts', 'dynamic_posts_widget' ), ) // Args
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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo esc_html__( 'Chohan Gee', 'dynamic_posts_widget' );
                $getPosts = get_posts(array(
                    'numberposts'=> 10,
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'orderby' => 'rand'
                ));
                foreach($getPosts as $showPosts){ 
                   
                    ?>
                <h1><a href="<?php echo esc_html__( get_permalink($showPosts->ID), 'dynamic_posts_widget' );  ?>" title="<?php  echo esc_html__( get_the_title($showPosts->ID), 'dynamic_posts_widget' );  ?>"><?php echo esc_html__( get_the_title($showPosts->ID), 'dynamic_posts_widget' );  ?></a></h1>   
               <?php }                
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Dynamic Posts', 'dynamic_posts_widget' );
                $defaultPosts = ! empty($instances['dynamicposts']) ? $instance['title'] : esc_html__('post', 'dynamic_posts_widget'); 
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Add Posts Title:', 'dynamic_posts_widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('dynamicposts')); ?>"><?php esc_attr_e('Select Post Name:','dynamic_posts_widget') ?></label>   
                    <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dynamicposts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dynamicposts' ) ); ?>">
                        <option vlaue="<?php echo esc_attr( $defaultPosts ); ?>"><?php echo esc_attr( $defaultPosts ); ?></option>
                    </select>
                    
                    

                </p>
		<?php 
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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
} 
function createWidget(){
    register_widget('Dynamic_Posts_Widget');  
} 
    add_action('widgets_init','createWidget');

function createWidgetOnActivation(){
    createWidget();
}
register_activation_hook(__FILE__,'createWidgetOnActivation');