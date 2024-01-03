<?php
/**
 * Shortcode for contact form
 *
 * @package ContactPlugin
 */

add_shortcode( 'contact', 'show_contact_form' );
add_action( 'rest_api_init', 'create_rest_route' );
add_action( 'init', 'create_submission_page' );

/**
 * Function to create submission page
 *
 * @return void
 */
function create_submission_page(): void {
	$args = array(
		'public'      => true,
		'has_archive' => true,
		'labels'      => array(
			'name'               => 'Submissions',
			'singular_name'      => 'Submission',
			'add_new_item'       => 'Add New Submission',
			'edit_item'          => 'Edit Submission',
			'all_items'          => 'All Submissions',
			'view_item'          => 'View Submission',
			'search_items'       => 'Search Submissions',
			'not_found'          => 'No submissions found',
			'not_found_in_trash' => 'No submissions found in trash',
			'menu_name'          => 'Submissions',
		),
		'menu_icon'   => 'dashicons-media-spreadsheet',
		'supports'    => array( 'custom-fields' ),
	// 'capabilities' => array(
	// 'create_posts' => 'do_not_allow',
	// ),
	);

	register_post_type( 'submission', $args );
}

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

	// Sanitize and validate user inputs.
	$name  = sanitize_text_field( $params['name'] );
	$email = sanitize_email( $params['email'] );

	// Check if required parameters are set.
	if ( empty( $name ) || empty( $email ) ) {
		return new WP_REST_Response( 'Invalid input data', 400 );
	}

	// Remove unnecessary parameters.
	unset( $params['enquiry_form_nonce'], $params['_wp_http_referer'] );

	// Send the email.
	$headers     = array();
	$admin_email = get_bloginfo( 'admin_email' );
	$admin_name  = get_bloginfo( 'name' );

	$headers[] = "From: {$admin_name} <{$admin_email}>";
	$headers[] = "Reply-To: {$name} <{$email}>";
	$headers[] = 'Content-Type: text/html; charset=UTF-8';

	$subject = 'Enquiry from ' . $name;

	$message = "<h1>Massage from {$name}</h1> <br />";

	// Create post of type submission.
	$postarr = array(
		'post_title'   => $subject,
		'post_content' => $message,
		'post_type'    => 'submission',
	);
	$post_id = wp_insert_post( $postarr );

	foreach ( $params as $key => $value ) {
		$message .= "<strong>{$key}:</strong> {$value} <br />";
		add_post_meta( $post_id, $key, $value );
	}

	try {
		wp_mail( $admin_email, $subject, $message, $headers );
	} catch ( Exception $e ) {
		return new WP_REST_Response(
			array(
				'message' => $e->getMessage(),
				'code'    => $e->getCode(),
			),
			500
		);
	}

	return new WP_REST_Response( 'Message sent', 200 );
}
