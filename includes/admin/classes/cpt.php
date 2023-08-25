<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXCPFCCPTclass
{

	/*
	* MXCPFCCPTclass constructor
	*/
	public function __construct()
	{
	}

	/*
	* Observe function
	*/
	public static function createCPT()
	{

		add_action('init', array('MXCPFCCPTclass', 'mxcpfc_custom_init'));
	}

	/*
	* Put in default content
	*/
	public static function mxcpfc_default_content()
	{

		add_filter('default_content', array('MXCPFCCPTclass', 'mxcpfc_preset_editor_content'), 10, 2);
	}

	/*
	* Create a Custom Post Type
	*/
	public static function mxcpfc_custom_init()
	{

		register_post_type('mxcpfc_payment', array(

			'labels'             => array(
				'name'               => 'Create Payment',
				'singular_name'      => 'Payment',
				'add_new'            => 'Add a new one',
				'add_new_item'       => 'Add new Customer',
				'edit_item'          => 'Edit the Pay',
				'new_item'           => 'New Pay',
				'view_item'          => 'See the Pay',
				'search_items'       => 'Find a Pay',
				'not_found'          =>  'Payments not found',
				'not_found_in_trash' => 'No Payments found in the trash',
				'parent_item_colon'  => '',
				'menu_name'          => 'Create Payment'

			),
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon' 		 => 'dashicons-products',
			'supports'           => array('title', 'editor')

		));
	}

	/*
	* Default content
	*/
	public static function mxcpfc_preset_editor_content($content, $post)
	{

		// global $post;

		if ($post->post_type !== 'mxcpfc_payment' || $content !== '') {
			return $content;
		}


		return 'Dear Jenny Johnson,

			Thank you for your very nice enquiry, and welcome to Company.

			We will be happy to make this offer for you.

			Here you can approve this quotation, confirm that you instruct us and can provide secure payment.
			[url_to_client]

			You will receive an instant receipt, and we will start working on your project right away.

			Kind regards.';
	}
}
