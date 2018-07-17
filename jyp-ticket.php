<?php

/*
 *	Plugin Name: Yohan's Ticketing Plugin
 *	Plugin URI: http://wordpress.org/
 *	Description: A ticketing plugin for support requests.
 *	Version: 1.0
 *	Author: Yohan Park
 *	Author URI: http://wordpress.org
 *	License: GPL2
 *
*/

/*
* demo ticket manager
* user: boblob
* pass: #5vFUKBlV@8(3FXvi*IzO4NC
*
* 2nd demo ticket manager
* user: michaelbluth
* pass: TR1IaP)4PBo8jhD^o%%DQtq(
*/


/*
* create custom post type
*
*/
function jyp_tickets() {
	//labels for custom post type
	$labels = array(
		'name'					=> __('Tickets'),
		'singualr_name'			=> __('Ticket'),
		'add_new'				=> __('Add New'),
		'add_new_item'			=> __('Add New Ticket'),
		'new_item'				=> __('New Ticket'),
		'edit_item'				=> __('Edit Ticket'),
		'view_item'				=> __('View Ticket'),
		'search_items'			=> __('Search Tickets'),
		'parent_item_colon'		=> __('Parent Tickets'),
		'not_found'				=> __('No Tickets Found'),
		'not_found_in_trash'	=> __('No tickets found in trash'),
		'archives'				=> __('Tickets Archive'),
		'insert_into_item'		=> __('Insert into ticket'),
		'uploaded_to_this_item'	=> __('Uploaded to this ticket'),
		'filter_items_list'		=> __('Filter ticket list'),
		'items_list_navigation'	=> __('Ticket list navigation'),
		'items_list'			=> __('Ticket list'),
	);
	//arguemnts for custom post type
	$args = array(
		'labels'			=> $labels,
		'public'			=> true,
		'publicly_queryable'=> true,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'query_var'			=> true,
		'rewrite'			=> array( 'slug' => 'tickets' ),
		'has_archive'		=> true,
		'hierarchical'		=> false,
		'menu_position'		=> null,
		'supports'			=> array( 'title', 'editor', 'author', 'custom-fields', 'comments' ),
		'capability_type'	=> array( 'jyp_ticket', 'jyp_tickets'),	//hooks $jyp_ticket_manager_role()
		'map_meta_cap'		=> true,								//hooks $jyp_ticket_manager_role()
	);
	//register this post type
	register_post_type( 'tickets', $args );
}
add_action( 'init', 'jyp_tickets' );

/*
* accept and process form data from CF7
*
*/

$tickets_select_custom_list = array(
	'your-name',
	'your-email',
	'your-phone',
	'importance',
	'department',
	'assigned-to',
	'building',
	'unit',
	'contact-preference'

);

function save_posted_data( $posted_data ) {

	//if the form title is Support Form, process the form
	$wpcf7 = WPCF7_ContactForm::get_current();
	if( $wpcf7->title == 'Support Form' ){

	//arguemtns for insert post
	$args = array(
		'post_type'		=> 'tickets',
		'post_status'	=> 'publish',
		'post_title'	=> $posted_data['your-subject'],
		'post_content'	=> $posted_data['your-message'],
		'post_author'	=> $posted_data['your-name'],
	);
	//insert post
	$post_id = wp_insert_post($args);


	//check if the populated item is not an error
	if(!is_wp_error($post_id)){	
		//check that field is set and update meta
		if( isset( $posted_data[ 'your-name' ]) ){	
			update_post_meta( $post_id, 'your-name' , $posted_data[ 'your-name' ]);
		}
		if( isset( $posted_data[ 'your-name' ]) ){	
			update_post_meta( $post_id, 'your-email' , $posted_data[ 'your-email' ]);
		}
		if( isset( $posted_data[ 'your-name' ]) ){	
			update_post_meta( $post_id, 'your-phone' , $posted_data[ 'your-phone' ]);
		}
		if( isset( $posted_data[ 'importance' ]) ){	
			update_post_meta( $post_id, 'importance' , $posted_data[ 'importance' ]);
		}
		if( isset( $posted_data[ 'department' ]) ){	
			update_post_meta( $post_id, 'department' , $posted_data[ 'department' ]);
		}
		if( isset( $posted_data[ 'building' ]) ){	
			update_post_meta( $post_id, 'building' , $posted_data[ 'building' ]);
		}
		if( isset( $posted_data[ 'unit' ]) ){	
			update_post_meta( $post_id, 'unit' , $posted_data[ 'unit' ]);
		}
		if( isset( $posted_data[ 'contact-preference' ]) ){	
			update_post_meta( $post_id, 'contact-preference' , $posted_data[ 'contact-preference' ]);
		}
	}
	return $posted_data;
		
	}
}

