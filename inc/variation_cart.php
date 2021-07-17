<?php
/**
 * Модуль вывода вариации в карточке товра
 */


/**
* Регистрация новой таксономии для вариации:
*/

add_action( 'init', 'create_varimit', 0 );
function create_varimit () {
$args = array(
   'label' => _x( 'Вариации', 'taxonomy general name' ), 
   'labels' => array(
               'name' => _x( 'Вариации', 'taxonomy general name' ), 
               'singular_name' => _x( 'Вариации', 'taxonomy singular name' ), 
               'menu_name' => __( 'Вариации' ), 
               'all_items' => __( 'Все вариации' ),
               'edit_item' => __( 'Изменить вариацию' ), 
               'view_item' => __( 'Просмотреть вариации' ), 
               'update_item' => __( 'Обновить вариацию' ), 
               'add_new_item' => __( 'Добавить новую вариацию' ), 
               'new_item_name' => __( 'Вариация' ), 
               'parent_item' => __( 'Родительская' ),
               'parent_item_colon' => __( 'Родительская:' ), 
               'search_items' => __( 'Поиск вариации' ),
               'popular_items' => null, 
               'separate_items_with_commas' => null, 
               'add_or_remove_items' => null, 
               'choose_from_most_used' => null, 
               'not_found' => __( 'Вариация не найдена.' ), 
               ),
   'public' => true, 
   'show_ui' => true, 
   'show_in_menu' => true, 
   'show_in_nav_menus' => true, 
   'show_tagcloud' => true, 
   'show_in_quick_edit' => true, 
   'meta_box_cb' => null, 
   'show_admin_column' => false,
   'description' => '', 
   'hierarchical' => true, 
   'update_count_callback' => '', 
   'query_var' => true, 
   'rewrite' => array(
       'slug' => 'varimit', 
       'with_front' => false,
       'hierarchical' => true, 
       'ep_mask' => EP_NONE, 
       ),
/*
// Массив полномочий зарегестрированных пользователей:
'capabilities' => array(
'manage_terms' => 'manage_resource',
'edit_terms'   => 'manage_categories',
'delete_terms' => 'manage_categories',
'assign_terms' => 'edit_posts',
),
*/

   'sort' => null, 
   '_builtin' => false, 
    );

register_taxonomy( 'varimit', array('product'), $args );
}

   
  /**
  * Вывод вариации в карточке товара
  */
  add_action( 'woocommerce_single_product_summary','varimit_display_in_single_product',15 ); 
  function varimit_display_in_single_product() {
    ?>
        <div class="varimit-output-single-product">           
            <?php  varimit_display_variation_single_product(); ?>
        </div>
       
    <?php
  } 

  /** 
   * Helper polifil
   */
  if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}


    /**
   * Функция вывода ссылок на попап вариативных товаров
   *  
   */
function varimit_display_variation_single_product() {
    global $wp_query;
    $product = wc_get_product( $wp_query->post );
    $id = $product->get_id(); 
    $key = ''; 
    $single =false; 

    $meta_values = get_post_meta( $id, $key, $single );

    $etalon = '_varimit__product_value_';

    foreach ($meta_values as $key => $val){
         if (str_contains( $key, $etalon)) {

            $select_list = unserialize($val[0]);            
            $var_id = $select_list[0];

            $name_variation = varimit_get_data_variation_cart($var_id);
           
            ?>
            <div class= "varimit-output-single-product-inner"> 
                <div class= "varimit-output-single-product-inner-left"       
                    data-key_parent= "<?php echo esc_attr( $key_num_parent ); ?>"
                    id ="<?php echo esc_attr( $varimit_idx ); ?>"
                >
                <?php
                echo "<b>".$name_variation[0]['namevari']."</b>";
                echo "<br>";
                echo $select_list[2];
                ?>
                </div> <!-- varimit-output-single-product-inner-left -->

                <div class= "varimit-output-single-product-inner-right">

                <svg 
                    focusable="false" 
                    viewBox="0 0 24 24" 
                    class="range-revamp-svg-icon range-revamp-chunky-header__icon" 
                    aria-hidden="true">
                    <path 
                    fill-rule="evenodd" 
                    clip-rule="evenodd" 
                    d="M15.6 12l-5.785 5.786L8.4 16.372l4.371-4.371-4.37-4.372 1.414-1.414L15.6 12z">
                    </path>
                </svg> 

                </div> <!-- varimit-output-single-product-inner-right -->

                <div class="varimit-popup-output" id ="modal<?php echo esc_attr( $key_num_parent ); ?>">
                
                    <div class="varimit-popup-output-title">
                    <?php
                        echo "<b>".$art_title_col."</b>";
                    ?>
                    </div> <!-- varimit-popup-output-title -->

                        <div class="varimit-popup-output-close">
                        <svg 
                            focusable="false" 
                            viewBox="0 0 24 24" 
                            class="range-revamp-svg-icon range-revamp-btn__icon" 
                            aria-hidden="true">
                            <path 
                            fill-rule="evenodd" 
                            clip-rule="evenodd" 
                            d="M12 13.415l4.95 4.95 1.414-1.415-4.95-4.95 4.95-4.95-1.415-1.413-4.95 4.95-4.949-4.95L5.636 7.05l4.95 4.95-4.95 4.95 1.414 1.414 4.95-4.95z">
                            </path>
                        </svg> 
                        </div> <!-- varimit-popup-output-close -->


                    <div class="varimit-mini-list">

                        <div class="varimit-mini-list-img">
                        
                        </div> <!-- varimit-mini-list-img -->

                        <div class="varimit-mini-list-title">
                        

                        </div> <!-- varimit-mini-list-title -->
                    </div> <!-- varimit-mini-list -->   


                </div> <!-- varimit-popup-output -->
            </div> <!-- varimit-output-single-product-inner -->
           
         <?php          
        }
    } 
  }  
?>

