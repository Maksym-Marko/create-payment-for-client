<?php

// uninstall
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die();
           
// Delete posts CPT
// $posts = get_posts( array( 'post_type' => 'mxcpfc_book', 'numberposts' => -1 ) );

// foreach( $posts as $post ){

// 	wp_delete_post( $post->ID, true );

// }

//delete_option( 'some_option' );