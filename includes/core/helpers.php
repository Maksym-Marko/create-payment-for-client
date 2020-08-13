<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Require class for admin panel
*/
function mxcpfc_require_class_file_admin( $file ) {

	require_once MXCPFC_PLUGIN_ABS_PATH . 'includes/admin/classes/' . $file;

}


/*
* Require class for frontend panel
*/
function mxcpfc_require_class_file_frontend( $file ) {

	require_once MXCPFC_PLUGIN_ABS_PATH . 'includes/frontend/classes/' . $file;

}

/*
* Require a Model
*/
function mxcpfc_use_model( $model ) {

	require_once MXCPFC_PLUGIN_ABS_PATH . 'includes/admin/models/' . $model . '.php';

}

/*
* Include a Component
*/
function mxcpfc_include_component( $file_name, $variable = [] ) {

	$file = MXCPFC_PLUGIN_ABS_PATH . 'includes/frontend/components/' . $file_name . '.php';

	if( file_exists( $file ) ) {

		extract( $variable );

		include $file;

	}

	return false;	

}

/*
* Get payment options
*/
function mxcpfc_get_payment_options() {

	$payment_options = get_option( '_mx_create_paymetn_options' );

	if( $payment_options ) {

		$unserialize_options = maybe_unserialize( $payment_options );

		return $unserialize_options;

	}

	return [
		'publishable_key' 			=> '',
		'secret_key' 				=> '',
		'process_page_url' 			=> '',
		'contact_us_page' 			=> '',		
		'company_email' 			=> '',
		'department_company' 		=> '',
		'company_name' 				=> '',
		'message_for_client' 		=> '',
		'company_address' 			=> '',
		'company_phone' 			=> '',
		'thank_you_message' 		=> '',
		'invalid_request_message' 	=> '',
		'enable_iban' 				=> 0
	];

}