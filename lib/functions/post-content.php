<?php
/**
 * Customize Post Content
 *
 * @package      Genesis CRM
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

function be_post_content() {

	// Get categories, then change from array of objects to standard array
	$category_objects = get_the_category();
	foreach ($category_objects as $category) $categories[] = $category->slug;
	
	// Fields
	global $post, $prefix;
	$status = get_custom_field($prefix.'status_summary');
	$revenue = get_custom_field($prefix.'revenue'); 
	$sources = get_the_terms( $post->ID, 'sources', '', ', ', '' ); 
	$list = ''; 
	if ($sources) { foreach ($sources as $data) $list[] = $data->name; }
	if (!empty($list)) $sources = implode(', ', $list);
	$email = get_custom_field($prefix.'client_email');
	$phone = get_custom_field($prefix.'client_phone');
				


	// Prospect and Closed Loop
	if ( in_array('prospect', $categories) || in_array('closed', $categories) ) {
		echo '<p>';
		if ($status) echo '<strong>Status:</strong> '.$status.' | ';
		if ($revenue) echo 'Quote: '.$revenue.' | ';
		if ($sources) echo 'Source: '.$sources.' | ';
		if ($email) echo 'Email '.$email.' | ';
		if ($phone) echo 'Phone '.$phone;
		echo '</p>';
	}
	
	// Active Loop
	if( in_array('active-project', $categories) ) { 
		$status = get_custom_field($prefix.'project_status');
		$status_summary = get_custom_field($prefix.'status_summary');
		$expense = get_custom_field($prefix.'expense');
		$profit = $revenue - $expense;
		if (!empty($revenue)) $revenue = money_format( '%(#10n', $revenue );
		if (!empty($expense)) $expense = money_format( '%(#10n', $expense );
		if (!empty($profit)) $profit = money_format( '%(#10n', $profit );
		$work = get_custom_field($prefix.'needs_work');
		if (empty($work)) $work = 'yes';

		echo '<p>';
		echo '<strong>'.ucwords($status).'</strong>: '.$status_summary .'<br />';
		if ($revenue) echo '<strong>Budget</strong>: '. $revenue;
		if ($expense) echo ' - '. $expense . ' = '. $profit;
		if ($revenue) echo  '<br />';
		if ($email) echo 'Email '.$email.' | ';
		if ($phone) echo 'Phone '.$phone;
		echo '</p>';
		
	}
	
	if( in_array('complete', $categories) ) {
		$revenue = get_custom_field($prefix.'revenue');
		$expense = get_custom_field($prefix.'expense');
		$profit = $revenue - $expense;
		$time = get_custom_field($prefix.'time_setup') + get_custom_field($prefix.'time_development') + get_custom_field($prefix.'time_phone') + get_custom_field($prefix.'time_other');
		if ($time) $rate = money_format('%(#10n', $profit / $time );
		if (!empty($revenue)) $revenue = money_format( '%(#10n', $revenue );
		if (!empty($expense)) $expense = money_format( '%(#10n', $expense );
		if (!empty($profit)) $profit = money_format( '%(#10n', $profit );

		echo '<p>';
		if ($revenue) {
			echo '<strong>Budget</strong>: '. $revenue;
			if ($expense) echo ' - '. $expense . ' = '. $profit;
			echo '<br />';
		}
		if ($time) echo '<strong>Time Spent:</strong> '. $time . ' hrs <br /><strong>Effective rate:</strong> '. $rate . ' /hr<br />';
		if ($email) echo 'Email '.$email.' | ';
		if ($phone) echo 'Phone '.$phone;
		echo '</p>';
	
	}

}
