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
 * Подключаем скрипты и стили
 */

function script_and_style_geo_promo(){
    wp_enqueue_style( 'varimit-style',  plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script( 'varimit-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'));
  }
  add_action( 'wp_enqueue_scripts', 'script_and_style_geo_promo' );

/**
 * Создаем пункт меню в админке "Вариации"
 */

add_action( 'admin_menu', 'register_menu_for_varimit' );

function register_menu_for_varimit () {
    
    add_menu_page( 
        'Вариации',       // Title
        'Вариации ',      // Пункт меню
        'manage_options', // Права доступа (кому будет видны пункты меню)
        'varimit',        // slug
        '', 
        'dashicons-images-alt', // Иконка
        30
     );
}

/**
 * Создаем подпункты главного меню вариации
 */

 /**
 * Значения для вариаций
 */ 

add_action('admin_menu', 'register_menu_for_varimit_submenu_variation');

function register_menu_for_varimit_submenu_variation() {
    
	add_submenu_page(
		'varimit',                 // slug - главного меню
		'Значения для вариаций',   // Title
		'Значения для вариаций',   // Пункт подменю
		'manage_options',          // Права доступа (кому будет видны пункты меню)
		'variation',               // slug подменю
		'varimit_submenu_variation',  // Название функции которая будет вызваться
        5                          // Позиция в списке подменю  
	);
}

 /**
  * Список вариации
  */
  add_action('admin_menu', 'register_menu_for_varimit_submenu_variation_list');

  function register_menu_for_varimit_submenu_variation_list() {
      add_submenu_page(
          'varimit',            // slug - главного меню
          'Список вариаций',    // Title
          'Список вариаций',    // Пункт подменю
          'manage_options',     // Права доступа (кому будет видны пункты меню)
          'variation-list',     // slug подменю
          'varimit_submenu_variation_list',  // Название функции которая будет вызваться
          10                    // Позиция в списке подменю  
      );
  }

  /**
   * Формируем Значения для вариации
   */

   function varimit_submenu_variation(){

    //require "inc/var-admin-form.php";
      
   }

  /**
  * Вывод вариации в каталоге
  */
  add_action( 'woocommerce_after_shop_loop_item','varimit_display_in_category',15 ); 
  function varimit_display_in_category() {
    ?>
        <div class="varimit-output">
            <p>Еще варианты</p>
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
            <p>Вывод вариаций</p>
        </div>
    <?php
  } 

?>