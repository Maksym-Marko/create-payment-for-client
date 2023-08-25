<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXCPFCPaymentToClientHandlerClass
{

	/*
	* MXCPFCPaymentToClientHandlerClass constructor
	*/
	public function __construct()
	{
	}

	/*
	* Observe function
	*/
	public static function add_scripts_to_admin_footer()
	{

		add_action('admin_footer', array('MXCPFCPaymentToClientHandlerClass', 'mxcpfc_add_handler'));
	}

	/*
	* Add handler
	*/
	public static function mxcpfc_add_handler()
	{

		if (get_post_type() !== 'mxcpfc_payment')
			return;

		// add html 
?>

		<style>
			#meta_of_url_to_client_field {
				width: 100%;
			}
		</style>

<?php }
}
