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

 /**
 * Добавление и изменения значения 
 * вариации товара
 */
add_action('wp_ajax_varimit_select_values', 'varimit_action_select_values'); 
function varimit_action_select_values(){ 
    global $wpdb;

    $main_arr = array();

    if ( isset( $_POST['optionpostid'] ) ) {
        $optionpostid = sanitize_text_field( $_POST['optionpostid'] );               
    }

    if ( isset( $_POST['value_id'] ) ) {
        $value_id = sanitize_text_field( $_POST['value_id'] ); 
        array_push($main_arr, $value_id);      

    }

    if ( isset( $_POST['option_slug'] ) ) {
        $option_slug = sanitize_text_field( $_POST['option_slug'] ); 
        array_push($main_arr, $option_slug);      

    }

    if ( isset( $_POST['option_name'] ) ) {
        $option_name = sanitize_text_field( $_POST['option_name'] );
        array_push($main_arr, $option_name);        

    }
    
    $basa_values = get_post_meta( $optionpostid, '_varimit__product_value', false );
    
    array_push($basa_values, $main_arr); 

    update_post_meta( $optionpostid, '_varimit__product_value',  $basa_values );

    echo "<pre>";
    print_r( $main_arr );
    echo "</pre>";


    
    wp_die();
}
?>