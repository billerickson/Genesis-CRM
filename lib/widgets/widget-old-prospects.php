<?php
/* Old Prospects Widget */
/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_prospects_load_widgets' );
function crm_prospects_load_widgets() {
	register_widget( 'Old_Prospects_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Old_Prospects_Widget extends WP_Widget {
	function Old_Prospects_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_old_prospects', 'description' => 'Shows posts that are 10 days or older and in the Prospect category' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'old-prospects-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'old-prospects-widget', 'Old Prospects', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'10 Day Old Prospects'.$after_title;
		
		$old = new WP_Query('category_name=prospect&showposts=-1&posts_per_page=-1&order=ASC');
		$count = 0;
		global $prefix;
		if ($old->have_posts()):
			echo '<ol>';
			while ($old->have_posts()): $old->the_post();
				global $post;
				if ($post->post_date > date('Y-m-d', strtotime('-10 days'))) continue; ?>
				<li><a href="<?php echo get_edit_post_link();?>"><?php echo be_get_project_name(); ?></a>, <?php the_date();?> <?php edit_post_link('Edit', '(', ')');?>
				<?php $status = get_custom_field($prefix.'status_summary'); if ($status) echo '<br /><strong>Status:</strong> '.$status; ?>
				<br />Source: <?php $sources = get_the_terms( $post->ID, 'sources', '', ', ', '' ); $list = ''; if ($sources) { foreach ($sources as $data) $list .= $data->name.', '; echo $list; }
				$email = get_custom_field($prefix.'client_email'); if ($email) echo 'Email: '.$email;
				$phone = get_custom_field($prefix.'client_phone'); if ($phone) echo 'Phone: '.$phone;
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