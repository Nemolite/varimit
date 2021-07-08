<?php
/**
 * Создание подпункта Вариации в пункте Товары
 */
if ( is_admin() ) {
    add_action( 'admin_menu', 'add_products_menu_entry', 100 );
  }
  
  function add_products_menu_entry() {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Вариации' ),
        __( 'Вариации' ),
        'manage_woocommerce', 
        'variation',
        'register_varimit_submenu_variation'
    );
  }
  
  function register_varimit_submenu_variation() {
  ?>
    <div class="wrap woocommerce">
        <?php      

            if ( ! empty( $_GET['varimit_action']) ) { // WPCS: CSRF ok.

                if ( 'edit'==$_GET['varimit_action'] ) {

                    /**
                    * Модуль изменения вариации
                    * variation.php
                    */
                    varimit_edit_variation();

                } elseif ( 'delete'==$_GET['varimit_action']) {

                    /**
                     * Удаление вариации 
                     * database.php 
                     */
                    varimit_delete_variation();

                } elseif ( 'сonfigure'==$_GET['varimit_action'] ) {

                    /**
                     * Форма настроки значений вариации
                     * values.php
                     */
                    varimit_add_variation_value();

                } elseif ( 'delete-value'==$_GET['varimit_action']) {

                    /**
                     * Удаление значения вариации
                     * database.php
                     */
                    varimit_delete_variation_value();

                } elseif ( 'edit-value'==$_GET['varimit_action']) {

                    /**
                     * Редактирование значения вариации
                     * values.php
                     */
                    varimit_edit_variation_value();

                }
 
            } elseif ( empty( $_GET['varimit_action'] ) ) {
   
                /**
                 * Модуль Добавления вариации
                 * variation.php
                 */
                varimit_add_variation();

            }       
        ?>
    </div>
  <?php
  }

?>