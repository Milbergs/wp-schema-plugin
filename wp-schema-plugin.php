<?php
/*
 * Plugin Name: WP Schema Plugin
 * Version: 0.1
 * Plugin URI: http://www.onthemapmarketing.com/
 * Description: Schema enhancement for Wordpress.
 * Author: On The Map Marketing
 * Author URI: http://www.onthemapmarketing.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
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
require_once( 'includes/class-wp-schema-plugin-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-wp-schema-plugin-admin-api.php' );
require_once( 'includes/lib/class-wp-schema-plugin-post-type.php' );
require_once( 'includes/lib/class-wp-schema-plugin-taxonomy.php' );
require_once( 'includes/lib/testimonial-meta.php' );
require_once( 'includes/lib/class-wp-schema-plugin-json.php' );

/**
 * Returns the main instance of wp_schema_plugin to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object wp_schema_plugin
 */
function wp_schema_plugin () {
	$instance = wp_schema_plugin::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = wp_schema_plugin_Settings::instance( $instance );
	}

	return $instance;
}

wp_schema_plugin();
wp_schema_plugin()->register_post_type( 'bustr_testimonials', __( 'Testimonials', 'wp-schema-plugin' ), __( 'Testimonials', 'wp-schema-plugin' ) );
