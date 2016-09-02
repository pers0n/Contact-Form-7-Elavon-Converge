<?php
/* @access      public
 * @since       1.1
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/*===================== Contact Form 7 - elavon Extension ====================*/

/*================== elavon Payment Form - Frontend Section ==================*/

/**

** A base module for elavon express checkout form that allows to submit payment from Contact Form 7.

**/
session_start();
add_filter('wp_head', 'wpcf7_add_elavon_script', 10, 2);
function wpcf7_add_elavon_script(){	

?>

	<script type="text/javascript">   
		jQuery(document).ready(function() {
			jQuery('.wpcf7').each(function(index, element){	
				
				var data = {
					'action': 'enable_elavon_gateway',
					'form': jQuery(this).find('input[name=_wpcf7]').val()
				};
				var elements = jQuery(this);
				var $form = jQuery(this).find('form');

				jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {	
				if(response == 1){
					response = 'elavon';
					$form.append(jQuery('<input type="hidden" name="enable_getway"/>').val(response));	
				}							
				});

				jQuery(document).on('mailsent.wpcf7', function (e) {
					var enable_elavon = elements.find('input[name=enable_getway]').val();

					if(enable_elavon == 'elavon')
					{
						var data = {
							'action': 'elavon_payment_gateway',
							'form': $form.serializeArray()
						};
						jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(data) {
							jQuery(elements).html(data);
						});
					}			
				});	
			});	
		});	 
	</script> 
<?php }
/**
 * Initiate the script.
 * Calls the validation options on the comment form.
 */



function wpcf7_elavon_enable_payment_gateway() {
	$form_id = $_POST['form'];
	$enable = get_post_meta( $form_id, "_cf7elavon_use", true);
	echo $enable;
	wp_die();
}
add_action( 'wp_ajax_enable_elavon_gateway', 'wpcf7_elavon_enable_payment_gateway' );
add_action( 'wp_ajax_nopriv_enable_elavon_gateway', 'wpcf7_elavon_enable_payment_gateway' );


add_action( 'wp_ajax_elavon_payment_gateway', 'wpcf7_elavon_payment_gateway_form' );
add_action( 'wp_ajax_nopriv_elavon_payment_gateway', 'wpcf7_elavon_payment_gateway_form' );

