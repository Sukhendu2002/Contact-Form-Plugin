/**
 * Handle the form submission
 *
 * @package contact-plugin
 */

jQuery( document ).ready(
	function ($) {
		$( '#enquiry_form' ).submit(
			function (e) {
				e.preventDefault();
				const form = $( this );
				const data = form.serialize();
				$.ajax(
					{
						type: 'POST',
						url: '/wp-json/contact-plugin/v1/contact',
						data: data,
						success: function (response) {
							form.hide();
							$( '#enquiry_form' ).after(
								'<p style="color: green">' +
								'' + response +
								'</p>'
							);
						},
						error: function (xhr, status, error) {
							$( '#enquiry_form' ).after( '<p style="color: red">Sorry, there was a problem with your enquiry</p>' );
						}
					}
				);

			}
		);
	}
);