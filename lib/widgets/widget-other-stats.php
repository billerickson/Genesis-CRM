<?php
/* Other Stats Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_other_stats_load_widgets' );
function crm_other_stats_load_widgets() {
	register_widget( 'Other_Stats_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Other_Stats_Widget extends WP_Widget {
	function Other_Stats_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_other_stats', 'description' => 'Open prospects, active projects, inquiries in past 7 and 30 days' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'other-stats-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'other-stats-widget', 'Other Stats', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Other Stats'.$after_title;
		
		global $active_projects, $thirty_days, $seven_days;
		
	$prospects = get_term_by('slug', 'prospect', 'category'); if (isset($prospects)) echo '<strong>Open Prospects:</strong> ' . $prospects->count . '<br />';
	if (isset($active_projects)) echo '<strong>Active Projects: </strong> '. $active_projects .'<br />';
	if (isset($thirty_days)) echo '<strong>Inquires over past 30 days: </strong> '. $thirty_days .'<br />';
	if (isset($seven_days)) echo '<strong>Inquiries over past 7 days: </strong> '. $seven_days .'<br />';

		
		echo $after_widget;
	}

	
}

add_action('crm_stat_loop', 'crm_other_stats_loop');
function crm_other_stats_loop() {
	global $post, $active_projects, $thirty_days, $seven_days;
	if (in_category('active-project')) $active_projects++;
	if ($post->post_date > date('Y-m-d', strtotime('-30 days'))) $thirty_days++;
	if ($post->post_date > date('Y-m-d', strtotime('-7 days'))) $seven_days++;

}