<?php
/* POC Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_poc_load_widgets' );
function crm_poc_load_widgets() {
	register_widget( 'POC_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class POC_Widget extends WP_Widget {
	function POC_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_poc', 'description' => 'Breaks down contacts by original point of contact ' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'poc-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'poc-widget', 'Point of Contact', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Original Point of Contact'.$after_title;

		echo '<ul>';
		global $total;
		$categories = get_categories('taxonomy=poc&orderby=count&order=DESC'); 
		foreach ($categories as $category) echo '<li>'.$category->name.': '. crm_percent($category->count, $total) . ' 	</li>';
		echo '</ul>';
		
		echo $after_widget;
	}

	
}