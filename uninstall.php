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

// // Do something here if plugin is being uninstalled.
// $pluginRepo = 'https://github.com/start-jobs/wp-schema-plugin/archive/master.zip';
// $downloadFolder = str_replace('wp-schema-plugin', 'wsp-testimonials.zip', __DIR__);
// $f = file_put_contents($downloadFolder, fopen("$pluginRepo", 'r'), LOCK_EX);
// if(FALSE === $f)
//     die("Couldn't write to file.");
// $zip = new ZipArchive;
// $res = $zip->open(str_replace('wp-schema-plugin', 'wsp-testimonials.zip', __DIR__));
// if ($res === TRUE) {
//   $zip->extractTo(str_replace('wp-schema-plugin', '', __DIR__));
//   $zip->close();
//   activate_plugin('wp-schema-plugin-master/wp-schema-plugin.php');
// } else {
//   //
// }
