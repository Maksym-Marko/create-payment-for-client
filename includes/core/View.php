<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* View class
*/
class MXCPFC_View
{

	public function __construct( ...$args )
	{
		
		$this->mxcpfc_render( ...$args );

	}
	
	// render HTML
	public function mxcpfc_render( $file, $data = NULL )
	{

		// view content
		if( file_exists( MXCPFC_PLUGIN_ABS_PATH . "includes/admin/views/{$file}.php" ) ) {

			// data from model
			$data = $data;

			require_once MXCPFC_PLUGIN_ABS_PATH . "includes/admin/views/{$file}.php";

		} else { ?>

			<div class="notice notice-error is-dismissible">

			    <p>The view file "<b>includes/admin/views/<?php echo $file; ?>.php</b>" doesn't exists.</p>
			    
			</div>
		<?php }


	}
	
}