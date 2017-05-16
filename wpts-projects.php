<?php
/*
Plugin Name: WPTS Projects
Plugin URI:  http://webpagesthatsell.com/
Description: Simple plugin that handle Projects via custom post type.
Version:     1.0.2
Author:     Web Pages That Sell
Author URI:  http://webpagesthatsell.com/
Text Domain: wpts-projects
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// register activation & deactivation action hook
register_activation_hook( __FILE__, 'wpts_projects_activation' );
register_deactivation_hook( __FILE__, 'wpts_projects_deactivation' );

// register project post type
function wpts_projects_setup_post_types() {

  	$labels = array(
  		'name'                  => _x( 'Projects', 'Post Type General Name', 'wpts-projects' ),
  		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'wpts-projects' ),
  		'menu_name'             => __( 'Projects', 'wpts-projects' ),
  		'name_admin_bar'        => __( 'Project', 'wpts-projects' ),
  		'archives'              => __( 'Item Archives', 'wpts-projects' ),
  		'attributes'            => __( 'Item Attributes', 'wpts-projects' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'wpts-projects' ),
  		'all_items'             => __( 'All Projects', 'wpts-projects' ),
  		'add_new_item'          => __( 'Add Project', 'wpts-projects' ),
  		'add_new'               => __( 'Add Project', 'wpts-projects' ),
  		'new_item'              => __( 'New Project', 'wpts-projects' ),
  		'edit_item'             => __( 'Edit Project', 'wpts-projects' ),
  		'update_item'           => __( 'Update Project', 'wpts-projects' ),
  		'view_item'             => __( 'View Project', 'wpts-projects' ),
  		'view_items'            => __( 'View Projects', 'wpts-projects' ),
  		'search_items'          => __( 'Search Project', 'wpts-projects' ),
  		'not_found'             => __( 'Not found', 'wpts-projects' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'wpts-projects' ),
  		'featured_image'        => __( 'Featured Image', 'wpts-projects' ),
  		'set_featured_image'    => __( 'Set featured image', 'wpts-projects' ),
  		'remove_featured_image' => __( 'Remove featured image', 'wpts-projects' ),
  		'use_featured_image'    => __( 'Use as featured image', 'wpts-projects' ),
  		'insert_into_item'      => __( 'Insert into Project', 'wpts-projects' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this Project', 'wpts-projects' ),
  		'items_list'            => __( 'Items list', 'wpts-projects' ),
  		'items_list_navigation' => __( 'Items list navigation', 'wpts-projects' ),
  		'filter_items_list'     => __( 'Filter items list', 'wpts-projects' ),
  	);
  	$rewrite = array(
  		'slug'                  => 'project',
  		'with_front'            => true,
  		'pages'                 => true,
  		'feeds'                 => true,
  	);
  	$args = array(
  		'label'                 => __( 'Project', 'wpts-projects' ),
  		'description'           => __( 'Create project custom post type.', 'wpts-projects' ),
  		'labels'                => $labels,
  		'supports'              => array( 'title', 'editor', 'thumbnail', ),
  		'taxonomies'            => array( 'category', 'post_tag' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 5,
  		'menu_icon'             => 'dashicons-layout',
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => true,
  		'can_export'            => true,
  		'has_archive'           => 'projects',
  		'exclude_from_search'   => false,
  		'publicly_queryable'    => true,
  		'rewrite'               => $rewrite,
  		'capability_type'       => 'page',
  	);
  	register_post_type( 'wpts_projects', $args );

}
add_action( 'init', 'wpts_projects_setup_post_types', 0 );

// action on activation
function wpts_projects_activation() {

  // trigger our function that registers the custom post type
  wpts_projects_setup_post_types();

  // clear the permalinks after the post type has been registered
  flush_rewrite_rules();
}

// action on deactivation
function wpts_projects_deactivation() {

  // clear the permalinks to remove our post type's rules
  flush_rewrite_rules();
}

define( 'WPTS_PROJECTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPTS_PROJECTS_DIRECTORY', plugin_dir_url( __FILE__ ) );
define( 'WPTS_PROJECTS_VERSION', '1.0.2' );
include( WPTS_PROJECTS_PATH . 'inc/wpts-projects-metabox.php');

function wpts_projects_asset() {
  wp_register_style( 'wpts-projects', WPTS_PROJECTS_DIRECTORY . 'css/wpts-projects.css', array(),  WPTS_PROJECTS_VERSION );
  wp_enqueue_style( 'wpts-projects' );
}
add_action( 'wp_enqueue_scripts', 'wpts_projects_asset' );
