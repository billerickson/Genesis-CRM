<?php
/**
 * Template Name: Download
 *
 * @package      genesis-crm
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

global $prefix;
wp_head(); ?>
						<table id="download">					
							<tr>
								<th>Prospect ID</th>
								<th>Client</th>
								<th>Client Email</th>
								<th>Client Phone</th>
								<th>Other Referral</th>
								<th>Points of Contact</th>
								<th>Contact Date</th>
								<th>Sources</th>
								<th>Category</th>
								<th>Project Status</th>
								<th>Status Summary</th>
								<th>Forwarded to</th>
								<th>Reason</th>
								<th>Revenue</th>
								<th>Expense</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Sales Status</th>
								<th>Actions Completed</th>
							</tr>
					
<?php 
$args = array(
	'posts_per_page' => '-1',
);
$downloads = new WP_Query($args);
while ($downloads->have_posts()): $downloads->the_post(); 
global $post; ?>
<tr>
	<td><a href="<?php the_permalink();?>"><?php echo $post->ID;?></a></td>
	<td><?php the_title();?></td>
	<td><?php echo get_custom_field($prefix.'client_email');?></td>
	<td><?php echo get_custom_field($prefix.'client_phone');?></td>
	<td><?php echo get_custom_field($prefix.'other_referral');?></td>
	<td><?php $poc = get_the_terms( $post->ID, 'poc', '', ', ', '' ); $list = ''; if ($poc) { foreach ($poc as $data) $list .= $data->name.', '; echo $list; } ?></td>
	<td><?php the_time('Y-m-d');?></td>
	<td><?php $sources = get_the_terms( $post->ID, 'sources', '', ', ', '' ); $list = ''; if ($sources) { foreach ($sources as $data) $list .= $data->name.', '; echo $list; } ?></td>
	<td><?php $cats = get_the_category(', '); $list = ''; if ($cats) { foreach ($cats as $data) $list .= $data->cat_name.', '; echo $list; } ?></td>
	<td><?php echo get_custom_field($prefix.'old_project_status');?></td>
	<td><?php echo get_custom_field($prefix.'status_summary');?></td>
	<td><?php echo get_custom_field($prefix.'forwarded_to');?></td>
	<td><?php echo get_custom_field($prefix.'reason');?></td>
	<td><?php echo get_custom_field($prefix.'revenue');?></td>
	<td><?php echo get_custom_field($prefix.'expense');?></td>
	<td><?php echo get_custom_field($prefix.'start_date');?></td>
	<td><?php echo get_custom_field($prefix.'end_date');?></td>
	<td><?php echo get_custom_field($prefix.'status');?></td>
	<td><?php echo get_custom_field($prefix.'sales_actions');?></td>
</tr>
<?php
endwhile;
wp_reset_query();?>