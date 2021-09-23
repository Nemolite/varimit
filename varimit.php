<?php
/**
* Plugin Name: Var imit
* Plugin URI: https://github.com/Nemolite/varimit
* Description: Имитация вариации.Формирует апселлы для каждой вариации 
* Version: 1.12.2
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
  
	wp_localize_script( 'varimit-script', 'varimitajax', array( 'varimitajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  }
  add_action( 'wp_enqueue_scripts', 'script_and_style_varimit' );

/**
 * Подключение скриптов и стилей для админки
 */
function script_and_style_varimit_admin(){
	
	wp_enqueue_style( 'varimit-adminjqui',  plugins_url('assets/css/jquery-ui.min.css', __FILE__));
	wp_enqueue_style( 'varimit-adminatyle',  plugins_url('assets/css/style-admin.css', __FILE__));

	wp_enqueue_script( 'varimit-adminjqui', plugins_url('assets/js/jquery-ui.min.js', __FILE__),array(),'1.12.1');
	wp_enqueue_script( 'varimit-adminscript', plugins_url('assets/js/varimit-admin.js', __FILE__),array(),'1.0.0','in_footer');

	wp_localize_script( 'varimit-adminscript', 'myajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  }
  add_action( 'admin_enqueue_scripts', 'script_and_style_varimit_admin' );

/**
 * Создание таблицы вариации при активации плагина
 */
register_activation_hook( __FILE__, 'varimit_create_plugin_tables_variation' );
function varimit_create_plugin_tables_variation()
{
	global $wpdb;
	$table_name_variation = $wpdb->prefix . 'varimit_variation';
	$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

	$sql = "CREATE TABLE $table_name_variation (
	id int(11) NOT NULL AUTO_INCREMENT,
	namevari varchar(255) DEFAULT NULL,
	slugvari varchar(255) DEFAULT NULL,	
	UNIQUE KEY id (id)
	){$charset_collate};";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
} 

/**
 * Создание таблицы значений вариации при активации плагина
 */
register_activation_hook( __FILE__, 'varimit_create_plugin_tables_variation_values' );
function varimit_create_plugin_tables_variation_values()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'varimit_variation_values';
	$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

	$sql = "CREATE TABLE $table_name (
	id int(11) NOT NULL AUTO_INCREMENT,
	namevalue varchar(255) DEFAULT NULL,
	slugvalue varchar(255) DEFAULT NULL,
	urlvalue varchar(255) DEFAULT NULL,
	variationid int(11) DEFAULT 0,
	prioritet int(11) DEFAULT 0,
	UNIQUE KEY id (id)
	){$charset_collate};";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
} 
/**
 * Helper
 */
function show( $arr ){
	echo "<pre>";
	print_r( $arr );
	echo "</pre>";
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
 * Модуль создания подменю вариации
 */
require "inc/submenu.php";

/**
 * Модуль работы с вариациями
 */
require "inc/variation.php";

/**
 * Модуль работы со значениями вариации
 */
require "inc/values.php";

/**
 * Модуль работы с базами данных
 */
require "inc/database.php";

/**
 * Модуль отображение информации в товаре
 */
require "inc/product.php";

/**
 * Модуль работы с произвольными полями продукта
 */
require "inc/product_db.php";

/**
 * Модуль вывода вариации в карточке товра
 */

require "inc/cart.php";

/**
 * Модуль работы с таблицами баз данных для страницы товара
 */
require "inc/cart_db.php";

/**
 * Модуль для скрытия товара ,к роме выбранного главного
 */
require "inc/filter.php";

/**
 * Модуль работы с таблицами баз данных для фильтра
 */
require "inc/filter_db.php";

/**
 * Модуль для работы с каталогом
 */
require "inc/catalog.php";

/**
 * Модуль для работы с каталогом баз данных
 */
require "inc/catalog_db.php";

/**
 * Модуль основных функции
 */
require "inc/global.php";
?>