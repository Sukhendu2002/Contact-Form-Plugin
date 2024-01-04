<?php
/**
 * Enqueue scripts and styles
 *
 * @package contact-plugin
 */

add_action( 'wp_enqueue_scripts', 'contact_enqueue_script' );
/**
 * Function for enqueue scripts
 */
function contact_enqueue_script(): void {
	wp_enqueue_script( 'contact-main-js', MY_PLUGIN_URL . 'public/js/main.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_style(
		'contact-style-css',
		MY_PLUGIN_URL . 'public/css/style.css',
		array(),
		filemtime( MY_PLUGIN_PATH . 'public/css/style.css' ),
		'all'
	);
}
