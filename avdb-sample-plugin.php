<?php
/*
Plugin Name: Fake Plugin for Update Test
Plugin URI: https://example.com
Description: A simple fake plugin used to test All-In-One updater behaviour. Includes version header and a small admin page.
Version: 1.0.0
Author: Test Bot
Author URI: https://example.com
Text Domain: fake-plugin-test
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
if ( ! defined( 'FPT_PLUGIN_VERSION' ) ) {
    define( 'FPT_PLUGIN_VERSION', '1.0.0' );
}

if ( ! defined( 'FPT_PLUGIN_SLUG' ) ) {
    define( 'FPT_PLUGIN_SLUG', 'fake-plugin-test' );
}

// Add a simple admin menu so we can see plugin is active
add_action( 'admin_menu', function() {
    add_options_page( 'Fake Plugin Test', 'Fake Plugin Test', 'manage_options', 'fake-plugin-test', 'fpt_render_admin_page' );
} );

function fpt_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>Fake Plugin for Update Test</h1>
        <p>Version: <strong><?php echo esc_html( FPT_PLUGIN_VERSION ); ?></strong></p>
        <p>This is a dummy plugin. Use it to test update flows from the All-In-One updater plugin.</p>
    </div>
    <?php
}

// Provide a programmatic helper to read current version (used by updater plugin C)
if ( ! function_exists( 'fpt_get_installed_version' ) ) {
    function fpt_get_installed_version() {
        return FPT_PLUGIN_VERSION;
    }
}

// Optional: expose a REST endpoint for quick checks (not required)
add_action( 'rest_api_init', function() {
    register_rest_route( 'fpt/v1', '/info', array(
        'methods' => 'GET',
        'callback' => function() {
            return array(
                'slug' => 'fake-plugin-test/fake-plugin-test.php',
                'version' => FPT_PLUGIN_VERSION,
                'name' => 'Fake Plugin for Update Test'
            );
        }
    ) );
} );

/*
---- Additional files to include when you create the release ZIP -----------------

1) update-manifest.json  (place this file somewhere public or in the repo raw/branch)

{
  "version": "1.1.0",
  "download_url": "https://github.com/<owner>/<repo>/releases/download/v1.1.0/fake-plugin-test-1.1.0.zip",
  "changelog": "- Test: updated version to 1.1.0\n- Added minor tweaks for updater testing"
}

2) Packaging instructions for GitHub Release asset (important):
- Create a ZIP containing a single top-level folder named exactly: fake-plugin-test
  Example ZIP contents when extracted:
    fake-plugin-test/
      fake-plugin-test.php
      readme.txt
      other-files...
- This ensures the upgrader will overwrite the existing plugin folder `wp-content/plugins/fake-plugin-test`.

3) Example manifest raw URL (to be used as json_url in plugin C):
   https://raw.githubusercontent.com/<owner>/<repo>/main/update-manifest.json

4) Quick-test steps:
- Install this plugin by placing folder `fake-plugin-test` inside wp-content/plugins and activate it.
- In your All-In-One updater plugin (plugin C), add an entry pointing to this plugin slug and the raw manifest URL.
- Click "Find Update" in plugin C. It should read update-manifest.json and show version 1.1.0 available.
- Click "Update" in plugin C to download the release asset and let the upgrader overwrite the folder.

----------------------------------------------------------------------------------
*/
