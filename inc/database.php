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

/**
 * Добавление значение вариации в таблицу базы данных
 * 
 */
add_action('wp_ajax_variation_add_value', 'varimit_action_variation_add_value'); 
function varimit_action_variation_add_value(){ 
    global $wpdb;

    if ( isset( $_POST['variation_label_value'] ) ) {
        $variation_label_value = sanitize_text_field( $_POST['variation_label_value'] );
    }

    if ( isset( $_POST['variation_name_value'] ) ) {
        $variation_name_value= sanitize_text_field( $_POST['variation_name_value'] );
    }  

    $urlvalue = "https://belmarco.promo-z.ru/wp-content/uploads/2018/06/Nika-26.06.1-1.png";
 
	$table_name_values = $wpdb->prefix . 'varimit_variation_values';
  
    $wpdb->insert( $table_name_values, [ 
        'namevalue' => $variation_label_value, 
        'slugvalue' => $variation_name_value,
        'urlvalue' => $urlvalue
        ] );

    wp_die();
    
}

/**
 * Извлечение данных значения вариации из таблицы базы данных вариаций
 */
add_filter( 'varimit_variation_values_display', 'varimit_variation_values_display_from_db', 10, 1);
function varimit_variation_values_display_from_db($results) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';
    $results = $wpdb->get_results( 'SELECT * FROM '.$table_name, ARRAY_A );
    return $results;

}

/**
 * Удаление значения вариации
 */
function varimit_delete_variation_value() {
    global $wpdb;

    $delete_value_id = isset( $_GET['delete-value'] ) ? absint( $_GET['delete-value'] ) : 0;

    $table_name = $wpdb->prefix . 'varimit_variation_values';


    $del_varimit_variation_value = $wpdb->delete( $table_name,
    [ 'id' => $delete_value_id ]
 );

    echo "Значение вариации удалено";

    header('Location: '. get_site_url() .'/wp-admin/edit.php?post_type=product&page=variation&varimit_action=сonfigure'); 

    return $del_varimit_variation_value;
        wp_die();
}



 ?>