<?php
/**
 * Модуль вывода вариации в карточке товра
 */


  /**
  * Вывод вариации в карточке товара, через хук
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
* Функция вывода ссылок на попап вариативных товаров
*  
*/
function varimit_display_variation_single_product() {   
    global $wp_query;
    
    $product = wc_get_product( $wp_query->post );
    $product_id = $product->get_id(); 

    // Извлекаем все мета поля данного товара в виде массива
    $key = ''; 
    $single =false; 
    $meta_values = get_post_meta( $product_id, $key, $single );

    // Получаем идентификатор вариации
    $product_iden_vari = varimit_get_iden_from_products( $product_id );

    // Получаем массив id продуктов с данным идентификатором
    if (isset($product_iden_vari)&&$product_iden_vari!==''){
      $product_id_arr = varimit_get_array_id_product( $product_iden_vari );
    }    

    // С данным мета полем будем рабоать
    $etalon = '_varimit__product_value_';

    // Перебираем мета поля и из них выбираем только _varimit__product_value_{id}
    foreach ($meta_values as $key_vari => $val){
         if (str_contains( $key_vari, $etalon)) {          

            $select_list = unserialize($val[0]);
            // Извлекаем id вариации
            /**
             * $select_list[0] - id вариации
             * $select_list[1] - slug значения вариации
             * $select_list[2] - name значения вариации
             */
            $var_id = $select_list[0];

            // Получаем имя вариации по id
            if( !is_array($var_id) ) {
                $name_variation = varimit_get_data_variation_cart($var_id);
            }
            $znach = array();
                foreach($product_id_arr as $ids_iden){
                    $znach[] = get_post_meta( $ids_iden, $key_vari, false );
                }
            
            $znach_res =array();
            foreach($znach as $znach_value){
                if(!empty($znach_value)){
                    $znach_res[] = $znach_value;
                }                
            }
         
            $count_znach_res = count($znach_res);
           
            /**
             * Проверяем значение имени массива, если массив раннее был выбран, и
             * позже удален не пропускаем в обработку
             * 
             */
            if( ('notselect'!==$select_list[1])
                && ($count_znach_res!=1)          
               ) {
            ?>
             <?php
                // На всякий случай убираем лишние данные (мусор от разработки)
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
                      <?php echo "<b>". esc_attr( $name_variation[0]['namevari'] ) ."</b>"; ?>
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
                            
                            /**
                             * Проверяем значения вариации товаров с одинаковым идентификационным
                             * номером вариации
                             */                        
                              
                              // Убираем сам товар из списка  
                              $arr_id = array();
                              $arr_id[] = $product_id;                             
                              $result_post_in = array_diff( $product_id_arr, $arr_id );
                            
                            show($result_post_in);


                              /**
                               * Динамический подсчет количества вариаций
                               */
                                $vari_val_count = count($result_post_in);
                             
                                $total_pred_arr[$key_vari] = $vari_val_count;

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
                            // Получения данных о значении вариации
                            echo  $var_id;
                            $arr_res =  varimit_get_mini_name_values(  $var_id, $post->ID  );
                            show($arr_res);
                            if ($arr_res[0][2]!==$select_list[2]){      
                            // Получение изображения            
                            $url_img = varimit_get_mini_img_values( $arr_res[0][0] );
                            ?>                                    

                            <?php 
                            // Ссылка на товар
                            ?>
                            <a href="<?php echo get_permalink( $post->ID ); ?>">

                                <div class="varimit-mini-list">
                                    <div class="varimit-mini-list-img">

                                    <img id="mimi_url_list" src="<?php echo $url_img[0]['urlvalue'];?>" alt="">
                                                                                                 
                                    </div> <!-- varimit-mini-list-img -->
                                    <div class="varimit-mini-list-title">
                                    <?php
                                        // Название значения вариации                                                                     
                                        echo $arr_res[0][2];
                                        echo "<br>";   
                                    ?>
                                    </div> <!-- varimit-mini-list-title -->
                                </div> <!-- varimit-mini-list --> 
                            </a>  
                        <?php            				
                        } // if    		     
                        }	
                            wp_reset_postdata();                   
                        ?>

                    </div> <!-- varimit-popup-output -->

                    <?php // Попап для мобильных ?>
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
                        /**
                             * Проверяем значения вариации товаров с одинаковым идентификационным
                             * номером вариации
                             */                        
                              
                              // Убираем сам товар из списка  
                              $arr_id = array();
                              $arr_id[] = $product_id;                             
                              $result_post_in = array_diff( $product_id_arr, $arr_id );

                            $args_left = array(
                            'post_type' => 'product',                                                            
                            'post__in' => $result_post_in,        
                                
                            );

                            $query_mini = new WP_Query($args_left);
                            if( $query_mini->have_posts() ){
                                while( $query_mini->have_posts() ){            
                                    $query_mini->the_post();

                                   
                        if ($arr_res[0][2]!==$select_list[2]){          
                        ?>                           
                            <div class="col-xs-6">
                              
                            <a href="<?php echo get_permalink( $post->ID ); ?>">
                            <img id="mimi_url_list" src="<?php echo $url_img[0]['urlvalue'];?>" alt="">
                          
                            <?php                                                                     
                                echo $arr_res[0][2];
                                echo "<br>";                               
                            ?>
                            </a>
                            </div>   <!-- varimit-left-output -->      
                    <?php 
                        } // if           				
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
    } // foreach

    $total_count = 0;
    foreach($total_pred_arr as $docount){
        $total_count += $docount;
    }
   
    update_post_meta( $product_id, '_vari_val_count', $total_count );

   // $count_t = get_post_meta( $product_id, '_vari_val_count', true );

   // echo $count_t;
} // function
  
 
?>

