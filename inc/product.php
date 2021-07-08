<?php
/**
 * Модуль отображения информации в товаре (админка)
 */

add_action('woocommerce_product_write_panel_tabs','varimit_output_variation_in_product',); 

function varimit_output_variation_in_product() {
  
  ?>
 
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
            name="iden_num" 
            id="iden_num" 
            value="" 
            placeholder=""
          /> 
       </p>

       <label class="form-check-label" for="mainCheckDefault">
          Главный товар в вариации
        </label>

        <input
          class="form-check-input"
          name="varimit-main-product-chekbox"
          type="checkbox"
          value="1"
          id="mainCheckDefault"
        />

        <input type="hidden" 
        name="varimit-main-product-chekbox" 
        value="0" />

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