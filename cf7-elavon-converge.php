<?php
/**
 * Plugin Name: Evalon Converge Payment CF7 Form
 * Plugin URL: 
 * Description:  This plugin will integrate Elavon Converge payment gateway for making your payments through Contact Form 7. It is a modified fork of the "Contact Form 7 - Elavon Converge" plugin by ZealousWeb Technologies.
 * Version: 1.1
 * Author: Anonymous
 * Author URI: 
 * Developer: Anonymous
 * Text Domain: contact-form-7-extension
 * Domain Path: /languages
 * 
 * Copyright: Forked from the GPLv3 WordPress plugin "Contact Form 7 - Elavon Converge" © 2009-2015 ZealousWeb Technologies.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Register the [elavon] shortcode for payment response in emails
 *
 * It will allow you to pass values in new tab 'elavon' like 
 * Test API/Secret key, Test Publishable key, Live API/Secret key, Live Publishable key, API mode, Currency, Item description, Item amount, Item quantity
 *
 * @access      public
 * @since       1.0 
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

require_once (dirname(__FILE__) . '/cf7-elavon-converge-update.php');
require_once (dirname(__FILE__) . '/cf7-elavon-converge.php');

//require_once (dirname(__FILE__) . '/assets/TCPDF/tcpdf.php');

/**
  * Deactivate plugin on deactivation of Contact Form 7
  */ 
register_deactivation_hook(WP_PLUGIN_DIR.'/contact-form-7/wp-contact-form-7.php', 'elavon_contact_form_7_deactivate' );
function elavon_contact_form_7_deactivate()
{
	deactivate_plugins(WP_PLUGIN_DIR . '/contact-form-7-Elavon-converge-payment-gateway/contact-form-7-elavon-converge.php');
	wp_die( __( '<b>Warning</b> : Deactivating Contact Form 7 will deactivate "Contact Form 7 - elavon Extension" plugin automatically.', 'contact-form-7' ) );
}

/** 
  * Create table 'cf7elavon_extension' on plugin activation 
  **/
register_activation_hook (__FILE__, 'wpcf7_elavon_activation_check');
function wpcf7_elavon_activation_check()
{	
	//Check if Contact Form 7 is active and add table to database for elavon extension
    if ( !in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        wp_die( __( '<b>Warning</b> : Install/Activate Contact Form 7 to activate "Contact Form 7 - elavon Extension" plugin', 'contact-form-7' ) );
    } 
    else {
    	global $wpdb;
		$table_name = $wpdb->prefix . "cf7elavon_extension";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    		$sql = "CREATE TABLE $table_name (
    				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			      	`form_id` INT(11) NOT NULL,			      	
			      	`field_values` TEXT NOT NULL,
			      	`payment_details` TEXT NOT NULL,
			      	`submit_time` INT(11) NOT NULL,
			      	`user` VARCHAR(255) NOT NULL,
			      	`ip` VARCHAR(255) NOT NULL,
			      	`token` VARCHAR(255) NOT NULL,
			      	`status` TINYINT NOT NULL DEFAULT '0',
			      	`unsubscribe` TINYINT NOT NULL DEFAULT '0',
			      	PRIMARY KEY (`id`)
				) DEFAULT COLLATE=utf8_general_ci";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);			
		}
	}	
}


require_once (dirname(__FILE__) . '/cf7-elavon-converge-payment-form.php');
require_once (dirname(__FILE__) . '/cf7-elavon-converge-settings.php');


/**
  * Add Script to Admin Footer
  */

if(isset($_GET['page']) && $_GET['page']  == 'elavon-extension-payments'){
	add_action( 'admin_footer', 'wpcf7_elavon_extension_action_includes' ); 
}
function wpcf7_elavon_extension_action_includes() { 
	/* Style */
	wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'elavon_extension_style',plugins_url('/css/elavon-extension.css', __FILE__));
	wp_enqueue_style( 'jquery-ui', 'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
	wp_enqueue_style( 'fontawesome'); 
	/* Script  */
	wp_enqueue_script( 'jquery-ui','http://code.jquery.com/ui/1.11.4/jquery-ui.js');
}


/**
  * Add Script to Admin Footer
  */
add_action( 'admin_footer', 'wpcf7_elavon_back_action_includes' ); 
function wpcf7_elavon_back_action_includes() { 
	wp_enqueue_style( 'elavon-extension_style',plugins_url('/css/elavon-extension.css', __FILE__));
	//wp_enqueue_script( 'paypal_extension_script',plugins_url('/js/scripts.js', __FILE__));
	wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'fontawesome');

	?>
	<script>
		jQuery(document).ready(function(){

			if (jQuery(".elavon-settings input[name='use_elavon']").is(':checked')) {
				jQuery(".elavon-settings input[name='amounts']").attr('required','required');
				// Add code 20/05/2016  
				jQuery(".elavon-settings input[name='transaction_type_elavon']").attr('required','required');
				jQuery(".elavon-settings input[name='merchant_id_elavon']").attr('required','required');
				jQuery(".elavon-settings input[name='user_id_elavon']").attr('required','required');
				jQuery(".elavon-settings input[name='pin_elavon']").attr('required','required');
			}
			jQuery('#wpcf7-mail fieldset legend').append('<span class="mailtag code used">[elavon]</span>');
			jQuery(".elavon-settings input[name='apimodes']").change(function() {
				if (jQuery(this).prop('checked')) {
					jQuery(".elavon-settings input[name='merchant_id_elavon']").val('');
					jQuery(".elavon-settings input[name='user_id_elavon']").val('');
					jQuery(".elavon-settings input[name='pin_elavon']").val('');	
				}else{
					jQuery(".elavon-settings input[name='merchant_id_elavon']").val('');
					jQuery(".elavon-settings input[name='user_id_elavon']").val('');
					jQuery(".elavon-settings input[name='pin_elavon']").val('');
				}
			});
			jQuery(".elavon-settings input[name='use_elavon']").change(function() {
				if (jQuery(this).prop('checked')) {
					jQuery(".elavon-settings input[name='amounts']").attr('required','required');
					jQuery(".elavon-settings input[name='merchant_id_elavon']").attr('required','required');
					jQuery(".elavon-settings input[name='user_id_elavon']").attr('required','required');
					jQuery(".elavon-settings input[name='pin_elavon']").attr('required','required');

				}else{
					jQuery(".elavon-settings input[name='amounts']").removeAttr('required');
					jQuery(".elavon-settings input[name='merchant_id_elavon']").removeAttr('required');
					jQuery(".elavon-settings input[name='user_id_elavon']").removeAttr('required');
					jQuery(".elavon-settings input[name='pin_elavon']").removeAttr('required');
				}
			});
		});
	</script>
<?php
}

add_action( 'wp_footer', 'wpcf7_elavon_front_action_includes' ); 
function wpcf7_elavon_front_action_includes() { 
	wp_enqueue_style( 'elavon_extension_style',plugins_url('/css/elavon-extension.css', __FILE__));
}
?>
