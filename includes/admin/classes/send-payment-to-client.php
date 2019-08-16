<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

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

		add_action( 'wp_ajax_mxcpfc_send_payment_to_client', array( 'MXCPFCSendPaymentToClient', 'prepare_payment_sending' ), 10, 1 );

	}

	/*
	* Prepare for data updates
	*/
	public static function prepare_payment_sending()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'meta_sent_to_client_action' ) ) {

			$message = $_POST['message'];
			$message = wp_kses( $message, 'default' );

			$email = sanitize_email( $_POST['email'] );
			$post_id = sanitize_key( $_POST['post_id'] );

			// progress
			self::progress_payment_sending( $message, $email, $post_id );			

		}

		wp_die();

	}

		// Send email
		public static function progress_payment_sending( $message, $email, $post_id )
		{

			$message = str_replace( '\"', '"', $message );			

			$_from = wp_get_current_user()->data->user_email;

			$headers = 'From: Company team <noreply@company.com>' . "\r\n";

			wp_mail( $email, 'Ordering and Payment', $message, $headers );

			// save metabox data of sendig
			$data = 'true';

			$data = sanitize_key( $data );

			update_post_meta( $post_id, '_meta_sent_to_client_data', $data );

			echo 'sent';

		}
	
}