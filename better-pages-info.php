<?php
/*
Plugin Name: Better Pages Info
Plugin URI: http://stomptheweb.co.uk
Description: Changes the columns on the edit page screeen.
Version: 1.0.0
Author: Steven Jones
Author URI: http://stomptheweb.co.uk/
License: GPL2
*/

// Filter the columns
function bpi_page_columns($columns) {
	unset($columns['author']); 
	unset($columns['date']); 
	unset($columns['comments']); 	
	$columns['template'] = 'Template';
	$columns['last_updated'] = 'Last Updated'; 	  
    return $columns;
}
add_filter('manage_edit-page_columns' , 'bpi_page_columns');

// Populate the data
function bpi_custom_page_columns( $column, $post_id ) {
    
    switch ( $column ) {

		case 'template' :
	   	 	$page_template = get_post_meta( $post_id , '_wp_page_template' , true ); 
			$template = preg_replace("/\\.[^.\\s]{3,4}$/", "", $page_template);
			$template = str_replace("templates/","",$template);
			$template = str_replace("-"," ",$template);
			echo ucwords($template);
	    	break;

	    case 'last_updated' :
	    	$post = get_post($post_id); 
	    	echo date('d F Y - h:i:s a', strtotime($post->post_modified));
	    break;
    }
}
add_action( 'manage_page_posts_custom_column' , 'bpi_custom_page_columns', 10, 2 );