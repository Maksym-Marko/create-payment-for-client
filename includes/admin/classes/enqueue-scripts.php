<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXCPFC_Enqueue_Scripts
{

	/*
	* MXCPFC_Enqueue_Scripts
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
		add_action('admin_enqueue_scripts', array('MXCPFC_Enqueue_Scripts', 'mxcpfc_enqueue'));
	}

	public static function mxcpfc_enqueue()
	{

		wp_enqueue_style('mxcpfc_font_awesome', MXCPFC_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css');

		wp_enqueue_style('mxcpfc_admin_style', MXCPFC_PLUGIN_URL . 'includes/admin/assets/css/style.css', array('mxcpfc_font_awesome'), MXCPFC_PLUGIN_VERSION, 'all');

		wp_enqueue_script('mxcpfc_admin_script', MXCPFC_PLUGIN_URL . 'includes/admin/assets/js/script.js', array('jquery'), MXCPFC_PLUGIN_VERSION, false);
	}
}
