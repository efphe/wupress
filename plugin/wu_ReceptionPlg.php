<?php
/**
 * Plugin Name: WuBook Online Reception Plugin
 * Plugin URI: http://en.wubook.net/
 * Description: A widget that insert an online booking system for hotel and bed and breakfast (aka online reception)
 * Version: 1.0
 * Author: Pranjal Srivastava
 * Author URI: http://wubook.net/
 * License: BSD
 * License owner: WuBook Srl, http://wubook.net/
 */


// Hook for adding admin menus

add_action('admin_menu', 'reception_menu');

function reception_menu() {
  add_options_page('Online Reception Options', 'Online Reception', 'manage_options', 'online-reception', 'reception_options');
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
					$icode ='';
					$avoiddates = get_option('avoiddates');
					$avoiddeletion = get_option('avoiddeletion');
					$avoidmail = get_option('avoidmail');
					$deflang = get_option('deflang');
					$layout = get_option('layout');
					
					$wborcss = get_option('wborcss');
					$horizontal = get_option('horizontal');
					$minimal = get_option('minimal');
					}
					else
					{
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
            else
			{
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
		
		
		/////////////////////////form designing
  	echo '<div class="wrap">';
 	 echo '<p>';?>
  		<div class="wrap">
			<?php    echo "<h2>" . __( 'Online Reception Display Option') . "</h2>"; ?>

			<form method="post">
            <input type="hidden" name="oscimp_hidden" value="Y">  
            <table width="759">
           	  <tr>
                <td width="152"><p><?php _e("Icode: " ); ?></p></td><td width="595"><p><input type="text" name="icode" value="<?php echo $icode; ?>" size="10"><?php if(isset($error)) _e($error); else  _e(" ex: 123" ); ?></p>
                </td></tr>
                <tr>
				<td><?php _e("Avoid dates: " ); ?></td>
                <?php $checked = 'checked=checked';?>			
                <td><input type="radio" name="avoiddates" value="false" <?php if($avoiddates != 'true'){echo $checked;}?>>False
              
                <input type="radio" name="avoiddates" value="true" <?php if($avoiddates == 'true'){ echo $checked;}?>>True
               
                </td>
                </tr>
                <tr><td><?php _e("Avoid Deletion: " ); ?></td>
                <td><input type="radio" name="avoiddeletion" value="false" <?php if($avoiddeletion != 'true'){echo $checked;}?> > False
                <input type="radio" name="avoiddeletion" value="true" <?php if($avoiddeletion == 'true'){echo $checked;}?>>True</td>
                </tr>
                <tr><td><?php _e("Avoid Mail: " ); ?></td><td><input type="radio" name="avoidmail" value="false" <?php if($avoidmail != 'true'){echo $checked;}?>> False
                <input type="radio" name="avoidmail" value="true" <?php if($avoidmail == 'true'){echo $checked;}?>>True</td></tr>
                
               
                <tr>
                <?php $selected = 'selected=selected';?>
                <td><p><?php _e("Deflang: " ); ?></p></td><td><select name="deflang" value="<?php echo $deflang; ?>">
                 <option value="en" <?php if($deflang == 'en'){ echo $selected;}?>>en</option>
				 <option value="it" <?php if($deflang == 'it'){ echo $selected;}?>>it</option>
				  <option value="de" <?php if($deflang == 'de'){ echo $selected;}?>>de</option>
				 <option value="fr" <?php if($deflang == 'fr'){ echo $selected;}?>>fr</option>
				  <option value="es" <?php if($deflang == 'es'){ echo $selected;}?>>es</option>
				 <option value="pt" <?php if($deflang == 'pt'){ echo $selected;}?>>pt</option>
				  <option value="ru" <?php if($deflang == 'ru'){ echo $selected;}?>>ru</option>
				 <option value="nl" <?php if($deflang == 'nl'){ echo $selected;}?>>nl</option>
                 </select>
                </td></tr>
                <tr>
				<td><?php _e("Layout: " ); ?></td><td><select name="layout">
                 <option value="wugle" <?php if($layout == 'wugle'){ echo $selected;}?>>wugle </option>
				 <option value="46" <?php if($layout == '46'){ echo $selected;}?>>46 </option>
				  <option value="wubook" <?php if($layout == 'wubook'){ echo $selected;}?>>wubook </option>
				 <option value="zak" <?php if($layout == 'zak'){ echo $selected;}?>>zak </option>
				  <option value="wcdonald" <?php if($layout == 'wcdonald'){ echo $selected;}?>>wcdonald </option>
				 <option value="serious" <?php if($layout == 'serious'){ echo $selected;}?>>serious </option>
                
                </select></td>
                </tr>
                <tr><td><?php _e("Wborcss: " ); ?></td><td><input type="radio" name="wborcss" value="false"  checked="checked"> False</td></tr>
                <tr><td><?php _e("Horizontal: " ); ?></td><td><input type="radio" name="horizontal" value="false" <?php if($horizontal != 'true'){echo $checked;}?>> False
                <input type="radio" name="horizontal" value="true" <?php if($horizontal == 'true'){echo $checked;}?>>True</td></tr>
                <tr><td><?php _e("Minimal: " ); ?></td><td><input type="radio" name="minimal" value="false" <?php if($minimal != 'true'){echo $checked;}?> > False
                <input type="radio" name="minimal" value="true" <?php if($minimal == 'true'){echo $checked;}?>>True</td></tr> <tr><td colspan="2">
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options') ?>" />
				</p></td></tr></table>
		  </form>
		</div>
	<?php echo '</p>';
  echo '</div>';

}
?>
