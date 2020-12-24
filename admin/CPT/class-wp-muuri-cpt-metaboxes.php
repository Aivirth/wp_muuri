<?php

class Wp_Muuri_Cpt_Metaboxes
{
    private string $cpt_name;
    private object $fields;

    public function __construct(string $cpt_name, object $htmlFieldsObject)
    {
        if (is_admin()) {
            $this->init_metaboxes();
        }
        $this->cpt_name = $cpt_name;
        $this->fields = $htmlFieldsObject;
    }

    /**
     * Adds a metabox for muuri configuration.
     *
     * @return void
     */
    public function add_muuri_configuration_metabox()
    {
        // die('metabox_fn');
        add_meta_box(
            'wp_muuri_cf_metabox',
            __('Muuri Configuration', 'wp_muuri'),
            [$this, 'render_muuri_configuration_metabox'],
            $this->cpt_name,
            'advanced',
            'low'
        );
    }

    /**
     * Adds a metabox for muuri gallery.
     *
     * @return void
     */
    // public function add_muuri_gallery_metabox()
    // {
    //     add_meta_box(
    //         'muuri_gallery_metabox',
    //         __('Muuri Images', 'wp_muuri'),
    //         [$this, 'render_muuri_gallery_metabox'],
    //         $this->CPT_name,
    //         'advanced',
    //         'low'
    //     );
    // }

    /**
     * Initializes metaboxes by calling all methods with a prefix of 'add_' and 'save_'
     *
     * @return void
     */
    public function init_metaboxes()
    {
        //> call all 'add_' methods
        $addMethods = preg_grep('/^add_/', get_class_methods($this));
        foreach ($addMethods as $addMethod) {
            add_action('add_meta_boxes', [$this, $addMethod]);
        }

        //> call all 'save_' methods
        // $saveMethods = preg_grep('/^save_/', get_class_methods($this));
        // foreach ($saveMethods as $saveMethod) {
        //     add_action('save_post', [$this, $saveMethod], 10, 2);
        // }
    }

    /**
     * Returns a nonce for security and validation.
     *
     * @return array
     */
    private function set_nonce(): array
    {
        $nonce_name = isset($_POST['wp_muuri_nonce'])
            ? $_POST['wp_muuri_nonce']
            : '';
        $nonce_action = 'wp_muuri_nonce_action';

        return [
            'name' => $nonce_name,
            'action' => $nonce_action,
        ];
    }

    private function verify_post_permissions($post_ID)
    {
        $nonce = $this->set_nonce();

        //> check if nonce is valid.
        if (!wp_verify_nonce($nonce['name'], $nonce['action'])) {
            return;
        }

        //> Check if user has permissions to save data.
        if (!current_user_can('edit_post', $post_ID)) {
            return;
        }

        //> Check if not an autosave.
        if (wp_is_post_autosave($post_ID)) {
            return;
        }

        //> Check if not a revision.
        if (wp_is_post_revision($post_ID)) {
            return;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $post_ID
     * @param [type] $post
     * @return void
     */
    public function save_muuri_configuration_metabox($post_ID, $post)
    {
        $this->verify_post_permissions($post_ID);

        $postWhitelist = [
            'muuriCssItems',
            'muuriShowDuration',
            'muuriShowEasing',
            'muuriLayoutFillGaps',
            'muuriLayoutIsHorizontal',
            'muuriLayoutAlignRight',
            'muuriLayoutAlignBottom',
            'muuriLayoutRounding',
            'muuriLayoutOnResize',
            'muuriLayoutOnInit',
            'muuriLayoutDuration',
            'muuriLayoutEasing',
            'muuriDragEnabled',
            'muuriDragContainer',
            'muuriDragHandle',
            'muuriDragAxis',
            'muuriDragSort',
            // 'muuriDragSortHeuristics',
            'muuriDragSortPredicate__threshold',
            'muuriDragSortPredicate__action',
            'muuriDragSortPredicate__migrateAction',
            'muuriDragRelease__duration',
            'muuriDragRelease__easing',
            'muuriDragRelease__useDragContainer',
        ];

        foreach ($postWhitelist as $postMeta) {
            update_post_meta($post_ID, $postMeta, $_POST[$postMeta]);
        }
    }

    /**
     * Returns the html for the tabs.
     *
     * @param array $headers
     * @return string
     */
    private function render_tabs(array $headers): string
    {
        $tabsHeaders = '<div class="uk-width-auto@m">';
        $tabsHeaders .=
            '<ul class="uk-tab-left" uk-tab="connect: #component-tab-left; animation: uk-animation-fade">';

        foreach ($headers as $header) {
            $tabsHeaders .= '<li><a href="#">' . $header . '</a></li>';
        }

        $tabsHeaders .= '</ul>';
        $tabsHeaders .= '</div>';

        return $tabsHeaders;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function render_muuri_configuration_metabox($post)
    {
        $this->set_nonce();
        $cptPost = get_post_custom($post->ID);

        $tabs = ['Animations', 'Layout', 'Drag'];

        //> Load fields value
        $muuriCssItems = isset($custom['muuriCssItems'][0])
            ? $custom['muuriCssItems'][0]
            : 'wp_muuri_gallery__' . $post->ID;

        $muuriCssItemsField = $this->fields->text(
            $muuriCssItems,
            'muuriCssItems',
            'CSS Items'
        );

        $html = '<div uk-grid>';
        $html .= $muuriCssItemsField;
        $html .= '</div>';
        echo $html;
        // print_r($post);
    }
}
