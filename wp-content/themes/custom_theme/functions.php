<?php 

function mytheme_enqueue_assets() {
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        [],
        '1.0'
    );
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');

function create_projects_post_type() {
    register_post_type('projects', [
        'labels' => [
            'name' => 'Projects',
            'singular_name' => 'Project'
        ],
        'public' => true,
        'has_archive' => true,   // rất quan trọng
        'rewrite' => ['slug' => 'projects'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'create_projects_post_type');

?>