<div class="accordion-grid">
  <?php while ($query->have_posts()): $query->the_post(); ?>
    <div class="accordion-item" data-post-id="<?php echo esc_attr(get_the_ID()); ?>">
      <div class="accordion-header">
        <div class="title-container">
          <h2 class="title"><?php the_title(); ?></h2>

        </div>
        <div class="accordion-menu-container">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
          </div>
      </div>
      <div class="post-content-<?php echo esc_attr(get_the_ID()); ?> accordion-content">
        <!-- Placeholder content to be replaced by AJAX response -->
        <div class="loading-spinner"></div>
      </div>
      <div class="post_adds">
        <?php
        // Tags and Categories output
        $tags = get_the_tags();
        $separator = "";
        if ($tags) {
          $j = 0;
          echo $atts['ch_simple_filter_tag_label'] . ": ";
          foreach ($tags as $tag) {
            $j++;
            if ($j > 1) {
              $separator = ", ";
            }
            echo '<span class="bold_tags">' . $separator . $tag->name . '</span>';
          }
        }
        echo "<br>";
        $categories = get_the_category();
        $separator = "";
        if ($categories) {
          $i = 0;
          echo $atts['ch_simple_filter_category_label'] . ": ";
          foreach ($categories as $category) {
            $i++;
            if ($i > 1) {
              $separator = ", ";
            }
            echo '<span class="bold_tags">' . $separator . $category->name . '</span>';
          }
        }
        ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php
// Enqueue jQuery

// Enqueue your custom script
/*wp_enqueue_script(
    'ch_simple_filter',
    plugin_dir_url(__FILE__) . 'script.js',
    array('jquery'),
    '1.0',
    true
);*/



// Localize the script
wp_localize_script('ch_simple_filter', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));

add_action('wp_ajax_get_post_content', 'get_post_content');
add_action('wp_ajax_nopriv_get_post_content', 'get_post_content');

function get_post_content() {
  error_log('AJAX Request Received');
  $nonce = $_POST['nonce'];
  if (!isset($nonce) || !wp_verify_nonce($nonce, 'your-nonce')) {
    wp_send_json_error('Invalid nonce.');
  }

  $post_id = $_POST['post_id'];
  $post_content = get_post_field('post_content', $post_id);

  $response = array(
    'post_content' => apply_filters('the_content', $post_content),
  );

  wp_send_json($response);
  die();
}
?>
