<?php

// uninstall
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die();
           
global $wpdb;

// table name
$table_names = array();

$table_names[] = $wpdb->prefix . 'mxcpfc_table_slug';

// drop table(s);
foreach( $table_names as $table_name ){

    $sql = 'DROP TABLE IF EXISTS ' . $table_name . ';';

    $wpdb->query( $sql );

}

// Delete posts CPT
$posts = get_posts( array( 'post_type' => 'mxcpfc_book', 'numberposts' => -1 ) );

foreach( $posts as $post ){

	wp_delete_post( $post->ID, true );

}

//delete_option( 'some_option' );