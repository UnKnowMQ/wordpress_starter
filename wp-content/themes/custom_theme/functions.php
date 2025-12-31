<?php

function mytheme_enqueue_assets()
{
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        [],
        '1.0'
    );
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');

function create_projects_post_type()
{
    register_post_type('projects', [
        'labels' => [
            'name' => 'Projects',
            'singular_name' => 'Project'
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'create_projects_post_type');

if (! get_role('hr')) {
    add_role('hr', __('HR'), array(
        'manage_users' => true,
        'read' => true,
        'create_users' => true,
        'edit_users' => true,
    ));
}
if (! get_role('CM')) {
    add_role('CM', __('Content Manager'), array(
        'edit_posts' => true,
        'edit_others_posts' => true,
        'publish_posts' => true,
        'delete_posts' => true,
        'delete_others_posts' => true,
        'edit_pages' => true,
        'edit_others_pages' => true,
        'publish_pages' => true,
        'delete_pages' => true,
        'delete_others_pages' => true,
        'upload_files' => true,
        'edit_files' => true,
        'moderate_comments' => true,
        'read' => true,
    ));
}
// function update_role_cap($caps, $role)
// {
//     $role = get_role($role);
//     if (!$role) return;
//     else {
//         for ($i = 0; $i < sizeof($caps); $i++) {
//             $role->add_cap($caps[$i]);
//         }
//     }
// }
// update_role_cap(['create_users', 'list_users', 'edit_users', 'read'], 'hr');



function mailer_config( $mailer ) {

    if ( ! defined('SMTP_server') ) {
        error_log( 'SMTP_server is not defined' );
        return;
    }

    $mailer->isSMTP();
    $mailer->Host       = SMTP_server;
    $mailer->Port       = SMTP_PORT;
    $mailer->SMTPAuth   = SMTP_AUTH;
    $mailer->Username   = SMTP_username;
    $mailer->Password   = SMTP_password;
    $mailer->CharSet    = 'UTF-8';
    $mailer->SMTPDebug  = ( defined('WP_DEBUG') && WP_DEBUG ) ? 2 : 0;
    $mailer->SMTPSecure = SMTP_SECURE;
    $mailer->From       = SMTP_FROM;
    $mailer->FromName   = SMTP_NAME;
}
add_action( 'phpmailer_init', 'mailer_config', 1, 1 );
add_action( 'wp_mail_failed', 'log_mailer_errors', 20, 1 );

function log_mailer_errors( $wp_error ) {
    error_log(
        'Mail error: ' . implode(', ', $wp_error->get_error_messages())
    );
}
