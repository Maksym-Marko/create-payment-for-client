<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFC_Enqueue_Scripts_Frontend
{

	/*
	* MXCPFC_Enqueue_Scripts_Frontend
	*/
	public function __construct()
	{

	}

	/*
	* Registration of styles and scripts
	*/
	public static function mxcpfc_register()
	{

		// register scripts and styles
		add_action( 'wp_enqueue_scripts', array( 'MXCPFC_Enqueue_Scripts_Frontend', 'mxcpfc_enqueue' ) );

	}

		public static function mxcpfc_enqueue()
		{

			wp_enqueue_style( 'mxcpfc_font_awesome', MXCPFC_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );
			
			wp_enqueue_style( 'mxcpfc_style', MXCPFC_PLUGIN_URL . 'includes/frontend/assets/css/style.css', array( 'mxcpfc_font_awesome' ), MXCPFC_PLUGIN_VERSION, 'all' );
			
			wp_enqueue_script( 'mxcpfc_script', MXCPFC_PLUGIN_URL . 'includes/frontend/assets/js/script.js', array( 'jquery' ), MXCPFC_PLUGIN_VERSION, false );
		
		}

}