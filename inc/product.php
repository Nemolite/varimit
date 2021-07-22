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
  $check_main = get_post_meta( $idenvar,'_varimit_main',true );  
  
  if("1"==$check_main){   
    $param_chek = "checked";
  } else {    
    $param_chek = "";
  }
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
          value="<?php echo $res_main;?>"
          <?php echo $param_chek;?>
          id="mainCheckDefault"
        />

       

       <div class="varimit-table-inner">
         <div class="varimit-table-inner-title">
          <p id="varimit-table-inner-title-txt">
            Атрибуты вариации
          </p>
         </div>
         <div class="varimit-table-inner-content">
           <?php
           /**
            * Получение вариации для выбора
            */
            $count_variation = varimit_variation_display_count_from_db();

            $results_data = array();
            $varimit_variation_output_product = apply_filters( 'varimit_variation_display_product', $results_data );
           
            $variation_name = 'namevari';
            $variation_slug = 'slugvari';
            $variation_id   = 'id';
           
           ?>
            <input type="hidden" 
              name="variation_count" 
              id="variation_count" 
              value=""
              data-variation_count="<?php echo esc_html( $count_variation ); ?>"
            >
           
         <table class="varimit-table-inner-content-table" id="slecet-point-process">
          <tdoby class="varimit-table-list"> 
              <tr>           
                <th class="varimit-table-inner-content-title">Вариации</th>
                <th class="varimit-table-inner-content-title">Значения</th>
                <th class="varimit-table-inner-content-title">Действие</th>
              </tr>
              <?php
              $index = 1;
                  foreach ($varimit_variation_output_product as $variation_output_list) {
                   // show( $variation_output_list );
              ?>        
              <tr 
              id="select_variation_<?php echo esc_attr( $index  ); ?>" 
              class="select-variation-list" 

              data-variation_id="<?php echo esc_attr( $index  ); ?>"
              >              


                  <td class="varimit-table-inner-content-txt">
                    <select>
                      <option value="notselect_variation">-Выбрать-</option>
                          <?php 
                          $results_data = array();
                          $vriation_output_select =  apply_filters( 'varimit_variation_display_product', $results_data );

                          foreach( $vriation_output_select as $arr_variation_list ):
                         
                          ?>
                      <option 
                              value="<?php echo esc_attr( $arr_variation_list['slugvari'] ); ?>"                          
                            >
                          <?php echo esc_attr( $arr_variation_list['namevari'] );?>
                      </option>
                        <?php endforeach; ?>
                    </select>
                  </td>


                  <td class="varimit-table-inner-content-txt">
                    <select>
                      <option value="notselect_values">-Выбрать-</option>
                          
                          <option 

                            value=""
                            
                          >
                          
                      </option>
                    
                    </select>
                  </td>


                  <td class="varimit-table-inner-content-txt">

                  <input 
                    id="select_del_<?php echo esc_attr( $variation_output_list[ $variation_id]  ); ?>" 
                    class="del-variation-list"
                    data-del_variation_id="<?php echo esc_attr( $variation_output_list[ $variation_id]  ); ?>"
                    type="button" 
                    value="Удалить">

                  </td>


                </tr>
               <?php
               $index++;
                }
                
               ?> 
             
              <input type="hidden" 
              name="varimit_value_index" 
              id="varimit_value_index" 
              value=""
              data-index_full="<?php echo esc_html( $varimit_index ); ?>"
              >
            </tdoby>   
          </table>
          <p></p>
          <input 
            id="select-add-list"
            type="button" 
            value="Добавить строку для ввода вариации и его значения"
          >
         </div>
       </div>
       
      </div> 
        
    </div> 
  </div>
  <?php
}
?>