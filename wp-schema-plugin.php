<?php
/**
 * Plugin Name: WP Schema Plugin
 * Version: 1.4.2
 * Plugin URI: http://www.onthemapmarketing.com/
 * Description: Schema enhancement for Wordpress.
 * Author: On The Map Marketing
 * Author URI: http://www.onthemapmarketing.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 * GitHub Plugin URI: /start-jobs/wp-schema-plugin
 * GitHub Plugin URI: https://github.com/start-jobs/wp-schema-plugin
 *
 * Text Domain: wp-schema-plugin
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-wp-schema-plugin.php' );
require_once( 'includes/class-wp-schema-plugin-updater.php' );
require_once( 'includes/class-wp-schema-plugin-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-wp-schema-plugin-admin-api.php' );
require_once( 'includes/lib/class-wp-schema-plugin-post-type.php' );
require_once( 'includes/lib/class-wp-schema-plugin-taxonomy.php' );
require_once( 'includes/lib/wp-schema-plugin-testimonial-meta.php' );
require_once( 'includes/lib/wp-schema-plugin-shortcodes.php' );
require_once( 'includes/lib/class-wp-schema-plugin-jsonld.php' );

/**
 * Returns the main instance of wp_schema_plugin to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object wp_schema_plugin
 */
function wp_schema_plugin () {
	$instance = wp_schema_plugin::instance( __FILE__, '1.4.2' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = wp_schema_plugin_Settings::instance( $instance );
	}

	return $instance;
}


// start the plugin
wp_schema_plugin();
// add_action( 'admin_init', 'wp_schema_plugin' );

// create custom testimonial post type
wp_schema_plugin()->register_post_type( 'wsp_testimonials', __( 'Testimonials', 'wp-schema-plugin' ), __( 'Testimonial', 'wp-schema-plugin' ) );

// // enhgage the updater
$updater = new wp_schema_plugin_updater( __FILE__ );
$updater->set_username( 'start-jobs' );
$updater->set_repository( 'wp-schema-plugin' );
// $updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
$updater->initialize();
