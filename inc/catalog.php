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
   
    
    $key_iden = '_varimit_iden'; 
    $key_main = '_varimit_main';

    $meta_iden = get_post_meta( $product_id, $key_iden, true );
   

    $res_count = varimit_get_result_compare_id($meta_iden, $key_iden, $key_main );


    $varimit_var_count = $res_count;
    if (0!= $varimit_var_count) {
      echo "<p>";
      printf( esc_html__( 'Еще варианты ', 'belmarco' ) );
      echo "<span>";
      printf( esc_html__( '+%s', 'belmarco' ),$varimit_var_count  );
      echo "</span>";
      echo "</p>";
    }  

  }

  /**
   * Получение массива значений вариации
   *
   * 
   */
  function varimit_value_display_product_all_for_catalog() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';

    $results_data = $wpdb->get_results( 'SELECT * FROM ' . $table_name, ARRAY_A );
    return $results_data;

}

function varimit_get_result_compare_id($meta_iden, $key_iden, $key_main ){
  if (isset($meta_iden)&&(!$meta_iden=='')&&(isset($key_main))) {

    $args = array(
      'post_type' => 'product',    
      'posts_per_page' => -1,
      'meta_query' => [
        'relation' => 'AND',
        [
          'key' => $key_iden,
          'value' => $meta_iden,
          'compare' => '='
        ],
        [
          'key' => $key_main,
          'value' => 1,
          'compare' => '=',
          'type'    => 'CHAR',
        ]
      ]
      
    );
    
    $query = new WP_Query( $args );
    
    $i=0;
    if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
        $query->the_post();
       $i++;
      }
    } 
    wp_reset_postdata();

  }
 return $i;
}



?>