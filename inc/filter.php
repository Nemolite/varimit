<?php
/**
 * Фильтр. Модуль скрытия товаров в каталоге
 */

add_action( 'pre_get_posts', 'hide_from_query' );
function hide_from_query( $query ) { 
    if ( !$query->is_main_query() || $query->is_singular() || !$query->is_post_type_archive() ) { return; }

    if( !is_admin() && is_shop() ){

        $query->set('post_type','product' );        
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