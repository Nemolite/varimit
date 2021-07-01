<?php
/**
 * Модуль отображения информации в товаре (админка)
 */

add_action('woocommerce_product_write_panel_tabs','varimit_output_variation_in_product',); 

function varimit_output_variation_in_product() {
  ?>
 
  <div class="varimit-admin-output-block">
  Вариации
  </div>
  <?php
}
?>