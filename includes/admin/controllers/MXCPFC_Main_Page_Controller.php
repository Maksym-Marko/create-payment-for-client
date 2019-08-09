<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFC_Main_Page_Controller extends MXCPFC_Controller
{
	
	public function index()
	{

		$model_inst = new MXCPFC_Main_Page_Model();

		$data = $model_inst->mxcpfc_get_row( NULL, 'id', 1 );

		return new MXCPFC_View( 'main-page', $data );

	}

	public function submenu()
	{

		return new MXCPFC_View( 'sub-page' );

	}

	public function hidemenu()
	{

		return new MXCPFC_View( 'hidemenu-page' );

	}

}