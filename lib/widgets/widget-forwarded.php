<?php
/* Forwarded Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_forwarded_load_widgets' );
function crm_forwarded_load_widgets() {
	register_widget( 'Forwarded_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Forwarded_Widget extends WP_Widget {
	function Forwarded_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_forwarded', 'description' => 'Breaks down forwarded away inquiries by reason ' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'forwarded-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'forwarded-widget', 'Reason for Forwarding Away', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Reason for Forwarding Away'.$after_title;

		echo '<ul>';
		global $forwarded_away;
		$forwarded_away_count = array_count_values($forwarded_away);
		$forwarded_away_total = count($forwarded_away);
		foreach ($forwarded_away_count as $key=>$value) echo '<li>'.$key.': '.crm_percent($value, $forwarded_away_total).'</li>';
		echo '</ul>';
		
		echo $after_widget;
	}

	
}


add_action('crm_stat_loop', 'crm_forwarded_loop');
function crm_forwarded_loop() {
	global $post, $meta, $forwarded_away, $prefix;
	if(isset($meta[$prefix.'old_project_status'][0])) { 
		$status = $meta[$prefix.'old_project_status'][0];
		if(isset($meta[$prefix.'reason'][0])) $reason = $meta[$prefix.'reason'][0];
		if ($status == 'forwarded away' && isset($reason)) $forwarded_away[] = $reason;
	}
}