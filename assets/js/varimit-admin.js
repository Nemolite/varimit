( function( $ ) {
     /**
      * Добавление вариацию в таблицы базы данных
      *
      * @param   {[type]}  #submit-variation  [#submit-variation description]
      * @param   {[type]}  click              [click description]
      * @param   {[type]}  function           [function description]
      *
      * @return  {[type]}                     [return description]
      */
    $('#submit-variation').on('click',function(){ 
                        
         let variation_form = document.querySelector('#variation_form');
         let getDateForm = new FormData(variation_form);
         getDateForm.append("action", "add_new_variation"); 
         
         $.ajax({
              url:myajax.ajaxurl, 
              data:getDateForm,
              processData : false,
              contentType : false,              
              type:'POST', 
              success:function(request){ 
                   
               setTimeout(function() { location.reload() }, 3000);
               
                                                          
          },           
  
          });
     });

/**
 * Редактирование Вариации
 *
 * @param   {[type]}  #submit-variation-edit  [#submit-variation-edit description]
 * @param   {[type]}  click                   [click description]
 * @param   {[type]}  function                [function description]
 *
 * @return  {[type]}                          [return description]
 */
     $('#submit-variation-edit').on('click',function(){ 
                        
          let variation_form_edit = document.querySelector('#variation-form-edit');        
          let getDateFormEdit = new FormData(variation_form_edit);
          getDateFormEdit.append("action", "edit_variation");           
          $.ajax({
               url:myajax.ajaxurl, 
               data:getDateFormEdit,
               processData : false,
               contentType : false,              
               type:'POST',  
               success:function(request){                                                            
                    alert("Вариация успешно обновлена"); 
                                                               
               },
              
           });
      });
     
  
} )( jQuery );