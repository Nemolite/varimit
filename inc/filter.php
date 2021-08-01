<?php
/**
 * Фильтр. Модуль скрытия товаров в каталоге
 */

add_action( 'pre_get_posts', 'hide_from_query' );
function hide_from_query( $query ) {   

    // id товаров которые нужно прятать
    //$exclude_ids = array(792);

        // Если это не админ и не карточка товара
        if ( ! $query->is_main_query() 
            || is_admin() 
            || is_single() 
            || ! $query->is_search
           
            || ! $query->is_home
             ) { 
            return;
        }

        $query->srt('post_type','product' );
        $query->set( 'meta_query', 
            [ [
                'key' =>  '_varimit_main', 
                'value' => 1,                 
            ] ],                   
            );
        

        return;
} 

?>