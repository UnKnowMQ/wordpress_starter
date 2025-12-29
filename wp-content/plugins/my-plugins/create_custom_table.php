<?php
/*
Plugin Name: My Plugin
Description: Custom form plugin
Version: 1.0
*/

if ( ! defined('ABSPATH') ) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/db.php';

register_activation_hook(__FILE__, 'create_custom_table');
register_activation_hook(__FILE__, 'create_custom_table2');
register_activation_hook(__FILE__, 'add_contact_info');

add_contact_info("name","email","test");