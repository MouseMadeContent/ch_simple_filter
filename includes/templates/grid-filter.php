<div class="post-grid">
    <?php
while ($query->have_posts()): $query->the_post();
?>
<div class="grid-item">
    <h2>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
    <div class="grid_filter_post_content">
        <?php 
        echo wp_trim_words(get_the_excerpt(), 15);
        $content = get_the_content();

        // Strip HTML tags from the content
        $stripped_content = strip_tags($content);
        
        // Count the number of words in the stripped content
        $word_count = str_word_count($stripped_content);
        if ($word_count>15)
        {
           
            echo '<div class="read_more"><a href="'.get_permalink().'">weiterlesen</a></div>';
        }        
       
?>
    </div>
   
        <div class="grid_filter_post_adds">
            <?php
            
            // Tags ausgeben
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
            // Kategorien ausgeben
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
    </p>
</div>
<?php endwhile;
            ?>
        </div>