function wpcf7_elavon_payment_gateway_form() {
	$form = $_POST['form'];
	foreach($form as $data){
		$formdata[$data['name']] = $data['value'];
	}

	if(isset($_POST['form']))
	{	
	$form_id = $formdata['_wpcf7'];

		$apimode = get_post_meta( $form_id, "_cf7elavon_modes", true);
		if($apimode == '1'){
			$url_field = 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo/processxml.do';	
		} else {
			$url_field = 'https://www.myvirtualmerchant.com/VirtualMerchant/processxml.do';
		}
		$buttonlabel = get_post_meta( $form_id, "_cf7elavon_button_label", true);
		$amount_field = get_post_meta( $form_id, "_cf7elavon_amounts", true);
		$returnURL = get_post_meta( $form_id, "_cf7elavon_return_url", true);
		
		$merchant_id_field = get_post_meta($form_id, "_cf7elavon_merchant_id", true);
		$user_id_field = get_post_meta($form_id, "_cf7elavon_user_id", true);
		$pin_field = get_post_meta($form_id, "_cf7elavon_pin_ela", true);
		$messasge_field = get_post_meta($form_id, "_cf7elavon_messages", true);
		$description_field = get_post_meta($form_id, "_cf7elavon_description", true); 
		$salestax_field = get_post_meta($form_id, "_cf7elavon_salestax", true); 
		$companyname_field = get_post_meta( $form_id, "_cf7elavon_company", true);	
		$address_field = get_post_meta($form_id, "_cf7elavon_address", true);
		$city_field = get_post_meta($form_id, "_cf7elavon_city", true);
		$state_field = get_post_meta($form_id, "_cf7elavon_state", true);
		$country_field = get_post_meta($form_id, "_cf7elavon_country", true);
		$zip_code_field = get_post_meta($form_id, "_cf7elavon_zip_code", true);
		$phone_field = get_post_meta($form_id, "_cf7elavon_phone", true);
		$email_field = get_post_meta($form_id, "_cf7elavon_email", true);

		if(isset($amount_field) && !empty($amount_field)){
			$amount = $formdata[$amount_field];
		}
		
		// Add code 20/05/2016 
		if(isset($url_field) && !empty($url_field)){
			$url = $url_field;
		}
		if(isset($merchant_id_field) && !empty($merchant_id_field)){
			$merchant_id = $merchant_id_field;
		}
		if(isset($user_id_field) && !empty($user_id_field)){
			$user_id = $user_id_field;
		}
		if(isset($pin_field) && !empty($pin_field)){
			$pin = $pin_field;	
		}
		if(isset($description_field) && !empty($description_field)){
			$description = $formdata[$description_field];	
		}
		if(isset($salestax_field) && !empty($salestax_field)){
			$salestax = $salestax_field;	
		}

		if(isset($companyname_field) && !empty($companyname_field)){
			$companyname = $formdata[$companyname_field];
		}		
		if(isset($address_field) && !empty($address_field)){
			$address = $formdata[$address_field];
		}
		if(isset($city_field) && !empty($city_field)){
			$city = $formdata[$city_field];
		}
		if(isset($state_field) && !empty($state_field)){
			$state = $formdata[$state_field];
		}
		if(isset($country_field) && !empty($country_field)){
			$countrys = $formdata[$country_field];
		}
		if(isset($zip_code_field) && !empty($zip_code_field)){
			$zip_code = $formdata[$zip_code_field];
		}
		if(isset($phone_field) && !empty($phone_field)){
			$phone = $formdata[$phone_field];
		}
		if(isset($email_field) && !empty($email_field)){
			$email = $formdata[$email_field];
		}

		if(($amount == "") || (!preg_replace("/[^0-9]/", "",$amount)))
		{
			echo '<span class="warning">Warning : You have not configured Amount field properly.</span><br><br>';
		} 
?>
	  	<script type="text/javascript">
		    //elavon.setPublishableKey('<?php echo $publishkey;?>');	
		    var returnurl = '<?php echo $returnURL;?>';
			jQuery(function($) {
				jQuery('#elavon_button').click(function(event) {	
					var seralizedata = jQuery('.elavon-form #elavon-payment-form').serialize();
					jQuery('#elavon-payment-form input[name="cardholdername"]').prop('disabled', 'disabled');
					jQuery('#elavon-payment-form input[name="card_number"]').prop('disabled', 'disabled');
					jQuery('#elavon-payment-form input[name="exp_month"]').prop('disabled', 'disabled');
					jQuery('#elavon-payment-form input[name="exp_year"]').prop('disabled', 'disabled');
					jQuery('#elavon-payment-form input[name="cvv_number"]').prop('disabled', 'disabled');
					jQuery(".elavon-loading").css('display','inline-block');
	  	   			
	  	   			var data1 = {
						'action': 'elavon_seralize_data',
						'seralizedata' : seralizedata
					};
					jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data1, function(result) {
						jQuery(".elavon-loading").css('display','none');
						var form_id = '<?php echo $form_id; ?>';
						var arr = [];
						var items = result.data.map(function (item) {		
					        arr.push({
					            tag: item.tag, 
					            value:  item.value
					        });
						});	
						
						jQuery.each(arr, function (index, data) {
						   if(data.tag == 'ERRORMESSAGE'){	
    							jQuery('.elavon-response-success').hide();
    							jQuery('.elavon-response-error').show();
    							jQuery('.elavon-response-error').text(data.value);
    							jQuery('#elavon-payment-form input[name="cardholdername"]').removeAttr('disabled');
								jQuery('#elavon-payment-form input[name="card_number"]').removeAttr('disabled');
								jQuery('#elavon-payment-form input[name="exp_month"]').removeAttr('disabled');
								jQuery('#elavon-payment-form input[name="exp_year"]').removeAttr('disabled');
								jQuery('#elavon-payment-form input[name="cvv_number"]').removeAttr('disabled');

    						}else{
    							if((data.tag == 'SSL_RESULT_MESSAGE') && (data.value == 'APPROVED' || data.value == 'APPROVAL')){//fixed
    							//if(data.tag == 'SSL_RESULT_MESSAGE') {//fixed
    								
    								var success_messasge = '<?php echo $messasge_field; ?>';
									jQuery('.elavon-response-error').hide();
									jQuery('.elavon-response-success').show();
									jQuery('#elavon-payment-form #elavon_button').prop('disabled', 'disabled'); 
									
	    							if(success_messasge != ''){
	    								var success_messasge = success_messasge;
	    							}else{
	    								var success_messasge = 'Your payment has been made successfully.';
	    							}

	    							jQuery('.elavon-response-success').text(success_messasge);
	    					
    								var form_id = '<?php echo $form_id; ?>';
    								var data = {
											'action': 'elavon_sendEmailToUser',
											'paymentdetails': arr,
											'form_id' : form_id
									};
									jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(result) {
										if(result == 0){
											if(returnurl != ""){
												jQuery("#elavon_button").html('Redirecting....');											
												setTimeout(function(){
											     window.location = returnurl;
											   },2000); 
											}else{
												jQuery(".elavon-loading").css('display','none');	
											}
										}else{
											jQuery(".elavon-loading").css('display','none');
										}
									});
    							}
    						}
						});
					});
	  	   		});
		    });    
	    </script> 
		<div class="elavon-form">
			<form id="elavon-payment-form" action="#" method="POST">			
				<p>Card holder name
					<span class="elavon-cardholdername"><input type="text" placeholder="Name"  name="cardholdername" size="20"></span>
				</p>
				<p>Card Number (required)
					<span class="elavon-cardnumber"><input type="text" placeholder="12345678999"  name="card_number" data-elavon="number" size="20"></span>
				</p>

				<p>Card Expiry Date (required)
					<span class="elavon-expires">
						<input type="text" placeholder="10" name="exp_month" data-elavon="exp-month" size="2" id="elavon-month">
						<input type="text" placeholder="2017" name="exp_year" data-elavon="exp-year"  size="4" id="elavon-year">
					</span>
				</p>

				<p>Card CVV (required)
					<span class="elavon-cvv">
						<input type="text" placeholder="123" name="cvv_number" data-elavon="cvc" size="4">
					</span>
				</p>
				<input type="hidden" name="form_id" value="<?php echo $form_id;?>">
				
				<?php if(isset($url) && !empty($url)){ ?>
					<input type="hidden" name="url" value="<?php echo $url;?>">
				<?php } ?>
					<input type="hidden" name="transaction_type" value="ccsale">
				<?php if(isset($merchant_id) && !empty($merchant_id)){ ?>
					<input type="hidden" name="merchant_id" value="<?php echo $merchant_id;?>">
				<?php } ?>
				<?php if(isset($user_id) && !empty($user_id)){ ?>
					<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
				<?php } ?>
				<?php if(isset($pin) && !empty($pin)){ ?>
					<input type="hidden" name="pin" value="<?php echo $pin;?>">
				<?php } ?>
				
				<?php if(isset($description) && !empty($description)){ ?>
					<input type="hidden" name="description" value="<?php echo $description;?>">
				<?php } ?>
				<?php if(isset($salestax) && !empty($salestax)){ ?>
					<input type="hidden" name="salestax" value="<?php echo $salestax;?>">
				<?php } ?>
				<?php if(isset($companyname) && !empty($companyname)){ ?>
					<input type="hidden" name="companyname" value="<?php echo $companyname;?>">
				<?php } ?>
				<?php if(isset($address) && !empty($address)){ ?>
					<input type="hidden" name="address" value="<?php echo $address;?>">
				<?php }else{ ?>
					<input type="hidden" name="address" value="address">
				<?php } ?>
				<?php if(isset($city) && !empty($city)){ ?>
					<input type="hidden" name="city" value="<?php echo $city;?>">
				<?php } ?>
				<?php if(isset($state) && !empty($state)){ ?>
					<input type="hidden" name="state" value="<?php echo $state;?>">
				<?php } ?>
				<?php if(isset($countrys) && !empty($countrys)){ ?>
					<input type="hidden" name="country" value="<?php echo $countrys;?>">
				<?php } ?>
				<?php if(isset($zip_code) && !empty($zip_code)){?>
					<input type="hidden" name="zip_code" value="<?php echo $zip_code;?>">

				<?php }else{ ?>
					<input type="hidden" name="zip_code" value="78003">
				<?php } ?>
				<?php if(isset($phone) && !empty($phone)){ ?>
					<input type="hidden" name="phone" value="<?php echo $phone;?>">
				<?php } ?>
				<?php if(isset($email) && !empty($email)){ ?>
					<input type="hidden" name="email" value="<?php echo $email;?>">
				<?php } ?>

				<?php if(isset($amount) && !empty($amount)){ ?>
					<input type="hidden" name="amount" value="<?php echo $amount;?>">
				<?php } ?>

				<button type="button" id="elavon_button"><?php echo (empty($buttonlabel)) ? 'Submit' : $buttonlabel;?></button>
				<span class="elavon-loading"></span>
			</form>
		</div>
		<div class="elavon-response-error"></div><div class="elavon-response-success"></div>

