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

        // Action to perform: add or edit.
            if ( ! empty( $_GET['varimit_action']) ) { // WPCS: CSRF ok.

                if ( 'edit'==$_GET['varimit_action'] ) { 

                    varimit_edit_variation();

                } elseif ( 'delete'==$_GET['varimit_action']) {

                    varimit_delete_variation();

                } elseif ( 'сonfigure'==$_GET['varimit_action'] ) {

                    varimit_сonfigure_variation();

                }
 
            } elseif ( empty( $_GET['varimit_action'] ) ) {
   
                varimit_add_variation();

            }       
        ?>
    </div>
  <?php
  }

/**
* Модуль Добавления вариации
*/

function varimit_add_variation(){
?>
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
                  $varimit_id   = 'id';

                  $varimit_repetitions = ( $varimit_variation_output ) ? count( $varimit_variation_output ) : 1;

                  ?>
                  <?php for ( $varimit_idx = 0; $varimit_idx <= ($varimit_repetitions-1); $varimit_idx++ ) { ?>
                        <tr>
                          <th scope="col">

                          <?php echo esc_html( $varimit_variation_output[ $varimit_idx ][ $varimit_name ] ); ?>
                          
                          <div class="row-actions">
                            <span class="edit">
                                <a href="<?php echo esc_url( add_query_arg( 'edit', $varimit_variation_output[ $varimit_idx ][ $varimit_id ], 'edit.php?post_type=product&amp;page=variation&amp;varimit_action=edit' ) ); ?>">
                                    <?php esc_html_e( 'Edit', 'woocommerce' ); ?>
                                </a> | 
                            </span>
                            <span class="delete">
                                <a class="delete" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'delete', $varimit_variation_output[ $varimit_idx ][ $varimit_id ], 'edit.php?post_type=product&amp;page=variation&amp;varimit_action=delete' ), 'woocommerce-delete-attribute_' . $tax->attribute_id ) ); ?>">
                                    <?php esc_html_e( 'Delete', 'woocommerce' ); ?>
                                </a>
                            </span>
                          </div>


                          </th>
                          <th scope="col">
                         
                          <?php echo esc_html( $varimit_variation_output[ $varimit_idx ][ $varimit_slug ] ); ?>

                          </th>                                   
                          <th scope="col">
                          <a href="<?php echo esc_url( add_query_arg( 'edit', $varimit_variation_output[ $varimit_idx ][ $varimit_id ], 'edit.php?post_type=product&amp;page=variation&amp;varimit_action=сonfigure' ) ); ?>">
                            <?php esc_html_e( 'Настройка значений', 'woocommerce' ); ?>
                          </a>
                          </th>
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

/**
* Модуль Изменения вариации
*/
function varimit_edit_variation() {
    global $wpdb;

		$edit = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;

        $table_name = $wpdb->prefix . 'varimit_variation';

		$variation_to_edit = $wpdb->get_row(
			$wpdb->prepare(
				"
				SELECT *
				FROM {$table_name} WHERE id = %d
				",
				$edit
            ),
            ARRAY_A
		);

?>
			<h1><?php esc_html_e( 'Изменить вариацию', 'varimit' ); ?></h1>
            <?php
			
				$namevari   = format_to_edit( $variation_to_edit['namevari'] );
				$slugvari    = $variation_to_edit['slugvari'];
                $editid    = $variation_to_edit['id'];
				
			?>
            <?php
            echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_type=product&amp;page=variation' ) ) . '">' . esc_html__( 'Вернутся в Вариации', 'varimit' ) . '</a></p>';
            ?>
			
				<form action="" name="variation-form-edit" id="variation-form-edit" method="post">
					<table class="form-table">
						<tbody>
							<?php do_action( 'varimit_before_edit_attribute_fields' ); ?>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="variation_label"><?php esc_html_e( 'Name', 'woocommerce' ); ?></label>
								</th>
								<td>
									<input name="variation_label" id="variation_label" type="text" value="<?php echo esc_attr( $namevari  ); ?>" />
									<p class="description"><?php esc_html_e( 'Name for the attribute (shown on the front-end).', 'woocommerce' ); ?></p>
								</td>
							</tr>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="variation_name"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></label>
								</th>
								<td>
									<input name="variation_name" id="attribute_name" type="text" value="<?php echo esc_attr( $slugvari ); ?>" maxlength="28" />
									<p class="description"><?php esc_html_e( 'Unique slug/reference for the attribute; must be no more than 28 characters.', 'woocommerce' ); ?></p>
								</td>
							</tr>
													
							<?php do_action( 'varimit_after_edit_attribute_fields' ); ?>
						</tbody>
					</table>
                    <input type="hidden" name="variation_id" id="variation_id" value="<?php echo esc_html( $editid ); ?>">
					<p class="submit"><button type="submit" name="save_variation" id="submit-variation-edit" class="button-primary" value="<?php esc_attr_e( 'Update', 'woocommerce' ); ?>"><?php esc_html_e( 'Update', 'woocommerce' ); ?></button></p>
					<?php // wp_nonce_field( 'woocommerce-save-attribute_' . $edit ); ?>
				</form>
               
<?php
}

/**
 * Форма настроки значений
 */
function varimit_сonfigure_variation() {
  echo "111";
}

?>