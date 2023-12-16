<?php
function ch_simple_filtersettings_page()
{
    ?>
    <div class="wrap">
        <h1>CH Simple Filter Settings</h1>
        <form method="post" action="">
            <?php settings_fields('ch_simple_filtersettings'); ?>
            <?php do_settings_sections('ch_simple_filtersettings'); ?>
            <?php wp_nonce_field('ch_simple_filtersettings_nonce', 'ch_simple_filtersettings_nonce'); ?>

            <h2>Auswählbare Tags</h2>
            <p>Reihenfolge kann per Drag & Drop geändert werden</p>
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
            echo "<br>";
            ?>
            <div id="tags_sort">
                <?php
                foreach ($tags as $tag) {
                    $checked = in_array($tag->term_id, $selected_tags) ? '' : '';
                    echo '<div id="' . $tag->name . '"><input type="checkbox" name="ch_simple_filtertags[]" value="' . esc_attr($tag->term_id) . '" ' . $checked . ' class="sortable-item">';
                    echo esc_html($tag->name) . '<br></div>';
                }
                ?>
            </div>

            <h2>Auswählbare Kategorien</h2>
            <?php
            $categories = get_categories();

            echo '<div id="cat_sort">';
            foreach ($categories as $category) {
                $checked = in_array($category->term_id, $selected_tags) ? '' : '';
                echo '<div id="' . $category->name . '"><input type="checkbox" name="ch_simple_filtercategories[]" value="' . esc_attr($category->term_id) . '" ' . $checked . '>';
                echo esc_html($category->name) . '<br></div>';
            }
            echo "<p></p>";
            echo '<span>Label für Tag-Filter-Selectbox (Default: Alle Tags)</span>';
            echo "</div><div>";
            echo '<input type="text" name="ch_filter_tag_label"><br><br>';
            echo '</div><div>';
            echo '<span>Label für Kategorie-Filter-Selectbox (Default: Alle Kategorien)</span>';
            echo "</div>";
            echo '<div>';
            echo '<input type="text" name="ch_filter_category_label"><br><br>';
            echo "</div>";


            if (isset($_POST['submit'])) {
                // Debug-Hinweis

                // Get the selected tags and categories from the form
                $selected_tags = isset($_POST['ch_simple_filtertags']) ? $_POST['ch_simple_filtertags'] : array();
                $selected_categories = isset($_POST['ch_simple_filtercategories']) ? $_POST['ch_simple_filtercategories'] : array();
                $select_tag_label=$_POST['ch_filter_tag_label'];
                $select_category_label=$_POST['ch_filter_category_label'];
                // Debug-Hinweis
                // Sanitize the selected options
                $selected_tags = array_map('sanitize_text_field', $selected_tags);

                // Debug-Hinweis
                // Update the options in the database
                update_option('ch_simple_filtertags', serialize($selected_tags));
                update_option('ch_simple_filtercategories', serialize($selected_categories));
                update_option('ch_simple_filter_tag_label', serialize($select_tag_label));
                update_option('ch_simple_filter_category_label', serialize($select_category_label));

                // Debug-Hinweis
                // Registriere den Shortcode mit den aktualisierten Optionen
                $blub = register_dynamic_shortcode();
                echo $blub;
            }
            ?>
            
            <?php 
          
          submit_button( __('Erzeuge Shortcode') );?>
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

// Shortcode für das Frontend-Formular
add_shortcode('ch_simple_filterform', 'ch_simple_filterform_shortcode');
?>