<?php
		wp_die(); 			
	}
}

add_action( 'wp_ajax_elavon_sendEmailToUser', 'wpcf7_get_elavon_sendEmailToUser' );
add_action( 'wp_ajax_nopriv_elavon_sendEmailToUser', 'wpcf7_get_elavon_sendEmailToUser' );

function wpcf7_get_elavon_sendEmailToUser(){
	foreach($_POST['paymentdetails'] as $data){
		$payment_details[$data['tag']] = $data['value'];
	}

	$form = $_POST['form_id'];
	$email = get_post_meta($form, '_mail', true);
	$email2 = get_post_meta($form, '_mail_2', true);
	
	global $wpdb;
		$tablename = $wpdb->prefix.'cf7elavon_extension';	
		$result = $wpdb->get_row("SELECT * FROM $tablename WHERE token LIKE '".$_SESSION['elavon_token']."'");	
		$field_value = $result->field_values;
		$payment_encode = json_encode($payment_details);
		$fields = json_decode($field_value);
	
		$wpdb->update( $tablename, array( 'payment_details' => $payment_encode), 
				array( 'id' => $result->id ), array( '%s' ), array( '%d' ) 
			);
	if($email2['active'] == 1){
		senmaildetails($email,$payment_details,$fields);
		senmaildetails($email2,$payment_details,$fields);	
	}else{
		
		senmaildetails($email,$payment_details,$fields);
	}
		session_write_close();
}	

