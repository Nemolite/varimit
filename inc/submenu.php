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
        'manage_woocommerce', // Required user capability
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
                                      <?php if ( wc_has_custom_attribute_types() ) : ?>
                                          <th scope="col"><?php esc_html_e( 'Type', 'woocommerce' ); ?></th>
                                      <?php endif; ?>
                                      <th scope="col"><?php esc_html_e( 'Order by', 'woocommerce' ); ?></th>
                                      <th scope="col"><?php esc_html_e( 'Terms', 'woocommerce' ); ?></th>
                                  </tr>
                              </thead>
                              <tbody>
                              <!-- вывод -->
                              </tbody>
                          </table>
                      </div>
                  </div>
  
                  <div id="col-left">
                      <div class="col-wrap">
                          <div class="form-wrap">
                              <h2><?php //esc_html_e( 'Add new Variation', 'woocommerce' ); 
                            esc_html_e( 'Добавить вариацию', 'woocommerce' );
                ?></h2>
                              <p><?php 
                // esc_html_e( 'Attributes let you define extra product data, such as size or color. You can use these attributes in the shop sidebar using the "layered nav" widgets.', 'woocommerce' ); 
                esc_html_e( 'Вариации позволяют определять дополнительные сведения о товаре, такие как размер и цвет.', 'woocommerce' ); 
                
                ?></p>
                              <form action="edit.php?post_type=product&amp;page=product_attributes" method="post">
                                  <?php do_action( 'woocommerce_before_add_attribute_fields' ); ?>
  
                                  <div class="form-field">
                                      <label for="attribute_label"><?php esc_html_e( 'Name', 'woocommerce' ); ?></label>
                                      <input name="attribute_label" id="attribute_label" type="text" value="" />
                                      <p class="description"><?php esc_html_e( 'Name for the attribute (shown on the front-end).', 'woocommerce' ); ?></p>
                                  </div>
  
                                  <div class="form-field">
                                      <label for="attribute_name"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></label>
                                      <input name="attribute_name" id="attribute_name" type="text" value="" maxlength="28" />
                                      <p class="description"><?php esc_html_e( 'Unique slug/reference for the attribute; must be no more than 28 characters.', 'woocommerce' ); ?></p>
                                  </div>
  
                                  <div class="form-field">
                                      <label for="attribute_public"><input name="attribute_public" id="attribute_public" type="checkbox" value="1" />
                      <?php esc_html_e( 'Enable Archives?', 'woocommerce' ); ?>
                    </label>
  
                                      <p class="description">
                        <?php // esc_html_e( 'Enable this if you want this attribute to have product archives in your store.', 'woocommerce' );
                          esc_html_e( 'Позволяет просматривать списки товаров с определённой вариацией.', 'woocommerce' ); 
                        ?>
                    </p>
                                  </div>
  
                                  <?php
                              
                                  if ( wc_has_custom_attribute_types() ) {
                                      ?>
                                      <div class="form-field">
                                          <label for="attribute_type"><?php esc_html_e( 'Type', 'woocommerce' ); ?></label>
                                          <select name="attribute_type" id="attribute_type">
                                              <?php foreach ( wc_get_attribute_types() as $key => $value ) : ?>
                                                  <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                                              <?php endforeach; ?>
                                              <?php
                                                  /**
                                                   * Deprecated action in favor of product_attributes_type_selector filter.
                                                   *
                                                   * @todo Remove in 4.0.0
                                                   * @deprecated 2.4.0
                                                   */
                                                  do_action( 'woocommerce_admin_attribute_types' );
                                              ?>
                                          </select>
                                          <p class="description">
                        <?php //esc_html_e( "Determines how this attribute's values are displayed.", 'woocommerce' ); 
                        esc_html_e( "Определяет, как отображаются значения этой вариации.", 'woocommerce' );
                    
                        ?>
                      </p>
                                      </div>
                                      <?php
                                  }
                                  ?>
  
                                  <div class="form-field">
                                      <label for="attribute_orderby"><?php esc_html_e( 'Default sort order', 'woocommerce' ); ?></label>
                                      <select name="attribute_orderby" id="attribute_orderby">
                                          <option value="menu_order"><?php esc_html_e( 'Custom ordering', 'woocommerce' ); ?></option>
                                          <option value="name"><?php esc_html_e( 'Name', 'woocommerce' ); ?></option>
                                          <option value="name_num"><?php esc_html_e( 'Name (numeric)', 'woocommerce' ); ?></option>
                                          <option value="id"><?php esc_html_e( 'Term ID', 'woocommerce' ); ?></option>
                                      </select>
                                      <p class="description">
                    <?php // esc_html_e( 'Determines the sort order of the terms on the frontend shop product pages. If using custom ordering, you can drag and drop the terms in this attribute.', 'woocommerce' ); 
                      esc_html_e( ' Определяет порядок сортировки значений на страницах товаров во фронтэнде. При использовании произвольного порядка, можно перетаскивать значения в этой вариации.', 'woocommerce' ); 
                    ?>
                    </p>
                                  </div>
  
                                  <?php do_action( 'woocommerce_after_add_attribute_fields' ); ?>
  
                                  <p class="submit"><button disabled="disabled" type="submit" name="add_new_attribute" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Добавить вариацию', 'woocommerce' ); ?>"><?php esc_html_e( 'Добавить вариацию', 'woocommerce' ); ?></button></p>
                                  <?php wp_nonce_field( 'woocommerce-add-new_attribute' ); ?>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
              <script type="text/javascript">
              /* <![CDATA[ */
  
                  jQuery( 'a.delete' ).on( 'click', function() {
                      if ( window.confirm( '<?php 
                          // esc_html_e( 'Are you sure you want to delete this attribute?', 'woocommerce' ); 
                          esc_html_e( 'Вы уверены, что хотите удалить эту вариацию?', 'woocommerce' ); 
                          
                          ?>' ) ) {
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