<?php
function ch_simple_filtersettings_page()
{



    ?>
    <div class="wrap">
        <h1><?php echo __('CH Simple Filter Settings', 'ch-simple-filter'); ?></h1>
        <form method="post" action="">
            <?php settings_fields('ch_simple_filtersettings'); ?>
            <?php do_settings_sections('ch_simple_filtersettings'); ?>
            <?php wp_nonce_field('ch_simple_filtersettings_nonce', 'ch_simple_filtersettings_nonce'); ?>
            
 
            <h2><?php echo __('Available Tags', 'ch-simple-filter') ;?></h2>
            <p><?php echo __('Order can be changed via drag & drop', 'ch-simple-filter');?>  </p>
            <?php
            $tags = get_tags();
            $selected_tags = unserialize(get_option('ch_simple_filtertags', ''));

            $selected_tags = is_array($selected_tags) ? $selected_tags : array();

            function compareTags($a, $b)
            {
                return strcmp($a->slug, $b->slug);
            }

            // Das Array nach dem Namen sortieren
            usort($tags, 'compareTags');

            // Ergebnis ausgeben
            echo '<b><input type="checkbox" name="select_all_tags" id="select_all_tags">'. __('Select all Tags','ch-simple-filter'). '</input><p></b>';
            ?>
            <div id="tags_sort" >
                <?php
                foreach ($tags as $tag) {
                    $checked = in_array($tag->term_id, $selected_tags) ? '' : '';
                    echo '<div id="' . $tag->name . '"><input type="checkbox" name="ch_simple_filtertags[]" value="' . esc_attr($tag->term_id) . '" ' . $checked . ' class="sortable-item">';
                    echo esc_html($tag->name) . '<br></div>';
                }
                ?>
            </div>

            <h2><?php echo __('Available categories', 'ch-simple-filter'); ?></h2>
            <?php
            $categories = get_categories();
            echo '<b><input type="checkbox" name="select_all_categories" id="select_all_categories">'. __('Select all Categories','ch-simple-filter'). '</input><p></b>';

            echo '<div id="cat_sort">';
            foreach ($categories as $category) {
                $checked = in_array($category->term_id, $selected_tags) ? '' : '';
                echo '<div id="' . $category->name . '"><input type="checkbox" name="ch_simple_filtercategories[]" value="' . esc_attr($category->term_id) . '" ' . $checked . '>';
                echo esc_html($category->name) . '<br></div>';
            }
          
            echo "</div>";
          
            /*
            echo '<ul class="sortable-list">';
            foreach ($categories as $category) {
               
                echo '<li class=cat_ids_test id="' . $category->name . '"value="' . esc_attr($category->term_id) . '" ' . $checked . '>';
                echo esc_html($category->name) . '<br></li>';
            }
            echo "</ul>"; */
        
           
        
            ?>
            <div><p>
            <span><?php echo __('Label for tag filter select box (default: tags)', 'ch-simple-filter'); ?></span><br>
            <input type="text" name="ch_filter_tag_label" ><br>

            <span><?php echo __('Label for category filter select box (default: tags)', 'ch-simple-filter'); ?></span><br>
            <input type="text" name="ch_filter_category_label"><br><br>
            <span>Filter View (Default: Grid View)</span><br>
            <select name="ch_filter_view_type" id="filter_type">
                <option value="grid-filter" <?php selected('grid-filter', get_option('filter_type', '')); ?>>Grid View</option>
                <option value="accordion-filter" <?php selected('accordion-filter', get_option('filter_type', '')); ?>>Accordion View</option>
            </select>
        </div>
        <br><p></p>
<?php
            if (isset($_POST['submit'])) {
                // Debug-Hinweis

                // Get the selected tags and categories from the form
                $selected_tags = isset($_POST['ch_simple_filtertags']) ? $_POST['ch_simple_filtertags'] : array();
                $selected_categories = isset($_POST['ch_simple_filtercategories']) ? $_POST['ch_simple_filtercategories'] : array();
                $select_tag_label=$_POST['ch_filter_tag_label'];
                $select_category_label=$_POST['ch_filter_category_label'];
                $select_filter_type=$_POST['ch_filter_view_type'];
                
                // Debug-Hinweis
                // Sanitize the selected options
                $selected_tags = array_map('sanitize_text_field', $selected_tags);

                // Debug-Hinweis
                // Update the options in the database
                update_option('ch_simple_filtertags', serialize($selected_tags));
                update_option('ch_simple_filtercategories', serialize($selected_categories));
                update_option('ch_simple_filter_tag_label', serialize($select_tag_label));
                update_option('ch_simple_filter_category_label', serialize($select_category_label));
                update_option('ch_simple_filter_view_type', serialize($select_filter_type));

                // Debug-Hinweis
                // Registriere den Shortcode mit den aktualisierten Optionen
                $shortcode = register_dynamic_shortcode();
                
                echo '<p>Der Shortcode für die aktuelle Auswahl lautet: <strong class="my-shortcode">' . $shortcode . '</strong></p>';
            }
            if (isset($shortcode))
            {
                echo '<button type="button" class="copy-button" value="copy">Copy to clipboard</button>';
            }
            ?>
            <?php 
          
          submit_button( __('Erzeuge Shortcode') ) ?>
          
        </form>

        <script>
            jQuery(function ($) {
                $("div#tags_sort").sortable();
                $("div#cat_sort").sortable();
            });
        </script>
        
    </div>
    <?php
}
// Enqueue your custom script
function sunset_load_admin_scripts(){ 

    wp_register_script('sunset-admin-script', plugin_dir_url( __FILE__ ) .'/js/script_admin.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('sunset-admin-script'); 
}
add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );
// Shortcode für das Frontend-Formular
add_shortcode('ch_simple_filterform', 'ch_simple_filterform_shortcode');
?>
