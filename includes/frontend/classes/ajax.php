<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXCPFC_ajax
{

	/*
	* MXCPFC_ajax
	*/
	public function __construct()
	{
	}

	/*
	* Registration of styles and scripts
	*/
	public static function mxcpfc_register_ajax()
	{

		add_action('wp_ajax_mxcpfc_set_meta_payment_confirm', array('MXCPFC_ajax', 'payment_confirm_prepare'), 10, 1);
	}

	public static function payment_confirm_prepare()
	{

		// Checked POST nonce is not empty
		if (empty($_POST['nonce'])) wp_die('0');

		// Checked or nonce match
		if (wp_verify_nonce($_POST['nonce'], 'nonce_payment_confirm')) {

			self::payment_confirm($_POST);
		}

		wp_die();
	}

	public static function payment_confirm($_post)
	{

		add_filter('wp_mail_content_type', array('MXCPFC_ajax', 'set_html_content_type'));

		$message = self::email_message_to_customer($_post);

		$company_team = self::get_payment_options()['company_name'];

		$noreply_email = self::get_payment_options()['noreply_email'];

		$headers = 'From: ' . $company_team . ' <' . $noreply_email . '>' . "\r\n";

		$customer_email = sanitize_email($_post['customer_email']);

		wp_mail($customer_email, 'Bill payment confirm', $message, $headers);

		// remove filter
		remove_filter('wp_mail_content_type', array('MXCPFC_ajax', 'set_html_content_type'));

		// report email

		// sanitize data
		$customer_name = sanitize_text_field($_post['customer_name']);

		$bill_amount = sanitize_text_field($_post['bill_amount']);

		$currency = sanitize_text_field($_post['currency']);

		$offer_type = sanitize_text_field($_post['offer_type']);

		$message2 = 'User ' . $customer_name . ' has paid ' . $bill_amount . $currency . ' for ' . $offer_type . ' on ' . get_home_url() . ' website.' . "\r\n";

		$message2 .= 'Check, please, your Stripe/Bank account.' . "\r\n";

		$owner_email = sanitize_email($_post['owner_email']);

		wp_mail($owner_email, 'Report. Bill payment confirm', $message2, $headers);

		$data = 'confirm';

		$data = sanitize_key($data);

		update_post_meta($_post['post_id'], '_meta_bill_confirm', $data);

		echo $data;
	}

	public static function set_html_content_type()
	{
		return "text/html";
	}

	public static function email_message_to_customer($_post)
	{

		// sanitize data
		$post_id = sanitize_text_field($_post['post_id']);

		$bill_amount = sanitize_text_field($_post['bill_amount']);

		$currency = sanitize_text_field($_post['currency']);

		$date_paid = sanitize_text_field($_post['date_paid']);

		$offer_type = sanitize_text_field($_post['offer_type']);

		$payment_options = get_option('_mx_create_paymetn_options');

		$unserialize_options = maybe_unserialize($payment_options);

		$message = $unserialize_options['message_for_client'];

		return $message;
	}

	public static function get_payment_options()
	{
		$payment_options = get_option('_mx_create_paymetn_options');

		if ($payment_options) {

			$unserialize_options = maybe_unserialize($payment_options);

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
			'invalid_request_message' 	=> '',
			'noreply_email' 			=> ''
		);
	}
}
