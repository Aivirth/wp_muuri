<?php
function wp_muuri_add_tags_to_images()
{
    register_taxonomy_for_object_type('post_tag', 'attachment');
}
add_action('init', 'wp_muuri_add_tags_to_images');
