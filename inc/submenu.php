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
              <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  
              <br class="clear" />
              <div id="col-container">
  
                  <div id="col-right">
                      <div class="col-wrap">
                          <table class="widefat attributes-table wp-list-table ui-sortable" style="width:100%">
                              <thead>
                                  <tr>
                                      <th scope="col"><?php esc_html_e( 'Name', 'woocommerce' ); ?></th>
                                      <th scope="col"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></th>                                   
                                      <th scope="col"><?php esc_html_e( 'Terms', 'woocommerce' ); ?></th>
                                  </tr>
                              </thead>
                              <tbody>
                              <!-- вывод -->
                              
                              <?php 
                              /**
                               * hock varimit_variation_display_from_db -10
                               */
                              $results = array();
                              $varimit_variation_output = apply_filters( 'varimit_variation_display',$results );

                              $varimit_name = 'namevari';
	                          $varimit_slug = 'slugvari';

                              $varimit_repetitions = ( $varimit_variation_output ) ? count( $varimit_variation_output ) : 1;

                              ?>
                              <?php for ( $varimit_idx = 1; $varimit_idx <= $varimit_repetitions; $varimit_idx++ ) { ?>
                                    <tr>
                                      <th scope="col">

                                      <?php echo esc_html( $varimit_variation_output[ $varimit_idx ][ $varimit_name ] ); ?>
                                      
                                      </th>
                                      <th scope="col">
                                     
                                      <?php echo esc_html( $varimit_variation_output[ $varimit_idx ][ $varimit_slug ] ); ?>

                                      </th>                                   
                                      <th scope="col"><?php esc_html_e( 'Настройка значений', 'varimit' ); ?></th>
                                  </tr>
                                <?php
                                }
                                ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
  
                  <div id="col-left">
                      <div class="col-wrap">
                          <div class="form-wrap">
                              <h2><?php esc_html_e( 'Добавить вариацию', 'varimit' ); ?></h2>
                              <p><?php esc_html_e( 'Вариации позволяют определять дополнительные сведения о товаре, такие как размер и цвет.', 'woocommerce' ); ?></p>
                              <form action="" name="variation_form" id="variation_form" method="post">
                                  <?php do_action( 'varimit_before_add_variation_fields' ); ?>
  
                                  <div class="form-field">
                                      <label for="variation_label"><?php esc_html_e( 'Name', 'woocommerce' ); ?></label>
                                      <input name="variation_label" id="variation_label" type="text" value="" />
                                      <p class="description">
                                      <?php esc_html_e( 'Название вариации (отображается во фронтенде).', 'varimit' ); ?></p>
                                  </div>
  
                                  <div class="form-field">
                                      <label for="variation_name"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></label>
                                      <input name="variation_name" id="variation_name" type="text" value="" maxlength="28" />
                                      <p class="description"><?php esc_html_e( 'Unique slug/reference for the attribute; must be no more than 28 characters.', 'woocommerce' ); ?></p>
                                  </div>
  
                             
                                  <?php do_action( 'varimit_after_add_variation_fields' ); ?>
  
                                  <p class="submit"><button type="submit" name="add_new_variation" id="submit-variation" class="button button-primary" value="<?php esc_attr_e( 'Добавить вариацию', 'woocommerce' ); ?>"><?php esc_html_e( 'Добавить вариацию', 'woocommerce' ); ?></button></p>
                                  <?php //wp_nonce_field( 'varimit_variation' ); ?>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
              <script type="text/javascript">
              /* <![CDATA[ */
  
                  jQuery( 'a.delete' ).on( 'click', function() {
                      if ( window.confirm( '<?php esc_html_e( 'Вы уверены, что хотите удалить эту вариацию?', 'varimit' ); ?>' ) ) {
                          return true;
                      }
                      return false;
                  });
  
              /* ]]> */
              </script>
          </div>

  <?php
  }

?>