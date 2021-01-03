<?php
function muuri__shortcode__html(array $atts = [])
{
    $atts = array_change_key_case($atts, CASE_LOWER);

    $atts = shortcode_atts(
        [
            'id' => 0,
        ],
        $atts
    );

    $ID = $atts['id'];

    if ($ID <= 0) {
        return 'Gallery id not valid
        ';
    }

    $gallery_cfg = get_post($ID);
    $galleryData = get_post_custom($ID);
    $gallery_itemsJson = get_post_custom($ID)['muuriGalleryItems'][0];

    $post_type = get_post_type($ID);

    if ($post_type !== 'wp-muuri') {
        return 'Post type:' . get_post_type($ID);
    }

    $plugin_name = 'wp-muuri';

    $galleryDataForJs = [];
    foreach ((array) $galleryData as $option => $value) {
        $galleryDataForJs[$option] =
            intval($value[0]) === 0 ? $value[0] : intval($value[0]);
    }

    try {
        wp_localize_script($plugin_name, 'wp_muuri_cfg_obj', $galleryDataForJs);
    } catch (\Throwable $th) {
        die($th->getMessage());
    }

    // var_dump((array) $galleryDataForJs);

    // print_r($atts);

    // $html = '<code><pre>' . print_r($gallery_cfg) . '</pre></code>';
    // $html .= '<hr><pre>' . var_dump($atts) . '</pre>';
    // $html .= '<hr><pre>' . var_dump(get_post_custom($ID)) . '</pre>';

    $html = "<div class=\"WP_Muuri__gridWrapper\" data-gallery_id=\"{$ID}\">";
    $html .= print_gallery_html($gallery_itemsJson);
    $html .= '</div>';

    return $html;
}

function print_gallery_html(string $galleryJson)
{
    $galleryItems = json_decode($galleryJson, true);

    $html = print_gallery_filters($galleryItems);
    $html .= '<div class="grid">';

    foreach ($galleryItems as $galleryItem) {
        $ID = $galleryItem['id'];
        $src = $galleryItem['src'];
        $title = $galleryItem['title'];
        $alt = $galleryItem['alt'];

        $tags = get_the_tags($ID);
        $dataSetTags = format_tags_for_dataset($tags);

        $html .= "<div class=\"item\" data-wp_muuri_gallery_item_id=\"{$ID}\">
                    <div class=\"item-content\">
                        <img src=\"{$src}\" src=\"{$alt}\" title=\"{$title}\" alt=\"{$alt}\" data-tags=\"{$dataSetTags}\"/>
                    </div>
                </div>";
    }

    $html .= '</div>';

    return $html;
}

function format_tags_for_dataset($wp_tags_raw)
{
    $tags = [];
    foreach ($wp_tags_raw as $tag) {
        $tags[] = $tag->slug;
    }

    $tags = implode('|', array_unique($tags));

    return $tags;
}

function print_gallery_filters(array $galleryItems = [])
{
    //> Purify tags array
    $sanitizedTagsArr = [];
    $allTagsArrayRaw = [];
    foreach ($galleryItems as $galleryItem) {
        $ID = $galleryItem['id'];
        $allTagsArrayRaw[$ID] = get_the_tags($ID);
    }

    foreach ($allTagsArrayRaw as $tagsArray) {
        foreach ($tagsArray as $tag) {
            $tagID = $tag->term_id;
            $tagName = $tag->name;
            $tagSlug = $tag->slug;
            $tagCount = $tag->count;

            $sanitizedTagsArr[$tagID]['name'] = $tagName;
            $sanitizedTagsArr[$tagID]['slug'] = $tagSlug;
            $sanitizedTagsArr[$tagID]['count'] = $tagCount;
        }
    }

    $filterKeys = [];

    foreach ($sanitizedTagsArr as $tag) {
        $tagKey = $tag['name'];
        $tagValue = $tag['slug'];
        $filterKeys[$tagKey] = $tagValue;
    }

    //Todo: Search and sort
    /**
     * <div class="control">Search
     *<input class="search-field form-control" type="text" name="search" placeholder="Enter the fruit name">
     *</div>
     */

    $html = '<div class="WP_Muuri__fieldsControl">';
    $html .= '<div class="control">';
    $html .= '<select class="WP_Muuri__field WP_Muuri__filter">';
    $html .= '<option value="all">' . __('All', 'wp-muuri') . '</option>';

    foreach ($filterKeys as $filterKey => $filterValue) {
        $html .= "<option value=\"{$filterValue}\">{$filterKey}</option>";
    }

    $html .= '</select>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

/**
 * Add new Shortcodes
 *
 * @return void
 */
function add_muuri_shortcodes()
{
    add_shortcode('wp_muuri_gallery', 'muuri__shortcode__html');
}
add_action('init', 'add_muuri_shortcodes');
