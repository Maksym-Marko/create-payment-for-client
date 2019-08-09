<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// require Route-Registrar.php
require_once MXCPFC_PLUGIN_ABS_PATH . 'includes/core/Route-Registrar.php';

/*
* Routes class
*/
class MXCPFC_Route
{

	public function __construct()
	{
		// ...
	}
	
	public static function mxcpfc_get( ...$args )
	{

		return new MXCPFC_Route_Registrar( ...$args );

	}
	
}