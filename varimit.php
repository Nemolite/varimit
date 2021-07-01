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


require "inc/submenu.php";

?>