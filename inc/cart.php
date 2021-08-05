<?php
/**
 * Модуль вывода вариации в карточке товра
 */


  /**
  * Вывод вариации в карточке товара
  */
  add_action( 'woocommerce_single_product_summary','varimit_display_in_single_product',15 ); 
  function varimit_display_in_single_product() {
    ?>
        <div class="varimit-output-single-product">           
            <?php  varimit_display_variation_single_product(); ?>
        </div>
       
    <?php
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
   * Функция вывода ссылок на попап вариативных товаров
   *  
   */
function varimit_display_variation_single_product() {

    // show( varimit_get_id_product_for_hide() );

    global $wp_query;
    $product = wc_get_product( $wp_query->post );
    $id = $product->get_id(); 
    $key = ''; 
    $single =false; 

    $meta_values = get_post_meta( $id, $key, $single );
    //show( $meta_values );

    $varimit_iden = get_post_meta( $id, '_varimit_iden', true );
    // show($varimit_iden);

    $arr_id_iden = varimit_get_product_union_iden( $varimit_iden ); 
    // show( $arr_id_iden );

    $etalon = '_varimit__product_value_';

    foreach ($meta_values as $key => $val){
         if (str_contains( $key, $etalon)) {

            $select_list = unserialize($val[0]);  

           // show( $select_list );          

            $var_id = $select_list[0];
            if( !is_array($var_id) ) {
                $name_variation = varimit_get_data_variation_cart($var_id);
                // show( $name_variation );
            }
            $arr_var_check = varimit_get_array_variation_for_product( $var_id );

            // show($arr_var_check);

            $for_post_in = array_intersect( $arr_id_iden, $arr_var_check );

            // show($for_post_in);

            // echo count($for_post_in);

            if ( 1===count($for_post_in) ) {
                  $marker_one = "false";
                 
            } else {
                $marker_one = "true"; 

            }

            // echo  $marker_one;
           
            if( ('notselect'!==$select_list[1])&&("true"==$marker_one) ) {
            ?>
             <?php
                if( !is_array( $select_list[2]  ) ) { 
            ?>
                <div class= "varimit-output-single-product-inner"> 
               
                        <div class= "varimit-output-single-product-inner-left"       
                            data-id_parent= "<?php echo esc_attr( $var_id ); ?>"                       
                        >
                        <?php
                       
                            echo "<b>". esc_attr( $name_variation[0]['namevari'] ) ."</b>";
                            echo "<br>";
                           
                            echo esc_attr( $select_list[2] );
                       
                       
                        ?>
                        </div> <!-- varimit-output-single-product-inner-left -->
               
                    <div class= "varimit-output-single-product-inner-right">

                    <svg 
                        focusable="false" 
                        viewBox="0 0 24 24" 
                        class="range-revamp-svg-icon range-revamp-chunky-header__icon" 
                        aria-hidden="true">
                        <path 
                        fill-rule="evenodd" 
                        clip-rule="evenodd" 
                        d="M15.6 12l-5.785 5.786L8.4 16.372l4.371-4.371-4.37-4.372 1.414-1.414L15.6 12z">
                        </path>
                    </svg> 

                    </div> <!-- varimit-output-single-product-inner-right -->

                    <div class="varimit-popup-output" id ="modal_<?php echo esc_attr( $var_id ); ?>">
                    
                        <div class="varimit-popup-output-title">
                        <?php
                            echo "<b>".$art_title_col."</b>";
                        ?>
                        </div> <!-- varimit-popup-output-title -->

                            <div class="varimit-popup-output-close" data-id_close ="<?php echo esc_attr( $var_id ); ?>">
                            <svg 
                                focusable="false" 
                                viewBox="0 0 24 24" 
                                class="range-revamp-svg-icon range-revamp-btn__icon" 
                                aria-hidden="true">
                                <path 
                                fill-rule="evenodd" 
                                clip-rule="evenodd" 
                                d="M12 13.415l4.95 4.95 1.414-1.415-4.95-4.95 4.95-4.95-1.415-1.413-4.95 4.95-4.949-4.95L5.636 7.05l4.95 4.95-4.95 4.95 1.414 1.414 4.95-4.95z">
                                </path>
                            </svg> 
                            </div> <!-- varimit-popup-output-close -->
                            <?php
                            
                               // получаем совпадения вариации
                              $post_in_arr = varimit_get_array_variation_for_product( $var_id );
                              // show($post_in_arr);
                              // show($arr_id_iden);

                              $for_post_in = array_intersect( $arr_id_iden, $post_in_arr );
                              // show($for_post_in);
                              // dev сортировка
                              // show($id);

                              $arr_id = array();
                              $arr_id[] = $id;
                              // show($arr_id);
                              $result_post_in = array_diff( $for_post_in, $arr_id );
                              // show($result_post_in);
                                $args = array(
                                'post_type' => 'product',
                                'numberposts' => -1,                                
                                'include' => $result_post_in,        
                                    
                                );
                                
                                $posts = get_posts($args);
                                foreach( $posts as $post ){
                                    setup_postdata($post);
                                                    
                                   
                            ?>
                              <?php
                             $arr_res =  varimit_get_mini_name_values(  $var_id, $post->ID  );
                             // show($arr_res);

                             $url_img = varimit_get_mini_img_values( $arr_res[0][0] );

                             //show($url_img);
                               ?>

                            <a href="<?php echo get_permalink( $post->ID ); ?>">

                                <div class="varimit-mini-list">
                                    <div class="varimit-mini-list-img">

                                    <img id="mimi_url_list" src="<?php echo $url_img[0]['urlvalue'];?>" alt="">
                                    <?php
                                      
                                      // echo get_the_post_thumbnail( $post->ID );
                                    ?>                                                                
                                    </div> <!-- varimit-mini-list-img -->
                                    <div class="varimit-mini-list-title">
                                    <?php
                                        //echo $post->post_title;
                                        //echo "<br>";                               
                                        echo $arr_res[0][2];
                                        echo "<br>";   
                                    ?>
                                    </div> <!-- varimit-mini-list-title -->
                                </div> <!-- varimit-mini-list --> 
                            </a>  
                        <?php            				
                            		     
                        }	
                            wp_reset_postdata();                   
                        ?>

                    </div> <!-- varimit-popup-output -->


                    <div class="varimit-left-output" id ="left_<?php echo esc_attr( $var_id ); ?>">
                    
                    <div class="varimit-popup-output-title"> 
                    <?php
                        echo "<b>".$art_title_col."</b>";
                    ?>
                    </div> <!-- varimit-popup-output-title -->

                        <div class="varimit-popup-output-close" data-id_close ="<?php echo esc_attr( $var_id ); ?>">
                        <svg 
                            focusable="false" 
                            viewBox="0 0 24 24" 
                            class="range-revamp-svg-icon range-revamp-btn__icon" 
                            aria-hidden="true">
                            <path 
                            fill-rule="evenodd" 
                            clip-rule="evenodd" 
                            d="M12 13.415l4.95 4.95 1.414-1.415-4.95-4.95 4.95-4.95-1.415-1.413-4.95 4.95-4.949-4.95L5.636 7.05l4.95 4.95-4.95 4.95 1.414 1.414 4.95-4.95z">
                            </path>
                        </svg> 
                        </div> <!-- varimit-popup-output-close -->

                        <div class="varimit_left_mini_content">                          
                        <?php
                        
                           // получаем совпадения вариации
                          $post_in_arr = varimit_get_array_variation_for_product( $var_id );
                          // show($post_in_arr);
                          // show($arr_id_iden);

                          $for_post_in = array_intersect( $arr_id_iden, $post_in_arr );
                          // show($for_post_in);
                          // dev сортировка

                          $arr_id = array();
                          $arr_id[] = $id;
                              // show($arr_id);
                          $result_post_in = array_diff( $for_post_in, $arr_id );

                            $args_left = array(
                            'post_type' => 'product',                                
                            'post__in' => $result_post_in,        
                                
                            );

                            $query_mini = new WP_Query($args_left);
                            if( $query_mini->have_posts() ){
                                while( $query_mini->have_posts() ){            
                                    $query_mini->the_post();
                                   
                        ?>                           
                            <div class="col-xs-6">
                              
                            <a href="<?php echo get_permalink( $post->ID ); ?>">
                            <img id="mimi_url_list" src="<?php echo $url_img[0]['urlvalue'];?>" alt="">
                            <?php
                            /*
                                        if ( has_post_thumbnail()) {
                                        the_post_thumbnail();
                                        }
                            */            
                            ?> 
                            <?php
                                         //echo $post->post_title;
                                        //echo "<br>";                               
                                        echo $arr_res[0][2];
                                        echo "<br>";                               
                            ?>
                            </a>
                            </div>   <!-- varimit-left-output -->      
                    <?php            				
                        }			     
                    }	
                        wp_reset_postdata();                   
                    ?>
                    </div> <!-- varimit_left_mini_content -->
                </div> <!-- varimit-left-output -->
        
              </div> <!-- varimit-output-single-product-inner -->
              <?php
                }
            ?>  
            <?php
            }
                   
        }
    } 
  } 
  
 
?>

