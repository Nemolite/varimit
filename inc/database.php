<?php
/**
 * Модуль работа с таблицами базами данных
 * 
 */

 /**
  * Добавление вариаций
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
 * Извлечение вариаций
 */
add_filter( 'varimit_variation_display', 'varimit_variation_display_from_db', 10, 1);
function varimit_variation_display_from_db($results) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';
    $results = $wpdb->get_results( 'SELECT * FROM '.$table_name, ARRAY_A );
    return $results;

}

/**
 * Редактирование вариации 
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
 * Удаление вариации
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

/******************* Значения вариации ************/

/**
 * Добавление значение вариации 
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

    if ( isset( $_POST['variationid'] ) ) {
        $variationid= sanitize_text_field( $_POST['variationid'] );
    }  

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $attachment_id = media_handle_upload( 'variation_file_value', 0 );
     
    $urlvalue = wp_get_attachment_url( $attachment_id ); 
	$table_name_values = $wpdb->prefix . 'varimit_variation_values';

    // Обработка приоритетов 

  $prioritet_arr = $wpdb->get_results( 'SELECT * FROM ' . $table_name_values . ' WHERE variationid = ' . $variationid, ARRAY_A );

    $max_prioritet =  count($prioritet_arr);

    $wpdb->insert( $table_name_values, [ 
        'namevalue' => $variation_label_value, 
        'slugvalue' => $variation_name_value,
        'urlvalue' => $urlvalue,
        'variationid' => $variationid,
        'prioritet' => $max_prioritet
        ] );

    wp_die();
    
}

/**
 * Извлечение значения вариации 
 */
add_filter( 'varimit_variation_values_display', 'varimit_variation_values_display_from_db', 10, 2);
function varimit_variation_values_display_from_db($results, $variationid) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';
    $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE variationid = ' . $variationid . ' ORDER BY prioritet ASC', ARRAY_A );
    return $results;

}

/**
 * Удаление значения вариации
 */
/*
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
*/
/**
 * Извлечение значений вариации для конкретной вариации
 */
add_filter( 'varimit_variation_values_output_arr', 'varimit_variation_values_output_arr_from_db', 10, 1);
function varimit_variation_values_output_arr_from_db( $variation_id_inner ) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';

    $results = $wpdb->get_results( 'SELECT namevalue FROM ' . $table_name . ' WHERE variationid = ' . $variation_id_inner . ' ORDER BY prioritet ASC' , ARRAY_A );
    return $results;

}

/**
 * Извлечение значений вариации 
 */
add_filter( 'varimit_variation_value_output_one_only', 'varimit_variation_value_output_one_only_from_db', 10, 1);
function varimit_variation_value_output_one_only_from_db( $valueid ) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation_values';

    $results = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $valueid, ARRAY_A );
    return $results;

}

/**
 * Изменение значения вариации 
 */
add_action('wp_ajax_variation_edit_value', 'varimit_action_variation_edit_value'); 
function varimit_action_variation_edit_value(){ 
    global $wpdb;

    if ( isset( $_POST['variation_value_label'] ) ) {
        $variation_value_label = sanitize_text_field( $_POST['variation_value_label'] );
    }

    if ( isset( $_POST['variation_value_name'] ) ) {
        $variation_value_name = sanitize_text_field( $_POST['variation_value_name'] );
    }

    if ( isset( $_POST['save_variation_value_id'] ) ) {
        $save_variation_value_id = sanitize_text_field( $_POST['save_variation_value_id'] );
    }

    $table_name = $wpdb->prefix . 'varimit_variation_values';


    $num_varimit = $wpdb->update( $table_name, [ 
        'namevalue' =>  $variation_value_label, 
        'slugvalue' =>  $variation_value_name
    ],
    [ 'id' => $save_variation_value_id ]
 );
       
return $num_varimit;
    wp_die();
}

/**
 * Сортировка по приоритетам
 */
add_action('wp_ajax_variation_values_sort', 'varimit_action_variation_values_sort'); 
function varimit_action_variation_values_sort(){ 
    global $wpdb;

    if ( isset( $_POST['variationid'] ) ) {
        $variationid = sanitize_text_field( $_POST['variationid'] );
    }

    if ( isset( $_POST['positions'] ) ) {
        $positions = sanitize_text_field( $_POST['positions'] );
        $prioritet = explode(";", $positions);
    }

    $table_name = $wpdb->prefix . 'varimit_variation_values';

    foreach ($prioritet as $key => $val) {
        $wpdb->update( 
            $table_name, 
            [ 
                'prioritet' =>  $key        
            ],
            [ 
                'variationid' => $variationid,
                'id' => $val 
            ],
            [ '%d' ],
            [ '%d','%d' ]
        );
    }

    wp_die();
}

/**
 * Удалаение значения вариации 
 */
add_action('wp_ajax_variation_values_del', 'varimit_action_variation_values_del'); 
function varimit_action_variation_values_del(){ 
    global $wpdb;

    if ( isset( $_POST['variationid'] ) ) {
        $variationid = sanitize_text_field( $_POST['variationid'] );
    }

    if ( isset( $_POST['value_del_id'] ) ) {
        $value_del_id = sanitize_text_field( $_POST['value_del_id'] );
    }

    $table_name = $wpdb->prefix . 'varimit_variation_values';

    $wpdb->delete( $table_name,
    [ 'id' => $value_del_id ]
    );

    echo "Значение вариации удалено";

    wp_die();
}
 ?>