function senmaildetails($email,$payment_details,$fields){
		$emailsubject = $email['subject'];
		$emailcontent = $email['body'];
		$recipient = $email['recipient'];
		$additional_headers = $email['additional_headers'];
		$sender = $email['sender'];
		$attachments = $email['attachments'];

		foreach($fields as $key=>$field){
			$attribute = '['.$key.']';
			if(is_array($field)){
				$field = implode(',',$field);
			}
			if(!empty($emailsubject)){
				$emailsubject = str_replace($attribute, $field, $emailsubject);
			}
			if(!empty($emailcontent)){
				$emailcontent = str_replace($attribute, $field, $emailcontent);
			}
			if(!empty($recipient)){
				$recipient = str_replace($attribute, $field, $recipient);
			}
			if(!empty($additional_headers)){
				$additional_headers = str_replace($attribute, $field, $additional_headers);
			}
			if(!empty($sender)){
				$sender = str_replace($attribute, $field, $sender);
			}
			if(!empty($attachments)){
				$attachments = str_replace($attribute, $field, $attachments);
			}				
		}
		
		if (strpos($emailcontent, '[elavon]') !== false) {
		    $elavondetails = "<br><b><u>Elavon Response Details:</u></b><br><br>";		
			$arr_payment_details = $payment_details;
			$select_key = array(
				'SSL_FIRST_NAME',
				'SSL_EMAIL', 
				'SSL_PHONE',
				'SSL_COMPANY',
				'SSL_CARD_NUMBER',
				'SSL_EXP_DATE',			
				'SSL_AVS_ADDRESS',
				'SSL_AVS_ZIP',
				'SSL_DESCRIPTION',
				'SSL_CITY',
				'SSL_STATE',
				'SSL_COUNTRY',
				'SSL_SALESTAX',
				'SSL_AMOUNT',
				'SSL_TXN_TIME');
			$payment_details = array_intersect_key($arr_payment_details, array_flip($select_key)); 

			if(is_array($payment_details)) {
				foreach($payment_details as $key=>$data){
					$key = str_replace("SSL_", "", $key);	
					$key = strtolower(str_replace("_", " ", $key));
					if(!empty($data)){
						$elavondetails .= ucwords($key).' - '.$data.'<br>';						
					}
				}
			} else {
				$elavondetails .= $payment_details;
			}
			$emailcontent = str_replace('[elavon]', $elavondetails, $emailcontent);
			$emailcontent = nl2br($emailcontent);
		}else{
			$emailcontent = nl2br($emailcontent);
		}
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = $additional_headers;
		$headers[] = 'From : '.$sender;
	
		if(isset($recipient) && !empty($recipient)){
			wp_mail( $recipient, $emailsubject, $emailcontent, $headers ); // removed attachment parameter from here
		}
}


