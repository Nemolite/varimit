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
	       $(`#left_${valueParentModal}`).css({'marginTop':'0', 'opacity':'1', 'height': "100%"});
               $(`#left_${valueParentModal}`).show();
               $(`#left_${valueParentModal}`).animate({marginLeft:"100%"},400);
               $('body').css('overflow', 'hidden');
          }
         
     });

     $(`.varimit-popup-output-close`).on('click', function() {           
          doc_w = $(document).width();

          let valueCloseModal = jQuery(this).attr("data-id_close");                                    
      
          if (doc_w>460) {
               $(`#modal_${valueCloseModal}`).hide();
          }

          if (doc_w<460) {

               $(`#left_${valueCloseModal}`).animate({marginLeft:"-100%", marginTop: "-150%", height: "0", opacity: "0"},500);
               
               setTimeout(function(){
	         $(`#left_${valueCloseModal}`).hide();
	       },300)
               
               $('body').css('overflow', 'unset');
          }
     });  
     
     /**
      * Сокрытие товаров в вариации
      */
     
      $(`.woof_reset_search_form`).on('click',function(){           
          
          baseUrl = window.location.href.split("?")[0];
          submit_link=baseUrl+"?swoof=2";
          history.pushState({}, "?", submit_link);

          location.reload();
          history.pushState({}, "?", baseUrl );                 
         
      });
      
      

       
} )( jQuery );

let PopupOpen = document.querySelectorAll('.varimit-left-output');
console.log(PopupOpen);
console.log('sfdb')