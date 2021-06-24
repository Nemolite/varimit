<?php
/**
 * Форма создания Вариации
 */
?>
<form action="edit.php?post_type=product&amp;page=product_attributes&amp;edit=<?php echo absint( $edit ); ?>" method="post">
					<table class="form-table">
						<tbody>
							<?php do_action( 'woocommerce_before_edit_attribute_fields' ); ?>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="attribute_label"><?php esc_html_e( 'Name', 'woocommerce' ); ?></label>
								</th>
								<td>
									<input name="attribute_label" id="attribute_label" type="text" value="<?php echo esc_attr( $att_label ); ?>" />
									<p class="description"><?php esc_html_e( 'Name for the attribute (shown on the front-end).', 'woocommerce' ); ?></p>
								</td>
							</tr>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="attribute_name"><?php esc_html_e( 'Slug', 'woocommerce' ); ?></label>
								</th>
								<td>
									<input name="attribute_name" id="attribute_name" type="text" value="<?php echo esc_attr( $att_name ); ?>" maxlength="28" />
									<p class="description"><?php esc_html_e( 'Unique slug/reference for the attribute; must be no more than 28 characters.', 'woocommerce' ); ?></p>
								</td>
							</tr>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="attribute_public"><?php esc_html_e( 'Enable archives?', 'woocommerce' ); ?></label>
								</th>
								<td>
									<input name="attribute_public" id="attribute_public" type="checkbox" value="1" <?php checked( $att_public, 1 ); ?> />
									<p class="description"><?php esc_html_e( 'Enable this if you want this attribute to have product archives in your store.', 'woocommerce' ); ?></p>
								</td>
							</tr>
							<?php
							/**
							 * Attribute types can change the way attributes are displayed on the frontend and admin.
							 *
							 * By Default WooCommerce only includes the `select` type. Others can be added with the
							 * `product_attributes_type_selector` filter. If there is only the default type registered,
							 * this setting will be hidden.
							 */
							if ( wc_has_custom_attribute_types() ) {
								?>
								<tr class="form-field form-required">
									<th scope="row" valign="top">
										<label for="attribute_type"><?php esc_html_e( 'Type', 'woocommerce' ); ?></label>
									</th>
									<td>
										<select name="attribute_type" id="attribute_type">
											<?php foreach ( wc_get_attribute_types() as $key => $value ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $att_type, $key ); ?>><?php echo esc_html( $value ); ?></option>
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
										<p class="description"><?php esc_html_e( "Determines how this attribute's values are displayed.", 'woocommerce' ); ?></p>
									</td>
								</tr>
								<?php
							}
							?>
							<tr class="form-field form-required">
								<th scope="row" valign="top">
									<label for="attribute_orderby"><?php esc_html_e( 'Default sort order', 'woocommerce' ); ?></label>
								</th>
								<td>
									<select name="attribute_orderby" id="attribute_orderby">
										<option value="menu_order" <?php selected( $att_orderby, 'menu_order' ); ?>><?php esc_html_e( 'Custom ordering', 'woocommerce' ); ?></option>
										<option value="name" <?php selected( $att_orderby, 'name' ); ?>><?php esc_html_e( 'Name', 'woocommerce' ); ?></option>
										<option value="name_num" <?php selected( $att_orderby, 'name_num' ); ?>><?php esc_html_e( 'Name (numeric)', 'woocommerce' ); ?></option>
										<option value="id" <?php selected( $att_orderby, 'id' ); ?>><?php esc_html_e( 'Term ID', 'woocommerce' ); ?></option>
									</select>
									<p class="description"><?php esc_html_e( 'Determines the sort order of the terms on the frontend shop product pages. If using custom ordering, you can drag and drop the terms in this attribute.', 'woocommerce' ); ?></p>
								</td>
							</tr>
							<?php do_action( 'woocommerce_after_edit_attribute_fields' ); ?>
						</tbody>
					</table>
					<p class="submit"><button type="submit" name="save_attribute" id="submit" class="button-primary" value="<?php esc_attr_e( 'Update', 'woocommerce' ); ?>"><?php esc_html_e( 'Update', 'woocommerce' ); ?></button></p>
					<?php wp_nonce_field( 'woocommerce-save-attribute_' . $edit ); ?>
				</form>