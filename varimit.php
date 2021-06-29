<?php
/**
* Plugin Name: Var imit
* Plugin URI: https://github.com/Nemolite/varimit
* Description: Имитация вариации.Формирует апселлы для каждой вариации 
* Version: 1.0.0
* Author: Nemolite
* Author URI: http://vandraren.ru/
* License: GPL2
*/

defined('ABSPATH') || exit;

/**
 * Подключение скриптов и стилей
 */

function script_and_style_varimit(){
    wp_enqueue_style( 'varimit-style',  plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script( 'varimit-script', plugins_url('assets/js/varimit.js', __FILE__),array(),'1.0.0','in_footer');
  }
  add_action( 'wp_enqueue_scripts', 'script_and_style_varimit' );

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
  * Вывод вариации в каталоге
  */
  add_action( 'woocommerce_shop_loop_item_title','varimit_display_in_category',15 ); 
  function varimit_display_in_category() {
     
    ?>
        <div class="varimit-output">
            
            <?php  varimit_display_variation(); ?>
           
        </div>
    <?php
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
   * Функция вывода количества вариации в каталоге для каждого товара
   */

  function varimit_display_variation() {
    global $wp_query;
    $product = wc_get_product( $wp_query->post );

    // Получение прикрепленных товаров к таксаномии (вариации)
        
    $id = $product->get_id();
    $taxonomy = "varimit";

    $arr_trems = get_the_terms( $id, $taxonomy );
      // Вывод количество вариации
    $varimit_var_count = 0;
    if( is_array( $arr_trems ) ){
      foreach ($arr_trems as $value) {
        if (0==$value->parent){ 
        
          $varimit_var_count = $varimit_var_count + $value->count;
     
          }   
      }
    }
    
    if (0!= $varimit_var_count) {
      echo "<p>";
      printf( esc_html__( 'Еще варианты +%s', 'belmarco' ),$varimit_var_count  );
      echo "</p>";
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

    $cat = $product->get_categories();

    // echo $cat;
    // echo "<br>";

    $cat2= $product->get_category_ids();

    // echo "<pre>";
    // print_r( $cat2);
    // echo "</pre>";
   

    $taxonomy = "varimit";

    $arr_trems = get_the_terms( $id, $taxonomy );
    
    $tax_title = array(); // Атрибут вариации
    $terms_inner = array(); // Вариации

    if( is_array( $arr_trems ) ){
      foreach ($arr_trems as $value) {
        if (0==$value->parent){ // Атрибут
        $tax_title[$value->term_id] = $value->name;
       } else {
        $terms_inner[$value->name] = $value->parent; 
       }  
      }
    }

    $varimit_idx = 1;

    foreach ($tax_title as $key_num_parent => $art_title_col) {
      ?>
    <div class= "varimit-output-single-product-inner"> 
    
      <div class= "varimit-output-single-product-inner-left" 
      
      data-key_parent= "<?php echo esc_attr( $key_num_parent ); ?>"
      id ="<?php echo esc_attr( $varimit_idx ); ?>"

      >
        <?php
          echo "<b>".$art_title_col."</b>";
          echo "<br>";
          foreach ($terms_inner as $var_title  => $num_parent) {
            if ($key_num_parent==$num_parent) {
           
                echo $var_title;
                echo "<br>";
         
            }
          }
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

      <?php

        $args = array(
          'post_type' => 'product',
          'posts_per_page' => -1, 
          'cat' => 9,
          'tax_query' => array(
              array(
                'taxonomy' => 'varimit',
                'field'    => 'slug',
                'terms'    => $var_title,
              )
          )                         
               
        );

        $query = new WP_Query($args);
          if( $query->have_posts() ){
            while( $query->have_posts() ){            
		    	    $query->the_post();
                // echo "<pre>";
                //  print_r($query);
                // echo "</pre>";
      ?>

        <a href="<?php echo get_permalink(); ?>">

          <div class="varimit-mini-list">

            <div class="varimit-mini-list-img">
              <?php

                if ( has_post_thumbnail()) {
                  the_post_thumbnail();
                }
              ?>
            </div> <!-- varimit-mini-list-img -->

            <div class="varimit-mini-list-title">
              <?php
                the_title();
                echo "<br>";
           
              ?>

            </div> <!-- varimit-mini-list-title -->
          </div> <!-- varimit-mini-list -->

        </a>

      <?php            				
        }			     
      }	
        wp_reset_postdata();
 $varimit_idx++;
      ?>
  </div> <!-- varimit-popup-output -->

</div>  <!-- varimit-output-single-product-inner -->
  <?php
    }
  ?>
          <div id="varimit-count" data-varimit-count="<?php echo esc_attr( $varimit_idx ); ?>"></div>
  <?php  
  }

?>