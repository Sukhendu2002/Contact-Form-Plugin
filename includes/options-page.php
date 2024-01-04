<?php
/**
 * Option page for the plugin
 *
 * @package contact-plugin
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'after_setup_theme', 'load_carbon_fields' );
add_action( 'carbon_fields_register_fields', 'create_option_page' );

/**
 * Create the option page
 */
function create_option_page(): void {
	Container::make( 'theme_options', __( 'Contact Form' ) )
		->set_page_menu_position( 30 )
		->set_icon( 'dashicons-media-text' )
		->add_fields(
			array(
				Field::make( 'checkbox', 'contact_plugin_active', __( 'Activate Contact Plugin' ) )
					->set_option_value( 'yes' )
					->set_help_text( __( 'Check this box to activate the contact plugin.' ) ),

				Field::make( 'text', 'contact_plugin_recipient', __( 'Recipient Email' ) )
					->set_attribute( 'placeholder', 'eg. your@mail.com' )
					->set_help_text( __( 'Enter the email address where you want to receive the messages.' ) ),

				Field::make( 'textarea', 'contact_plugin_message', __( 'Confirmation Message' ) )
					->set_attribute( 'placeholder', 'Type your message here' )
					->set_help_text( __( 'Enter the message that will be displayed after the form is submitted.' ) ),
			)
		);
}

/**
 * Load Carbon Fields
 */
function load_carbon_fields(): void {
	\Carbon_Fields\Carbon_Fields::boot();
}
