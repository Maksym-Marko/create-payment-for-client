<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

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
		add_action('wp_enqueue_scripts', array('MXCPFC_Enqueue_Scripts_Frontend', 'mxcpfc_enqueue'));
	}

	public static function mxcpfc_enqueue()
	{

		$payment_options = get_option('_mx_create_paymetn_options');

		$unserialize_options = maybe_unserialize($payment_options);

		wp_enqueue_style('mxcpfc_font_awesome', MXCPFC_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css');

		wp_enqueue_style('mxcpfc_style', MXCPFC_PLUGIN_URL . 'includes/frontend/assets/css/style.css', array('mxcpfc_font_awesome'), MXCPFC_PLUGIN_VERSION, 'all');

		wp_enqueue_script('mxcpfc_script_stripe', 'https://js.stripe.com/v3/', array(), MXCPFC_PLUGIN_VERSION, false);

		wp_enqueue_script('mxcpfc_script', MXCPFC_PLUGIN_URL . 'includes/frontend/assets/js/script.js', array('jquery', 'mxcpfc_script_stripe'), MXCPFC_PLUGIN_VERSION, false);

		wp_localize_script('mxcpfc_script', 'mxcpfc_js_obj', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('nonce_payment_confirm'),
			'owner_email' => $unserialize_options['company_email'],
			'pk_stripe_key' => $unserialize_options['publishable_key']
		));
	}
}