add_action( 'wp_ajax_elavon_seralize_data', 'wpcf7_elavon_seralize_data_form' );
add_action( 'wp_ajax_nopriv_elavon_seralize_data', 'wpcf7_elavon_seralize_data_form' );

function wpcf7_elavon_seralize_data_form(){
	$form = $_POST['seralizedata'];

	parse_str($form, $unseralize_data);
	
	if(isset($unseralize_data['cardholdername']) && (!empty($unseralize_data['cardholdername']))){
		$ssl_cardholdername = $unseralize_data['cardholdername'];
	}else{
		$ssl_cardholdername = '';
	}
	if(isset($unseralize_data['card_number']) && (!empty($unseralize_data['card_number']))){
		$ssl_card_number = $unseralize_data['card_number'];
	}else{
		$ssl_card_number = '';
	}
	if(isset($unseralize_data['exp_month']) && (!empty($unseralize_data['exp_month']))){
		$exp_month = $unseralize_data['exp_month'];
			if(strlen($exp_month)==1)
			{
				$exp_month = '0'.$exp_month;
			}
	}else{
		$exp_month = '';
	}
	if(isset($unseralize_data['exp_year']) && (!empty($unseralize_data['exp_year']))){
		$exp_year = $unseralize_data['exp_year'];
		$exp_year = substr($exp_year, -2);
	}else{
		$exp_year = '';
	}
	$ssl_exp_date = $exp_month.$exp_year;

	if(isset($unseralize_data['cvv_number']) && (!empty($unseralize_data['cvv_number']))){
		$ssl_cvv_number = $unseralize_data['cvv_number'];
	}else{
		$ssl_cvv_number = '';
	}

	if(isset($unseralize_data['amount']) && (!empty($unseralize_data['amount']))){
		$ssl_amount = $unseralize_data['amount'];
	}else{
		$ssl_amount = '';
	}
	
	if(isset($unseralize_data['salestax']) && (!empty($unseralize_data['salestax']))){
		$ssl_salestax = $unseralize_data['salestax'];
	}else{
		$ssl_salestax = '';
	}
	if(isset($unseralize_data['description']) && (!empty($unseralize_data['description']))){
		$ssl_description = $unseralize_data['description'];
	}else{
		$ssl_description = '';
	}


	if(isset($unseralize_data['companyname']) && (!empty($unseralize_data['companyname']))){
		$ssl_companyname = $unseralize_data['companyname'];
	}else{
		$ssl_companyname = '';
	}

	if(isset($unseralize_data['address']) && (!empty($unseralize_data['address']))){
		$ssl_address = $unseralize_data['address'];
	}else{
		$ssl_address = '';
	}
	if(isset($unseralize_data['city']) && (!empty($unseralize_data['city']))){
		$ssl_city = $unseralize_data['city'];
	}else{
		$ssl_city = '';
	}
	if(isset($unseralize_data['state']) && (!empty($unseralize_data['state']))){
		$ssl_state = $unseralize_data['state'];
	}else{
		$ssl_state = '';
	}
	if(isset($unseralize_data['country']) && (!empty($unseralize_data['country']))){
		$ssl_country = $unseralize_data['country'];
	}else{
		$ssl_country = '';
	}
	if(isset($unseralize_data['zip_code']) && (!empty($unseralize_data['zip_code']))){
		$ssl_zip_code = $unseralize_data['zip_code'];
	}else{
		$ssl_zip_code = '';
	}
	if(isset($unseralize_data['phone']) && (!empty($unseralize_data['phone']))){
		$ssl_phone = $unseralize_data['phone'];
	}else{
		$ssl_phone = '';
	}
	if(isset($unseralize_data['email']) && (!empty($unseralize_data['email']))){
		$ssl_email = $unseralize_data['email'];
	}else{
		$ssl_email = '';
	}

	if(isset($unseralize_data['url']) && (!empty($unseralize_data['url']))){
		$ssl_url = $unseralize_data['url'];
	}else{
		$ssl_url = '';
	}

	if(isset($unseralize_data['transaction_type']) && (!empty($unseralize_data['transaction_type']))){
		$ssl_transaction_type = $unseralize_data['transaction_type'];
	}else{
		$ssl_transaction_type = '';
	}

	if(isset($unseralize_data['merchant_id']) && (!empty($unseralize_data['merchant_id']))){
		$ssl_merchant_id = $unseralize_data['merchant_id'];
	}else{
		$ssl_merchant_id = '';
	}

	if(isset($unseralize_data['user_id']) && (!empty($unseralize_data['user_id']))){
		$ssl_user_id = $unseralize_data['user_id'];
	}else{
		$ssl_user_id = '';
	}

	if(isset($unseralize_data['pin']) && (!empty($unseralize_data['pin']))){
		$ssl_pin = $unseralize_data['pin'];
	}else{
		$ssl_pin = '';
	}
	 $ip = (isset($_SERVER['X_FORWARDED_FOR'])) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

	$ssl_test_mode = 'false';//this must be false for real transactions to work, otherwise set it to true. TODO: make this a nicer option
	$ssl_cvv2cvc2_indicator = '1';

	$xmlreq = '<txn>
				<ssl_merchant_id>'.$ssl_merchant_id.'</ssl_merchant_id>
				<ssl_user_id>'.$ssl_user_id.'</ssl_user_id>
				<ssl_pin>'.$ssl_pin.'</ssl_pin>
				<ssl_test_mode>'.$ssl_test_mode.'</ssl_test_mode>
				<ssl_transaction_type>'.$ssl_transaction_type.'</ssl_transaction_type>	
				<ssl_exp_date>'.$ssl_exp_date.'</ssl_exp_date>
				<ssl_amount>'.$ssl_amount.'</ssl_amount>
				<ssl_salestax>'.$ssl_salestax.'</ssl_salestax>
				<ssl_cvv2cvc2_indicator>'.$ssl_cvv2cvc2_indicator.'</ssl_cvv2cvc2_indicator>
				<ssl_cvv2cvc2>'.$ssl_cvv_number.'</ssl_cvv2cvc2>
				<ssl_card_number>'.$ssl_card_number.'</ssl_card_number>
				<ssl_first_name>'.$ssl_cardholdername.'</ssl_first_name>
				<ssl_company>'.$ssl_companyname.'</ssl_company>
				<ssl_avs_address>'.$ssl_address.'</ssl_avs_address>
				<ssl_description>'.$ssl_description.'</ssl_description>
				<ssl_address2></ssl_address2>
				<ssl_city>'.$ssl_city.'</ssl_city>
				<ssl_state>'.$ssl_state.'</ssl_state>
				<ssl_avs_zip>'.$ssl_zip_code.'</ssl_avs_zip>
				<ssl_country>'.$ssl_country.'</ssl_country>
				<ssl_email>'.$ssl_email.'</ssl_email>
				<ssl_phone>'.$ssl_phone.'</ssl_phone>
				<ssl_cardholder_ip>'.$ip.'</ssl_cardholder_ip>
				</txn>';

	$response = wp_safe_remote_post( $ssl_url, array(
		'redirection' => 0,
		'method'     => 'POST',
		'body'       => array( "xmldata" => $xmlreq ),
		'timeout'    => 60,
		'sslverify'  => true,
		'user-agent' => "PHP " . PHP_VERSION,
		'headers'    => array(
		'referer' => site_url(),
		),
	) );

		$p = xml_parser_create();
		xml_parse_into_struct($p, $response['body'], $vals, $index);
		xml_parser_free($p);

	wp_send_json_success($vals);	
}


