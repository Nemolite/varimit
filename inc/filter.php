<?php
/**
 * Фильтр. Модуль скрытия товаров в каталоге
 */

add_action( 'pre_get_posts', 'hide_from_query' );
function hide_from_query( $query ) {   

    if ( is_admin() ||
    is_post_type_archive( 'product' ) ) {
        return;
      }

    if(  $query->is_main_query()  ){

        $query->srt('post_type','product' );        
        $query->set( 'meta_query', 
            [ 
             
                'relation' => 'OR',
                
            [
                'key' =>  '_varimit_main', 
                'value' => 1,                 
            ],
            
            [
                'key' =>  '_varimit_iden',              
                'compare' => 'NOT EXISTS',                 
            ],    
    
        
        ],                   
            );
        
    }
    
} 

?>