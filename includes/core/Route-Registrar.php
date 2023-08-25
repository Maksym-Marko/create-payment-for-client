<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFC_Route_Registrar
{
	
	/**
	* set controller
	*/
	public $controller = '';

	/**
	* set action
	*/
	public $action = '';

	/**
	* set slug or parent menu slug
	*/
	public $slug = MXCPFC_MAIN_MENU_SLUG;

	/**
	* catch class error
	*/
	public $class_attributes_error = NULL;

	/**
	* set properties
	*/
	public $properties = [
		'page_title' 	=> 'Title of the page',
		'menu_title' 	=> 'Link Name',
		'capability' 	=> 'manage_options',
		'menu_slug' 	=> MXCPFC_MAIN_MENU_SLUG,
		'dashicons' 	=> 'dashicons-image-filter',
		'position' 		=> 111
	];

	/**
	* set slug of sub menu
	*/
	public $sub_menu_slug = false;

	/**
	* set slug of sub menu
	*/
	public $settings_sub_menu_slug = false;

	/**
	* MXCPFC_Route_Registrar constructor
	*/
	public function __construct( ...$args )
	{

		// set data
		$this->mxcpfc_set_data( ...$args );

	}

	/**
	* require class
	*/
	public function mxcpfc_require_controller( $controller )
	{

		if( file_exists( MXCPFC_PLUGIN_ABS_PATH . "includes/admin/controllers/{$controller}.php" ) ) {

			require_once MXCPFC_PLUGIN_ABS_PATH . "includes/admin/controllers/{$controller}.php";

		}

	}

	/**
	* $controller 		- Controller
	*
	* $action 			- Action
	*
	* $slug 			- if NULL - menu item will investment into
	*						MXCPFC_MAIN_MENU_SLUG menu item
	*
	* $menu_properties 	- menu properties
	*
	* $sub_menu_slug 	- slug of sub menu
	*
	*/
	public function mxcpfc_set_data( $controller='', $action='', $slug = MXCPFC_MAIN_MENU_SLUG, array $menu_properties=[], $sub_menu_slug = false, $settings_sub_menu_slug = false )
	{

		// set controller
		$this->controller = $controller;

		// set action
		$this->action = $action;

		// set slug
		if( $slug == NULL ) {

			$this->slug = MXCPFC_MAIN_MENU_SLUG;

		} else {

			$this->slug = $slug;

		}

		// set properties
		foreach ( $menu_properties as $key => $value ) {
			
			$this->properties[$key] = $value;

		}

		// callback function
		$mxcpfc_callback_function_menu = 'mxcpfc_create_admin_main_menu';

		/*
		* check if it's submenu
		* set sub_menu_slug
		*/
		if( $sub_menu_slug !== false ) {

			$this->sub_menu_slug = $sub_menu_slug;

			$mxcpfc_callback_function_menu = 'mxcpfc_create_admin_sub_menu';
			
		} elseif ( $settings_sub_menu_slug !== false ) {
			
			$this->settings_sub_menu_slug = $settings_sub_menu_slug;

			$mxcpfc_callback_function_menu = 'mxcpfc_create_admin_settings_parent';
			
		}

		/**
		* require controller
		*/
		$this->mxcpfc_require_controller( $this->controller );

		/**
		* catching errors of class attrs
		*/
		$is_error_class_atr = MXCPFC_Catching_Errors::mxcpfc_catch_class_attributes_error( $this->controller, $this->action );
		
		// catch error class attr
		if( $is_error_class_atr !== NULL ) {

			$this->class_attributes_error = $is_error_class_atr;

		}

		// register admin menu
		add_action( 'admin_menu', array( $this, $mxcpfc_callback_function_menu ) );

	}

	/**
	* Create Main menu
	*/
	public function mxcpfc_create_admin_main_menu()
	{

		add_menu_page( __( $this->properties['page_title'], 'mxcpfc-domain' ),
			 __( $this->properties['menu_title'], 'mxcpfc-domain' ),
			 $this->properties['capability'],
			 $this->slug,
			 array( $this, 'mxcpfc_view_connector' ),
			 $this->properties['dashicons'], // icons https://developer.wordpress.org/resource/dashicons/#id
			 $this->properties['position'] );

	}

	/**
	* Create Sub menu
	*/
	public function mxcpfc_create_admin_sub_menu()
	{
		
		// create a menu
		add_submenu_page( $this->slug,
			 __( $this->properties['page_title'], 'mxcpfc-domain' ),
			 __( $this->properties['menu_title'], 'mxcpfc-domain' ),
			 $this->properties['capability'],
			 $this->sub_menu_slug,
			 array( $this, 'mxcpfc_view_connector' )
		);

	}

		// connect view
		public function mxcpfc_view_connector()
		{

			if( $this->class_attributes_error == NULL ) {

				$class_inst = new $this->controller();

				call_user_func( array( $class_inst, $this->action ) );

			}
			
		}

	/**
	* Settings parent
	*/
	public function mxcpfc_create_admin_settings_parent()
	{
		
		// create a menu
		add_options_page(
			__( $this->properties['page_title'], 'mxcpfc-domain' ),
			__( $this->properties['menu_title'], 'mxcpfc-domain' ),
			$this->properties['capability'],
			$this->settings_sub_menu_slug,
			array( $this, 'mxcpfc_view_connector' )
		);

	}

}