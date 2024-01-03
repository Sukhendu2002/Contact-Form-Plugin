<?php
/**
 * Form Template
 *
 * @package ContactPlugin
 */

?>
<form id="enquiry_form" method="post">
	<?php wp_nonce_field( 'enquiry_form', 'enquiry_form_nonce' ); ?>
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" />
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" />
	</div>

	<div class="form-group">
		<label for="phone">Phone</label>
		<input type="tel" name="phone" id="phone" />
	</div>

	<div class="form-group">
		<label for="message">Message</label>
		<textarea name="message" id="message"></textarea>
	</div>

	<button type="submit">Submit</button>
</form>
