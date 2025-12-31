<?php

/**
 * Template Name: 21 - Page Contact
 */
get_header(); ?>

<h1>Contact Us</h1>
<?php
// Handle form submission
$contact_errors = array();
$contact_success = false;


if ("POST" === $_SERVER['REQUEST_METHOD'] && isset($_POST['my_contact_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['my_contact_nonce'])), 'my_contact_action')) {
        $contact_errors[] = 'Security check failed.';
    } else {
        $name    = sanitize_text_field(wp_unslash($_POST['contact_name'] ?? ''));
        $email   = sanitize_email(wp_unslash($_POST['contact_email'] ?? ''));
        $message = sanitize_textarea_field(wp_unslash($_POST['contact_message'] ?? ''));

        if (empty($name)) {
            $contact_errors[] = 'Please enter your name.';
        }
        if (empty($email) || ! is_email($email)) {
            $contact_errors[] = 'Please enter a valid email address.';
        }
        if (empty($message)) {
            $contact_errors[] = 'Please enter a message.';
        }

        if (empty($contact_errors)) {
            $to      = $email;
            $subject = 'Contact form: ' . get_bloginfo('name');
            $body    = "Thank you for contacting us, $name.\n\nWe have received your message:\n\n$message\n\nWe will get back to you shortly.";
            $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>');

            $sent = wp_mail($to, $subject, $body, $headers);

            $wpdb->insert(
                $wpdb->prefix . 'contact_information',
                array(
                    'name'      => $name,
                    'email'     => $email,
                    'message'   => $message,
                    'created_at' => current_time('mysql'),
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                )
            );

            if ($sent) {
                $contact_success = true;
                // optionally log success
                error_log('Contact form sent: ' . $email);
            } else {
                // $errors = $wp_error->get_error_messages();
                // foreach ($errors as $error) {
                //     error_log('WP-Mail error: ' . $error);
                // }
                add_action('wp_mail_failed', 'onMailError', 10, 1);
                function onMailError($wp_error)
                {
                    error_log($wp_error);
                }
                $contact_errors[] = 'Failed to send email. Please try again later.';
                error_log('Contact form failed to send: ' . $email);
            }
        }
    }
}
?>

<?php if ($contact_success) : ?>
    <div class="contact-success">Thank you — your message was sent.</div>
<?php else : ?>

    <?php if (! empty($contact_errors)) : ?>
        <div class="contact-errors">
            <ul>
                <?php foreach ($contact_errors as $err) : ?>
                    <li><?php echo esc_html($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="" class="my-contact-form">
        <?php wp_nonce_field('my_contact_action', 'my_contact_nonce'); ?>

        <p>
            <label for="contact_name">Name</label><br />
            <input type="text" id="contact_name" name="contact_name" value="<?php echo isset($name) ? esc_attr($name) : ''; ?>" required />
        </p>

        <p>
            <label for="contact_email">Email</label><br />
            <input type="email" id="contact_email" name="contact_email" value="<?php echo isset($email) ? esc_attr($email) : ''; ?>" required />
        </p>

        <p>
            <label for="contact_message">Message</label><br />
            <textarea id="contact_message" name="contact_message" rows="6" required><?php echo isset($message) ? esc_textarea($message) : ''; ?></textarea>
        </p>

        <p>
            <button type="submit">Send Message</button>
        </p>
    </form>

<?php endif; ?>

<?php get_footer(); ?>