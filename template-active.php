<?php
/**
 * Template Name: Active
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
add_action('genesis_loop', 'be_active_loop');

function be_active_loop() {
	echo '<div class="two-thirds first">';

	$order = array('dev', 'maintenance', 'edit', 'dev-complete', 'project-complete');
	setlocale(LC_MONETARY, 'en_US');
	foreach ($order as $order_item):
		
		$loop_counter = 1;
		global $prefix;
		$args = array(
			'category_name' => 'active-project',
			'posts_per_page' => '-1',
			'meta_query' => array(
				array(
					'key' => $prefix.'project_status',
					'value' => $order_item,
				)
			)
		);
	
		$active = new WP_Query($args);
		if( $active->have_posts() )
			echo '<h2 class="first">' . ucwords($order_item) . '</h2>';
		while ($active->have_posts()): $active->the_post();
			
			$status = get_custom_field($prefix.'project_status');
			$type = get_custom_field( $prefix . 'project_type' );
			$status_summary = get_custom_field($prefix.'status_summary');
			$revenue = get_custom_field($prefix.'revenue');
			$expense = get_custom_field($prefix.'expense');
			$profit = $revenue - $expense;
			if (!empty($revenue)) $revenue = money_format( '%(#10n', $revenue );
			if (!empty($expense)) $expense = money_format( '%(#10n', $expense );
			if (!empty($profit)) $profit = money_format( '%(#10n', $profit );
			$work = get_custom_field($prefix.'needs_work');
			if (empty($work)) $work = 'yes';
			$classes = array('project', strtolower($order_item), $work);
			if (($loop_counter % 2 == 1) && ($loop_counter !== '1')) $classes[] = 'first';
		
			echo '<div class=" '. implode(' ', $classes) . '">';
			echo '<h4><a href="'.get_edit_post_link().'">'.be_get_project_name().'</a></h4>';
			echo '<p>';
			echo '<strong>'.ucwords($status).'</strong>: '.$status_summary .'<br />';
			if( $type ) echo '<strong>Type</strong>: '. $type . '<br />';
			if ($revenue) echo '<strong>Budget</strong>: '. $revenue;
			if ($expense) echo ' - '. $expense . ' = '. $profit . '<br />';
			echo '</p>';
			echo '</div>';
	
			$loop_counter++;
		endwhile;
	endforeach;

	echo '</div><div class="one-third grey">';
	echo '<h1>Scheduled Projects</h1>';

	global $prefix;
	$args = array(
		'category_name' => 'scheduled-project',
		'posts_per_page' => '-1',
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'meta_key' => $prefix.'date_dev_start',
	);

	$scheduled = new WP_Query($args);
	global $be_output_end;
	$be_output_end = '';
	while ($scheduled->have_posts()): $scheduled->the_post();

		$output = '';
		global $be_output_end;
		$start = get_custom_field($prefix.'date_dev_start');
		$type = get_custom_field( $prefix . 'project_type' );
		$status_summary = get_custom_field($prefix.'status_summary');
		$revenue = get_custom_field($prefix.'revenue');
		$expense = get_custom_field($prefix.'expense');
		$profit = $revenue - $expense;
			if (!empty($revenue)) $revenue = money_format( '%(#10n', $revenue );
			if (!empty($expense)) $expense = money_format( '%(#10n', $expense );
			if (!empty($profit)) $profit = money_format( '%(#10n', $profit );
		
		$classes = array( 'project' );
		$work = get_custom_field($prefix.'needs_work');
		$classes[] = $work;
		$output .= '<div class="' . implode( ' ', $classes ) . '">';
		$output .= '<p><a href="'.get_edit_post_link().'">'.be_get_project_name().'</a><br />';
		$output .= '<strong>Scheduled for: </strong>'. date('F j, Y', $start) . '<br />';
		if ($status_summary) 
			$output .= '<strong>Status:</strong> '.$status_summary.'<br />';
		if( $type ) 
			$output .= '<strong>Type:</strong> ' . $type . '<br />';
		if ($revenue) 
			$output .= '<strong>Budget</strong>: '. $revenue;
		if ($expense) 
			$output .= ' - '. $expense . ' = '. $profit . '<br />';

		$output .= '</div>';
		
		if( 'delayed' == $work )
			$be_output_end .= $output;
		else
			echo $output;

	endwhile;
	echo $be_output_end;
	
	echo '</div>';
}
genesis();
?>