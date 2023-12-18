<?php   
 // Register plugin page
    function register_ch_simple_filterplugin()
    {
        add_menu_page('CH Simple Filter', 'CH Simple Filter', 'manage_options', 'custom-filter-plugin', 'ch_simple_filtersettings_page');
    }

    add_action('admin_menu', 'register_ch_simple_filterplugin');
    function register_dynamic_shortcode()
    {
        $selected_tags = unserialize(get_option('ch_simple_filtertags', ''));
        $selected_categories = unserialize(get_option('ch_simple_filtercategories', ''));
        $select_tag_label = unserialize(get_option('ch_simple_filter_tag_label', ''));
        $select_category_label = unserialize(get_option('ch_simple_filter_category_label', ''));
        $select_filter_type = unserialize(get_option('ch_simple_filter_view_type', ''));
        

        // Generate the shortcode based on the selected tags and categories


        // Erstelle einen eindeutigen Shortcode-Namen basierend auf den ausgewählten Tags und Kategorien
        $shortcode_atts = array();

        if (!empty($selected_tags))
        {
            $shortcode_atts[] = 'ch_simple_filtertags="' . implode(',', $selected_tags) . '"';
        }

        if (!empty($selected_categories))
        {
            $shortcode_atts[] = 'ch_simple_filtercategories="' . implode(',', $selected_categories) . '"';
        }
        if (!empty($select_tag_label))
        {
            $shortcode_atts[] = 'ch_simple_filter_tag_label="' .$select_tag_label . '"';
        }
        else{
            $shortcode_atts[] = 'ch_simple_filter_tag_label="Alle Tags"';

        }
        if (!empty($select_category_label))
        {
            $shortcode_atts[] = 'ch_simple_filter_category_label="' .$select_category_label . '"';
        }
        else{
            $shortcode_atts[] = 'ch_simple_filter_category_label="Alle Kategorien"';
        }
      
            $shortcode_atts[] = 'ch_simple_filter_view_type="' .$select_filter_type . '"';
      
     
        // Füge die Shortcode-Attribute hinzu
        $shortcode_output = '[ch_simple_filter ' . implode(' ', $shortcode_atts) . ']';

        // Registriere den Shortcode, wenn er noch nicht existiert
        if (!shortcode_exists('ch_simple_filter'))
        {
            add_shortcode('ch_simple_filter', 'ch_simple_filter_shortcode');
            add_action('admin_notices', function () use ($shortcode_output)
            {
                echo '<p>Der Shortcode für die aktuelle Auswahl lautet: <strong>' . $shortcode_output . '</strong></p>';
            });
        }
        # echo '<p>Der Shortcode für die aktuelle Auswahl lautet: <strong>' . $shortcode_output . '</strong></p>';
        return $shortcode_output;
    }
add_action('admin_menu', 'register_dynamic_shortcode');
?>