/**

  * This function skips mail send by Contact Form 7.

  */

add_action('wpcf7_before_send_mail', 'wpcf7_elavon_before_send_mail');
function wpcf7_elavon_before_send_mail($WPCF7_form) {
	$enable = get_post_meta( $WPCF7_form->id(), "_cf7elavon_use", true);
	if($enable == '1'){
		$WPCF7_form->skip_mail = true;
	}
}

/* Extra field validation */

add_filter( 'wpcf7_validate_text', 'wpcf7_text_custom_validation_message', 20, 2 );
add_filter( 'wpcf7_validate_text*', 'wpcf7_text_custom_validation_message', 20, 2 );
 
function wpcf7_text_custom_validation_message( $result, $tag ) {
  
	$cmtagobj = new WPCF7_Shortcode( $tag );
	$name = $cmtagobj->name;
	$post_id = sanitize_text_field($_POST['_wpcf7']);
	$amount_field = trim(get_post_meta( $post_id, "_cf7elavon_amounts", true));
    if ( $amount_field == $name) {	
       if(isset($_POST[$amount_field]) && $_POST[$amount_field] == ''){
       		$result->invalidate( $cmtagobj, "The field is required." );	
       }else{
       		$expr = '/^[0-9.]+$/i';
       		$preg_amount = isset( $_POST[$amount_field] ) ? preg_match($expr, $_POST[$amount_field]):'';

       		if($preg_amount == 0 ) {

        		$result->invalidate( $cmtagobj, "You have not configured Amount field properly." );
       	 	}
       }
    } 
    return $result;
}
	
