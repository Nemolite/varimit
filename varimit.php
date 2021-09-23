<?php
/**
* Plugin Name: Variation Imitation for Woocommerce
* Plugin URI: https://github.com/Nemolite/varimit
* Description: Имитация вариации.Позволяет создавать вариации для простых товаров.
* Version: 2.0.1
* Author: Nemolite
* Author URI: http://vandraren.ru/
* License: GPL2
*/
defined('ABSPATH') || exit;

if ( !function_exists('is_woocommerce_active') ){
	function is_woocommerce_active(){
	    $active_plugins = (array) get_option('active_plugins', array());
	   
	    return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce');
	}
}

if(is_woocommerce_active()) {
	if(!class_exists('Varimit_Product_Options')){
		class Varimit_Product_Options {
			const TEXT_DOMAIN = 'varimit';

			public function __construct(){
				add_action('init', array($this, 'init'));
			}

			public function init() {
				define('VARIMIT_VERSION', '2.0.1');
				!defined('VARIMIT_BASE_NAME') && define('VARIMIT_BASE_NAME', plugin_basename( __FILE__ ));
				!defined('VARIMIT_PATH') && define('VARIMIT_PATH', plugin_dir_path( __FILE__ ));
				!defined('VARIMIT_URL') && define('VARIMIT_URL', plugins_url( '/', __FILE__ ));
				!defined('VARIMIT_ASSETS_URL') && define('VARIMIT_ASSETS_URL', VARIMIT_URL .'assets/');
                !defined('VARIMIT_INCLUDES_URL') && define('VARIMIT_INCLUDES_URL', VARIMIT_URL .'inc/');

				$this->load_plugin_textdomain();

				require_once( VARIMIT_INCLUDES_URL . 'class-varimit.php' );
				Varimit::instance();
			}			
		}
	}
	new Varimit_Product_Options();
}
?>