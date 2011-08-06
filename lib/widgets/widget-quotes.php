<?php
/* Outstanding Quotes Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_outstanding_quotes_load_widgets' );
function crm_outstanding_quotes_load_widgets() {
	register_widget( 'Outstanding_Quotes_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Outstanding_Quotes_Widget extends WP_Widget {
	function Outstanding_Quotes_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_outstanding_quotes', 'description' => '' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'outstanding-quotes-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'outstanding-quotes-widget', 'Outstanding Quotes', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title. 'Outstanding Quotes' .$after_title;
		
		$args = array(
			'category_name' => 'outstanding-quote',
			'posts_per_page' => '-1'
		);
		$new = new WP_Query($args);
		$count = 0;
		global $prefix;
		if ($new->have_posts()):
			echo '<ol>';
			while ($new->have_posts()): $new->the_post();
				global $post; ?>
				<li><a href="<?php echo get_edit_post_link();?>"><?php echo be_get_project_name(); ?></a>, <?php the_date();?> <?php edit_post_link('Edit', '(', ')');?>
				<?php $status = get_custom_field($prefix.'status_summary'); if ($status) echo '<br /><strong>Status:</strong> '.$status; ?>
				<br />
				<?php 
				$revenue = get_custom_field($prefix.'revenue'); if ($revenue) echo 'Quote: '.$revenue.'<br />';
				$email = get_custom_field($prefix.'client_email'); if ($email) echo 'Email: '.$email;
				$phone = get_custom_field($prefix.'client_phone'); if ($phone) echo 'Phone: '.$phone;
				?>
				</li>
				<?php
			$count++;
			endwhile;
			
			if($count < 1) echo "<p>This displays any contacts with a status of Outstanding Quote.</p>";
			
			echo '</ol>';
			else:
				echo "<p>This displays any contacts with a status of Outstanding Quote.</p>";
	
			endif;
			wp_reset_query();
		
		echo $after_widget;
	}

	
}