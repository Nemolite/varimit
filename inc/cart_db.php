<?php
/**
 * Модуль работы с таблицами баз данных для страницы товара
 */

 function varimit_get_data_variation_cart($var_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';

    $results_data = $wpdb->get_results( 'SELECT namevari FROM ' . $table_name .' WHERE id = ' . $var_id, ARRAY_A );
    return $results_data;

 }

 /**
  * Функция получения объединение товаров по 
  * по индентификации вариации
  */

 function varimit_get_product_union_iden( $iden ) {
   $arr_iden = array();

   $args = array(
       'post_type' => 'product',
       'meta_query' => [ [
           'key' => '_varimit_iden',
           'value' => $iden,
       ] ],               
           
       );
   $query = new WP_Query($args);
       if( $query->have_posts() ){
           while( $query->have_posts() ){            
               $query->the_post();
               $arr_iden[] = get_the_ID();
           }
       }    

  return $arr_iden;
 }

/**
 * Функция получения совпадающих вариации
 */

 function varimit_get_array_variation_for_product( $var_id ) {

   $meta_name_key = '_varimit__product_value_'.$var_id;  

      $post_in_arr= array();
      
      $args = array(
         'post_type' => 'product', 
         'meta_query' => [ [
            'key' =>  $meta_name_key,
            
        ] ],                                
              
             
         );

         $query = new WP_Query($args);
         if( $query->have_posts() ){
             while( $query->have_posts() ){            
                     $query->the_post();
                     $post_in_arr[] = get_the_ID();
             }
         } 
      wp_reset_postdata();                 

      return $post_in_arr;
 }

 /**
  * Вывод в карточке товара, в попап, миниатюры вариации
  */
  function varimit_get_mini_img_values(){
      echo "img";
  }
?>