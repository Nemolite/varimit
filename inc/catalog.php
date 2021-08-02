<?php
/**
 * Модуль для работы с каталогом
 */

   /**
  * Вывод вариации в каталоге
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
    
    // Получение прикрепленных товаров к таксаномии (вариации)
    /*    
    $id = $product->get_id();
    $taxonomy = "varimit";

    $arr_trems = get_the_terms( $id, $taxonomy );
      // Вывод количество вариации
    $varimit_var_count = 0;
    if( is_array( $arr_trems ) ){
      foreach ($arr_trems as $value) {
        if (0==$value->parent){ 
        
          $varimit_var_count = $varimit_var_count + $value->count;
     
          }   
      }
    }
    */
    $inx = 0;
    $arr_value = varimit_value_display_product_all_for_catalog(); 
    foreach( $arr_value as $values){
      $key = '_varimit__product_value_'.$values['id']; 
      $meta_values = get_post_meta( $product_id, $key, $single );
      if($meta_values){
        $inx++;
      }
    }   
   

    $varimit_var_count = $inx;
    if (0!= $varimit_var_count) {
      echo "<p>";
      printf( esc_html__( 'Еще варианты ', 'belmarco' ) );
      echo "<span>";
      printf( esc_html__( '+%s', 'belmarco' ),$varimit_var_count  );
      echo "</span>";
      echo "</p>";
    }  

  }

  function varimit_value_display_product_all_for_catalog() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';

    $results_data = $wpdb->get_results( 'SELECT * FROM ' . $table_name, ARRAY_A );
    return $results_data;

}

?>