<?php
/*
Plugin Name: Fake Plugin for Update Test
Plugin URI: https://example.com
Description: A simple fake plugin used to test All-In-One updater behaviour.
Version: 1.0.0
Author: Test Bot
Author URI: https://example.com
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_menu', function() {
    add_menu_page(
        'Fake Plugin Test',
        'Fake Plugin Test',
        'manage_options',
        'fake-plugin-test',
        function() {
            echo '<div class="wrap"><h1>Fake Plugin for Update Test</h1><p>Version: 1.0.0</p></div>';
        }
    );
});
