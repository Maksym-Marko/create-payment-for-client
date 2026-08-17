<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Model class
*/
class MXCPFC_Model
{

	private $wpdb;

	/**
	* Table name
	*/
	protected $table = MXCPFC_TABLE_SLUG;

	/**
	* fields
	*/
	protected $fields = '*';

	/*
	* Model constructor
	*/
	public function __construct()
	{
		
		global $wpdb;

    	$this->wpdb = $wpdb;    	

	}	

	/**
	* select row from the database
	*/
	public function mxcpfc_get_row( $table = NULL, $wher_name='', $wher_value='' )
	{

		$table_name = $this->wpdb->prefix . $this->table;

		if( $table !== NULL ) {

			$table_name = $table;

		}

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter -- Identifiers are plugin-controlled, value is prepared.
		$get_row = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT {$this->fields} FROM {$table_name} WHERE {$wher_name} = %s", $wher_value ) );

		return $get_row;
		
	}

	/**
	* get results from the database
	*/
	public function mxcpfc_get_results( $table = false, $wher_name = NULL, $wher_value = 1 )
	{

		$table_name = $this->wpdb->prefix . $this->table;

		if( $table !== false ) {

			$table_name = $table;

		}

		if( $wher_name !== NULL ) {

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter -- Identifiers are plugin-controlled, value is prepared.
			$results = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT {$this->fields} FROM {$table_name} WHERE {$wher_name} = %s", $wher_value ) );

		} else {

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter -- Identifiers are plugin-controlled.
			$results = $this->wpdb->get_results( "SELECT {$this->fields} FROM {$table_name}" );

		}		

		return $results;
		
	}

}