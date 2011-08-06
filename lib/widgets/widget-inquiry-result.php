<?php
/* POC Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_inquiry_result_load_widgets' );
function crm_inquiry_result_load_widgets() {
	register_widget( 'Inquiry_Result_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Inquiry_Result_Widget extends WP_Widget {
	function Inquiry_Result_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_inquiry_result', 'description' => 'Breaks down inquiries by result ' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'inquiry-result-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'inquiry-result-widget', 'Result of Inquiry', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Result of Inquiry'.$after_title;

		echo '<ul>';
		global $project_result;
		$project_result_count = array_count_values($project_result);
		$total_project_result = count($project_result);
		foreach ($project_result_count as $key=>$value) echo '<li>'.$key.': '.crm_percent($value, $total_project_result).'</li>';
		echo '</ul>';
		
		echo $after_widget;
	}

	
}

add_action('crm_stat_loop', 'crm_inquiry_result_loop');
function crm_inquiry_result_loop() {
	global $project_result, $post, $meta, $prefix;
	if(isset($meta[$prefix.'old_project_status'][0])) 	$project_result[] = $meta[$prefix.'old_project_status'][0];
}