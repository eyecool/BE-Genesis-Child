<?php
/**
 * Functions
 *
 * @package      BE Genesis Child
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Theme Setup
 *
 * This setup function attaches all of the site-wide functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */

add_action('genesis_setup','child_theme_setup', 15);
function child_theme_setup() {
	
	// ** Backend **	
	
	// Image Sizes
	// add_image_size ('be_featured', 400, 100, true );
	
	// Sidebars
	//unregister_sidebar('sidebar-alt');
	//genesis_register_sidebar(array('name' => 'Blog Sidebar', 'id' => 'blog-sidebar'));
	//add_theme_support( 'genesis-footer-widgets', 3 );

	// Remove Unused Page Layouts
	//genesis_unregister_layout( 'full-width-content' );
	//genesis_unregister_layout( 'content-sidebar' );	
	//genesis_unregister_layout( 'sidebar-content' );
	//genesis_unregister_layout( 'content-sidebar-sidebar' );
	//genesis_unregister_layout( 'sidebar-sidebar-content' );
	//genesis_unregister_layout( 'sidebar-content-sidebar' );
	
	// Editor Styles
	add_editor_style( 'editor-style.css' );
		
	// Setup Theme Settings, if Genesis 1.8 or later
	if ( version_compare( PARENT_THEME_VERSION, '1.7.9', '>' ) ) 
		include_once( CHILD_DIR . '/lib/admin/child-theme-settings.php');
	
	// Don't update theme
	add_filter( 'http_request_args', 'be_dont_update_theme', 5, 2 );
		
	// ** Frontend **		
	
	// Remove Edit link
	add_filter( 'edit_post_link', '__return_false' );
}

// ** Backend Functions ** //

/**
 * Don't Update Theme
 * If there is a theme in the repo with the same name, 
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */

function be_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}

// ** Frontend Functions ** //