# WordPress Contact Form Plugin 📬

A WordPress plugin for creating and managing contact forms on your website. This plugin utilizes the WordPress Shortcode API to display the contact form on the front end, and it includes a REST API for AJAX data submission. Form submissions are stored as metadata for custom post types called 'submission,' and an email notification is sent using the `wp_mail` function. Additionally, the plugin integrates with Carbon Fields for easy administration.

## Features 🚀

- **Front End Form:** Display the contact form on any page using the WordPress Shortcode API.
- **AJAX Data Submission:** Utilize the REST API for asynchronous form data submission.
- **Custom Post Type:** Store form submissions as metadata for a custom post type named 'submission.'
- **Email Notifications:** Send email notifications using the `wp_mail` function upon successful form submission.
- **Admin Panel Integration:** Manage and view form submissions seamlessly using Carbon Fields.
- **Customizable Settings:** Configure the plugin settings in the WordPress admin panel.
- **Sanitize and Validate Data:** Sanitize and validate form data using the WordPress inbuilt functions.
- **Nonces:** Use nonces to prevent CSRF attacks.

## Installation 📦

1. Download the plugin ZIP file from the [releases page](https://github.com/your-username/your-plugin/releases).
2. Upload the ZIP file to your WordPress site.
3. Activate the plugin through the WordPress admin panel.

## Usage 📝

### Shortcode

Use the following shortcode to display the contact form on any page or post:

```shortcode
[contact]
```
### REST API Endpoint

Submit form data using the following REST API endpoint:

```endpoint
/wp-json/contact-plugin/v1/submit
```
Request Body:
    
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "123-456-7890",
        "message": "Hello, this is a test message."
    }
    ```
### Admin Panel

Navigate to the 'Submissions' menu in the WordPress admin panel to view and manage form submissions.
### Configuration

Configure the plugin settings in the WordPress admin panel under 'Contact Form'.

## Dependencies 🛠️
- Carbon Fields - Used for easy admin page integration.