<?php
/* Referral Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_referral_load_widgets' );
function crm_referral_load_widgets() {
	register_widget( 'Referral_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Referral_Widget extends WP_Widget {
	function Referral_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_referral', 'description' => ' Displays "other referral source" that has sent more than one referral ' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'referral-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'referral-widget', 'Other Referrals', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Other Referrals'.$after_title;

		echo '<ul>';
		global $referrals;
		$others = array_count_values($referrals);
		foreach ($others as $key=>$value) if ($value > 1) echo '<li>'.$key.': '.$value.'</li>';
		echo '</ul>';
		
		echo $after_widget;
	}

	
}

add_action('crm_stat_loop', 'crm_referral_loop');
function crm_referral_loop() {
	global $meta, $referrals, $prefix;
	if (isset($meta[$prefix.'other_referral'][0])) $referrals[] = $meta[$prefix.'other_referral'][0];

}