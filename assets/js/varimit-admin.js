( function( $ ) {
    $('#submit-variation').on('click',function(){ 

                            
         let variation_form = document.querySelector('#variation_form');
         let getDateForm = new FormData(variation_form);
         getDateForm.append("action", "add_new_variation"); 
         // alert(myajax.ajaxurl);
         $.ajax({
              url:myajax.ajaxurl, 
              data:getDateForm,
              processData : false,
              contentType : false,              
              type:'POST',  
              success:function(request){                                                            
                   alert(request);            
                                 
              },
              error: function (error) {
                alert(error);
            }
  
          });
     });
  
} )( jQuery );