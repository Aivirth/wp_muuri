<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://aivirth.dev
 * @since             1.0.0
 * @package           Wp_Muuri
 *
 * @wordpress-plugin
 * Plugin Name:       WP Muuri
 * Plugin URI:        None
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Aivirth
 * Author URI:        https://aivirth.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-muuri
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WP_MUURI_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-muuri-activator.php
 */
function activate_wp_muuri()
{
    require_once plugin_dir_path(__FILE__) .
        'includes/class-wp-muuri-activator.php';
    Wp_Muuri_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-muuri-deactivator.php
 */
function deactivate_wp_muuri()
{
    require_once plugin_dir_path(__FILE__) .
        'includes/class-wp-muuri-deactivator.php';
    Wp_Muuri_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_muuri');
register_deactivation_hook(__FILE__, 'deactivate_wp_muuri');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wp-muuri.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_muuri()
{
    $plugin = new Wp_Muuri();
    $plugin->run();
}
run_wp_muuri();

require plugin_dir_path(__FILE__) . 'functions/wp-muuri-gallery-shortcode.php';
require plugin_dir_path(__FILE__) .
    'functions/wp-muuri-media-manager-fields.php';
