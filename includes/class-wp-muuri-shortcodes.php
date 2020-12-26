<?php

class Wp_muuri_shortcodes
{
    public function __construct(array $atts = [])
    {
        $this->publish($atts);
    }

    /**
     * Bootstraps the shortcode.
     *
     * @param array $atts
     * @return void
     */
    public function publish(array $atts)
    {
        $this->render($atts);
    }

    /**
     * Calls add_shortcode with a callback of $this->add_shortcode()
     *
     * @return void
     */
    public function init_shortcode()
    {
        add_action('init', [$this, 'add_shortcode']);
    }

    /**
     * Calls add_shortcode with a callback of $this->render().
     *
     * @return void
     */
    public function add_shortcode()
    {
        add_shortcode('wp_muuri_gallery', [$this, 'render']);
    }

    /**
     * Renders the shortcode html.
     *
     * @param array $atts
     * @return void
     */
    public function render(array $atts)
    {
        $atts = $this->change_array_keys_to_lower($atts);
        $shortcode_atts = $this->apply_shortcode_atts_override($atts);
        $gallery_ID = $shortcode_atts['id'];

        $this->get_gallery_data($gallery_ID);
    }

    /**
     * Changes the attributes array keys to lower for consistency with shortcode_atts.
     *
     * @param array $array
     * @return array
     */
    public function change_array_keys_to_lower(array $array = [])
    {
        return array_change_key_case($array, CASE_LOWER);
    }

    /**
     * Calls shortcode_atts overriding shortcode defaults.
     *
     * @param array $atts
     * @return array
     */
    public function apply_shortcode_atts_override(array $atts)
    {
        $defaultParams = ['id' => 0, 'bar' => ''];
        $atts = shortcode_atts($defaultParams, $atts);
        return $atts;
    }

    /**
     * Gets gallery normal and cpt data.
     *
     * @param int $gallery_ID
     * @return void
     */
    public function get_gallery_data(int $gallery_ID)
    {
        if ($gallery_ID <= 0) {
            return '<p>ID not valid</p>';
        }

        $galleryData = get_post($gallery_ID);
        $galleryCustomFields = get_post_custom($gallery_ID);

        $html = '<pre>' . var_dump($galleryData) . '</pre>';
        $html .= '<hr><pre>' . var_dump($galleryCustomFields) . '</pre>';

        return $html;
    }
}