add_filter( 'wpcf7_posted_data', 'save_posted_data');

/*
* Use Custom Templates
*
*/

function get_ticket_template( $template ) {
     global $post;
     function get_custom_field( $field_name ){
     	echo get_post_meta( get_the_ID(), $field_name, true);
     }

     $plugindir = plugin_dir_path(__FILE__);

     if ( is_post_type_archive( 'tickets' ) ) {
         $template = $plugindir . 'templates/archive-tickets.php';
     }
     if ( is_singular( 'tickets' ) ) {
		$template = $plugindir . 'templates/single-tickets.php';
	}
    return $template;
}

add_filter( 'template_include', 'get_ticket_template' );


/*
* User Role Ticket Manager
*
*/

function jyp_ticket_manager_role(){
	add_role(
		'jyp_ticket_manager',
		'Ticket Manager',
		array(
			'read'			=> true,
			'edit_posts'	=> false,
			'delete_posts'	=> false,
			'publish_posts'	=> false,
			'upload_files'	=> true,
		)

	);
}

register_activation_hook( __FILE__, 'jyp_ticket_manager_role' );

//custom role capabilities
function jyp_ticket_role_caps(){
	$roles = array( 'jyp_ticket_manager', 'editor', 'administrator' );
	foreach( $roles as $the_role ){
		$role = get_role( $the_role );
		//if( !$role ) continue;
		$role->add_cap( 'read' );
		$role->add_cap( 'read_jyp_ticket');
		$role->add_cap( 'read_private_jyp_tickets' );
		$role->add_cap( 'edit_jyp_ticket' );
		$role->add_cap( 'edit_jyp_tickets' );
		$role->add_cap( 'edit_others_jyp_tickets' );
		$role->add_cap( 'edit_published_jyp_tickets' );
		$role->add_cap( 'edit_private_jyp_tickets');
		$role->add_cap( 'publish_jyp_tickets' );
		$role->add_cap( 'delete_jyp_ticket' );
		$role->add_cap( 'delete_jyp_tickets' );
		$role->add_cap( 'delete_others_jyp_tickets' );
		$role->add_cap( 'delete_private_jyp_tickets' );
		$role->add_cap( 'delete_published_jyp_tickets' );
	}
}
add_action( 'admin_init', 'jyp_ticket_role_caps', 999 );


/*
* Custom admin Columns for Post Type Tickets
*
*/

//add admin columns
function jyp_ticket_columns_list() {
	$columns['importance']	= __( 'Importance' );
	$columns['department']	= __( 'Department' );
	$columns['building']	= __( 'Building Number' );
	$columns['unit']		= __( 'Unit Number' );
	$columns['assigned_to']	= __( 'Assigned To' );
	$columns['id']			= __( 'ID#' );
	return $columns;
}
add_filter( 'manage_tickets_posts_columns', 'jyp_ticket_columns_list' );

//reorder columns
function jyp_ticket_admin_columns() {
	$columns = array(
		'cb'			=> $columns['cb'], //check box
		'title'			=> __('Title'),
		'date'			=> __( 'Date' ),
		'author'		=> __( 'Author' ),
		'building'		=> __( 'Building Number' ),
		'unit'			=> __( 'Unit Number' ),
		'importance'	=> __( 'Importance' ),
		'department'	=> __( 'Department' ),
		'assigned_to'	=> __( 'Assigned To' ),
		'id'			=> __( 'ID#' ),
	);
	return $columns;
}
add_filter( 'manage_tickets_posts_columns', 'jyp_ticket_admin_columns' );

//populate column
function jyp_ticket_column_values( $column, $post_id ){
	switch( $column ){
		case 'importance':
		case 'department':
		case 'assigned_to':
		case 'building':
		case 'unit':
			echo get_post_meta( $post_id, $column, true );
		break;

		case 'id': 
			echo get_the_ID();
		break;
	}
}
add_action( 'manage_tickets_posts_custom_column', 'jyp_ticket_column_values', 10, 2 );

/*
* Metabox 2
*
*/

//callback function admin display
function show_ticket_meta_box( $object ) {

    wp_nonce_field( basename(__FILE__), 'meta-box-nonce' );
    require( plugin_dir_path(__FILE__) . 'admin/meta-box.php' );
}

