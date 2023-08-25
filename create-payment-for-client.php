<?php
/*
Plugin Name: Create a payment request. Donation form
Plugin URI: https://github.com/Maxim-us/create-payment-for-client
Description: Stripe payment gateway. You can create a payment request for your client. There is functionality to create a Donation page.
Author: Maksym Marko
Version: 4.1
Author URI: https://github.com/Maxim-us
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/*
* Unique string - MXCPFC
*/

/*
* Define MXCPFC_PLUGIN_PATH
*
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\create-payment-for-client\create-payment-for-client.php
*/
if (!defined('MXCPFC_PLUGIN_PATH')) {

	define('MXCPFC_PLUGIN_PATH', __FILE__);
}

/*
* Define MXCPFC_PLUGIN_URL
*
* Return http://my-domain.com/wp-content/plugins/create-payment-for-client/
*/
if (!defined('MXCPFC_PLUGIN_URL')) {

	define('MXCPFC_PLUGIN_URL', plugins_url('/', __FILE__));
}

/*
* Define MXCPFC_PLUGN_BASE_NAME
*
* 	Return create-payment-for-client/create-payment-for-client.php
*/
if (!defined('MXCPFC_PLUGN_BASE_NAME')) {

	define('MXCPFC_PLUGN_BASE_NAME', plugin_basename(__FILE__));
}

/*
* Define MXCPFC_TABLE_SLUG
*/
if (!defined('MXCPFC_TABLE_SLUG')) {

	define('MXCPFC_TABLE_SLUG', 'mxcpfc_table_slug');
}

/*
* Define MXCPFC_PLUGIN_ABS_PATH
* 
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\create-payment-for-client/
*/
if (!defined('MXCPFC_PLUGIN_ABS_PATH')) {

	define('MXCPFC_PLUGIN_ABS_PATH', dirname(MXCPFC_PLUGIN_PATH) . '/');
}

/*
* Define MXCPFC_PLUGIN_VERSION
*/
if (!defined('MXCPFC_PLUGIN_VERSION')) {

	// version
	define('MXCPFC_PLUGIN_VERSION', '4.1'); // Must be replaced before production on for example '1.0'

}

/*
* Define MXCPFC_MAIN_MENU_SLUG
*/
if (!defined('MXCPFC_MAIN_MENU_SLUG')) {

	// version
	define('MXCPFC_MAIN_MENU_SLUG', 'mxcpfc-create-payment-for-client-menu');
}

/**
 * activation|deactivation
 */
require_once plugin_dir_path(__FILE__) . 'install.php';

/*
* Registration hooks
*/
// Activation
register_activation_hook(__FILE__, array('MXCPFC_Basis_Plugin_Class', 'activate'));

// Deactivation
register_deactivation_hook(__FILE__, array('MXCPFC_Basis_Plugin_Class', 'deactivate'));


/*
* Include the main MXCPFCCreatePaymentForClient class
*/
if (!class_exists('MXCPFCCreatePaymentForClient')) {

	require_once plugin_dir_path(__FILE__) . 'includes/final-class.php';

	/*
	* Translate plugin
	*/
	add_action('plugins_loaded', 'mxcpfc_translate');

	function mxcpfc_translate()
	{

		load_plugin_textdomain('mxcpfc-domain', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}

	// add settings link
	add_filter('plugin_action_links', 'mxcpfc_plugin_action_links', 10, 2);

	function mxcpfc_plugin_action_links($actions, $plugin_file)
	{
		if (false === strpos($plugin_file, basename(__FILE__)))
			return $actions;

		$settings_link = '<a href="options-general.php?page=mxcpfc_payment_settings">Settings</a>';

		array_unshift($actions, $settings_link);

		return $actions;
	}
}
