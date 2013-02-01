<?php
/*
 * Plugin Name: WuBook plugin
 * Plugin URI: http://en.wubook.net/
 * Description: Insert an online booking system for hotel and bed and breakfast (aka online reception)
 * Version: 2.0.1
 * Author: Eugenio Palumbo (aka Steel), Federico Tomassini (aka yellow), Pranjal Srivastava
 * Author URI: http://en.wubook.net/
 * License: BSD
 * License owner: WuBook Srl, http://wubook.net/
 * See plugin documentation here:
 * https://sites.google.com/site/wubookdocs/online-booking/how-to-install-the-widget-on-wordpress-based-websites
 */

// Hook for adding admin menus

add_action('admin_menu', 'reception_menu');

function reception_menu() {
    add_options_page('Online Reception Options', 'WuBook', 'manage_options', 'online-reception', 'reception_options');
}

function reception_options() {
    if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if($_POST['oscimp_hidden'] == 'Y') {
	//Form data sent
	$icode = $_POST['icode'];
	if (!preg_match('/^[0-9]{3,}/', $icode)) {
	    $error = ' Please enter numeric value';
	    $icode = '';
	    $avoiddates = get_option('avoiddates');
	    $avoiddeletion = get_option('avoiddeletion');
	    $avoidmail = get_option('avoidmail');
	    $deflang = get_option('deflang');
	    $layout = get_option('layout');
	    $wborcss = get_option('wborcss');
	    $horizontal = get_option('horizontal');
	    $minimal = get_option('minimal');
	} else {
	    //$icode = $_POST['icode'];
	    update_option('icode', $icode);

	    $avoiddates = $_POST['avoiddates'];
	    update_option('avoiddates', $avoiddates);

	    $avoiddeletion = $_POST['avoiddeletion'];
	    update_option('avoiddeletion', $avoiddeletion);

	    $avoidmail = $_POST['avoidmail'];
	    update_option('avoidmail', $avoidmail);
	    
	    
	    $deflang = $_POST['deflang'];
	    update_option('deflang', $deflang);

	    $layout = $_POST['layout'];
	    update_option('layout', $layout);

	    $wborcss = $_POST['wborcss'];
	    update_option('wborcss', $wborcss);

	    $horizontal = $_POST['horizontal'];
	    update_option('horizontal', $horizontal);
	    $minimal = $_POST['minimal'];
	    update_option('minimal', $minimal);
	}
    }
    ////////////////// Normal page view
    else {
	$icode = get_option('icode');

	$avoiddates = get_option('avoiddates');
	$avoiddeletion = get_option('avoiddeletion');
	$avoidmail = get_option('avoidmail');
	$deflang = get_option('deflang');
	$layout = get_option('layout');
	
	$wborcss = get_option('wborcss');
	$horizontal = get_option('horizontal');
	$minimal = get_option('minimal');
    }
    ///////////////////////// form designing
    ?>
    <div class="wrap">
	<div class="wrap">
	    <?php    echo "<h2>" . __( 'Online Reception Display Option') . "</h2>"; ?>
	    <form method="post">
		<input type="hidden" name="oscimp_hidden" value="Y">
		<table width="759">
		<tr>
		    <td width="152"><p><?php _e("Icode: " ); ?></p></td>
		    <td width="595"><p><input type="text" name="icode" value="<?php echo $icode; ?>" size="10"><?php if(isset($error)) _e($error); else  _e(" ex: 123" ); ?></p></td>
		</tr>
                <tr>
		    <td><?php _e("Avoid dates: " ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="avoiddates" value="false" <?php if($avoiddates != 'true'){echo $checked;}?>>False
			<input type="radio" name="avoiddates" value="true" <?php if($avoiddates == 'true'){ echo $checked;}?>>True
		    </td>
                </tr>
                <tr>
		    <td><?php _e("Avoid Deletion: " ); ?></td>
		    <td>
			<input type="radio" name="avoiddeletion" value="false" <?php if($avoiddeletion != 'true'){echo $checked;}?> > False
			<input type="radio" name="avoiddeletion" value="true" <?php if($avoiddeletion == 'true'){echo $checked;}?>>True
		    </td>
                </tr>
                <tr>
		    <td><?php _e("Avoid Mail: " ); ?></td>
		    <td>
			<input type="radio" name="avoidmail" value="false" <?php if($avoidmail != 'true'){echo $checked;}?>> False
			<input type="radio" name="avoidmail" value="true" <?php if($avoidmail == 'true'){echo $checked;}?>>True
		    </td>
		</tr>
                <tr>
		    <td><p><?php _e("Deflang: " ); ?></p></td>
		    <td>
			<?php $selected = 'selected="selected"';?>
			<select name="deflang" value="<?php echo $deflang; ?>">
			    <option value="en" <?php if($deflang == 'en'){ echo $selected;}?>>en</option>
			    <option value="it" <?php if($deflang == 'it'){ echo $selected;}?>>it</option>
			    <option value="de" <?php if($deflang == 'de'){ echo $selected;}?>>de</option>
			    <option value="fr" <?php if($deflang == 'fr'){ echo $selected;}?>>fr</option>
			    <option value="es" <?php if($deflang == 'es'){ echo $selected;}?>>es</option>
			    <option value="pt" <?php if($deflang == 'pt'){ echo $selected;}?>>pt</option>
			    <option value="ru" <?php if($deflang == 'ru'){ echo $selected;}?>>ru</option>
			    <option value="nl" <?php if($deflang == 'nl'){ echo $selected;}?>>nl</option>
			</select>
		    </td>
		</tr>
                <tr>
		    <td><?php _e("Layout: " ); ?></td>
		    <td>
			<select name="layout">
			    <option value="wugle" <?php if($layout == 'wugle'){ echo $selected;}?>>wugle </option>
			    <option value="46" <?php if($layout == '46'){ echo $selected;}?>>46 </option>
			    <option value="wubook" <?php if($layout == 'wubook'){ echo $selected;}?>>wubook </option>
			    <option value="zak" <?php if($layout == 'zak'){ echo $selected;}?>>zak </option>
			    <option value="wcdonald" <?php if($layout == 'wcdonald'){ echo $selected;}?>>wcdonald </option>
			    <option value="serious" <?php if($layout == 'serious'){ echo $selected;}?>>serious </option>
			</select>
		    </td>
                </tr>
                <tr>
		    <td><?php _e("Wborcss: " ); ?></td>
		    <td><input type="radio" name="wborcss" value="false"  checked="checked"> False</td>
		</tr>
                <tr>
		    <td><?php _e("Horizontal: " ); ?></td>
		    <td>
			<input type="radio" name="horizontal" value="false" <?php if($horizontal != 'true'){echo $checked;}?>> False
			<input type="radio" name="horizontal" value="true" <?php if($horizontal == 'true'){echo $checked;}?>>True
		    </td>
		</tr>
                <tr>
		    <td><?php _e("Minimal: " ); ?></td>
		    <td>
			<input type="radio" name="minimal" value="false" <?php if($minimal != 'true'){echo $checked;}?> > False
			<input type="radio" name="minimal" value="true" <?php if($minimal == 'true'){echo $checked;}?>>True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p></td>
		</tr>
		</table>
	    </form>
	</div>
    </div>
    <?php
}

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
      *  Widget setup.
      */
    function reception_Widget() {
	/* Widget settings. */
	$widget_ops = array( 'classname' => 'cls_recieption', 'description' => __('An widget that displays a online reception block.', 'reception') );
	/* Widget control settings. */
	$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'example-widget' );
	/* Create the widget. */
	$this->WP_Widget( 'example-widget', __('WuBook', 'cls_reception'), $widget_ops, $control_ops );
    }

    /**
      *  How to display the widget on the screen.
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

	if(empty($icode) and empty($avoiddates) and empty($avoiddeletion) and empty($avoidmail) and empty($deflang) and empty($layout) and empty($wborcss) and empty($horizontal) and empty($minimal)) {
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

	echo '<script src="http://wubook.net/js/wbloader.js"></script><div style="font-family:arial" id="__wbor__"><div style="margin-top:8px;font-size:10px" id="__wb_banner__"><a style="border:none;font-decoration:none;float:right" href="http://wubook.net/" title="wubook, online booking, pms, channel manager"><img src="http://wubook.net/imgs/share/lwu.png" alt="channel manager,booking online bed and breakfast,software hotel bed and breakfast" style="border:none;font-decoration:none;margin-top:4px" title="channel manager, expedia,booking online bed and breakfast,property management system" /></a><span id="__wb_banner_txt__">Direct reservation with full customer care and best price granted</span></div></div>';
	echo "<script>
	    wbLoadInit(".$icode.",".$avoiddates.",".$avoiddeletion.",".$avoidmail.",'".$deflang."','".$layout."',".$wborcss.",".$horizontal.",".$minimal.");
	</script>";
	echo $after_widget; 
    }
    /**
      *  Update the widget settings.
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
	$defaults = array( 'title' => __('WuBook', 'example'));
	$instance = wp_parse_args( (array) $instance, $defaults );
	?>
	    <!-- Widget Title: Text Input -->
	    <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
	    </p>
	<?php
    }
}
?>