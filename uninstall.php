<?php

/**
 *
 * This file runs when the plugin in uninstalled (deleted).
 * This will not run when the plugin is deactivated.
 * Ideally you will add all your clean-up scripts here
 * that will clean-up unused meta, options, etc. in the database.
 *
 */

// If plugin is not being uninstalled, exit (do nothing)
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// remove all options
function wp_schema_plugin_uninstall(){
	$wsp_options = array(
		'wsp_LocalBusinessType',
		'wsp_BusinessName',
		'wsp_SiteUrl',
		'wsp_BusinessLogo',
		'wsp_BusinessImage',
		'wsp_Description',
		'wsp_Address',
		'wsp_City',
		'wsp_StateRegion',
		'wsp_PostalCode',
		'wsp_Country',
		'wsp_Lattitude',
		'wsp_Longtitude',
		'wsp_BusinessDays',
		'wsp_BusinessHoursOpening',
		'wsp_BusinessHoursClosing',
		'wsp_BusinessPhone',
		'wsp_ManualRating',
		'wsp_ManualReviews',
		'wsp_ToggleAutomatic',
		'wsp_social_facebook',
		'wsp_social_twitter',
		'wsp_social_google-plus',
		'wsp_social_instagram',
		'wsp_social_youtube',
		'wsp_social_linkedin',
		'wsp_social_myspace',
		'wsp_social_pinterest',
		'wsp_social_soundcloud',
		'wsp_social_tumblr',
		'wsp_social_avvo',
		'wsp_social_yelp',
		'wsp_PriceRange',
		'wsp_Breadcrumbs',
		'wsp_BreadcrumbSpacing',
		'wsp_PersonName',
		'wsp_PersonJobTitle',
		'wp_schema_plugin_version'
	);

	foreach($wsp_options as $option){
		delete_option($option);
	}

	// install fallbacks Testimonials
	$pluginRepo = 'https://github.com/kasparsp/wsp-testimonials/archive/master.zip';
	$downloadFolder = str_replace('wp-schema-plugin', 'wsp-testimonials.zip', __DIR__);
	$f = file_put_contents($downloadFolder, fopen("$pluginRepo", 'r'), LOCK_EX);
	if(FALSE === $f)
	    die("Couldn't write to file.");
	$zip = new ZipArchive;
	$res = $zip->open(str_replace('wp-schema-plugin', 'wsp-testimonials.zip', __DIR__));
	if ($res === TRUE) {
	  $zip->extractTo(str_replace('wp-schema-plugin', '', __DIR__));
	  $zip->close();
	  activate_plugin('wsp-testimonials-master/wsp-testimonials.php');
	} else {
	  //
	}
}


wp_schema_plugin_uninstall();
