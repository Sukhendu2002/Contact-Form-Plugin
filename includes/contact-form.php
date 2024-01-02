<?php
/**
 * Shortcode for contact form
 *
 * @package ContactPlugin
 */

add_shortcode( 'contact', 'show_contact_form' );
function show_contact_form() {
	$contact_form = file_get_contents( MY_PLUGIN_PATH . '/includes/templates/contact-form.php', true );
	return $contact_form;
}
