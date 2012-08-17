<?php
/**
 * Template Name: Form 
 *
 * @package      Genesis CRM
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

wp_head(); 

?>
<style>
#gform_wrapper_1 input,
#gform_wrapper_1 textarea,
#gform_wrapper_1 label {
	font-size: 13px;
	line-height: 20px;
	font-family: Helvetica, Arial, sans-serif;
}
</style>
<?php

if( have_posts() ): while( have_posts() ): the_post();
	the_content();
endwhile; endif;
?>