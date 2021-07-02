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

/**
 * Редактирование Вариации базы данных 
 */
add_action('wp_ajax_edit_variation', 'varimit_action_edit_variation'); 
function varimit_action_edit_variation(){ 
    global $wpdb;

    if ( isset( $_POST['variation_label'] ) ) {
        $variation_label = sanitize_text_field( $_POST['variation_label'] );
    }

    if ( isset( $_POST['variation_name'] ) ) {
        $variation_name = sanitize_text_field( $_POST['variation_name'] );
    }

    if ( isset( $_POST['variation_id'] ) ) {
        $variation_id = sanitize_text_field( $_POST['variation_id'] );
    }

    $table_name = $wpdb->prefix . 'varimit_variation';


    $num_varimit = $wpdb->update( $table_name, [ 
        'namevari' => $variation_label, 
        'slugvari' => $variation_name
    ],
    [ 'id' => $variation_id ]
 );
       
return $num_varimit;
    wp_die();
}

/**
 * Удаление Вариации базы данных 
 */

function varimit_delete_variation(){ 
    global $wpdb;

    $delete_id = isset( $_GET['delete'] ) ? absint( $_GET['delete'] ) : 0;

    $table_name = $wpdb->prefix . 'varimit_variation';


    $del_varimit = $wpdb->delete( $table_name,
    [ 'id' => $delete_id ]
 );
 
 echo "Вариация удалена";

header('Location: '. get_site_url() .'/wp-admin/edit.php?post_type=product&page=variation'); 

return $del_varimit;
    wp_die();
}
 ?>