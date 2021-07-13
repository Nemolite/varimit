<?php
/**
 * Модуль работы с произвольными полями продукта
 */
/**
 * Создание произвольных полей
 */



 /**
 * Добавление и изменения значения произвольного поля
 * идентификатора вариации для товара
 */
add_action('wp_ajax_varimit_variation_iden_num', 'varimit_action_varimit_variation_iden_num'); 
function varimit_action_varimit_variation_iden_num(){ 
    global $wpdb;

    if ( isset( $_POST['postid'] ) ) {
        $postid = sanitize_text_field( $_POST['postid'] );       

    }

    if ( isset( $_POST['iden'] ) ) {
        $iden = sanitize_text_field( $_POST['iden'] );
        $iden = strval( $iden );          
    }
    
    update_post_meta( $postid, '_varimit_iden',  $iden );
    
    wp_die();
}

 /**
 * Добавление и изменения значения 
 * определение главного товара
 */
add_action('wp_ajax_varimit_variation_iden_main', 'varimit_action_varimit_variation_iden_main'); 
function varimit_action_varimit_variation_iden_main(){ 
    global $wpdb;

    if ( isset( $_POST['postid'] ) ) {
        $postid = sanitize_text_field( $_POST['postid'] );       

    }

    if ( isset( $_POST['main'] ) ) {
        $main = sanitize_text_field( $_POST['main'] );      
        $main = strval( $main );                  
    }
    
    update_post_meta( $postid, '_varimit_main',  $main );

    
    wp_die();
}

/**
 * Получение вариации для товара, для выбора
 */
add_filter( 'varimit_variation_display_product', 'varimit_variation_display_product_all_from_db', 10, 1);
function varimit_variation_display_product_all_from_db( $results_data ) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';

    $results_data = $wpdb->get_results( 'SELECT * FROM ' . $table_name, ARRAY_A );
    return $results_data;

}

/**
 * Получение значения товара вариации для товара
 */
add_filter( 'varimit_variation_values_display_product_all', 'varimit_variation_values_display_product_all_from_db', 10, 1);
function varimit_variation_values_display_product_all_from_db( $value_id_out ) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';

    $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE variationid = ' . $value_id_out, ARRAY_A );
    return $results;

}
?>