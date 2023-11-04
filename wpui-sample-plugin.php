<?php
/**
 * Plugin Name: WPUI Sample Plugin
 * Update URI:  wpui-sample-plugin
 */

/**
 * Plugin admin menu and page
 *
 * @return void
 */
function wsp_admin_menu()
{
    add_menu_page(
        __('WPUI Plugin', 'wsplugin'),
        __('WPUI Plugin', 'wsplugin'),
        'manage_options',
        'wpui-sample-plugin',
        function () {
            echo '<div id="wpui-sample-plugin" class="placeholder-styles"></div>';
        },
        'dashicons-superhero',
        2
    );
}
add_action('admin_menu', 'wsp_admin_menu');

/**
 * Plugin Assets
 *
 * @param string $hook
 * @return void
 */
function wsp_wp_admin_scripts($hook)
{
    // Load assets only on plugin page(s)
    if ('toplevel_page_wpui-sample-plugin' !== $hook) {
        return;
    }

    // Automatically load imported dependencies and assets version.
    $asset_file = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

    // Enqueue CSS dependencies.
    foreach ($asset_file['dependencies'] as $style) {
        wp_enqueue_style($style);
    }

    // Load plugin js
    wp_register_script(
        'wpui-sample-plugin',
        plugins_url('build/index.js', __FILE__),
        $asset_file['dependencies'],
        $asset_file['version'],
        [
            'in_footer' => true
        ]
    );
    wp_enqueue_script('wpui-sample-plugin');

    // Load our style.css.
    wp_register_style(
        'wpui-sample-plugin',
        plugins_url('build/index.css', __FILE__),
        [],
        $asset_file['version']
    );
    wp_enqueue_style('wpui-sample-plugin');
}

add_action('admin_enqueue_scripts', 'wsp_wp_admin_scripts');
