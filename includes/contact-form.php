<?php
/**
 * Shortcode for contact form
 *
 * @package ContactPlugin
 */

add_shortcode( 'contact', 'show_contact_form' );
/**
 * Function to show contact form
 *
 * @return string
 */
function show_contact_form(): string {
	$contact_form = file_get_contents( MY_PLUGIN_PATH . '/includes/templates/contact-form.php', true );
	return $contact_form;
}

/**
 * Function to create rest route
 *
 * @return void
 */
function create_rest_route(): void {
	register_rest_route(
		'contact-plugin/v1',
		'/contact',
		array(
			'methods'  => 'POST',
			'callback' => 'contact_form_submit',
		)
	);
}

/**
 * Function to submit contact form
 *
 * @return void
 */
function contact_form_submit(): void {
	echo 'Hello';
}