/**

  * This function saves Contact Form 7 data to database.

  */
add_action('wpcf7_mail_sent', 'wpcf7_elavon_after_send_mail');		
function wpcf7_elavon_after_send_mail($WPCF7_form) {	
	$enable = get_post_meta( $WPCF7_form->id(), "_cf7elavon_use", true);
	if($enable == '1'){
		$WPCF7_form->additional_settings = "on_sent_ok:  \"document.getElementById('contactform').style.display = 'none';\"";		
		global $wpdb;
		$submission = WPCF7_Submission::get_instance();
	    if ($submission) {
	        $data = array();
	       	$data['posted_data'] = $submission->get_posted_data();  
	        $date = current_time("Y-m-d H:i:s");
	        $form_id = $data['posted_data']['_wpcf7'];
	        
	        foreach($data['posted_data'] as $key=>$values){        	
	        	if (!preg_match('/^_(.*)$/', $key) ) {
	        		$fields[$key] = $values;
	        	}        	
	        }
	        $field_values = json_encode($fields);
	     	$submit_time = strtotime($date);  
	        $user = 'Guest';
	        if (function_exists('is_user_logged_in') && is_user_logged_in()) {
	            $current_user = wp_get_current_user(); // WP_User
	            $user = $current_user->user_login;
	        }                   
	        $user = $user;
	        $ip = (isset($_SERVER['X_FORWARDED_FOR'])) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	    }
		$_SESSION['elavon_token'] = md5(uniqid(rand(), true));
		$wpdb->insert( $wpdb->prefix . "cf7elavon_extension", array( 'id' => NULL, 
				'form_id' => $form_id, 
				'field_values' => $field_values, 
				'payment_details' => '',
				'submit_time' => $submit_time,
				'token' => $_SESSION['elavon_token'],
				'user' => $user,
				'ip' => $ip), array( '%d', '%d', '%s', '%s', '%d', '%s', '%s', '%s' ) );	
	}
}



