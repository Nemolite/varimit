<?php
/**
 * Модуль для работы с базами данных каталога
 */

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

/**
 * Функция подсчета вариации (устаревшее)
 */

function varimit_get_result_compare_id($meta_iden, $key_iden, $key_main ){
  if (isset($meta_iden)&&(!$meta_iden=='')&&(isset($key_main))) {

    $args = array(
      'post_type' => 'product',    
      'posts_per_page' => -1,
      'meta_query' => [
        'relation' => 'AND',
        [
          // Идентификатор
          'key' => $key_iden,
          'value' => $meta_iden,
          'compare' => '='
        ],
       
        [
          // главный товар
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

/**
 * Функция проверки на наличие вариации (устарешее)
 *
 */
function varimit_check_vari_aka_product_id( $product_id ){
  global $wpdb;

  $table_name = $wpdb->prefix . 'varimit_variation_values';

  $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name, ARRAY_A );

  foreach($results as $res ){
   $gibrid = get_post_meta( $product_id, '_varimit__product_value_'.$res['id'], false );
   if( empty( $gibrid ) || ($gibrid[0]=='notselect') ) {
    $marker = "true";
      } else {
        $marker = "false";
        break;
      }
  }

  return  $marker;
}

/**
 * Функция проверки, главный товар или нет
 *
 */
function varimit_check_main_product($product_id, $key_main){
  if ( isset($key_main)&&(!$key_main=='') ) {
    $main_marker = get_post_meta( $product_id, $key_main, true );

    return $main_marker;
    
  }
}

/**
 * Функция подсчета количества вариации
 */
function varimit_get_array_id_product_with_iden ( $meta_iden ){

  $meta_name_key = '_varimit_iden';  

  $args = array(
    'post_type' => 'product',
    'numberposts' => -1,                                
    'meta_query' => [ [
      'key' =>  $meta_name_key,
      'value' => $meta_iden,
      
  ] ],                           
      
        
    );
    
    $posts = get_posts($args);
   $cori = 0;
    foreach( $posts as $post ){
        setup_postdata($post);
        $post_id = $post->ID;

        $marker = varimit_check_vari_aka_product_id( $post_id );

       if($marker == "false"){
         $cori++;
       }
    }
    wp_reset_postdata(); 
    return $cori;       
}
?>