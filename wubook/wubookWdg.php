<?php
/*
 * Plugin Name: WuBook Online Reception Plugin
 * Plugin URI: http://en.wubook.net/
 * Description: Insert an online booking system for hotel and bed and breakfast (aka online reception)
 * Version: 1.0
 * Author: Pranjal Srivastava
 * Author URI: http://wubook.net/
 * License: BSD
 * License owner: WuBook Srl, http://wubook.net/
 */

/*
 * Add function to widgets_init that'll load our widget.
 */

add_action( 'widgets_init', 'load_widgets' );
/**

 * Register our widget.
 * 'reception_Widget' is the widget class used below.
 *
 * @since 0.1

 */

function load_widgets() {
  register_widget( 'reception_Widget' );
}



/**
 * reception_Widget Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */

class reception_Widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function reception_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'cls_recieption', 'description' => __('An widget that displays a online reception block.', 'reception') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'example-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'example-widget', __('Online Reception', 'cls_reception'), $widget_ops, $control_ops );
	}



	/**

	 * How to display the widget on the screen.

	 */

	function widget( $args, $instance ) {

		extract( $args );



		/* Our variables from the widget settings. */

		$title = apply_filters('widget_title', $instance['title'] );

		



		/* Before widget (defined by themes). */

		echo $before_widget;



		/* Display the widget title if one was input (before and after defined by themes). */

		if ( $title )

			echo $before_title . $title . $after_title;

			$icode = get_option('icode');

			$avoiddates = get_option('avoiddates');

			$avoiddeletion = get_option('avoiddeletion');

			$avoidmail = get_option('avoidmail');

			$deflang = get_option('deflang');

			$layout = get_option('layout');

			$wborcss = get_option('wborcss');

			$horizontal = get_option('horizontal');

			$minimal = get_option('minimal');

			if(empty($icode) and empty($avoiddates) and empty($avoiddeletion) and empty($avoidmail) and empty($deflang) and empty($layout) and empty($wborcss) and empty($horizontal) and empty($minimal)){
			
			$icode = '123';

			$avoiddates = 'false';

			$avoiddeletion = 'false';

			$avoidmail = 'false';

			$deflang = 'en';

			$layout = 'wugle';

			$wborcss = 'false';

			$horizontal = 'false';
			$minimal = 'false';
			 }

		echo '<script src="https://wubook.net/js/wbk/wbloader.js"></script>

					<div id="__wbor__">

					<div style="max-width:200px;margin-top:8px;font-size:10px" id="__wb_banner__">

					<a style="border:none;font-decoration:none;float:right" href="http://wubook.net/">

					<img style="border:none;font-decoration:none;margin-top:4px" src="http://wubook.net/imgs/share/lwu.png"/>

					</a>Direct reservation with full customer care and best price granted

					</div>

					</div>';

	echo "<script>

		wbLoadInit(".$icode.",".$avoiddates.",".$avoiddeletion.",".$avoidmail.",'".$deflang."','".$layout."',".$wborcss.",".$horizontal.",".$minimal.");

		</script>";

	}



	/**

	 * Update the widget settings.

	 */

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */

		$instance['title'] = strip_tags( $new_instance['title'] );

		

		return $instance;

	}



	/**

	 * Displays the widget settings controls on the widget panel.

	 * Make use of the get_field_id() and get_field_name() function

	 * when creating your form elements. This handles the confusing stuff.

	 */

	function form( $instance ) {



		/* Set up some default widget settings. */

		$defaults = array( 'title' => __('Online Reception', 'example'));

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>



		<!-- Widget Title: Text Input -->

		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>

			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />

		</p>



	<?php

	}

}
?>