//save meta
function jyp_ticket_save_meta( $post_id ) {
	
	// validation
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'meta-box-nonce' ] ) && wp_verify_nonce( $_POST[ 'meta-box-nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	$can_edit_tickets = current_user_can( 'edit_jyp_tickets', $post_id );

    // Exits script depending on status
    if ( $is_autosave || !$is_valid_nonce || !$can_edit_tickets ) {
        return;
    }
	
    // Checks for input and sanitizes and saves if needed
	if( !is_wp_error( $post_id ) ){
		if ( isset ( $_POST[ 'importance' ] ) ) {
			update_post_meta( $post_id, 'importance', $_POST[ 'importance' ] );
		}
		if ( isset ( $_POST[ 'department' ] ) ) {
			update_post_meta( $post_id, 'department', $_POST[ 'department' ] );
		}
		if ( isset ( $_POST[ 'assigned-to' ] ) ) {
			update_post_meta( $post_id, 'assigned-to', $_POST[ 'assigned-to' ] );
		}
		if ( isset ( $_POST[ 'building' ] ) ) {
			update_post_meta( $post_id, 'building', $_POST[ 'building' ] );
		}
		if ( isset ( $_POST[ 'unit' ] )  && $_POST[ 'unit' ] !== "" ) {
			update_post_meta( $post_id, 'unit', $_POST[ 'unit' ] );
		}
		if ( isset ( $_POST[ 'contact-preference' ] ) && $_POST[ 'building' ] !== "" ) {
			update_post_meta( $post_id, 'contact-preference', $_POST[ 'contact-preference' ] );

		}

	}
}
add_action( 'save_post', 'jyp_ticket_save_meta', 10 , 3 );

//add ticket metabox
function jyp_tickets_add_meta_box() {
	add_meta_box(
		'ticket_meta_box',		//$id* 			used in the 'id' attribute for the meta box
		'Ticket Details',		//$title* 		title of the meta box
		'show_ticket_meta_box',	//$callback* 	fills the box with desired content (echo output)
		'tickets',				//$screen 		screen/s to show the box (ex. post type, 'link', or 'comment')
		'side',					//$context 		where the boxes should display ('normal', 'side', and 'advanced')
		'high'					//$priority 	('high', 'low')
		//$callback_args 
	);
}
add_action( 'add_meta_boxes', 'jyp_tickets_add_meta_box');

/*
* settings page
*
*/

//register option
function test_submenu(){
	$parent_slug	= 'edit.php?post_type=tickets';
	$page_title		= 'Ticket Settings';
	$menu_title		= 'Settings';
	$capability 	= 'edit_posts';
	$menu_slug		= 'tickets-settings';
	$function		= 'jyp_tickets_settings_page';
	add_submenu_page(
		$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function
	);
}
add_action( 'admin_menu', 'test_submenu');

//display and save
function jyp_tickets_settings_page(){

	//yohan, work on validation and settings display page

	// validation
    $is_valid_nonce = wp_verify_nonce( 'settings_nonce' );
	$can_edit_tickets = current_user_can( 'edit_posts' );

    // kill script depending on save status
    //if ( !$is_valid_nonce || !$can_edit_tickets ) {
    //    wp_die( 'Unauthorized User' );
    //}

	//if form is selected from settings save form 
	if ( isset( $_POST['cf7-form'] ) ){
		$value = $_POST['cf7-form'];
		update_option( 'cf7-form', $value );
	}

	//get exisiting cf7 forms
	$forms = get_posts( array(
       'post_type'     => 'wpcf7_contact_form',
       'numberposts'   => -1
    ) );

    //get existing option
	$options = get_option( 'cf7-form' );

	//settings page
	include 'admin/settings.php';

}


/*
* deregister cf7 css and js on select pages
*
*/


function jyp_deregister_cf7_scripts(){
	if ( !is_page( array(
		'contact',
		'contact-us',
		'contact-form',
		'tickets',
		'ticket',
		'suport-ticket',
		'suport-tickets',
		'support'
	) ) ){
		wp_deregister_script( 'contact-form-7' );
	}
}
add_action( 'wp_print_scripts', 'jyp_deregister_cf7_scripts', 100 );

function jyp_deregister_cf7_styles(){
	if ( !is_page( array(
		'contact',
		'contact-us',
		'contact-form',
		'tickets',
		'ticket',
		'suport-ticket',
		'suport-tickets',
		'support'
	) ) ){
		wp_deregister_style( 'contact-form-7' );
	}
}
add_action( 'wp_print_styles', 'jyp_deregister_cf7_styles', 100 );



