<?php
/**
 * Модуль работа с таблицами базами данных
 * 
 */

 /**
  * Запись в таблицу новых вариаций
  */

add_action('wp_ajax_add_new_variation', 'varimit_add_new_variation'); 

function varimit_add_new_variation(){ 
    global $wpdb;

    if ( isset( $_POST['variation_label'] ) ) {
        $variation_label = sanitize_text_field( $_POST['variation_label'] );
    }

    if ( isset( $_POST['variation_name'] ) ) {
        $variation_name = sanitize_text_field( $_POST['variation_name'] );
    }

    $table_name = $wpdb->prefix . 'varimit_variation';
    $wpdb->insert( $table_name, [ 
        'namevari' => $variation_label, 
        'slugvari' => $variation_name
         ] );
       

    wp_die();
}

/**
 * Извлечение данных из таблицы базы данных вариаций
 */
add_filter( 'varimit_variation_display', 'varimit_variation_display_from_db', 10, 1);
function varimit_variation_display_from_db($results) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';
    $results = $wpdb->get_results( 'SELECT * FROM '.$table_name, ARRAY_A );
    return $results;

}
 ?>