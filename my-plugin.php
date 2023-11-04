<?php

/**
 * Plugin Name: My Plugin
 * Update URI:  lubus-my-plugin
 */

//myp

function myp_admin_menu()
{
    // Create a new admin page for our app.
    add_menu_page(
        __('My Plugin', 'myplugin'),
        __('My Plugin', 'myplugin'),
        'manage_options',
        'my-plugin',
        function () {
            echo '<div id="my-plugin"></div>';
        },
        'dashicons-plugins-checked',
        2
    );
}

add_action('admin_menu', 'myp_admin_menu');

function myp_wp_admin_scripts($hook)
{
    // Load only on ?page=my-plugin
    if ('toplevel_page_my-plugin' !== $hook) {
        return;
    }

    // Load the required WordPress packages.

    // Automatically load imported dependencies and assets version.
    $asset_file = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

    // Enqueue CSS dependencies.
    foreach ($asset_file['dependencies'] as $style) {
        wp_enqueue_style($style);
    }

    // Load our app.js.
    wp_register_script(
        'my-plugin',
        plugins_url('build/index.js', __FILE__),
        $asset_file['dependencies'],
        $asset_file['version']
    );
    wp_enqueue_script('my-plugin');

    // Load our style.css.
    wp_register_style(
        'my-plugin',
        plugins_url('style.css', __FILE__),
        [],
        $asset_file['version']
    );
    wp_enqueue_style('my-plugin');
}

add_action('admin_enqueue_scripts', 'myp_wp_admin_scripts');
