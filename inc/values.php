<?php
/**
 * Раздел работы со значения вариации
 */

 /**
 * Форма настроки значений вариации
 */
function varimit_add_variation_value( $variationid, $namevari ) {
   
    ?>

    <h1>Добавление значений вариации <?php echo esc_html( $namevari ); ?></h1>

    <?php echo '<div id="message" class="updated"><p>'         
        . '</p><p><a href="' 
        . esc_url( admin_url( 'edit.php?post_type=product&amp;page=variation' ) ) 
        . '">' 
        . esc_html__( 'Назад к вариации ', 'varimit' ) . '</a></p></div>';
	?>
  
    <br class="clear" />
    <div id="col-container">

    <div id="col-right">
          <div class="col-wrap">
             
              <div class="varimit-values">
                  <p>* Для сортировки приоритетов используйте перетаскивание</p>
                <div class="varimit-values-head">

                <div class="varimit-values-head-name">
                    <p class="varimit-values-head-txt"><?php esc_html_e( 'Name', 'woocommerce' ); ?></p>                    
                </div>
                <div class="varimit-values-head-slug">
                    <p class="varimit-values-head-txt"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></p>                    
                </div>
                <div class="varimit-values-head-img">
                    <p class="varimit-values-head-txt"><?php esc_html_e( 'Миниатюра', 'varimit' ); ?></p>                    
                </div>

                </div>
                <div class="varimit-values-content" 
                data-variationid="<?php echo esc_html($variationid)?>"
                >
                    <?php 
                    /**
                     * hock varimit_variation_display_from_db -10
                     */
                    $results = array();
                    $varimit_variation_values_output = apply_filters( 'varimit_variation_values_display', $results, $variationid );
                  
                    $varimit_value_id = 'id';
                    $varimit_value_name = 'namevalue';
                    $varimit_value_slug = 'slugvalue';
                    $urlvalue   = 'urlvalue';

                    if ($varimit_variation_values_output) {
                    ?>
                    <?php foreach($varimit_variation_values_output as $varimit_temp_list) { ?>

                    <div class="varimit-values-content-item" 
                        id ="<?php echo esc_html( $varimit_temp_list[ $varimit_value_id ] ); ?>"
                     >
                        <div class="varimit-values-content-item-name">
                            <p class="varimit-values-head-txt">
                                <?php echo esc_html( $varimit_temp_list[ $varimit_value_name ] ); ?>
                            </p>

                            <div class="row-actions-values">
                            <span class="edit">
                                <a href="
                                    <?php echo esc_url( 
                                        add_query_arg( 
                                            'edit-value', $varimit_temp_list[ $varimit_value_id ] , 
                                            'edit.php?post_type=product&amp;page=variation&amp;varimit_action=edit-value' ) ); 
                                    ?>"
                                >
                                    <?php esc_html_e( 'Edit', 'woocommerce' ); ?>
                                </a> | 
                            </span>
                            <span class="delete">
                                <!--
                                <a class="delete-value" href="<?php // echo esc_url( wp_nonce_url( add_query_arg( 'delete-value', $varimit_temp_list[ $varimit_value_id ], 'edit.php?post_type=product&amp;page=variation&amp;varimit_action=delete-value' ), 'woocommerce-delete-attribute_' . $tax->attribute_id ) ); ?>">
                                    <?php // esc_html_e( 'Delete', 'woocommerce' ); ?>
                                </a>
                                -->
                                <a href="" 
                                    class="delete-value"
                                    data-value_del_id="<?php echo esc_html( $varimit_temp_list[ $varimit_value_id ] ); ?>"
                                    
                                >
                                    <?php esc_html_e( 'Delete', 'woocommerce' ); ?>
                                </a>
                            </span>
                          </div>



                        </div>
                        <div class="varimit-values-content-item-slug">
                            <p class="varimit-values-head-txt">
                                <?php echo esc_html( $varimit_temp_list[ $varimit_value_slug ] ); ?>
                            </p>
                        </div>
                        <div class="varimit-values-content-item-img">
                            <img src="<?php echo esc_url( $varimit_temp_list[ $urlvalue  ] ); ?>" alt="">
                        </div>
                    </div>

                    <?php
                    }
                } else {
                    echo "Значения для вариации ". $namevari ." не создано";
                }
                    ?>

                </div>

              </div>
          </div>
      </div>
   
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2><?php esc_html_e( 'Добавить значение к вариации ', 'varimit' ); ?><?php echo esc_html( $namevari ); ?></h2>
                
                    <form action="" name="variation_form_value" id="variation_form_value" method="post">
                        <?php do_action( 'varimit_before_add_variation_value_fields' ); ?>
  
                        <div class="form-field">
                            <label for="variation_label_value"><?php esc_html_e( 'Name', 'woocommerce' ); ?></label>
                            <input name="variation_label_value" id="variation_label_value" type="text" value="" />
                           
                        </div>
  
                        <div class="form-field">
                            <label for="variation_name_value"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></label>
                            <input name="variation_name_value" id="variation_name_value" type="text" value="" maxlength="28" />
                            
                        </div>

                        <div class="form-field">
                            <label for="variation_file_value"><?php esc_html_e( 'Загрузка миниатюры', 'varimit' ); ?></label>
                            <input name="variation_file_value" id="variation_file_value" type="file" accept="image/jpeg,image/png,image/gif" />
                            
                        </div>

                   
                        <?php do_action( 'varimit_after_add_variation_value_fields' ); ?>

                        <input type="hidden" name="variationid" id="variationid" value="<?php echo esc_html( $variationid ); ?>">
                        <p class="submit">
                            <button 
                                type="submit" 
                                name="add_new_variation_value" 
                                id="add_new_variation_value" 
                                class="button button-primary" 
                                value="<?php esc_attr_e( 'Добавить значение вариации', 'varimit' ); ?><?php echo esc_html( $namevari ); ?>"
                            >
                                <?php esc_html_e( 'Добавить значение вариации ', 'woocommerce' ); ?><?php echo esc_html( $namevari ); ?>
                            </button>
                        </p>
                        <?php //wp_nonce_field( 'varimit_variation' ); ?>
                    </form>
                </div>
            </div>
        </div>
    
    <script type="text/javascript">
    /* <![CDATA[ */
  
        jQuery( 'a.delete-value' ).on( 'click', function() {
            if ( window.confirm( '<?php esc_html_e( 'Вы уверены, что хотите удалить это значение вариации?', 'varimit' ); ?>' ) ) {
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
 * Редактирование значения вариации
 */
function varimit_edit_variation_value( $valueid ) {

/**
 * Получение значения вариации из базы данных
 * Вход id значения вариации $valueid
 * Выход Имя значения вариации , ссылка, миниатюра
 */
$vriation_value_output_one_only = apply_filters( 'varimit_variation_value_output_one_only', $valueid );
    ?>
  <div class="wrap woocommerce">			
  
    <h1><?php esc_html_e( 'Изменить значение вариации', 'varimit' ); ?></h1>

    <?php echo '<div id="message" class="updated"><p>'         
        . '</p><p><a href="' 
        . esc_url( admin_url( 'edit.php?post_type=product&amp;page=variation' ) ) 
        . '">' 
        . esc_html__( 'Назад к значениям вариации ', 'varimit' ) . '</a></p></div>';
	?>
	<form action="" name="variation-value-form-edit" id="variation-value-form-edit" method="post">
					<table class="form-table">
						<tbody>
							<?php do_action( 'varimit_before_edit_variation-value_fields' ); ?>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="variation_value_label">
                                        <?php esc_html_e( 'Name', 'woocommerce' ); ?>
                                    </label>
								</th>
								<td>
									<input 
                                        name="variation_value_label" 
                                        id="variation_value_label" 
                                        type="text" 
                                        value="<?php echo esc_attr( $vriation_value_output_one_only[0]['namevalue']  ); ?>" 
                                    />
									<p class="description">
                                        <?php esc_html_e( 'Значение вариации будет отображено во front-end', 'varimit' ); ?>
                                    </p>
								</td>
							</tr>

							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="variation_value_name">
                                        <?php esc_html_e( 'Slug', 'woocommerce' ); ?>
                                    </label>
								</th>
								<td>
									<input 
                                        name="variation_value_name" 
                                        id="variation_value_name" 
                                        type="text" 
                                        value="<?php echo esc_attr( $vriation_value_output_one_only[0]['slugvalue']  ); ?>" 
                                        maxlength="28" 
                                    />
									<p class="description">
                                        <?php esc_html_e( 'Unique slug/reference for the attribute; must be no more than 28 characters.', 'woocommerce' ); ?>
                                    </p>
								</td>
							</tr>

                            <tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="variation_value_img">
                                        <?php esc_html_e( 'Миниатюра', 'varimit' ); ?>
                                    </label>
								</th>
								<td>
									<input 
                                        name="variation_value_img" 
                                        id="variation_value_img"
                                        type="file" 
                                        accept="image/jpeg,image/png,image/gif"
                                    />
                  
									<p class="description">
                                        <?php esc_html_e( 'Будет отображено во front-end', 'varimit' ); ?>
                                    </p>
								</td>
							</tr>
        
													
							<?php do_action( 'varimit_after_edit_variation-value_fields' ); ?>
						</tbody>
					</table>
                    <input  
                        type="hidden" 
                        name="save_variation_value_id" 
                        id="save_variation_value_id" 
                        value="<?php echo esc_html( $valueid ); ?>"
                    >
					<p class="submit">
                        <button 
                            type="submit" 
                            name="save_variation_value" 
                            id="save_variation_value" 
                            class="button-primary" 
                            value="<?php esc_attr_e( 'Update', 'woocommerce' ); ?>"
                        >
                            <?php esc_html_e( 'Update', 'woocommerce' ); ?></button>
                    </p>
					<?php // wp_nonce_field( 'woocommerce-save-attribute_' . $edit ); ?>
				</form>


  </div>    
    <?php
}
?>