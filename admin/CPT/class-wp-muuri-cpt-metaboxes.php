<?php

class Wp_Muuri_Cpt_Metaboxes
{
    private string $cpt_name;
    private object $fields_renderer;
    private object $fields;

    public function __construct(
        string $cpt_name,
        object $fieldsRenderer,
        object $fields
    ) {
        if (is_admin()) {
            $this->init_metaboxes();
        }
        $this->cpt_name = $cpt_name;
        $this->fields_renderer = $fieldsRenderer;
        $this->fields = $fields;
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
            __('Muuri Configuration', $this->cpt_name),
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
    public function add_muuri_gallery_metabox()
    {
        add_meta_box(
            'muuri_gallery_metabox',
            __('Muuri Images', $this->cpt_name),
            [$this, 'render_muuri_gallery_metabox'],
            $this->CPT_name,
            'advanced',
            'low'
        );
    }

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
    public function save_muuri_configuration_metabox($post_ID)
    {
        $this->verify_post_permissions($post_ID);

        $cfg_animations = $this->fields->animations();
        $cfg_layout = $this->fields->layout();
        $cfg_drag_basic = $this->fields->drag_basic();
        $cfg_drag_predicate = $this->fields->drag_predicate();
        $cfg_drag_release = $this->fields->drag_release();
        $cfg_drag_cssProps = $this->fields->drag_cssProps();

        $fieldsCompositeArray = [
            $cfg_animations,
            $cfg_layout,
            $cfg_drag_basic,
            $cfg_drag_predicate,
            $cfg_drag_release,
            $cfg_drag_cssProps,
        ];

        //> generate whitelist for post fields
        $fieldsNames = array_map(function ($fieldCfg) {
            return $fieldCfg['name'];
        }, array_merge_recursive(...$fieldsCompositeArray));

        foreach ($fieldsNames as $whiteListedField) {
            update_post_meta(
                $post_ID,
                $whiteListedField,
                $_POST[$whiteListedField]
            );
        }
    }

    /**
     * Returns the html for the tabs.
     *
     * @param array $headers
     * @return string
     */
    private function render_tabs_headers(array $headers): string
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

    private function render_tabs(array $tabs)
    {
        $html = '<div class="uk-width-expand@m">';
        $html .= '<ul id="component-tab-left" class="uk-switcher">';

        foreach ($tabs as $tab) {
            foreach ($tab as $content) {
                $html .= '<li>' . $content . '</li>';
            }
        }

        $html .= '</ul>';
        $html .= '</div>';

        return $html;
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

        $tabsHeaders = ['Animations', 'Layout', 'Drag'];
        $tabs = $this->render_tabs_headers($tabsHeaders);

        try {
            $muuriCssItems = isset($custom['muuriCssItems'][0])
                ? $custom['muuriCssItems'][0]
                : 'wp_muuri_gallery__' . $post->ID;

            $muuriCssItemsField = $this->fields_renderer->text(
                $muuriCssItems,
                'muuriCssItems',
                'CSS Items'
            );
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
        //> Load fields value
        $cfg_animations = $this->fields->animations();
        $cfg_layout = $this->fields->layout();
        $cfg_drag_basic = $this->fields->drag_basic();
        $cfg_drag_predicate = $this->fields->drag_predicate();
        $cfg_drag_release = $this->fields->drag_release();
        $cfg_drag_cssProps = $this->fields->drag_cssProps();

        //> Build fields html
        $animations = '';
        foreach ($cfg_animations as $field) {
            $animations .= $this->fields_renderer->sort($field, $cptPost);
        }

        $layout = '';
        foreach ($cfg_layout as $field) {
            $layout .= $this->fields_renderer->sort($field, $cptPost);
        }

        $drag_basic = '';
        foreach ($cfg_drag_basic as $field) {
            $drag_basic .= $this->fields_renderer->sort($field, $cptPost);
        }

        $drag_predicate = '';
        foreach ($cfg_drag_predicate as $field) {
            $drag_predicate .= $this->fields_renderer->sort($field, $cptPost);
        }

        $drag_release = '';
        foreach ($cfg_drag_release as $field) {
            $drag_release .= $this->fields_renderer->sort($field, $cptPost);
        }

        $drag_cssProps = '';
        foreach ($cfg_drag_cssProps as $field) {
            $drag_cssProps .= $this->fields_renderer->sort($field, $cptPost);
        }

        //~ Build content html array
        // $tabsHeaders = ['Animations', 'Layout', 'Drag'];
        $tabsContent = [
            'animations' => [$animations],
            'layout' => [$layout],
            'drag' => [
                $drag_basic,
                $drag_predicate,
                $drag_release,
                $drag_cssProps,
            ],
        ];

        //>> Print metabox complete html
        $html = '<div uk-grid>';
        $html .= $muuriCssItemsField;
        $html .= '<div uk-grid>';
        $html .= $tabs;
        $html .= $this->render_tabs($tabsContent);
        $html .= '</div>';
        $html .= '</div>';
        echo $html;
        // print_r($post);
    }

    public function render_muuri_gallery_metabox($post)
    {
        $cptPost = get_post_custom($post->ID);

        $galleryItems = isset($cptPost['muuriGalleryItems'][0])
            ? $cptPost['muuriGalleryItems'][0]
            : '[]';
        $galleryItemsDecoded = json_decode($galleryItems, true);

        wp_enqueue_media();

        $html = '<div uk-grid class="uk-margin">
                    <div class="wpMuuriGallery__container">
                        <ul id="wpMuuriGallery__list" uk-grid-small uk-child-width-1-2 uk-child-width-1-6@s uk-text-center" uk-sortable="handle: .uk-card" uk-grid>';

        foreach ($galleryItemsDecoded as $item) {
            $imageID = $item['id'];
            $imageTitle = $item['title'];
            $imageSrc = $item['src'];
            $imageCaption = $item['caption'];
            $imageAlt = $item['alt'];

            $html .= "<li class=\"wpMuuriGallery__item\" data-gallery-item-id=\"{$imageID}\">
                        <div class=\"uk-card uk-card-default uk-card-body uk-padding-remove\">
                            <img
                            src=\"{$imageSrc}\"
                            title=\"{$imageTitle}\"
                            alt=\"{$imageAlt}\"
                            width=\"150\" height=\"150\"/>
                            <button
                            data-gallery-item-id=\"{$imageID}\"
                            class=\"uk-position-top-right uk-icon-link wpMuuriGallery__removeItem\" uk-icon=\"close\"></button>
                        </div>
                    </li>";
        }

        // Add button

        $html .= '
        <li>
            <div class="uk-padding-remove uk-height-1-1 uk-flex uk-flex-center uk-flex-middle">
                <div id="wpMuuriGallery__add" class="uk-button uk-button-default">
                    <span class="uk-padding-small" uk-icon="plus-circle"></span>
                </div>
            </div>
        </li>';

        $html .= '</ul>';
        $html .= '</div>';
        $html .= "<textarea id=\"wpMuuriGallery__galleryInputHidden\" name=\"muuriGalleryItems\" >{$galleryItems}</textarea>";

        echo $html;
    }
}
