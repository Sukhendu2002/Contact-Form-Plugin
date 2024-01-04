<?php
/**
 * Trigger this file on Plugin uninstall
 *
 * @package contact-plugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clear posts of type 'submission' and related post meta.
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'submission'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );

// Clear all options.
$wpdb->query( "DELETE FROM wp_options WHERE option_name LIKE '_contact_plugin%'" );