( function( $ ) {

     /**
      * Модальное окно в карточке товара
      */
    
     $(`.varimit-output-single-product-inner-left`).on('click', function() {           
         
          let valueParentModal = jQuery(this).attr("data-id_parent");                                    
                     
          $(`#modal_${valueParentModal}`).show();

     });

     $(`.varimit-popup-output-close`).on('click', function() {           
         
          let valueCloseModal = jQuery(this).attr("data-id_close");                                    
                     
          $(`#modal_${valueCloseModal}`).hide();

     });
	
} )( jQuery );