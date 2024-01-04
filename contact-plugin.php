<?php
/**
 * Plugin Name: Contact Plugin
 *
 * @package contact-plugin
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
			define( 'MY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			require_once MY_PLUGIN_PATH . '/vendor/autoload.php';
		}

		/**
		 * Initialize the plugin
		 */
		public function initialize(): void {
			require_once MY_PLUGIN_PATH . '/includes/utils.php';
			require_once MY_PLUGIN_PATH . '/includes/enqueue.php';
			require_once MY_PLUGIN_PATH . '/includes/options-page.php';
			require_once MY_PLUGIN_PATH . '/includes/contact-form.php';
		}
	}
	$contact_plugin = new ContactPlugin();
	$contact_plugin->initialize();
}
