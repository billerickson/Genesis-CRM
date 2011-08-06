<?php
/* Project Sources Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_project_sources_load_widgets' );
function crm_project_sources_load_widgets() {
	register_widget( 'Project_Sources_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Project_Sources_Widget extends WP_Widget {
	function Project_Sources_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_project_sources', 'description' => 'Breaks down projects won by source ' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'project-sources-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'project-sources-widget', 'Sources of Projects', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Sources of Projects'.$after_title;

		echo '<ul>';
		global $projects;
		$project_count = array_count_values($projects);
		$total_projects = count($projects);
		foreach ($project_count as $key=> $value) echo '<li>'.$key.': '.crm_percent($value, $total_projects).'</li>';
		echo '</ul>';
		
		echo $after_widget;
	}

	
}

add_action('crm_stat_loop', 'crm_project_sources_loop');
function crm_project_sources_loop() {
	global $post, $meta, $projects, $prefix;
	$sources_of_projects = get_the_terms( $post->ID, 'sources', '', ', ', '' );
	if(isset($meta[$prefix.'old_project_status'][0]) && $meta[$prefix.'old_project_status'][0] == 'quoted and won') { 
		foreach ($sources_of_projects as $source) $projects[] = $source->name;
	}

}