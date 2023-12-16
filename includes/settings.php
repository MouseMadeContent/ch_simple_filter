<?php
// Register Settings
function ch_simple_filtersettings_init()
{

    // Check for the existence of nonce in the request
    if (!isset($_POST['ch_simple_filtersettings_nonce']))
    {
        return;
    }

    // Verify the nonce
    $nonce = sanitize_text_field($_POST['ch_simple_filtersettings_nonce']);
    if (!wp_verify_nonce($nonce, 'ch_simple_filtersettings_nonce'))
    {
        return;
    }

    register_setting('ch_simple_filtersettings', 'ch_simple_filtertags', 'sanitize_text_field');
    register_setting('ch_simple_filtersettings', 'ch_simple_filtercategories', 'sanitize_text_field');
}
add_action('admin_init', 'ch_simple_filtersettings_init');
?>
