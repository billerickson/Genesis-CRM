<?php
/**
 * Create Metaboxes
 *
 * @package      Genesis CRM
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

function be_create_metaboxes() {
	global $prefix;
	$prefix = '_crm_';
	$meta_boxes = array();

	$meta_boxes[] = array(
    	'id' => 'client_information',
	    'title' => 'Client Information',
	    'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names left of input
	    'fields' => array(
	        array(
	            'name' => 'Client Email',
	            'id' => $prefix.'client_email',
	            'desc' => 'Client Email',
	            'type' => 'text',
	        ),
	        array(
	            'name' => 'Client Phone',
	            'id' => $prefix.'client_phone',
	            'desc' => 'Client Phone',
	            'type' => 'text',
	        ),
	        array(
	            'name' => 'Client URL',
	            'id' => $prefix.'client_url',
	            'desc' => 'Client URL',
	            'type' => 'text',
	        ),
	        array(
	        	'name' => 'Project Name',
	        	'id' => $prefix.'project_name',
	        	'desc' => '',
	        	'type' => 'text'
	        ),
	        array(
	            'name' => 'Other Referral',
	            'id' => $prefix.'other_referral',
	            'desc' => 'Other Referral Source',
				'type' => 'text',
	        )
	    )
	);

	$meta_boxes[] = array(
	    'id' => 'project_information',
	    'title' => 'Project Information',
	    'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names left of input
	    'fields' => array(
	        array(
	        	'name' => 'Reason for forwarding away or losing',
	        	'id' => $prefix.'reason', 
	        	'type' => 'select',
	        	'options' => array(
	        		array('name' => '', 'value' => ''),
	        		array('name' => 'project too small', 'value' => 'project too small'),
	        		array('name' => 'not interested', 'value' => 'not interested'),
	        		array('name' => 'outside expertise', 'value' => 'outside expertise'),
	        		array('name' => 'timeframe too short', 'value' => 'timeframe too short'),
	        		array('name' => 'quoted too high', 'value' => 'quoted too high')
	        	)
	        ),
	        array(
	        	'name' => 'Project Type',
	        	'id' => $prefix . 'project_type',
	        	'type' => 'select',
	        	'options' => array(
	        		array( 'name' => 'Custom Theme', 'value' => 'Custom Theme'),
	        		array( 'name' => 'Theme Modification', 'value' => 'Theme Modification' ),
	        	)
	        ),
	        array(
	            'name' => 'Project Status',
	            'id' => $prefix.'project_status',
	            'type' => 'radio_inline',
	            'options' => array(
	            	array('name' => 'Dev', 'value' => 'dev'),
	            	array('name' => 'Edit', 'value' => 'edit'),
	            	array('name' => 'Dev Complete', 'value' => 'dev-complete'),
	            	array('name' => 'Project Complete', 'value' => 'project-complete'),
	            	array('name' => 'Maintenance', 'value' => 'maintenance')
	            )
	        ),
	        array(
	   	     	'name' => 'Needs Work',
	        	'id' => $prefix.'needs_work',
	        	'type' => 'radio_inline',
	        	'options' => array(
	        		array('name' => 'Yes', 'value' => 'yes'),
	        		array('name' => 'No', 'value' => 'no'),
	        		array( 'name' => 'Delayed', 'value' => 'delayed' ),
   		     	)
	        ),
	        array(
	            'name' => 'Status Summary',
	            'id' => $prefix.'status_summary',
	            'type' => 'text',
	        ),
	        array(
	        	'name' => 'Revenue',
 		       	'id' => $prefix.'revenue',
	        	'type' => 'text_money',
	        ),
 	       array(
	        	'name' => 'Expense',
	        	'id' => $prefix.'expense',
	        	'type' => 'text_money',
	        ),
 	   )
	);

	$meta_boxes[] = array(
	    'id' => 'project-dates',
	    'title' => 'Project Dates',
	    'pages' => array('post'), // post type
		'context' => 'side',
		'priority' => 'high',
		'show_names' => true, // Show field names left of input
	    'fields' => array(
			array(
		        'name' => 'Dev Start',
		        'desc' => '',
		        'id' => $prefix . 'date_dev_start',
		        'type' => 'text_date_timestamp'
		    ),
			array(
		        'name' => 'Complete',
		        'desc' => '',
		        'id' => $prefix . 'date_complete',
		        'type' => 'text_date_timestamp'
		    ),
		    array(
		    	'name' => 'Include in Complete Listing',
		    	'desc' => '',
		    	'id' => $prefix.'include_complete',
		    	'type' => 'checkbox'
		    )
	    )
	);

	$meta_boxes[] = array(
	    'id' => 'crm_notes',
	    'title' => 'Notes',
	    'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => false, // Show field names left of input
	    'fields' => array()
	);
	
	$meta_boxes[] = array(
		'id' => 'server-information',
		'title' => 'Server Information',
		'pages' => array('post'),
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => false,
		'fields' => array(
			array(
				'name' => 'Server Information',
				'desc' => '',
				'id' => $prefix . 'server_information',
				'type' => 'textarea'
			)
		)
	);

 	
 	require_once(CHILD_DIR . '/lib/metabox/init.php'); 
}

?>