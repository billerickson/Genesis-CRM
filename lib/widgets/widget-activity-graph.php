<?php
/* Activity Graph Widget */
/* Based on the WordPress Archive Chart Plugin */
/* @link: http://wordpress.org/extend/plugins/wordpress-archive-chart */


/** Add our function to the widgets_init hook. **/
add_action( 'widgets_init', 'crm_activity_graph_load_widgets' );
function crm_activity_graph_load_widgets() {
	register_widget( 'Activity_Graph_Widget' );
}

/** Define the Widget as an extension of WP_Widget **/
class Activity_Graph_Widget extends WP_Widget {
	function Activity_Graph_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_activity_graph', 'description' => 'Graphs the number of contacts added by date' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'activity-graph-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'activity-graph-widget', 'Activity Graph', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.'Activity Graph'.$after_title;
		

	global $wpdb, $wp_locale;

	$name = '';
	$width = '280';
	$height = '120';
	$count = '12';
	$linecolor = '3D7930';
	$fillcolor = 'C5D4B5';
	$filltrans = 'BB';
	$bgcolor = 'FFFFFF';
	$bgtrans = '';
	$r = '';
	$limit = '';

	$where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
	$join  = apply_filters( 'getarchives_join', "", $r );

	$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
	$key   = md5($query);
	$cache = wp_cache_get( 'wp_get_archives' , 'general');

	if ( !isset( $cache[ $key ] ) ) {
		$arcresults = $wpdb->get_results($query);
		$cache[ $key ] = $arcresults;
		wp_cache_set( 'wp_get_archives', $cache, 'general' );
	} else {
		$arcresults = $cache[ $key ];
	}

	foreach( (array) $arcresults as $arcresult ) {
		$archivemonths[] = $text = sprintf(__('%1$s %2$d'), substr( $wp_locale->get_month($arcresult->month), 0, 3 ) , $arcresult->year );
		$archivecounts[] = $arcresult->posts;
	};

	// cut the "last" n entries, default above is 12
	$archivemonths = array_slice( $archivemonths, 0, esc_attr( $count ) );
	$archivecounts = array_slice( $archivecounts, 0, esc_attr( $count ) );

	// reverse the arrays
	$archivemonths = array_reverse( $archivemonths );
	$archivecounts = array_reverse( $archivecounts );

	//find max val
	$archivemax = max( $archivecounts );
	
	$chart_code =  '<img '.
	'width="' . esc_attr( $width ) . '" '
	. 'height="' . esc_attr($height) . '" '
	. 'alt="" '
	. 'src="http://chart.apis.google.com/chart?'
	// title
	. 'chtt=' . esc_attr( $name ) . '&amp;'
	// fill labels of the x-axis
	. 'chxl=0:|' . join( '|', $archivemonths )  . '&amp;'
	//scale
	. 'chxr=0,0,' . ( $archivemax + 1 ) . '|1,0,' . ( $archivemax + 1 ) . '&amp;'
#	. 'chxs=0,676767,11.5,0,lt,676767' . '&amp;'
	// select axises
	. 'chxt=x,y&amp;'
	// scaling
	. 'chs=' . esc_attr( $width ) . 'x' . esc_attr( $height ) .'&amp;'
	// chart type
	. 'cht=lc&amp;'
	// chart color (line)
	. 'chco=' . esc_attr( $linecolor ) . '&amp;'
	// fill color marker
		// B, --> FILL path
		// C5D4B5 --> COLOR
		// BB --> TRANSPARENCY
		// 0,0,0 --> PRIORITY
	. 'chm=B,' . esc_attr( $fillcolor ) . esc_attr( $filltrans ) . ',0,0,0&amp;'
	// background-color and transparency of the image
	. 'chf=bg,s,' . esc_attr( $bgcolor ) . esc_attr( $bgtrans ) . '&amp;'
	// fill data of numbers
	. 'chd=t:' . join( ',', $archivecounts ) . '&amp;'
	// scale
	. 'chds=0,' . ( $archivemax + 1 ) . '&amp;'
	// line style
	. 'chls=2,4,0&amp;'
	// grid size, line-style of grid
	// (-1) -> automatic, which means: for every data point 1 vertical
	. 'chg=-1,-1,1,1">';

	echo $chart_code;


		echo $after_widget;
	}

	
}