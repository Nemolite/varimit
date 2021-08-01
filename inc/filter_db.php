<?php
/**
 * Модуль работы с таблицами баз данных для фильтра _varimit_main
 */
function varimit_get_id_product_for_hide(){
    
    $meta_name_key = '_varimit_main';  

    $arr_id_hide= array();
    
    $args = array(
       'post_type' => 'product', 
       'meta_query' => [ [
          'key' =>  $meta_name_key, 
          'value' => 1,                 
      ] ],                              
            
           
       );

       $query = new WP_Query($args);
       if( $query->have_posts() ){
           while( $query->have_posts() ){            
                   $query->the_post();

                $arr_id_hide[] = get_the_ID();
           }
       } 
    wp_reset_postdata(); 

    return $arr_id_hide;
}

?>