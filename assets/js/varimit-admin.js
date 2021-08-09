( function( $ ) {
     /**
      * Добавление вариацию в таблицы базы данных
      *     
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

  /**
   * Товар в админке
   * Сохранение идентификатора вариации
   */
   $('#varimit_variation_iden_num').on('change', function() { 
                        
     let postid = $('#idenvar').val();
     let iden = $('#varimit_variation_iden_num').val();    
    
     let idenData =  {  
          action: 'varimit_variation_iden_num',   
          postid: postid,  
          iden  : iden               
        };  
        
          $.ajax({
               url:myajax.ajaxurl, 
               data:idenData,                       
               type:'POST',  
               success:function(request){ 
                         
                                                            
               }
               
          
          });
     });
     

     /**
   * Товар в админке
   * выставление главного товара 
   */
   $('#varimit-main-product-chekbox').on('change', function() { 
                       
     let postid = $('#idenvar').val();
     let main; 
     
     if ($('#varimit-main-product-chekbox').is(':checked')){          
          main = "1";
     } else {        
          main = "0";
     }
    
     let mainData =  {  
          action: 'varimit_variation_iden_main',   
          postid: postid,  
          main  : main               
        };  
        
          $.ajax({
               url:myajax.ajaxurl, 
               data:mainData,                       
               type:'POST',  
               success:function(request){                       
                                                            
               }
               
          
          });
     });

       /**
   * Товар в админке
   * выборка из select
   */
     const valueselect = ( id ) => {      
          $('#slecet-point-process').on('change', `#select_values_${id}`, function() { 
               let optionpostid = $('#idenvar').val();

               let valueID = jQuery(`#select_values_${id}`).attr("data-value_id");                                  
               let optionValueSlug = jQuery(`#select_values_${id}`).val();                
               let optionValueName = jQuery(`#select_values_${id} option:selected`).text();     
                          
              jQuery.ajax({
                      url: myajax.ajaxurl,
                      type: 'POST',
                      data: {
                          action: 'varimit_select_values',
                          optionpostid: optionpostid,
                          value_id: valueID,
                          option_slug: optionValueSlug,
                          option_name: optionValueName,

                      },success:function( request ){
                         
                         
                      } 
               });
  
          });
          
      }     
      
      const varimit_value_index = jQuery("input[name='varimit_value_index']").attr("data-index_full");    
    

      for ( let i = 1;i<=varimit_value_index;i++ ) {
          valueselect( i );        
        
      } 

      /**
       * Сортировка и перетаскивание
       */       
       $('.varimit-values-content').sortable({
          placeholder: 'emptySpace',
          cursor:'move',
          update: function(event, ui) {
               var variationid = $(this).attr("data-variationid");
               var changedList = this.id;
               var order = $(this).sortable('toArray');
               var positions = order.join(';');           
            
               jQuery.ajax({
                    url: myajax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'variation_values_sort',
                        positions: positions,
                        variationid: variationid                     

                    },success:function( request ){                       
                      
                    } 
                });
          }
      });

/**
 * Удаление значения вариации
 * 
 */
  
     $(`.delete-value`).on('click', function() { 
          let variationid = $('.varimit-values-content').attr("data-variationid");
         
          let valueDelID = jQuery(this).attr("data-value_del_id");                                    
                     
         jQuery.ajax({
                 url: myajax.ajaxurl,
                 type: 'POST',
                 data: {
                     action: 'variation_values_del',
                     variationid: variationid,
                     value_del_id: valueDelID                   

                 },success:function( request ){
                    
                    alert( request );
                 } 
             });

     });
/**
 * Скрываем не выбранные вариации
 */

const selecthide = (id) => {
     let temper = $(`#select_values_${id}`).val();    
     if ('notselect'==temper){
          $(`#select_values_${id}`).parent().parent().hide();
     }
}

const cordiner = jQuery("input[name='varimit_value_index']").attr("data-index_full");    
for ( let i = 1;i<=cordiner;i++ ) {
     selecthide( i );        
  
} 


/**
 * Товар в админке
 * Добавление (показ других вариации)
 */
 $(`#select-add-list`).on('click', function() { 
     $(`.select-variation-list`).each(function (index, element) {         
          let temper = $(element).is(':visible');
          
          if (!temper) {
               $(element).show();
               return false; 
          }  
   
          /*
          let variationCount = $(`#variation_count`).attr(`data-variation_count`);       
        
          if ((index+1)==variationCount) {
             $(`#select-add-list`).hide();  
          }
          */
     });
       
});

/**
 * Товар в адпминке
 * Удаление строки вариации и его значения
 */

       const deleteselect = ( id ) => {      
          $(`#select_del_${id}`).on('click', function() { 
               let optionpostid = $('#idenvar').val();
               
               let valueID = $(`#select_del_${id}`).attr("data-del_variation_id");                                               
                      
              jQuery.ajax({
                      url: myajax.ajaxurl,
                      type: 'POST',
                      data: {
                          action: 'varimit_delete_select_option',
                          optionpostid: optionpostid,                         
                          value_id: valueID,                          

                      },success:function( request ){                         
                         
                        $(`#select_del_${id}`).parent().parent().hide();
                         
                      },error: function( err ) {
                                  	
                    } 
                  });
  
          });
          
      }     
      
      const varimit_value_index_del = jQuery("input[name='varimit_value_index']").attr("data-index_full");    
  

      for ( let i = 1;i<=varimit_value_index_del;i++ ) {
          deleteselect( i );        
        
      } 

   /**
   * Товар в админке
   * выборка вариации из select и запись выброного id в базу данных
   */
     const varianselect = ( id ) => {      
          $(`#select_varian_${id}`).on('change', function() { 
               let optionpostid = $('#idenvar').val();               

               let select_vari_slug = $(`#select_varian_${id}`).val(); 
            
               let select_vari_id = $(`#select_varian_${id} option[value=${select_vari_slug}]`).attr('data-varian_id');    
          
               $(`#select_varian_${id} option`).each(function( index, element ) {

                 if ( $( element ).attr("data-varian_id")==select_vari_id ){
                    $( element ).attr('selected','selected'); 
                 } else {
                    $( element ).removeAttr("selected"); 
                 }
           
               });

               let select_vari_name = $(`#select_varian_${id} option:selected`).text();                 
              
               jQuery.ajax({
                    url: myajax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'varimit_select_vari',
                        optionpostid: optionpostid,
                        vari_id: select_vari_id,
                        vari_slug: select_vari_slug,
                        vari_name: select_vari_name,

                    },success:function( request ){

                         $(`#select_varian_${id}`).parent().next().html(request);     

                    /*     
                    var obj = jQuery.parseJSON( request );
                    obj.forEach(function(item, i, arr) {
                         console.log( i + ": " + item + " (массив:" + arr + ")" );
                       });
                       
                    */   
                    } 
             });
             
          });
          
      }     
      
      const varimit_varian_index = jQuery("input[name='varimit_value_index']").attr("data-index_full");    
    

      for ( let ik = 1;ik<=varimit_varian_index;ik++ ) {
          varianselect ( ik );                
      } 
  


} )( jQuery );