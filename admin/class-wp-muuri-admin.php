<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://aivirth.dev
 * @since      1.0.0
 *
 * @package    Wp_Muuri
 * @subpackage Wp_Muuri/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Muuri
 * @subpackage Wp_Muuri/admin
 * @author     Aivirth <aivirth.dev@gmail.com>
 */
class Wp_Muuri_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Muuri_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Muuri_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        try {
            wp_enqueue_style(
                "{$this->plugin_name}__uikit-css",
                plugin_dir_url(__FILE__) . 'css/uikit.min.css',
                [],
                false,
                'all'
            );

            wp_enqueue_style(
                "{$this->plugin_name}__wp-muuri-metaboxes-css",
                plugin_dir_url(__FILE__) . 'css/wp_muuri_metaboxes.css',
                [],
                false,
                'all'
            );

            wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url(__FILE__) . 'css/wp-muuri-admin.css',
                [],
                $this->version,
                'all'
            );
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Muuri_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Muuri_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script(
            "{$this->plugin_name}__uikit-js",
            plugin_dir_url(__FILE__) . '/js/uikit.min.js'
        );

        wp_enqueue_script(
            "{$this->plugin_name}__uikit-icons",
            plugin_dir_url(__FILE__) . '/js/uikit-icons.min.js'
        );

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wp-muuri-admin.js',
            ['jquery'],
            $this->version,
            false
        );

        wp_enqueue_script(
            "{$this->plugin_name}__wp-muuri-metaboxes_js",
            plugin_dir_url(__FILE__) . '/js/wp_muuri_metaboxes.js',
            [],
            false,
            true
        );
    }
}
