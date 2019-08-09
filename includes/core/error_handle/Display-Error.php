<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Error Handle calss
*/
class MXCPFC_Display_Error
{

	/**
	* Error notice
	*/
	public $mxcpfc_error_notice = '';

	public function __construct( $mxcpfc_error_notice )
	{

		$this->mxcpfc_error_notice = $mxcpfc_error_notice;

	}

	public function mxcpfc_show_error()
	{
		
		add_action( 'admin_notices', function() { ?>

			<div class="notice notice-error is-dismissible">

			    <p><?php echo $this->mxcpfc_error_notice; ?></p>
			    
			</div>
		    
		<?php } );

	}

}