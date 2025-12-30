<?php
/**
 * Add this code to plugin's main file.
 * After adding, YOU HAVE TO RE-ACTIVATE THE PLUGIN.
 * Plugin Name: Custom Cron Job 
 * Description: An example plugin to demonstrate custom cron job scheduling in WordPress.
 * Version: 1.0
 */

add_action('daily_email_event', 'send_daily_email');

function send_daily_email() {
    wp_mail('user@example.com', 'Daily report', 'Nội dung báo cáo');
}

add_action('cleanup_old_posts', 'delete_old_posts');

function delete_old_posts() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE post_date < NOW() - INTERVAL 1 YEAR");
}

add_action('send_contact_email', 'send_email_task', 10, 1);

function send_email_task($data) {
    wp_mail($data['to'], $data['subject'], $data['message']);
}

// Khi user submit form
function handle_form_submit() {
    $data = [
        'to' => 'buiminhquan300304@gmail.com',
        'subject' => 'New contact',
        'message' => 'Message content',
    ];
    // Push vào cron để chạy background
    if (! wp_next_scheduled('send_contact_email')) {
        wp_schedule_single_event(time(), 'send_contact_email', [$data]);
    }
}

