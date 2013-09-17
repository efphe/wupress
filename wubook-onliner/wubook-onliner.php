<?php
/*
 * Plugin Name: WuBook Onliner
 * Plugin URI: http://en.wubook.net/
 * Description: Show the widget for reservation and open the online reception. To see how it works take a look at the <a href="https://sites.google.com/site/wubookdocs/online-booking/online-booking-for-wordpress" target="blank">documentation page</a>.
 * Version: 2.0.1
 * Author: Eugenio Palumbo (aka Steel)
 * Author URI: http://www.itasolution.it/?ref=wb
 * License: BSD
 * License owner: WuBook Srl, http://wubook.net/
 */

// Hook for adding admin menus

load_plugin_textdomain( 'wb', false, dirname( plugin_basename( __FILE__ ) ) . '/locale' );

add_action('admin_menu', 'reception_menu');

function reception_menu() {
    add_options_page('WuBook Settings', __('WuBook Settings', 'wb'), 'manage_options', 'wubook-settings', 'wubook_settings');
}

function wubook_settings() {
    if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.', 'wb') );
    }

    $couldI = @$_POST['oscimp_hidden'];
    if($couldI == 'Y') {
	//Form data sent
	$wu_lcode = @$_POST['wu_lcode'];
	$wu_width = @$_POST['wu_width'];
	$wu_height = @$_POST['wu_height'];
	$wu_email = @$_POST['wu_email'];
	$wu_cancel = @$_POST['wu_cancel'];
	$wu_lang = @$_POST['wu_lang'];
	$wu_dates = @$_POST['wu_dates'];
	$wu_failback_lang = @$_POST['wu_failback_lang'];
	$wu_bgcolor = @$_POST['wu_bgcolor'];
	$wu_textcolor = @$_POST['wu_textcolor'];
	$wu_cards = @$_POST['wu_cards'];
	$wu_wbgoogle = @$_POST['wu_wbgoogle'];
	$wu_bestprice = @$_POST['wu_bestprice'];
	$wu_bids = @$_POST['wu_bids'];
	$wu_layout = @$_POST['wu_layout'];
	$wu_css = @$_POST['wu_css'];

	if(!is_numeric($wu_lcode)) $wu_lcode_error = '<span style="color:#e50000">' . __('Lodging code is not valid!') . '</span>';
	if(!is_numeric($wu_width)) $wu_width_error = '<span style="color:#e50000">' . __('Width value is not valid!') . '</span>';
	if(!is_numeric($wu_height) && $wu_height != 'auto') $wu_height_error = '<span style="color:#e50000">' . __('Height value is not valid!') . '</span>';

	update_option('wu_lcode', strip_tags($wu_lcode));
	update_option('wu_width', strip_tags($wu_width));
	update_option('wu_height', strip_tags($wu_height));
	update_option('wu_email', strip_tags($wu_email));
	update_option('wu_cancel', strip_tags($wu_cancel));
	update_option('wu_lang', strip_tags($wu_lang));
	update_option('wu_dates', strip_tags($wu_dates));
	update_option('wu_failback_lang', strip_tags($wu_failback_lang));
	update_option('wu_bgcolor', strip_tags($wu_bgcolor));
	update_option('wu_textcolor', strip_tags($wu_textcolor));
	update_option('wu_cards', strip_tags($wu_cards));
	update_option('wu_wbgoogle', strip_tags($wu_wbgoogle));
	update_option('wu_bestprice', strip_tags($wu_bestprice));
	update_option('wu_bids', strip_tags($wu_bids));
	update_option('wu_layout', strip_tags($wu_layout));
	update_option('wu_css', strip_tags($wu_css));
	update_option('wu_iframe_data', 0);

	$updated = '<div class="update-nag" style="width:400px;">I dati sono stati aggiornati.</div>';
    }
    ////////////////// Normal page view
    else {
	$wu_lcode = get_option('wu_lcode');
	$wu_width = get_option('wu_width');
	$wu_height = get_option('wu_height');
	$wu_email = get_option('wu_email');
	$wu_cancel = get_option('wu_cancel');
	$wu_lang = get_option('wu_lang');
	$wu_dates = get_option('wu_dates');
	$wu_failback_lang = get_option('wu_failback_lang');
	$wu_bgcolor = get_option('wu_bgcolor');
	$wu_textcolor = get_option('wu_textcolor');
	$wu_cards = get_option('wu_cards');
	$wu_wbgoogle = get_option('wu_wbgoogle');
	$wu_bestprice = get_option('wu_bestprice');
	$wu_bids = get_option('wu_bids');
	$wu_layout = get_option('wu_layout');
	$wu_css = get_option('wu_css');
    }
    ///////////////////////// form designing
    ?>
    <div class="wrap">
	<div class="wrap">
	    <?php    echo "<h2>" . __( 'WuBook Online Reception Settings', 'wb') . "</h2>"; ?>
	    <?php echo ((isset($updated))?$updated:''); ?>
	    <form method="post" name="wbsettings" id="wbsettings">
		<input type="hidden" name="oscimp_hidden" value="Y">
		<table width="759">
		<tr>
		    <td width="152"><?php _e("Lodging code: ", 'wb' ); ?></td>
		    <td width="595"><input type="text" name="wu_lcode" value="<?php echo (($wu_lcode == '')?'1213394817':$wu_lcode); ?>" onblur="if($('input[name=wu_lcode]').val() == '') { alert('<?php _e('Lodging code cannot be blank and must be valid.', 'wb' ); ?>'); $('input[name=wu_lcode]').focus(); }"><?php echo ((isset($wu_lcode_error))?' ' . $wu_lcode_error:''); ?></td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("You can retreive it in the WuBook extranet panel.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Width: ", 'wb' ); ?></td>
		    <td><input type="text" name="wu_width" value="<?php echo (($wu_width == '')?'200':$wu_width); ?>"><?php echo ((isset($wu_width_error))?' ' . $wu_width_error:''); ?></td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("The width of the widget (integer). Default value is 200.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Height: ", 'wb' ); ?></td>
		    <td><input type="text" name="wu_height" value="<?php echo (($wu_height == '')?'auto':$wu_height); ?>"><?php echo ((isset($wu_height_error))?' ' . $wu_height_error:''); ?></td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("The height of the widget (integer). Default value is auto.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("e-Mail: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_email" value="0" <?php if($wu_email == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_email" value="1" <?php if($wu_email == '1' || $wu_email == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Show the feedback form in the widget (0 or 1). Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Cancellation: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_cancel" value="0" <?php if($wu_cancel == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_cancel" value="1" <?php if($wu_cancel == '1' || $wu_cancel == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Show the cancellation form in the widget (0 or 1). Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Language: ", 'wb' ); ?></td>
		    <td>
			<?php $selected = 'selected="selected"';?>
			<select name="wu_lang">
			    <option value=""><?php _e('Autodetect', 'wb'); ?></option>
			    <option value="en" <?php if($wu_lang == 'en'){ echo $selected;}?>>en</option>
			    <option value="it" <?php if($wu_lang == 'it'){ echo $selected;}?>>it</option>
			    <option value="de" <?php if($wu_lang == 'de'){ echo $selected;}?>>de</option>
			    <option value="fr" <?php if($wu_lang == 'fr'){ echo $selected;}?>>fr</option>
			    <option value="es" <?php if($wu_lang == 'es'){ echo $selected;}?>>es</option>
			    <option value="pt" <?php if($wu_lang == 'pt'){ echo $selected;}?>>pt</option>
			    <option value="ru" <?php if($wu_lang == 'ru'){ echo $selected;}?>>ru</option>
			    <option value="nl" <?php if($wu_lang == 'nl'){ echo $selected;}?>>nl</option>
			    <option value="cs" <?php if($wu_lang == 'cs'){ echo $selected;}?>>cs</option>
			    <option value="fi" <?php if($wu_lang == 'fi'){ echo $selected;}?>>fi</option>
			    <option value="gr" <?php if($wu_lang == 'gr'){ echo $selected;}?>>gr</option>
			    <option value="hr" <?php if($wu_lang == 'hr'){ echo $selected;}?>>hr</option>
			    <option value="ro" <?php if($wu_lang == 'ro'){ echo $selected;}?>>ro</option>
			</select>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("The language, no param means auto-detect.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Dates: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_dates" value="0" <?php if($wu_dates == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_dates" value="1" <?php if($wu_dates == '1' || $wu_dates == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Dates selection (dates selection is not mandatory to open Online Reception), 0 or 1. Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Failback language: ", 'wb' ); ?></td>
		    <td>
			<?php $selected = 'selected="selected"';?>
			<select name="wu_failback_lang">
			    <option value="en" <?php if($wu_failback_lang == 'en'){ echo $selected;}?>>en</option>
			    <option value="it" <?php if($wu_failback_lang == 'it'){ echo $selected;}?>>it</option>
			    <option value="de" <?php if($wu_failback_lang == 'de'){ echo $selected;}?>>de</option>
			    <option value="fr" <?php if($wu_failback_lang == 'fr'){ echo $selected;}?>>fr</option>
			    <option value="es" <?php if($wu_failback_lang == 'es'){ echo $selected;}?>>es</option>
			    <option value="pt" <?php if($wu_failback_lang == 'pt'){ echo $selected;}?>>pt</option>
			    <option value="ru" <?php if($wu_failback_lang == 'ru'){ echo $selected;}?>>ru</option>
			    <option value="nl" <?php if($wu_failback_lang == 'nl'){ echo $selected;}?>>nl</option>
			    <option value="cs" <?php if($wu_failback_lang == 'cs'){ echo $selected;}?>>cs</option>
			    <option value="fi" <?php if($wu_failback_lang == 'fi'){ echo $selected;}?>>fi</option>
			    <option value="gr" <?php if($wu_failback_lang == 'gr'){ echo $selected;}?>>gr</option>
			    <option value="hr" <?php if($wu_failback_lang == 'hr'){ echo $selected;}?>>hr</option>
			    <option value="ro" <?php if($wu_failback_lang == 'ro'){ echo $selected;}?>>ro</option>
			</select>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Just in case language is not specified and server cannot detect the language: this language will be used.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Background color: ", 'wb' ); ?></td>
		    <td>
			<input type="text" name="wu_bgcolor" value="<?php echo (($wu_bgcolor != '') ? '' . $wu_bgcolor : '#E7F2E7' ); ?>" class="colorfield"/>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Background color. Default is #E7F2E7.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Font color: ", 'wb' ); ?></td>
		    <td>
			<input type="text" name="wu_textcolor" value="<?php echo (($wu_textcolor != '')?'' . $wu_textcolor:'#003D18'); ?>" class="colorfield"/>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("The fonts color. Default is #003D18.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Cards: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_cards" value="0" <?php if($wu_cards == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_cards" value="1" <?php if($wu_cards == '1' || $wu_cards == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Show cards icons (0 or 1). Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Google integration: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_wbgoogle" value="0" <?php if($wu_wbgoogle == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_wbgoogle" value="1" <?php if($wu_wbgoogle == '1' || $wu_wbgoogle == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Google Analytics enabled (0 or 1). Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Best price: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_bestprice" value="0" <?php if($wu_bestprice == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_bestprice" value="1" <?php if($wu_bestprice == '1' || $wu_bestprice == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Show the Best Price icon (0 or 1). Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Bids: ", 'wb' ); ?></td>
		    <td>
			<?php $checked = 'checked="checked"';?>
			<input type="radio" name="wu_bids" value="0" <?php if($wu_bids == '0'){ echo $checked;}?>> False
			<input type="radio" name="wu_bids" value="1" <?php if($wu_bids == '1' || $wu_bids == ''){ echo $checked;}?>> True
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Show the Bids Icon (0 or 1). Default is 1.", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("Layout: ", 'wb' ); ?></td>
		    <td>
			<?php $selected = ' selected="selected"';?>
			<select name="wu_layout">
			    <option value=""<?php if($wu_layout == ''){ echo $selected;}?>>Default</option>
			    <option value="atlantic"<?php if($wu_layout == 'atlantic'){ echo $selected;}?>>atlantic</option>
			    <option value="aventinn"<?php if($wu_layout == 'aventinn'){ echo $selected;}?>>aventinn</option>
			    <option value="demetra"<?php if($wu_layout == 'demetra'){ echo $selected;}?>>demetra</option>
			    <option value="dianapalace"<?php if($wu_layout == 'dianapalace'){ echo $selected;}?>>dianapalace</option>
			    <option value="dostoevsky"<?php if($wu_layout == 'dostoevsky'){ echo $selected;}?>>dostoevsky</option>
			    <option value="hotelpeople"<?php if($wu_layout == 'hotelpeople'){ echo $selected;}?>>hotelpeople</option>
			    <option value="nautilusinn"<?php if($wu_layout == 'nautilusinn'){ echo $selected;}?>>nautilusinn</option>
			    <option value="octaviana"<?php if($wu_layout == 'octaviana'){ echo $selected;}?>>octaviana</option>
			    <option value="orangewhite"<?php if($wu_layout == 'orangewhite'){ echo $selected;}?>>orangewhite</option>
			    <option value="purple"<?php if($wu_layout == 'purple'){ echo $selected;}?>>purple</option>
			    <option value="residencemoika"<?php if($wu_layout == 'residencemoika'){ echo $selected;}?>>residencemoika</option>
			    <option value="serious"<?php if($wu_layout == 'serious'){ echo $selected;}?>>serious</option>
			    <option value="shelfort"<?php if($wu_layout == 'shelfort'){ echo $selected;}?>>shelfort</option>
			    <option value="wcdonald"<?php if($wu_layout == 'wcdonald'){ echo $selected;}?>>wcdonald</option>
			    <option value="wubook"<?php if($wu_layout == 'wubook'){ echo $selected;}?>>wubook</option>
			    <option value="wugle"<?php if($wu_layout == 'wugle'){ echo $selected;}?>>wugle</option>
			    <option value="zak"<?php if($wu_layout == 'zak'){ echo $selected;}?>>zak</option>
			    <option value="zizi"<?php if($wu_layout == 'zizi'){ echo $selected;}?>>zizi</option>
			</select>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Use a specific theme (optional).", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td><?php _e("CSS: ", 'wb' ); ?></td>
		    <td><textarea rows="4" cols="40" name="wu_css"><?php if($wu_css != '') { echo $wu_css; } ?></textarea></td>
		</tr>
		<tr>
		    <td colspan="2"><?php _e("Inline css to fully customize the widget (optional). Example: css=\"a {font-size: 100px}\"", 'wb' ); ?><br/><br/></td>
		</tr>

		<tr>
		    <td colspan="2"><p class="submit"><button type="submit"><?php _e('Update Options', 'wb'); ?></button></p></td>
		</tr>
		</table>
	    </form>
	    <?php
		wp_enqueue_style(  'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	    ?>
	    <script>
		jQuery(document).ready(function($){
		    $('.colorfield').wpColorPicker();
		});
	    </script>
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
	$widget_ops = array( 'classname' => 'cls_reception', 'description' => __('This widget displays the online reception widget. Onliner version.', 'reception') );
	/* Widget control settings. */
	#$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'example-widget' );
	$control_ops = array();
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

	$wbgenerato = get_option('wu_widget_mask');

	if(!isset($wbgenerato) || $wbgenerato == '') {
	    $wbgenerato = '<p>' . __('The widget is installed but not configured.', 'wb') . '</p>';
	}

	echo "\n" . stripslashes($wbgenerato) . "\n";

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
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wb'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
	    </p>
	<?php
    }
}


/**
  * 
  * SHORTCODE
  * 
  */

function wb_func( $atts ){
    $dp = array(
	'iframe' => 'N',
	'width'  => 840,
	'height' => '"auto"',
    );
    extract( shortcode_atts($dp, $atts, 'wb') );
    if($iframe == 'Y') {
	$contenuto = stripslashes(get_option('wu_iframe_mask'));
	$contenuto = str_replace('#####width#####', $width, $contenuto);
	$contenuto = str_replace('#####height#####', $height, $contenuto);
    } else {
	$contenuto = stripslashes(get_option('wu_widget_mask'));
	$contenuto = str_replace('__wubookwidget__', '_wbord_', $contenuto);
    }
    return $contenuto;
}
add_shortcode( 'wb', 'wb_func' );

$iframe      = get_option('wu_iframe_mask');
$iframe_date = get_option('wu_iframe_data');
$wbgenerato  = get_option('wu_widget_mask');

if($wbgenerato == false || $wbgenerato == '' || $iframe == false || $iframe == '' || (time() - $iframe_date) > 2592000) {
    update_option('wu_iframe_data', time());
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, 'https://wubook.net/wbkd/xwidget/gen.html');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    $data = array(
	'lcode'    => get_option('wu_lcode'),
	'wtype'    => 'design_iframe', #design_widget | design_iframe
	'wdivid'   => '__wubookiframe__', # (default= _wbord_)
	'sitelang' => substr(WPLANG, 0, 2),
	'width'    => '#####width#####',
	'height'   => '#####height#####',
	'layout'   => get_option('wu_layout')
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    #$info = curl_getinfo($ch);
    curl_close($ch);
    update_option('wu_iframe_mask', $output);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, 'https://wubook.net/wbkd/xwidget/gen.html');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    $data = array(
	'lcode'         => get_option('wu_lcode'),
	'wtype'         => 'design_widget', # design_widget | design_iframe
	'wdivid'        => '__wubookwidget__', # (default= _wbord_)
	'sitelang'      => substr(WPLANG, 0, 2),
	'width'         => get_option('wu_width'),
	'height'        => get_option('wu_height'),
	'email'         => get_option('wu_email'),
	'cancel'        => get_option('wu_cancel'),
	'lang'          => get_option('wu_lang'),
	'dates'         => get_option('wu_dates'),
	'failback_lang' => get_option('wu_failback_lang'),
	'bgcolor'       => get_option('wu_bgcolor'),
	'textcolor'     => get_option('wu_textcolor'),
	'cards'         => get_option('wu_cards'),
	'wbgoogle'      => get_option('wu_wbgoogle'),
	'bestprice'     => get_option('wu_bestprice'),
	'bids'          => get_option('wu_bids'),
	'layout'        => get_option('wu_layout'),
	'css'           => get_option('wu_css')
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    #$info = curl_getinfo($ch);
    curl_close($ch);
    update_option('wu_widget_mask', $output);
}
?>