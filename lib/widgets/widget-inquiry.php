<?php
/* POC Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_inquiry_load_widgets' );
function crm_inquiry_load_widgets() {
	register_widget( 'Inquiry_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Inquiry_Widget extends WP_Widget {
	function Inquiry_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_inquiry', 'description' => 'Breaks down inquiries by source ' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'inquiry-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'inquiry-widget', 'Source of Inquiry', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Source of Inquiry'.$after_title;

		echo '<ul>';
		global $total;
		$sources = get_categories('taxonomy=sources&orderby=count&order=DESC');
		foreach ($sources as $source) echo '<li>' . $source->name .': '. crm_percent($source->count, $total) . '</li>';
		echo '</ul>';
		
		echo $after_widget;
	}

	
}