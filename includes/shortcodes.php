<?php

function ch_simple_filter_shortcode($atts)
{
    // Get the saved options from the database
    $selected_tags = isset($atts['ch_simple_filtertags']) ? array_map('intval', explode(',', $atts['ch_simple_filtertags'])) : array();
    $selected_categories = isset($atts['ch_simple_filtercategories']) ? array_map('intval', explode(',', $atts['ch_simple_filtercategories'])) : array();
    $selected_category_ids = isset($atts['ch_simple_filtercategories']) ? array_map('intval', explode(',', $atts['ch_simple_filtercategories'])) : array();
    $selected_tags_ids = isset($atts['ch_simple_filtertags']) ? array_map('intval', explode(',', $atts['ch_simple_filtertags'])) : array();
    $filter_view_type=$atts['ch_simple_filter_view_type'];
    ob_start();
    ?>

    <form id="custom-filter-form" action="" method="get">
        <div class="select-container">
            <div class="select_label">

                <label for="filter_tags"><?php echo $atts['ch_simple_filter_tag_label'] ?>:</label>
            </div>
            <div class="select_box">
                <select name="filter_tags[]" >
                <option value="0"><?php echo __('All', 'ch-simple-filter') . ' '. $atts['ch_simple_filter_tag_label']; ?></option>
                    <?php
                
                    foreach ($selected_tags as $tag_id) {
                        $tag = get_term($tag_id, 'post_tag');
                        if ($tag && !is_wp_error($tag)) {
                            $selected="";
                            if(!empty($_GET['filter_tags'])){
                            $selected = ($_GET['filter_tags'][0] == $tag->term_id) ? 'selected' : '';
                            }
                            echo '<option value="' . esc_attr($tag->term_id) . '" ' . $selected . '>' . esc_html($tag->name) . '</option>';
                        
                    }
                }
                    ?>
                </select>
            </div>
        </div>
        <p></p>
        <div class="select-container">
            <div class="select_label">
            <label for="filter_tags"><?php echo $atts['ch_simple_filter_category_label'] ?>:</label>
            </div>
            <div class="select_box">
                
                <select name="filter_categories[]" >
                 <!-- <option value="0"><?php echo __('All categories', 'ch-simple-filter'); ?></option>-->
                 <option value="0"><?php echo __('All', 'ch-simple-filter') . ' '. $atts['ch_simple_filter_category_label']; ?></option>
                    <?php
                     
                    foreach ($selected_categories as $category_id) {
                        $category = get_term($category_id, 'category');
                        if ($category && !is_wp_error($category)) {
                            $selected="";
                            if(!empty($_GET['filter_categories'])){
                            $selected = ($_GET['filter_categories'][0] == $category->term_id) ? 'selected' : '';
                            }
                            echo '<option value="' . esc_attr($category->term_id) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
                        
                    }
                }
                    ?>
                </select>
            </div>
       
        </div>

        <br>
        <?php 

?>
        <span class="filter-button">
            <input class="filter-button" type="submit" value="<?php echo __('Filter', 'ch-simple-filter') ;?>">
        </span>
    </form>
    <p></p>

    <?php
    // The custom query
    $query_args = array(
        'post_type' => 'post', // Anpassen, wenn Sie einen anderen Beitragstyp verwenden
        'posts_per_page' => -1, // -1 zeigt alle Beiträge an, anpassen, wenn Sie eine bestimmte Anzahl möchten
    );
    #echo $filter_view_type;
    $selected_tags = isset($_GET['filter_tags']) ? array_map('intval', $_GET['filter_tags']) : array();
    $selected_categories = isset($_GET['filter_categories']) ? array_map('intval', $_GET['filter_categories']) : array();
    
   
    if (!empty($selected_tags) || !empty($selected_categories)) {
        $tax_query = array('relation' => 'AND');
        if (!empty($selected_tags)) {
            if ($selected_tags[0] == 0) {
                $selected_tags = $selected_tags_ids;
            }
            $tax_query[] = array(
                'taxonomy' => 'post_tag',
                'field' => 'id',
                'terms' => $selected_tags,
            );
        }

        if (!empty($selected_categories)) {
            if ($selected_categories[0] == 0) {
                $selected_categories = $selected_category_ids;
            }
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $selected_categories,
            );
        }

        $query_args['tax_query'] = $tax_query;
    } else {
        $tax_query = array('relation' => 'AND');
        if($selected_category_ids)
        {
            $term_cat=$selected_category_ids;
        }
        else
        {
            $term_cat=wp_list_pluck(get_categories(), 'term_id');
        }
      
        $tax_query[] = array(
            'taxonomy' => 'post_tag',
            'field' => 'id',
            'terms' => $selected_tags_ids,
        );

        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' =>  $term_cat,
        );

        $query_args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($query_args);

    if ($query->have_posts()):

    
            
        

      include(plugin_dir_path(__FILE__) . 'templates/'.$filter_view_type.'.php');
   


        wp_reset_postdata(); // Reset the global $post variable
    else:
        echo __('No Entries found', 'ch-simple-filter');
    endif;
    return ob_get_clean();
}

add_shortcode('ch_simple_filter', 'ch_simple_filter_shortcode');

// Diese Aktion sollte nur im Admin-Menü ausgeführt werden
function generate_ch_simple_filtershortcode()
{
    $selected_tags = get_option('ch_simple_filtertags', array());
    $selected_tags_ids = unserialize(get_option('ch_simple_filtertags', array()));
    $selected_categories = get_option('ch_simple_filtercategories', array());
    $selected_category_ids = unserialize(get_option('ch_simple_filtercategories', array()));
    $shortcode_atts = array();

    if (!empty($selected_tags)) {
        $shortcode_atts[] = 'ch_simple_filtertags="' . implode(',', (array)$selected_tags) . '"';
    }

    if (!empty($selected_categories)) {
        $shortcode_atts[] = 'ch_simple_filtercategories="' . implode(',', (array)$selected_categories) . '"';
    }

    return '[ch_simple_filter ' . implode(' ', $shortcode_atts) . ']';

}
function load_accordion_script(){ 
    wp_register_script('accordion_script', plugin_dir_url( __FILE__ ) .'/js/script.js', array('jquery'), '1.0.0', true);
    wp_localize_script( 'accordion_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'relataive' )));  
    wp_enqueue_script('accordion_script'); 
  }
  add_action( 'wp_enqueue_scripts', 'load_accordion_script');


function get_wp_posts_ajax_request() {

    $post_id = $_POST['post_id'];
    $post_content = get_post_field('post_content', $post_id);

    echo $post_content;

   die();
}

// This bit is a special action hook that works with the WordPress AJAX functionality.
add_action( 'wp_ajax_get_wp_posts_ajax_request', 'get_wp_posts_ajax_request' );
add_action( 'wp_ajax_nopriv_get_wp_posts_ajax_request', 'get_wp_posts_ajax_request' );
?>