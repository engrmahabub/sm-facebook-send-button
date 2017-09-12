<?php 
/*
Plugin Name: SM Facebook Send Button
Plugin URI: https://profiles.wordpress.org/mahabubs/
Author: Mahabubur Rahman
Author URI: https://profiles.wordpress.org/mahabubs/
*/


class SMFacebookSendButton extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'SMFacebookSendButton',
			'description' => 'SM Facebook Send Button is a wordpress plugin to send current URL to your friend for facebook massenger.',
		);
		parent::__construct( 'SMFacebookSendButton', 'SM Facebook Send Button', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$title              = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		$facebook_app_id    =	($instance['facebook_app_id'])? $instance['facebook_app_id']:'396134523823142';
		global $wp;
		$current_url        = home_url(add_query_arg(array(),$wp->request));
		
		// ob_start();
		echo $args['before_widget'];
//		$title=$title;
		if ( ! empty( $title ) )
		 	echo $args['before_title'] . $title . $args['after_title'];
		?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1404625236449876";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-send" data-href="<?=$current_url;?>"></div>
		<?php
		echo $args['after_widget'];
		// return ob_get_clean();
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Facebook Page', 'embed_facebook_page' );
		}

		if(isset($instance['facebook_app_id'])){
				$facebook_app_id=$instance['facebook_app_id'];
		}else{
			$facebook_app_id='';
		}

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'facebook_app_id' ); ?>"><?php _e( 'Facebook App ID:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_app_id' ); ?>" name="<?php echo $this->get_field_name( 'facebook_app_id' ); ?>" type="text" value="<?php echo esc_attr( $facebook_app_id ); ?>" >
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['facebook_app_id'] = ( ! empty( $new_instance['facebook_app_id'] ) ) ? strip_tags( $new_instance['facebook_app_id'] ) : '';
		return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'SMFacebookSendButton' );
});