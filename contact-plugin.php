<?php
/**
 * Plugin Name: Contact Plugin
 *
 * @package ContactPlugin
 */

/**
 * Plugin Name: Contact Plugin
 * Description: A plugin to create contact forms.
 * Version: 1.0.0
 * Text Domain: contact-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

if ( ! class_exists( 'ContactPlugin' ) ) {
	/**
	 * ContactPlugin class
	 */
	class ContactPlugin {
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
			define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			require_once MY_PLUGIN_PATH . '/vendor/autoload.php';
		}

		/**
		 * Initialize the plugin
		 */
		public function initialize() {
			require_once MY_PLUGIN_PATH . '/includes/utils.php';
			require_once MY_PLUGIN_PATH . '/includes/options-page.php';
		}
	}
	$contact_plugin = new ContactPlugin();
	$contact_plugin->initialize();
}
