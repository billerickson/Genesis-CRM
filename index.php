<?php
/**
 * Index - Used for everything but page templates
 *
 * @package      Genesis CRM
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Loop Setup
 *
 * This setup function attaches all of the loop-specific functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */
add_action('genesis_before', 'be_loop_setup');
function be_loop_setup() {

	// Customize Post Info and Meta
	remove_action('genesis_before_post_content', 'genesis_post_info');
	remove_action('genesis_after_post_content', 'genesis_post_meta');
	add_action('genesis_before_post_title', 'genesis_post_info');
	add_filter('genesis_post_info', 'be_post_info');

	// Post Title clicks to edit link
	add_filter('genesis_post_title_output', 'be_post_title');
	
	// Customize Post Content
	remove_action('genesis_post_content', 'genesis_do_post_content');
	add_action('genesis_post_content', 'be_post_content');
	
	// Post Classes
	add_filter('post_class', 'be_post_class');
	
	// Archive Title
	add_action('genesis_before_loop', 'be_archive_title');
	
}


/**
 * Customize Post Info
 *
 * @author Bill Erickson
 * @link http://dev.studiopress.com/shortcode-reference
 * @param string, original post info
 * @return string, modified post info
 */

function be_post_info($post_info) {
	$post_info = '[post_categories before=""]';
	return $post_info;
}

/**
 * Customize Post Titles. 
 * @uses be_get_project_name() for Title
 * @uses get_edit_post_link() for Permalink
 *
 * @author Bill Erickson
 * @param string, original title output
 * @return string, modified title output 
 */

function be_post_title($title) {
	
	$title = be_get_project_name();

	if ( strlen( $title ) == 0 )
		return;

	if ( is_singular() ) {
		$title = sprintf( '<h1 class="entry-title">%s</h1>', apply_filters( 'genesis_post_title_text', $title ) );
	} else {
		$title = sprintf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', get_edit_post_link(), the_title_attribute('echo=0'), apply_filters( 'genesis_post_title_text', $title ) );
	}
	
	return $title; 

}

/**
 * Customize Post Content
 *
 * @author Bill Erickson
 */

include_once( 'lib/functions/post-content.php'); 

/**
 * Post Classes
 *
 * @author Bill Erickson
 * @link http://codex.wordpress.org/Function_Reference/post_class#Add_Classes_By_Filters
 * @param array, original post classes
 * @return array, modified post classes
 */
 
function be_post_class($classes){
	if (in_category('active-project')) {
		global $prefix;
		$work = get_custom_field($prefix.'needs_work');
		if (empty($work)) $work = 'yes';
		$classes[] = 'work-'.$work;
	}
	
	global $loop_counter;
	$classes[] = 'one-third';
	if ($loop_counter % 3 == 0) $classes[] = 'first';
	
	return $classes;
}

/**
 * Archive Title
 *
 * @author Bill Erickson
 */

function be_archive_title() {
	
	if ( is_search() ) $title = 'Search Results for <em>'. get_query_var('s') . '</em>';
	if ( is_category() ) $title = 'Category Results for <em>'. get_query_var('category_name') . '</em>';
	
	if ( isset($title) ) {
		printf( '<div class="taxonomy-description">%s</div>', $title );
	}
	
}

genesis();
?>