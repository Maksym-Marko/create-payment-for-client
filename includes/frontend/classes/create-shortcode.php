<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFC_Create_Shortcode
{

	/*
	* MXCPFC_Create_Shortcode
	*/
	public function __construct()
	{

	}

	/*
	* Registration of shortcodes
	*/
	public static function mxcpfc_register_shortcodes()
	{
		// create payment page
		add_shortcode( 'mxcpfc_payment_confirm_page', array( 'MXCPFC_Create_Shortcode', 'payment_confirm_page' ) );

		// donation page
		add_shortcode( 'mxcpfc_payment_donation_page', array( 'MXCPFC_Create_Shortcode', 'payment_donation_page' ) );

		// confirm donation page
		add_shortcode( 'mxcpfc_payment_confirm_donation_page', array( 'MXCPFC_Create_Shortcode', 'payment_confirm_donation_page' ) );

	}

	// create payment page
	public static function payment_confirm_page()
	{

		if( is_admin() ) return;

		global $wpdb;

		$valid_request = false;

		$current_url = home_url( add_query_arg( null, null ));

		if( ! isset( $_GET['payment_request'] ) ) {

			return 'invalid request.';

		}

		$payment_request = $_GET['payment_request'];

		// if valid request
		if( $payment_request !== NULL ) {

			$valid_request = true;

		}

		$valid_meta = false;

		// get meta data
		$row_meta = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE meta_value = '" . $payment_request . "'" );

		// if valid valid meta
		if( $row_meta !== NULL ) {

			$valid_meta = true;

		}

		if( $row_meta === NULL ) {
			
			return 'invalid Get request.';
			
		}

		// customer information
		$_get_customer_info = get_post( $row_meta->post_id );

			// create info array
			$custom_info = array(
				'customer_name' => $_get_customer_info->post_title,
				'offer' 		=> get_post_meta( $row_meta->post_id, '_meta_offer_data', true ),
				'invoice_number' 		=> get_post_meta( $row_meta->post_id, '_meta_invoice_number_data', true ),
				'customer_email' 		=> get_post_meta( $row_meta->post_id, '_meta_customer_email_data', true ),
				'url_hash' 		=> get_post_meta( $row_meta->post_id, '_meta_url_hash_data', true ),
				'url_to_client' 		=> get_post_meta( $row_meta->post_id, '_meta_url_to_client_data', true ),
				'amount' 		=> get_post_meta( $row_meta->post_id, '_meta_of_amount_data', true ),
				'currency' 		=> get_post_meta( $row_meta->post_id, '_meta_currency_data', true ),
				
			);

		// options
		$options = array(

			// 'current_url' 		=> $current_url,
			'payment_request' 	=> $payment_request,
			'row_meta'			=> $row_meta,
			'valid_meta' 		=> $valid_meta,
			'valid_request' 	=> $valid_request,
			'custom_info' 		=> $custom_info

		);

		// output
		ob_start();

		if( $options['valid_meta'] && $options['valid_request'] ) :

			mxcpfc_include_component( 'create_payment/welcome-template', $options );

		else : ?>

			<?php

				$text = self::get_payment_options()['invalid_request_message'];

				$thanks_text = str_replace( array( "\n", "\n\r" ), '<br />', $text );

				echo $thanks_text;

			?>

		<?php endif; ?>

		<?php return ob_get_clean();

	}	

	public static function get_payment_options()
	{
		$payment_options = get_option( '_mx_create_paymetn_options' );

		if( $payment_options ) {

			$unserialize_options = maybe_unserialize( $payment_options );

			return $unserialize_options;

		}

		return array(
			'publishable_key' 			=> '',
			'secret_key' 				=> '',
			'process_page_url' 			=> '',
			'company_email' 			=> '',
			'department_company' 		=> '',
			'company_name' 				=> '',
			'message_for_client' 		=> '',
			'company_address' 			=> '',
			'company_phone' 			=> '',
			'thank_you_message' 		=> '',
			'invalid_request_message' 	=> ''
		);
	}

	// donation page
	public static function payment_confirm_donation_page()
	{

		if( is_admin() ) return;

		ob_start(); 

		var_dump($_POST);

		if(
			! isset( $_POST['customer_email'] ) ||
			! isset( $_POST['mx_bill_amount'] ) ||
			! isset( $_POST['mx_currency'] ) 	||
			! isset( $_POST['invoice_number'] )	||
			! isset( $_POST['customer_name'] )	
			
		) {
			echo 'Try one more time! ';
			echo '<a href="/donation/">Back to donation page</a>';
			return;
		} 

			// create info array
			$custom_info = array(
				'customer_name'			=> $_POST['customer_name'],
				'offer' 				=> 'Donate',
				'invoice_number' 		=> $_POST['invoice_number'],
				'customer_email' 		=> $_POST['customer_email'],
				'url_hash' 		=> 'hash',
				'amount' 		=> $_POST['mx_bill_amount'],
				'currency' 		=> $_POST['mx_currency'],
				
			);

		// options
		$options = array(

			'custom_info' 		=> $custom_info

		); ?>

		<?php if( $options ) : ?>

			<!-- <h1>Valid request and meta</h1> -->

			<?php self::payment_window_template( $options ); ?>

		<?php else : ?>

			<?php

				$text = self::get_payment_options()['invalid_request_message'];

				$thanks_text = str_replace( array( "\n", "\n\r" ), '<br />', $text );

				echo $thanks_text;

			?>

		<?php endif; ?>

		<?php return ob_get_clean();

	}

	// donation page
	public static function payment_donation_page()
	{

		if( is_admin() ) return;

		ob_start(); ?>

		<form class="mx-make-donation-button-wrap" action="/donate-confirmation/" method="POST">
			<input type="hidden" name="invoice_number" value="<?php echo time(); ?>">

			<ul>
				
				<li>
                    <div>
                    	<label for="customer_name">Your Name</label>
                    	<div>
                    		<input type="text" id="customer_name" name="customer_name" value="" required />
                    	</div>
                    </div>
            	</li>
				<li>
                    <div>
                    	<label for="customer_email">Email Address</label>
                    	<div>
                    		<input type="email" id="customer_email" name="customer_email" value="" required />
                    	</div>
                    </div>
            	</li>
				<li>
                    <div>
                    	<label for="mx_bill_amount">Amount</label>
                    	<div>
                    		<input type="number" id="mx_bill_amount" name="mx_bill_amount" value="100" required />
                    	</div>
                    </div>
            	</li>

				<li>
                    <div>
                    	<label for="mx_currency">Currency</label>
                    	<div>
                    		<select name="mx_currency" id="mx_currency">
								<option value="GBP">GBP</option>
								<option value="USD">USD</option>
								<option value="EUR">EUR</option>
							</select>
                    	</div>
                    </div>
            	</li>
			</ul>
			

			<button class="mx-make-donation mx-buttons">Donate</button>
		</form>	

		<?php return ob_get_clean();

	}

}