<?php
/**
 * Модуль для работы с каталогом
 */

   /**
  * Вывод вариации в каталоге, через хук
  */
  add_action( 'woocommerce_shop_loop_item_title','varimit_display_in_category',15 ); 
  function varimit_display_in_category() {   
    ?>
        <div class="varimit-output">            
            <?php  varimit_display_variation(); ?>           
        </div>
    <?php
  } 

   /**
   * Функция вывода количества вариации в каталоге для каждого товара
   */

  function varimit_display_variation() {
    global $wp_query;
    $product = wc_get_product( $wp_query->post );
    if( $product ){
      $product_id = $product->get_id();
    }       
    
    $key_iden = '_varimit_iden'; 
    $key_main = '_varimit_main';

    // Извлекаем идентификационный номер вариации для данного товара
    $meta_iden = get_post_meta( $product_id, $key_iden, true ); 
    
    // Проверяем, главный ли товар (если 1 то главный товар)

    $main_marker = varimit_check_main_product($product_id, $key_main);  
     
    // $res_count = varimit_get_result_compare_id( $meta_iden, $key_iden, $key_main);
    // $no_vari = varimit_check_vari_aka_product_id( $product_id );    

   
    if ( $main_marker=="1" ) {
      // Получаем массив id продуктов с данным идентификатором
      if (isset($meta_iden)&&$meta_iden!==''){
        $product_id_arr = varimit_get_array_id_product_with_iden( $meta_iden );
      }
      $counter_total = $product_id_arr-1;     

      echo "<p>";
      printf( esc_html__( 'Еще варианты ', 'belmarco' ) );
      echo "<span>";
    //  printf( esc_html__( '+%s', 'belmarco' ),($product_id_arr-1) );
    printf( esc_html__( '+%s', 'belmarco' ), $counter_total );
    
      echo "</span>";
      echo "</p>";
    }    

  }  
?>