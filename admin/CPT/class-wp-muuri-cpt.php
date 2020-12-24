<?php

/**
 * Defines CPT.
 *
 * @link       https://aivirth.dev
 * @since      1.0.0
 *
 * @package    Wp_Muuri
 * @subpackage Wp_Muuri/admin
 */

/**
 * Defines CPT.
 *
 * Defines a CPT through class methods with various checks.
 *
 * @package    Wp_Muuri
 * @subpackage Wp_Muuri/admin
 * @author     Aivirth <aivirth.dev@gmail.com>
 */

class Wp_Muuri_Cpt
{
    private string $domain_text;
    private string $name;
    private int $priority;
    private array $labels = [];
    private array $args = [];

    public function __construct(
        string $domain_text,
        string $name,
        array $labels,
        array $args,
        int $priority = 0
    ) {
        $this->domain_text = $domain_text;
        $this->name = $name;
        $this->priority = $priority;
        $this->setLabels($labels)->setArgs($args);
        $this->activate();
    }

    /**
     * Merges a default of labels with an override array styled as per wordpress documentation.
     *
     * @param array $labels
     * @return self
     */
    private function setLabels(array $labels = [])
    {
        $defaults = [
            'name' => _x(
                'Galleries',
                'Post Type General Name',
                $this->domain_text
            ),
            'singular_name' => _x(
                $this->name,
                'Post Type Singular Name',
                $this->domain_text
            ),
            'menu_name' => _x(
                'Muuri Galleries',
                'Admin Menu text',
                $this->domain_text
            ),
            'name_admin_bar' => _x(
                $this->name,
                'Add New on Toolbar',
                $this->domain_text
            ),
            'archives' => __("{$this->name} Archives", $this->domain_text),
            'attributes' => __("{$this->name} Attributes", $this->domain_text),
            'parent_item_colon' => __(
                "Parent {$this->name}:",
                $this->domain_text
            ),
            'all_items' => __('All Galleries', $this->domain_text),
            'add_new_item' => __("Add New {$this->name}", $this->domain_text),
            'add_new' => __('Add New', $this->domain_text),
            'new_item' => __("New {$this->name}", $this->domain_text),
            'edit_item' => __("Edit {$this->name}", $this->domain_text),
            'update_item' => __("Update {$this->name}", $this->domain_text),
            'view_item' => __("View {$this->name}", $this->domain_text),
            'view_items' => __('View Custom Posts', $this->domain_text),
            'search_items' => __("Search {$this->name}", $this->domain_text),
            'not_found' => __('Not found', $this->domain_text),
            'not_found_in_trash' => __(
                'Not found in Trash',
                $this->domain_text
            ),
            'featured_image' => __('Featured Image', $this->domain_text),
            'set_featured_image' => __(
                'Set featured image',
                $this->domain_text
            ),
            'remove_featured_image' => __(
                'Remove featured image',
                $this->domain_text
            ),
            'use_featured_image' => __(
                'Use as featured image',
                $this->domain_text
            ),
            'insert_into_item' => __(
                "Insert into {$this->name}",
                $this->domain_text
            ),
            'uploaded_to_this_item' => __(
                "Uploaded to this {$this->name}",
                $this->domain_text
            ),
            'items_list' => __('Custom Posts list', $this->domain_text),
            'items_list_navigation' => __(
                'Custom Posts list navigation',
                $this->domain_text
            ),
            'filter_items_list' => __(
                'Filter Custom Posts list',
                $this->domain_text
            ),
        ];

        $merged_labels = array_merge($labels, $defaults);

        $this->labels = $merged_labels;
        return $this;
    }

    /**
     * Merges a default of args with an override array styled as per wordpress documentation.
     *
     * Must be called after setLabels
     *
     * @param array $args
     * @return self
     */
    private function setArgs(array $args = [])
    {
        $defaults = [
            'label' => __($this->name, $this->domain_text),
            'description' => __(
                "{$this->name} description",
                $this->domain_text
            ),
            'labels' => $this->cpt_labels,
            'menu_icon' => 'dashicons-editor-table',
            'supports' => ['title', 'editor'],
            'taxonomies' => ['wp_muuri'],
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'show_in_rest' => true,
            'publicly_queryable' => true,
            'capability_type' => 'post',
            'rewrite' => ['slug' => 'muuri-galleries'],
        ];

        $merged_args = array_merge($args, $defaults);
        $this->args = $merged_args;

        return $this;
    }

    /**
     * Calls register_post_type().
     *
     * @return void
     */
    public function register(): void
    {
        register_post_type($this->domain_text, $this->args);
    }

    /**
     * Calls add_action using register() as argument.
     *
     * @return void
     */
    public function activate(): void
    {
        add_action('init', [$this, 'register'], $this->priority);
    }
}
