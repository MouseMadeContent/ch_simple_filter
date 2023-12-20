<?php
function enqueue_custom_styles()
{
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');

    wp_enqueue_style('ch_filter_css', plugin_dir_url(__FILE__) . 'style.css');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
add_action('admin_enqueue_scripts', 'enqueue_custom_styles');


?>
