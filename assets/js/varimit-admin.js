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
               alert("Вариация успешно создано");    
               setTimeout(function() { location.reload() }, 1000);
                                                 
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
                    setTimeout(function() { location.reload() }, 1000);  
                                                               
               },
              
          });
     }); 
 
 /**
 * Добавление значения вариации
 *
 * @var {[type]}
 */
            
 
     $('#variation_file_value').on('change', function(){ 
    
       file = this.files;
       $('#add_new_variation_value').on('click',{param1: file}, function(event){         
           
            let variation_form_value = document.querySelector('#variation_form_value');
            let getDateFormValue = new FormData(variation_form_value);
            getDateFormValue.append("action", "variation_add_value");        
          $.ajax({
               url:myajax.ajaxurl, 
               data:getDateFormValue,
               processData : false,
               contentType : false, 
               type:'POST', 
                    success:function(request){
                         alert("Значение вариации добавлена");
                         setTimeout(function() { location.reload() }, 1000);   
                                                                                                         
                    },
                    error: function( err ) {
                         console.log( err );            	
                    }
          });

       });
     });

     /**
      * Изменения значения вариации      
      * 
      * 
      */           
 
  $('#variation_value_img').on('change', function(){ 
    
     file = this.files;
     $('#save_variation_value').on('click',{param1: file}, function(event){         
          
               let variation_form_value = document.querySelector('#variation-value-form-edit');
               let getDateFormValue = new FormData(variation_form_value);
               getDateFormValue.append("action", "variation_edit_value");        
          $.ajax({
               url:myajax.ajaxurl, 
               data:getDateFormValue,
               processData : false,
               contentType : false, 
               type:'POST', 

               success:function(request){
                    alert("Значение вариации изменено"); 
                    setTimeout(function() { location.reload() }, 1000); 
                                                                                                    
               },
               error: function( err ) {
                    console.log( err );            	
               }
          });

     });
  }); 
     
  
} )( jQuery );


