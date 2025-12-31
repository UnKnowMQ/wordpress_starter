<?php

/**
 * Add this code to plugin's main file.
 * After adding, YOU HAVE TO RE-ACTIVATE THE PLUGIN.
 * Plugin Name: Custom Cron Job 
 * Description: An example plugin to demonstrate custom cron job scheduling in WordPress.
 * Version: 1.0
 */

function custom_cron_schedules($schedules)
{
    if (! isset($schedules['daily_mail'])) {
        $schedules['daily_mail'] = array(
            'interval' => 60, // 1 minutes in seconds for testing purpose, change to 86400 for daily
            'display'  => __('Daily task' ,'gca-core'),
        );
    }
    return $schedules;
}
add_filter('cron_schedules', 'custom_cron_schedules');


function custom_core_activate() {
	if ( ! wp_next_scheduled( 'daily_email_event' ) ) {
		wp_schedule_event( time(), 'daily_mail', 'daily_email_event' );
	}
}

register_activation_hook( __FILE__, 'custom_core_activate' );


add_action('daily_email_event', 'send_daily_email');

function send_daily_email()
{

    error_log( date( 'Y-m-d H:i:s', time() ) );
	update_option( 'custom_crone_run_at', date( 'Y-m-d H:i:s', time() ) );
    global $wpdb;
    $result = $wpdb->get_results("SELECT DISTINCT email from {$wpdb->prefix}contact_information");
    if(! $result ) {
        error_log( 'No subscribers found.' );
        return;
    }
    foreach ($result as $row) {
        wp_mail($row->email, 'Daily report', 'Nội dung báo cáo gửi các subcriber của wp_starter');
    }
}

add_action('cleanup_old_posts', 'delete_old_posts');

function delete_old_posts()
{
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE post_date < NOW() - INTERVAL 1 YEAR");
}

add_action('send_contact_email', 'send_email_task', 10, 1);

// function send_email_task($data)
// {
//     wp_mail($data['to'], $data['subject'], $data['message']);
// }

// // Khi user submit form
// function handle_form_submit()
// {
//     $data = [
//         'to' => 'buiminhquan300304@gmail.com',
//         'subject' => 'New contact',
//         'message' => 'Message content',
//     ];
//     if (! wp_next_scheduled('send_contact_email')) {
//         wp_schedule_event(time(), 'send_contact_email', [$data]);
//     }
// }


function custom_deactivation() {
	wp_clear_scheduled_hook( 'daily_email_event' );
}

register_deactivation_hook( __FILE__, 'custom_deactivation' );