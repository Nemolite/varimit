<?php
/**
 * Модуль отображения информации в товаре (админка)
 */

add_action('woocommerce_product_write_panel_tabs','varimit_output_variation_in_product',); 

function varimit_output_variation_in_product() {
  
  global $post;
  $idenvar = $post->ID;  
  // $metas = get_post_meta( $idenvar,'_varimit_iden',true );  
  // echo $metas;
  ?>
  <input type="hidden" 
         name="idenvar" 
         id="idenvar" 
         value="<?php echo esc_html( $idenvar ); ?>"
  >

  <div class="varimit-admin-output-block">
    
    <div class="varimit-admin-output-block-left">
      <p>Вариации</p>
    </div>
    <div class="varimit-admin-output-block-right">
        
      <div class="varimit-form-check">

      <p class="varimit-form-field" id="varimit-iden-num">
		      <label for="iden_num">Идентификатор вариации</label>
          <input type="text" 
            class="" 
            style="" 
            name="varimit_variation_iden_num" 
            id="varimit_variation_iden_num" 
            value="<?php echo get_post_meta( $idenvar, '_varimit_iden', true ); ?>" 
            placeholder=""
          /> 
       </p>
     
       <label class="form-check-label" for="mainCheckDefault">
          Главный товар в вариации
        </label>

        <input
          class="form-check-input"
          name="varimit-main-product-chekbox"
          id="varimit-main-product-chekbox"
          type="checkbox"
          value="<?php echo get_post_meta( $idenvar, '_varimit_main', true ); ?>"
          id="mainCheckDefault"
        />

       

       <div class="varimit-table-inner">
         <div class="varimit-table-inner-title">
          <p id="varimit-table-inner-title-txt">
            Атрибуты вариации
          </p>
         </div>
         <div class="varimit-table-inner-content">
           
         <table class="varimit-table-inner-content-table">
  
              <tr>           
                <th class="varimit-table-inner-content-title">Вариации</th>
                <th class="varimit-table-inner-content-title">Значения</th>
              </tr>

              <tr>              
                <td class="varimit-table-inner-content-txt">Цвет</td>
                <td class="varimit-table-inner-content-txt">Подсветка фар</td>
              </tr>

              <tr>                
                <td class="varimit-table-inner-content-txt">Белый</td>
                <td class="varimit-table-inner-content-txt">Без подсветки</td>
              </tr>

              <tr>              
                <td class="varimit-table-inner-content-txt"></td>
                <td class="varimit-table-inner-content-txt"></td>
              </tr>

              <tr>                
                <td class="varimit-table-inner-content-txt"></td>
                <td class="varimit-table-inner-content-txt"></td>
              </tr>

          </table>



         </div>
       </div>
       
      </div> 
        
    </div> 
  </div>
  <?php
}

/**
 * Создание произвольных полей к товару
 * - Главный товар true/false 
 * - Идентификатор
 */


?>