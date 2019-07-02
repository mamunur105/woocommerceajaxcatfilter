(function($) {
            
    $('.catagory_filter_button').click(function(){
     var cat_id = $(this).data('id'),
        data = "&action=product_filter&id="+cat_id;
         $.post(ajaxurlbook, data, function(product) {
             if(product){ 
                 $( ".product-list" ).empty().html(product);
             }      
         });
    }) ;
    
 })(jQuery);