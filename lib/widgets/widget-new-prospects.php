<?php
/* New Prospects Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_new_prospects_load_widgets' );
function crm_new_prospects_load_widgets() {
	register_widget( 'New_Prospects_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class New_Prospects_Widget extends WP_Widget {
	function New_Prospects_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_new_prospects', 'description' => 'Shows newest posts in the Prospect category' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'new-prospects-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'new-prospects-widget', 'New Prospects', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title. 'Newest Prospects' .$after_title;
		
		$new = new WP_Query('category_name=prospect&posts_per_page=20');
		$count = 0;
		global $prefix;
		if ($new->have_posts()):
			echo '<ol>';
			while ($new->have_posts()): $new->the_post();
				global $post; ?>
				<li><a href="<?php echo get_edit_post_link();?>"><?php echo be_get_project_name(); ?></a>, <?php the_date();?> <?php edit_post_link('Edit', '(', ')');?>
				<?php $status = get_custom_field($prefix.'status_summary'); if ($status) echo '<br /><strong>Status:</strong> '.$status; ?>
				<br />Source: <?php $sources = get_the_terms( $post->ID, 'sources', '', ', ', '' ); $list = ''; if ($sources) { foreach ($sources as $data) $list .= $data->name.', '; echo $list; }
				$email = get_custom_field($prefix.'client_email'); if ($email) echo '<br />Email: '.$email;
				$phone = get_custom_field($prefix.'client_phone'); if ($phone) echo '<br />Phone: '.$phone;
				?>
				</li>
				<?php
			$count++;
			endwhile;
			
			if($count < 1) echo "<p>WooHoo! You're either really fast at responding to prospects, or you haven't set up your categories yet. </p><p>This area shows posts that are 10 days or older and in the 'Prospect' category. If you haven't done so already, create a category with the slug 'prospect'.</p>";
			
			echo '</ol>';
			else:
				echo "<p>WooHoo! You're either really fast at responding to prospects, or you haven't set up your categories yet. </p><p>This area shows posts that are 10 days or older and in the 'Prospect' category. If you haven't done so already, create a category with the slug 'prospect'.</p>";
	
			endif;
			wp_reset_query();
		
		echo $after_widget;
	}

	
}