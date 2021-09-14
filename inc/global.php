<?php
/**
 * Модуль основных функции
 */
add_action( 'init','varimit_global_set_options_arr',40 );
 function varimit_global_set_options_arr(){

    $meta_name_key = '_varimit_iden'; 
    $post_in_arr= array();
    
    $args = array(
       'post_type' => 'product', 
       'posts_per_page' => -1, 
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
    update_option('post_in_arr',$post_in_arr);
 }
?>