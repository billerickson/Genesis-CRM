<?php
/* Active Projects Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_active_projects_load_widgets' );
function crm_active_projects_load_widgets() {
	register_widget( 'Active_Projects_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Active_Projects_Widget extends WP_Widget {
	function Active_Projects_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_active_projects', 'description' => 'Shows all posts in the Active Project category' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'active-project-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'active-project-widget', 'Active Projects', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Active Projects'.$after_title;
		
		$order = array('Dev', 'Maintenance', 'Edit', 'Design', 'Dev Complete', 'Project Complete');
		echo '<ol>';
		foreach ($order as $order_item):
		
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
		global $prefix;
		$prefix = '_crm_';
			while ($active->have_posts()): $active->the_post(); global $post; 
				$project_name = get_custom_field($prefix.'project_name');
				if (!empty($project_name)) $name = $project_name .' ('.get_the_title().')';
				else $name = get_the_title();
				?>
				<li><a href="<?php the_permalink();?>"><?php echo $name; ?></a> <?php edit_post_link('Edit', '(', ')');?><br /> 
				<?php 
				$status_summary = get_custom_field($prefix.'status_summary'); 
				$status = get_custom_field($prefix.'project_status');
				if (!empty($status)) echo '<strong>Status:</strong> '.$status;
				if (!empty($status_summary)) echo ' | '.$status_summary;
				if (!empty($status) || !empty($status_summary)) echo '<br />';
				$started = get_custom_field($prefix.'start_date'); if ($started) echo '<strong>Started:</strong> '.date('F j, Y', strtotime($started)).','; 
				$revenue = get_custom_field($prefix.'revenue');
				$expense = get_custom_field($prefix.'expense');
				if ($revenue) echo 'Budget: $' . (number_format($revenue - $expense)) . '</li>';
			endwhile; 
		endforeach;
			echo '</ol>';
		wp_reset_query();
		
		echo $after_widget;
	}

	
}