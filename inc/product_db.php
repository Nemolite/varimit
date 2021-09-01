<?php
/**
 * Модуль работы с произвольными полями продукта
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
 * Добавление и изменения 
 * вариации товара
 */
add_action('wp_ajax_varimit_select_variation', 'varimit_action_select_product_variation'); 
function varimit_action_select_product_variation(){ 
   
    $main_arr = array();

    if ( isset( $_POST['optionpostid'] ) ) {
        $optionpostid = sanitize_text_field( $_POST['optionpostid'] );               
    }

    if ( isset( $_POST['var_id'] ) ) {
        $var_id = sanitize_text_field( $_POST['var_id'] );
        array_push($main_arr, $var_id );  
        $meta_key = '_varimit_product_variation_'. $var_id;

    }

    if ( isset( $_POST['option_var_slug'] ) ) {
        $option_var_slug = sanitize_text_field( $_POST['option_var_slug'] ); 
        array_push($main_arr, $option_var_slug);      

    }

    if ( isset( $_POST['option_var_name'] ) ) {
        $option_var_name = sanitize_text_field( $_POST['option_var_name'] );
        array_push($main_arr, $option_var_name);        

    }   
  
    update_post_meta( $optionpostid, $meta_key,  $main_arr );    
    
    wp_die();
}

 /**
 * Добавление и изменения значения 
 * вариации товара
 */
add_action('wp_ajax_varimit_select_values', 'varimit_action_select_values'); 
function varimit_action_select_values(){ 
   
    $main_arr = array();

    if ( isset( $_POST['optionpostid'] ) ) {
        $optionpostid = sanitize_text_field( $_POST['optionpostid'] );               
    }

    if ( isset( $_POST['value_id'] ) ) {
        $value_id = sanitize_text_field( $_POST['value_id'] );
        array_push($main_arr, $value_id);  
        $meta_key = '_varimit__product_value_'. $value_id;

    }

    if ( isset( $_POST['option_slug'] ) ) {
        $option_slug = sanitize_text_field( $_POST['option_slug'] ); 
        array_push($main_arr, $option_slug);      

    }

    if ( isset( $_POST['option_name'] ) ) {
        $option_name = sanitize_text_field( $_POST['option_name'] );
        array_push($main_arr, $option_name);        

    }   
  
    update_post_meta( $optionpostid, $meta_key,  $main_arr );    
    
    wp_die();
}

/**
 * Извлечение slug вариации для конкретной вариации
 */

function varimit_variation_get_slug_from_db( $selected_vari_id ) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'varimit_variation';

    $output = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $selected_vari_id , ARRAY_A );
    return $output;

}

/**
 * Товар в админке
 * Удаление строки вариации и его значения
 * 
 */
add_action('wp_ajax_varimit_delete_select_option', 'varimit_action_varimit_delete_select_option'); 
function varimit_action_varimit_delete_select_option(){ 

    if ( isset( $_POST['optionpostid'] ) ) {
        $optionpostid = (int)sanitize_text_field( $_POST['optionpostid'] );   
    }


    if ( isset( $_POST['value_id'] ) ) {
        $value_id = sanitize_text_field( $_POST['value_id'] );             
        $meta_key = '_varimit__product_value_'. $value_id;

    }
    
    $marker = delete_post_meta( $optionpostid, $meta_key );
    echo $marker;

    wp_die();  
}

 /**
* Товар в админке
 * Добавление и изменения  
 * вариации товара
 */
add_action('wp_ajax_varimit_select_vari', 'varimit_action_varimit_select_vari'); 
function varimit_action_varimit_select_vari(){ 
   
    $vari_arr = array();

    if ( isset( $_POST['optionpostid'] ) ) {
        $optionpostid = sanitize_text_field( $_POST['optionpostid'] );               
    }   

    if ( isset( $_POST['vari_id'] ) ) {
        $vari_id = sanitize_text_field( $_POST['vari_id'] );
        array_push($vari_arr, $vari_id);  
        $meta_key = '_varimit__product_vari_'.$vari_id;

    }

    if ( isset( $_POST['vari_slug'] ) ) {
        $vari_slug = sanitize_text_field( $_POST['vari_slug'] ); 
        array_push( $vari_arr, $vari_slug);      

    }

    if ( isset( $_POST['vari_name'] ) ) {
        $vari_name = sanitize_text_field( $_POST['vari_name'] );
        array_push($vari_arr, $vari_name);        

    }   
  
    update_post_meta( $optionpostid, $meta_key,  $vari_arr );    

    // Извлекаем значения у данной вариации из таблицы
    $arr_values = varimit_variation_values_display_product_all_from_db( $vari_id );
  // print_r(json_encode($arr_values));
   // $tram = "Good!";
    //echo "<div>". $tram ."</div>";

    //show($arr_values);

    $output_start = <<<    HTML
    <select name="select_values_$vari_id" 
            id="select_values_$vari_id" 
            class="selectclass" 
            data-value_id=$vari_id>
        <option value="notselect">-не выбран-</option>           
    HTML;

    foreach($arr_values as $values){
        $output_content .= <<<    HTML
         <option value=$values[slugvalue]>$values[namevalue]</option>  
        HTML;
    }
    

    $output_end = <<<    HTML
    </select>
    HTML;

    $res = $output_start.$output_content.$output_end;

    echo $res;
/*
    <select 
    name="select_values_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
    id="select_values_<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>" 
    class="selectclass" 
    data-value_id="<?php echo esc_attr( $vriation_value_output_select[0]['variationid']  );?>"
  >

  foreach($arr_values as $values){


    }
*/
    wp_die();
}


?>