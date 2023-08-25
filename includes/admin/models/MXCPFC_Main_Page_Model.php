<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Main page Model
 */
class MXCPFC_Main_Page_Model extends MXCPFC_Model
{

	/*
	* Observe function
	*/
	public static function mxcpfc_wp_ajax()
	{

		add_action('wp_ajax_mxcpfc_options_update', array('MXCPFC_Main_Page_Model', 'mxcpfc_prepare_options_update'));
	}

	/*
	* Get options
	*/
	public function mxcpfc_get_options()
	{

		$payment_options = get_option('_mx_create_paymetn_options');

		if ($payment_options) {

			$unserialize_options = maybe_unserialize($payment_options);

			return $unserialize_options;
		}

		return array(
			'publishable_key' 		=> '',
			'secret_key' 			=> '',
			'process_page_url' 		=> '',
			'company_email'			=> '',
			'noreply_email' 		=> '',
			'department_company' 	=> '',
			'company_name' 			=> '',
			'message_for_client' 	=> '',
			'thank_you_message' 	=> ''
		);
	}

	public static function mxcpfc_prepare_options_update()
	{

		// Checked POST nonce is not empty
		if (empty($_POST['nonce'])) wp_die('0');

		// Checked or nonce match
		if (wp_verify_nonce($_POST['nonce'], 'mxcpfc_nonce_request')) {

			// Add map
			self::_mxcpfc_options_update($_POST);
		}

		wp_die();
	}

	public static function _mxcpfc_options_update($_post)
	{


		$mxcpfc_publishable_key = sanitize_text_field($_post['mxcpfc_publishable_key']);

		$mxcpfc_secret_key = sanitize_text_field($_post['mxcpfc_secret_key']);

		$mxcpfc_process_page_url = sanitize_text_field($_post['mxcpfc_process_page_url']);

		$mxcpfc_contact_us_page = sanitize_text_field($_post['mxcpfc_contact_us_page']);

		$mxcpfc_company_email = sanitize_email($_post['mxcpfc_company_email']);

		$mxcpfc_noreply_email = sanitize_email($_post['mxcpfc_noreply_email']);

		$mxcpfc_department_company = sanitize_text_field($_post['mxcpfc_department_company']);

		$mxcpfc_company_name = sanitize_text_field($_post['mxcpfc_company_name']);

		$mxcpfc_message_for_client = wp_kses($_post['mxcpfc_message_for_client'], 'default');

		$mxcpfc_company_address = sanitize_text_field($_post['mxcpfc_company_address']);

		$mxcpfc_company_phone = sanitize_text_field($_post['mxcpfc_company_phone']);

		$mxcpfc_thank_you_message = wp_kses($_post['mxcpfc_thank_you_message'], 'default');

		$mxcpfc_invalid_request_message = wp_kses($_post['mxcpfc_invalid_request_message'], 'default');

		$mxcpfc_enable_iban = sanitize_text_field($_post['mxcpfc_enable_iban']);

		if (
			$mxcpfc_publishable_key == '' ||
			$mxcpfc_secret_key == '' ||
			$mxcpfc_process_page_url == '' ||
			$mxcpfc_contact_us_page == '' ||
			$mxcpfc_company_email == '' ||
			$mxcpfc_department_company == '' ||
			$mxcpfc_company_name == '' ||
			$mxcpfc_message_for_client == '' ||
			$mxcpfc_company_address == '' ||
			$mxcpfc_company_phone == '' ||
			$mxcpfc_thank_you_message == '' ||
			$mxcpfc_invalid_request_message == '' ||
			$mxcpfc_noreply_email == ''
		) {

			echo 'You have to fill out all fields!';
		} else {

			$serialize_potion = array(
				'publishable_key' 			=> $mxcpfc_publishable_key,
				'secret_key' 				=> $mxcpfc_secret_key,
				'process_page_url' 			=> $mxcpfc_process_page_url,
				'contact_us_page' 			=> $mxcpfc_contact_us_page,
				'company_email' 			=> $mxcpfc_company_email,
				'department_company' 		=> $mxcpfc_department_company,
				'company_name' 				=> $mxcpfc_company_name,
				'message_for_client' 		=> $mxcpfc_message_for_client,
				'company_address' 			=> $mxcpfc_company_address,
				'company_phone' 			=> $mxcpfc_company_phone,
				'thank_you_message' 		=> $mxcpfc_thank_you_message,
				'invalid_request_message' 	=> $mxcpfc_invalid_request_message,
				'noreply_email' 			=> $mxcpfc_noreply_email,
				'enable_iban' 				=> $mxcpfc_enable_iban
			);

			$payment_options = serialize($serialize_potion);

			$update_op = update_option('_mx_create_paymetn_options', $payment_options);

			if ($update_op) {
				echo 'success';
			} else {
				echo 'failed';
			}
		}
	}
}
