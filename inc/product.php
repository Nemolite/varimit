<?php
/**
 * Модуль отображения информации в товаре (админка)
 */

add_action('woocommerce_product_write_panel_tabs','varimit_output_variation_in_product',); 

function varimit_output_variation_in_product() {
  
  global $post;
  $idenvar = $post->ID;   

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
         <div class="outlister">

         </div>  
           <?php
           /**
            * Получение вариации для выбора
            */
            $count_variation = varimit_variation_display_count_from_db();

            $results_data = array();
            $varimit_variation_output_product = apply_filters( 'varimit_variation_display_product', $results_data );
           
            $varimit_name = 'namevari';
            $varimit_slug = 'slugvari';
            $varimit_id   = 'id';

            $varimit_repetitions_output = ( $varimit_variation_output_product ) ? count( $varimit_variation_output_product ) : 1;
            //show($varimit_repetitions_output);
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

  <?php for ( $varimit_index = 0; $varimit_index <= ($varimit_repetitions_output-1); $varimit_index++ ) { 

    $value_id_out = $varimit_variation_output_product[ $varimit_index ][ $varimit_id ];                         
    $vriation_value_output_select = apply_filters( 'varimit_variation_values_display_product_all', $value_id_out );
        
          $selected_vari_id = $vriation_value_output_select[0]['variationid'];
          if( $selected_vari_id ) {
            $selected_vari_slug = varimit_variation_get_slug_from_db( $selected_vari_id );
          }         

  ?>
                <tr class="select-variation-list"> 

                  <?php // Блок выбора вариации?>             

                  <td class="varimit-table-inner-content-txt">

                  <select 
                      name="select_varian_<?php echo $selected_vari_id;?>" 
                      id="select_varian_<?php echo $selected_vari_id;?>"                    
                      data-select_varian_id="<?php echo $selected_vari_id;?>"
                  >

                      <option value="notselect">-не выбран-</option>
    
                      <?php 
                    
                          foreach($varimit_variation_output_product as $varimit_name_option){
                      ?>
                        <option 
                          value="<?php echo esc_attr( $varimit_name_option['slugvari']  );?>"
                          data-varian_id="<?php echo esc_attr( $varimit_name_option['id']   );?>"
                          
                          <?php selected( $selected_vari_slug[0]['slugvari'], $varimit_name_option['slugvari']); ?>
                          
                        >
                            <?php echo esc_attr( $varimit_name_option['namevari']  );?>
                        </option>
                      <?php
                      }
                      ?>

                    </select> 

                  </td>
                  <?php // Блок выбора значения вариации ?>
                  <td class="varimit-table-inner-content-txt" >
                    <select 
                      name="select_values_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
                      id="select_values_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
                      class="selectclass" 
                      data-select_var_id="<?php echo esc_attr( $variation_output_list[ $variation_id]  ); ?>"
                  
                    >
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
<!-- end Вариации-->
<!-- Значения Вариации-->

                  <td class="varimit-table-inner-content-txt">
                    <select>
                      <option value="notselect_values">-Выбрать-</option>
                          
                          <option 

                            value=""
                            
                          >
                          
                      </option>
                    
                    </select>
                  </td> 

                  <?php // Блок удаление?>
                  <td class="varimit-table-inner-content-txt">

                  <input 
                    id="select_del_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
                    class="del-variation-list"
                    data-del_variation_id="<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>"
                    type="button" 
                    value="Удалить"
                  >

                </td> 

                </tr>

              <?php } ?>

              <input type="hidden" 
              name="varimit_select_var_index" 
              id="varimit_select_var_index" 
              value=""
              data-index_full="<?php echo esc_html( $index ); ?>"
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