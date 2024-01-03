<?php
/**
 * Form Template
 *
 * @package ContactPlugin
 */

?>
<form id="enquiry_form" method="post">
	<h2>Contact Form</h2>
	<?php wp_nonce_field( 'enquiry_form', 'enquiry_form_nonce' ); ?>
	<div class="form-group">
		<label for="name">Name
			<span class="required">*</span>
		</label>
		<input type="text" name="name" id="name" required />
	</div>

	<div class="form-group">
		<label for="email">Email<span class="required">*</span></label>
		<input type="email" name="email" id="email" required/>
	</div>

	<div class="form-group">
		<label for="phone">Phone<span class="required">*</span></label>
		<input type="text" name="phone" id="phone" required/>
	</div>

	<div class="form-group">
		<label for="message">Message<span class="required">*</span></label>
		<textarea name="message" id="message"
					cols="30" rows="10"
					required></textarea>
	</div>

	<button type="submit">Submit</button>
</form>
