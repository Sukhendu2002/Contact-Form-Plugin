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
							// Handle the success response here.
							console.log( 'AJAX request successful:', response );
						},
						error: function (xhr, status, error) {
							// Handle the error here.
							console.error( 'AJAX request error:', status, error );
						}
					}
				);

			}
		);
	}
);