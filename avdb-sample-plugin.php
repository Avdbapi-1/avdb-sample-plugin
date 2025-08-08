<?php
/*
Plugin Name: AVDB Sample One File
Description: Plugin mẫu một file để test update qua AVDB All In One.
Version: 1.0.0
Author: AVDB
*/
if (!defined('ABSPATH')) exit;

define('AVDB_SAMPLE_VERSION', '1.0.0');

add_action('admin_menu', function () {
    add_management_page(
        'AVDB Sample',
        'AVDB Sample',
        'manage_options',
        'avdb-sample',
        function () {
            echo '<div class="wrap"><h1>AVDB Sample</h1><p>Version: ' . esc_html(AVDB_SAMPLE_VERSION) . '</p></div>';
        }
    );
});

add_shortcode('avdb_sample', function () {
    return 'AVDB Sample v' . AVDB_SAMPLE_VERSION;
});

add_filter('plugin_action_links_' . plugin_basename(__FILE__), function ($links) {
    $links[] = '<a href="' . admin_url('tools.php?page=avdb-sample') . '">Open</a>';
    return $links;
});
