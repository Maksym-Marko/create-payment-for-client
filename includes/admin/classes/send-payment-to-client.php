<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Main page Model
 */
class MXCPFCSendPaymentToClient extends MXCPFC_Model
{

	/*
	* Observe function
	*/
	public static function mxcpfc_wp_ajax()
	{

		add_action('wp_ajax_mxcpfc_send_payment_to_client', array('MXCPFCSendPaymentToClient', 'prepare_payment_sending'), 10, 1);
	}

	/*
	* Prepare for data updates
	*/
	public static function prepare_payment_sending()
	{

		// Checked POST nonce is not empty
		if (empty($_POST['nonce'])) wp_die('0');

		// Checked or nonce match
		if (wp_verify_nonce($_POST['nonce'], 'meta_sent_to_client_action')) {

			$message = $_POST['message'];
			$message = wp_kses($message, 'default');

			$email = sanitize_email($_POST['email']);
			$post_id = sanitize_key($_POST['post_id']);

			// progress
			self::progress_payment_sending($message, $email, $post_id);
		}

		wp_die();
	}

	// Send email
	public static function progress_payment_sending($message, $email, $post_id)
	{

		$message = str_replace('\"', '"', $message);

		$_from = wp_get_current_user()->data->user_email;

		$company_team = self::get_payment_options()['company_name'];

		$noreply_email = self::get_payment_options()['noreply_email'];

		$headers = 'From: ' . $company_team . ' <' . $noreply_email . '>' . "\r\n";

		wp_mail($email, 'Ordering and Payment', $message, $headers);

		// save metabox data of sendig
		$data = 'true';

		$data = sanitize_key($data);

		update_post_meta($post_id, '_meta_sent_to_client_data', $data);

		echo 'sent';
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
