<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXCPFC_FrontEnd_Main
{

	/*
	* MXCPFC_FrontEnd_Main constructor
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
		mxcpfc_require_class_file_frontend('enqueue-scripts.php');

		MXCPFC_Enqueue_Scripts_Frontend::mxcpfc_register();

		// create shortcode call
		mxcpfc_require_class_file_frontend('create-shortcode.php');

		MXCPFC_Create_Shortcode::mxcpfc_register_shortcodes();

		// bill payment confirm
		mxcpfc_require_class_file_frontend('ajax.php');

		MXCPFC_ajax::mxcpfc_register_ajax();
	}
}

// Initialize
$initialize_admin_class = new MXCPFC_FrontEnd_Main();

// include classes
$initialize_admin_class->mxcpfc_additional_classes();
