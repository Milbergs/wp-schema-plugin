<?php
/**
 * Plugin Name: WP Schema Plugin
 * Version: 1.4.4
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
	$instance = wp_schema_plugin::instance( __FILE__, '1.4.4' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = wp_schema_plugin_Settings::instance( $instance );
	}

	// updater
	if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
		$config = array(
			'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
			'proper_folder_name' => 'wp-schema-plugin', // this is the name of the folder your plugin lives in
			'api_url' => 'https://api.github.com/repos/start-jobs/wp-schema-plugin', // the GitHub API url of your GitHub repo
			'raw_url' => 'https://raw.github.com/start-jobs/wp-schema-plugin/master', // the GitHub raw url of your GitHub repo
			'github_url' => 'https://github.com/start-jobs/wp-schema-plugin', // the GitHub url of your GitHub repo
			'zip_url' => 'https://github.com/start-jobs/wp-schema-plugin/archive/master.zip', // the zip url of the GitHub repo
			'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
			'requires' => '4.0', // which version of WordPress does your plugin require?
			'tested' => '4.7', // which version of WordPress is your plugin tested up to?
			'readme' => 'README.md', // which file to use as the readme for the version number
			'access_token' => '', // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
		);
		new WP_GitHub_Updater($config);
	}

	return $instance;
}


// start the plugin
wp_schema_plugin();
// add_action( 'admin_init', 'wp_schema_plugin' );

// create custom testimonial post type
wp_schema_plugin()->register_post_type( 'wsp_testimonials', __( 'Testimonials', 'wp-schema-plugin' ), __( 'Testimonial', 'wp-schema-plugin' ) );
