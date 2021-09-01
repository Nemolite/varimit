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
  function varimit_get_mini_img_values( $slug ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';
    $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE slugvalue = "'.$slug.'"', ARRAY_A );
    
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

function varimit_razbor_vari( $product_id_arr, $meta_values, $product_id ){
    if ( empty($product_id_arr) ){
        return "false";
    }    

    $etalon = '_varimit__product_value_';

    $key = '';
    $et_acc = get_post_meta( $product_id, $key, false );

    // Доставем данные с самого товара

    foreach ( $et_acc as $key_vari_et => $val_et){

        if (str_contains( $key_vari_et, $etalon)) {
            // Запоминаем слаг самого товара
            $select_et = unserialize($val_et[0]);
            $res_acoc_et[$key_vari_et] = $select_et[1];
        }
    } 


    // Доставем данные с других товаров
    foreach($product_id_arr as $one_id){
// Результат в виде  $total_res[ключ - мета_поле вариации] = id      
$total_prom = array();
$total_parent_pro = array();
$minus = array();
        $key = ''; 
        $single =false; 
        $meta_values = get_post_meta( $one_id, $key, $single );

        $res_acoc_arr[$one_id] = array();
        foreach ($meta_values as $key_vari => $val){

            if (str_contains( $key_vari, $etalon)) {
                // Запоминаем слаг
                $select_list = unserialize($val[0]);
                $res_acoc_arr[$one_id][$key_vari] = $select_list[1];
            }
        } 
    }

    $count_et = count($res_acoc_et);

   foreach($res_acoc_arr as $arr_keys => $arr_values ){
     
      if($count_et==count($arr_values)) {
        $sovpad_key = 0;
        $sovpad_znach = 0;
        $i = 0;
        $ne_sovpad_znach = 0;
          foreach($res_acoc_et as $key_et =>$var_et){
               // если существует такая вариация
               // и он не исключен из обраотки
                   
                    foreach($arr_values as $key_val => $val_val) {

                        if( $key_et==$key_val ) {
                            
                            $sovpad_key++; 
                            if($res_acoc_et[$key_et]==$arr_values[$key_val])
                            {
                                $sovpad_znach++;
                            } else {
                                $ne_sovpad_znach++;
                                if ($ne_sovpad_znach>1){                                    
                                    $minus[] = $arr_keys;
                                } elseif($ne_sovpad_znach==1) {                                   
                                    unset($total_prom);
                                    $total_prom[$key_et] = $arr_keys;                         
                                }
                               
                            }
                        } 
                    } //    
            $i++;        
                 
            if( ( !empty($total_prom ) )&&( ( $count_et-$sovpad_znach )==1 )&&($count_et!=$sovpad_znach) ) {
            
                $total_parent_pro[] = $total_prom;
                unset($total_prom);
            }     
            

          }          
      
        } 
   }

    // Убираем те id у которых больше чем 1 совпадений   
 
    foreach($minus as $minus_id){
            foreach($total_parent_pro as $parent_pro => $parent_pro_id){

                    foreach($parent_pro_id as $key_value_itog => $key_value_itog_id ){
                       
                        if($minus_id==$key_value_itog_id){                          
                            
                            unset($total_parent_pro[$parent_pro][$key_value_itog]);
                        } 

                    }

            }
    }

foreach($total_parent_pro as $key_prov => $znach_prov){
    if (!empty($znach_prov)){
        $total_parent_pro_new[$key_prov] = $znach_prov;
    }
} 

   return $total_parent_pro_new; 

}

function varimit_get_prioritet_structure($var_id, $slug){
    global $wpdb;

    $table_name_values = $wpdb->prefix . 'varimit_variation_values';

    $prioritet = $wpdb->get_results( 'SELECT * FROM ' . $table_name_values . ' WHERE variationid = ' . $var_id . ' AND slugvalue= "' . $slug. '"', ARRAY_A );

    return $prioritet[0]["prioritet"];
}
?>