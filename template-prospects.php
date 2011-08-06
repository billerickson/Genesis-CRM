<?php
/**
 * Template Name: Prospects
 *
 * @package      Genesis CRM
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Change layout to Full Width
 */
 
add_filter('genesis_pre_get_option_site_layout', 'be_prospect_layout');

function be_prospect_layout($opt) {
	return 'full-width-content';
}

/**
 * Prospect Count
 */
 
add_action('genesis_before', 'be_prospect_count');
function be_prospect_count() {

	$all = new WP_Query('showposts=-1&posts_per_page=-1');
	global $prefix;
	do_action('crm_pre_stat_loop');
	global $total;
	$total = 0;
	while ($all->have_posts()): $all->the_post(); global $post, $meta, $prefix;
		$meta = get_post_custom($post->ID);
		$total++;
		do_action('crm_stat_loop');
	endwhile;
	wp_reset_query(); 

}

/**
 * Prospect Display
 */

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'be_prospect_loop');
function be_prospect_loop() {

	echo '<div class="one-third first widget-area">';
	dynamic_sidebar('home-column-1');
	echo '</div>';
	echo '<div class="one-third widget-area">';
	dynamic_sidebar('home-column-2');
	echo '</div>';
	echo '<div class="one-third widget-area">';
	dynamic_sidebar('home-column-3');
	echo '</div>';
}

genesis();
?>