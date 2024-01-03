<?php
/**
 * Enqueue scripts and styles
 *
 * @package ContactPlugin
 */

add_action( 'wp_enqueue_scripts', 'contact_enqueue_script' );
/**
 * Function for enqueue scripts
 */
function contact_enqueue_script(): void {
	wp_enqueue_script( 'contact-main-js', MY_PLUGIN_URL . 'public/js/main.js', array( 'jquery' ), '1.0.0', true );
}
