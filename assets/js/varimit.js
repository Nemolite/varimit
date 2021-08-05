( function( $ ) {

     /**
      * Модальное окно в карточке товара
      */
    
     $(`.varimit-output-single-product-inner-left`).on('click', function() { 
          doc_w = $(document).width();         
         
               $(`.varimit-output-single-product-inner`).each(function (index, element) { 

                    $(`.varimit-popup-output`).hide();                    
                    $(`.varimit-left-output`).hide();                                            
                  
               });                
         
          let valueParentModal = jQuery(this).attr("data-id_parent");                                    
          
          if (doc_w>460) {
               $(`#modal_${valueParentModal}`).show();
          }

          if (doc_w<460) {

               $(`#left_${valueParentModal}`).show();
               $(`#left_${valueParentModal}`).animate({marginLeft:"100%"},1000);
          }
         
     });

     $(`.varimit-popup-output-close`).on('click', function() {           
          doc_w = $(document).width();

          let valueCloseModal = jQuery(this).attr("data-id_close");                                    
      
          if (doc_w>460) {
               $(`#modal_${valueCloseModal}`).hide();
          }

          if (doc_w<460) {

               $(`#left_${valueCloseModal}`).animate({marginLeft:"-100%"},1000);
               $(`#left_${valueCloseModal}`).hide();
          }
     });
       
} )( jQuery );