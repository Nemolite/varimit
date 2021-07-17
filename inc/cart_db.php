<?php
/**
 * Модуль работы с таблицами баз данных для страницы товара
 */

 function varimit_get_data_variation_cart($var_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';

    $results_data = $wpdb->get_results( 'SELECT namevari FROM ' . $table_name .' WHERE id = ' . $var_id, ARRAY_A );
    return $results_data;

 }
?>