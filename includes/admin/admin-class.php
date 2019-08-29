<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFC_Admin_Main
{

	// list of model names used in the plugin
	public $models_collection = [
		'MXCPFC_Main_Page_Model'
	];

	/*
	* MXCPFC_Admin_Main constructor
	*/
	public function __construct()
	{

	}

	/*
	* Additional classes
	*/
	public function mxcpfc_additional_classes()
	{

		// enqueue_scripts class
		mxcpfc_require_class_file_admin( 'enqueue-scripts.php' );

		MXCPFC_Enqueue_Scripts::mxcpfc_register();


		// CPT class
		mxcpfc_require_class_file_admin( 'cpt.php' );

		MXCPFCCPTclass::createCPT();

		// set default content
		MXCPFCCPTclass::mxcpfc_default_content();

		// Metaboxes class
		mxcpfc_require_class_file_admin( 'metaboxes.php' );

		MXCPFCMetaboxesclass::createMetaboxes();

		// Handler class
		mxcpfc_require_class_file_admin( 'payment-to-client-handler.php' );

		MXCPFCPaymentToClientHandlerClass::add_scripts_to_admin_footer();

		// Sending payment to client class
		mxcpfc_require_class_file_admin( 'send-payment-to-client.php' );

		MXCPFCSendPaymentToClient::mxcpfc_wp_ajax();
		
	}

	/*
	* Models Connection
	*/
	public function mxcpfc_models_collection()
	{

		// require model file
		foreach ( $this->models_collection as $model ) {
			
			mxcpfc_use_model( $model );

		}		

	}

	/**
	* registration ajax actions
	*/
	public function mxcpfc_registration_ajax_actions()
	{

		// ajax requests to main page
		MXCPFC_Main_Page_Model::mxcpfc_wp_ajax();

	}

	/*
	* Routes collection
	*/
	public function mxcpfc_routes_collection()
	{

		MXCPFC_Route::mxcpfc_get( 'MXCPFC_Main_Page_Controller', 'index', 'NULL', [
			'page_title' => 'Create Payment settings',
			'menu_title' => 'Create Payment settings',
		], false, 'mxcpfc_payment_settings' );

	}

}

// Initialize
$initialize_admin_class = new MXCPFC_Admin_Main();

// include classes
$initialize_admin_class->mxcpfc_additional_classes();

// include models
$initialize_admin_class->mxcpfc_models_collection();

// ajax requests
$initialize_admin_class->mxcpfc_registration_ajax_actions();

// include controllers
$initialize_admin_class->mxcpfc_routes_collection();