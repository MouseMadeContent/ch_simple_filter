jQuery(document).ready(function($) {
    // Define myFunction outside the click event handler
 
    let ajax_url = myAjax.ajaxurl;   
    jQuery('.accordion-header').click(function () {
        $('.plus').removeClass('minusitem');
        $(this).closest('.accordion-item').find('.plus').toggleClass('minusitem plusitem');

        // Use myFunction here
        

        // This is the variable we are passing via AJAX
   
        var postId = $(this).closest('.accordion-item').data('post-id');

        if ($(this).closest('.accordion-item').hasClass('accordion-content-inline')) {
            $(this).closest('.accordion-item').removeClass('accordion-content-inline');
            $(this).closest('.accordion-header').removeClass('change');
        } else {
            $('.accordion-item').removeClass('accordion-content-inline');
            var $accordionItem = $(this).closest('.accordion-item');
            setTimeout(function() {
                // Use the stored reference to add the class
                $accordionItem.addClass('accordion-content-inline');

            }, 300);
            //$(this).closest('.accordion-item').addClass('accordion-content-inline');
            $('.accordion-header').removeClass('change');
            $(this).closest('.accordion-header').addClass('change');
           
        }

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: {
                'action': 'get_wp_posts_ajax_request',
                'post_id': postId,
            },
            success: function(data) {
                $('.post-content-' + postId).html(data);
            }
        });
    });
});
