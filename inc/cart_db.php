<?php
/**
 * Извлекаем имя вариации
 */

 function varimit_get_data_variation_cart($var_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';

    $results_data = $wpdb->get_results( 'SELECT namevari FROM ' . $table_name .' WHERE id = ' . $var_id, ARRAY_A );
    return $results_data;

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
  * Вывод в карточке товара, в попап, значение вариации
  */
  function varimit_get_mini_name_values( $var_id, $product_id ){

    $meta_name_key = '_varimit__product_value_'.$var_id;
    
    $meta_values = get_post_meta( $product_id, $meta_name_key, false );    

    // return $value_name;

    return $meta_values;
}


 /**
  * Вывод в карточке товара, в попап, миниатюры вариации
  */
  function varimit_get_mini_img_values( $value_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';
    $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $value_id, ARRAY_A );
    
    // return $url_img;

    return $results;
  }

/**
 * Функция получения идентификатора продукта
 */
function varimit_get_iden_from_products( $product_id ){
    $key_iden = '_varimit_iden';   

        $product_iden = get_post_meta( $product_id, $key_iden, false ); 

    return $product_iden;
}

/**
 * Функция извлечения массива id продуктов 
 * с одинковым идентификаторм вариации
 * 
 * Возвращаем массив из ID товаров участвующих в вариации
 */
function varimit_get_array_id_product( $iden_vari ){

    $meta_name_key = '_varimit_iden';  

    $product_id_arr= array();
    
    $args = array(
       'post_type' => 'product',        
       'meta_query' => [ [
          'key' =>  $meta_name_key,
          'value' => $iden_vari
          
      ] ],                                
            
           
       );

       $query = new WP_Query($args);
       if( $query->have_posts() ){
           while( $query->have_posts() ){            
                   $query->the_post();
                   $product_id_arr[] = get_the_ID();
           }
       } 
    wp_reset_postdata();                 

    return $product_id_arr;
}

/**
 * Проверки наличия вариации такого же значения вариации
 */

 function varimit_check_id_in_products_iden($varimit_product_value, $products_id_iden_arr, $id ) {

    // Смотрим какое значение вариации у самого товара у конкретной вариации
    $self_value = get_post_meta( $id, $varimit_product_value, false ); 
    
    $couner = count($products_id_iden_arr);

    // Крутим цикл по количеству id продуктов с одинаковым идентификаторм вариации
    $marker = array();
    
    for ($i = 0; $i<$couner; $i++ ){
       
        $other = get_post_meta( $products_id_iden_arr[$i], $varimit_product_value, false ); 
 

        if(isset( $other )&&!empty($other)){
            if($self_value[0][1]==$other[0][1]){
                $marker[$products_id_iden_arr[$i]] = "true";
               
            } else {
                $marker[$products_id_iden_arr[$i]] = "false";
            }
        } else {
            $marker[$products_id_iden_arr[$i]] = "zero";
        }
    }

   return $marker;

 }

function varimit_get_name_product_on_id($id_pr){
    $args = array(
        'post_type' => 'product',        
        'p' => $id_pr                          
             
            
        );
 
        $query = new WP_Query($args);
        if( $query->have_posts() ){
            while( $query->have_posts() ){            
                    $query->the_post();
                    $title = get_the_title();                
            }
        } 
     wp_reset_postdata();                 
 
   return $title;
 }

 /**
  * Извлечение количества вариации
  */

  function varimit_get_count_variation_for_display() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';
    $results = $wpdb->get_results( 'SELECT * FROM '.$table_name, ARRAY_A );
    $results_count = count($results);

    return $results_count;
}
?>