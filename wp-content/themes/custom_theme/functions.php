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

add_action('init', function(){
    register_post_type('project', [
    'labels' => [
            'name' => 'Projects',
            'singular_name' => 'Project',
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true, // Gutenberg
    ]);
})

?>