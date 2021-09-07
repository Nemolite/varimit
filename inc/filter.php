<?php
/**
 * Фильтр. Модуль скрытия товаров в каталоге
 */

add_action( 'pre_get_posts', 'hide_from_query' );
function hide_from_query( $query ) {      

    if ( ! is_admin() && $query->is_main_query() ) {
		// не админка
		// и основной цикл страницы
 
		if ( is_product_category()
        || is_shop()       
       ) {
			// страница архива рубрик
			
			$query->set( 'posts_per_page', -1 );
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
		} // if category

	}  // if admin 
    return;
} // function

?>