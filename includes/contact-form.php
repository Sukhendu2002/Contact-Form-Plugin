<?php
/**
 * Shortcode for contact form
 *
 * @package ContactPlugin
 */

add_shortcode( 'contact', 'show_contact_form' );
add_action( 'rest_api_init', 'create_rest_route' );
add_action( 'init', 'create_submission_page' );
add_action( 'add_meta_boxes', 'create_meta_box' );
add_filter( 'manage_submission_posts_columns', 'submission_custom_column' );
add_action( 'manage_submission_posts_custom_column', 'submission_custom_column_data', 10 );
add_action( 'admin_init', 'setup_search' );

/**
 * Function to set up search
 *
 * @return void
 */
function setup_search(): void {
	global $typenow;

	if ( 'submission' === $typenow ) {
		add_filter( 'posts_search', 'submission_search_override', 10, 2 );
	}
}

/**
 * Function to override search
 *
 * @param string         $search Search string.
 * @param WP_Query|mixed $query Query.
 * @return string
 */
function submission_search_override( $search, $query ) {

	global $wpdb;

	if ( $query->is_main_query() && ! empty( $query->query['s'] ) ) {
		$sql    = "
              or exists (
                  select * from {$wpdb->postmeta} where post_id={$wpdb->posts}.ID
                  and meta_key in ('name','email','phone')
                  and meta_value like %s
              )
          ";
		$like   = '%' . $wpdb->esc_like( $query->query['s'] ) . '%';
		$search = preg_replace(
			"#\({$wpdb->posts}.post_title LIKE [^)]+\)\K#",
			$wpdb->prepare( $sql, $like ),
			$search
		);
	}

	return $search;
}

/**
 * Function to add data to custom column
 *
 * @param string $column Column name.
 * @return void
 */
function submission_custom_column_data( string $column ): void {
	global $post;
	$meta = get_post_meta( $post->ID );
	unset( $meta['_edit_lock'], $meta['_edit_last'] );
	echo esc_html( $meta[ $column ][0] );
}

/**
 * Function to add custom column
 *
 * @param array $columns Columns.
 * @return array
 */
function submission_custom_column( array $columns ): array {
	$columns = array(
		'cb'      => $columns['cb'],
		'title'   => __( 'Name', 'contact-plugin' ),
		'email'   => __( 'Email', 'contact-plugin' ),
		'phone'   => __( 'Phone', 'contact-plugin' ),
		'message' => __( 'Message', 'contact-plugin' ),
		'date'    => __( 'Date', 'contact-plugin' ),
	);

		return $columns;
}

/**
 * Function to create meta box
 *
 * @return void
 */
function create_meta_box(): void {
	add_meta_box(
		'submission_meta_box',
		'Submission Details',
		'display_submission',
		'submission',
		'normal',
		'high'
	);
}

/**
 * Function to display submission
 *
 * @return void
 */
function display_submission(): void {
	global $post;
	$meta = get_post_meta( $post->ID );
	unset( $meta['_edit_lock'], $meta['_edit_last'] );
	echo '<table>';
	foreach ( $meta as $key => $value ) {
		echo '<tr>';
		echo '<td><strong>' . esc_html( $key ) . ':</strong></td>';
		echo '<td>' . esc_html( $value[0] ) . '</td>';
		echo '</tr>';
	}
	echo '</table>';
}

/**
 * Function to create submission page
 *
 * @return void
 */
function create_submission_page(): void {
	$args = array(
		'public'          => true,
		'has_archive'     => true,
		'labels'          => array(
			'name'               => 'All Submissions',
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
		'menu_icon'       => 'dashicons-media-spreadsheet',
		'supports'        => false,
		'capability_type' => 'post',
		'capabilities'    => array(
			'create_posts' => false,
		),
		'map_meta_cap'    => true,
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
		'post_status'  => 'publish',
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
