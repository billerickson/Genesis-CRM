<?php
/**
 * Template Name: Complete 
 *
 * @package      Genesis CRM
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Custom Loop
 */
 
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'be_complete_loop');
function be_complete_loop() { 

	do_action( 'genesis_before_post_title' );
	do_action( 'genesis_post_title' );
	do_action( 'genesis_after_post_title' );

	global $prefix;
	$args = array(
		'category_name' => 'complete',
		'posts_per_page' => '20',
		'meta_query' => array(
			array(
				'key' => $prefix.'include_complete'
			)
		)
	);
	
	$complete = new WP_Query($args);
	setlocale(LC_MONETARY, 'en_US');
	$loop_counter = 0;
	while ($complete->have_posts()): $complete->the_post();
			
		$revenue = get_custom_field($prefix.'revenue');
		$expense = get_custom_field($prefix.'expense');
		$profit = $revenue - $expense;
		$time = get_custom_field($prefix.'time_setup') + get_custom_field($prefix.'time_development') + get_custom_field($prefix.'time_phone') + get_custom_field($prefix.'time_hourly') + get_custom_field($prefix.'time_other');
		if ($time) $rate = money_format('%(#10n', $profit / $time );
		if (!empty($revenue)) $revenue = money_format( '%(#10n', $revenue );
		if (!empty($expense)) $expense = money_format( '%(#10n', $expense );
		if (!empty($profit)) $profit = money_format( '%(#10n', $profit );
		
		if ($loop_counter % 3 == 0) echo '<div class="first project">';
		else echo '<div class="project">';
		echo '<h3><a href="'.get_edit_post_link().'">'.be_get_project_name().'</a></h3>';
		echo '<p>';
		if ($revenue) {
			echo '<strong>Budget</strong>: '. $revenue;
			if ($expense) echo ' - '. $expense . ' = '. $profit;
			echo '<br />';
		}
		if ($time) echo '<strong>Time Spent:</strong> '. $time . ' hrs <br /><strong>Effective rate:</strong> '. $rate . ' /hr<br />';
		
		echo '</p>';
		echo '</div>';
		$loop_counter++;
	
	endwhile;

}

genesis();
?>