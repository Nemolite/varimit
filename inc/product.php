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

  // show( get_post_meta($idenvar,'_varimit__product_value_2',false) );

  // show( get_post_meta($idenvar,'',true) );

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
            $results_data = array();
            $varimit_variation_output_product = apply_filters( 'varimit_variation_display_product', $results_data );
           
            $varimit_name = 'namevari';
            $varimit_slug = 'slugvari';
            $varimit_id   = 'id';

            $varimit_repetitions_output = ( $varimit_variation_output_product ) ? count( $varimit_variation_output_product ) : 1;
            //show($varimit_repetitions_output);
           ?>
           
         <table class="varimit-table-inner-content-table" id="slecet-point-process">
  
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
                    <select> 
                      <option value="notselect">-не выбран-</option>
    
                      <?php 
                    
                          foreach($varimit_variation_output_product as $varimit_name_option){
                      ?>
                        <option 
                          value="<?php echo esc_attr( $varimit_name_option['slugvari']  );?>"
                          data-vari_id=<?php echo esc_attr( $varimit_name_option['id']   );?>

                          <?php              
                        if(isset($selected_vari_slug[0]['slugvari'])) {
                          selected( $selected_vari_slug[0]['slugvari'], $varimit_name_option['slugvari']);
                        }
                        
                          ?>
                                                
                        >
                            <?php echo esc_attr( $varimit_name_option['namevari']  );?>
                        </option>
                      <?php
                      }
                      ?>

                    </select> 

                  </td>
                  <?php // Блок выбора вариации?>
                  <td class="varimit-table-inner-content-txt">
                    <select 
                      name="select_values_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
                      id="select_values_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
                      class="selectclass" 
                      data-value_id="<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>"
                    >
                      <option value="notselect">-не выбран-</option>
                        <?php 
                        foreach( $vriation_value_output_select as $key => $arr_ariation_values_list):
                          $req_key_meta = '_varimit__product_value_' . $vriation_value_output_select[0]['variationid'];
                          $req_meta_values = get_post_meta( $idenvar, $req_key_meta, false );
                          $selected_value = $req_meta_values[0][1];
                          echo $selected_value;
                          echo "<br>";
                          echo $arr_ariation_values_list['slugvalue']; 
                        ?>
                          <option 
                            value="<?php echo esc_attr( $arr_ariation_values_list['slugvalue']  );?>"

                            <?php selected($selected_value, $arr_ariation_values_list['slugvalue']);?>
                            
                          >
                          <?php echo esc_attr( $arr_ariation_values_list['namevalue']  );?>
                        </option>
                        <?php endforeach; ?>
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
              name="varimit_value_index" 
              id="varimit_value_index" 
              value=""
              data-index_full="<?php echo esc_html( $varimit_index ); ?>"
              >
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