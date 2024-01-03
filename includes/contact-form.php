<?php
/**
 * Shortcode for contact form
 *
 * @package ContactPlugin
 */

add_shortcode( 'contact', 'show_contact_form' );
add_action( 'rest_api_init', 'create_rest_route' );
/**
 * Function to show contact form
 *
 * @return string
 */
function show_contact_form(): string {
	require_once MY_PLUGIN_PATH . 'includes/templates/contact-form.php';
	return ob_get_clean();
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
 * @param WP_REST_Request $data Request data.
 * @return WP_REST_Response
 */
function contact_form_submit( WP_REST_Request $data ): WP_REST_Response {
	$params = $data->get_params();
	if ( ! isset( $params['enquiry_form_nonce'] ) && ! wp_verify_nonce( $params['enquiry_form_nonce'], 'enquiry_form' ) ) {
		return new WP_REST_Response( 'Message not sent', 403 );
	}

	unset( $params['enquiry_form_nonce'] );
	unset( $params['_wp_http_referer'] );

	return new WP_REST_Response( 'Message sent', 200 );
}
