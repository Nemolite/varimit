<?php
/**
 * Модуль вывода вариации в карточке товра
 */
  /**
  * Вывод вариации в карточке товара, через хук
  */
  add_action( 'woocommerce_single_product_summary','varimit_display_in_single_product',15 ); 
  function varimit_display_in_single_product() { 
    if( is_product_category() || is_product() ) {    
    ?>
        <div class="varimit-output-single-product">           
            <?php       

            varimit_display_variation_single_product();                                           
                    
            ?>
        </div>
       
    <?php
    }
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

    /**
     * По входным id, получаем разбросанный по 
     * вариациям id
     */
    $razbros_vari = varimit_razbor_vari($product_id_arr,$meta_values,$product_id );   
   
if(!empty($razbros_vari)){


    // С данным мета полем будем рабоать
    $etalon = '_varimit__product_value_';

    // Находим свои вариации
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

            $proverka = $etalon.$var_id;
            $mak_prov = "false";
    foreach($razbros_vari as $vr_dbet){
    
      foreach($vr_dbet as $ker_val =>$ker_id){
        if(($ker_val==$proverka)&&($mak_prov == "false")){
            $mak_prov = "true";
            // Получаем имя вариации по id
            if( !is_array($var_id) ) {
                $name_variation = varimit_get_data_variation_cart($var_id);
            }
     
            /**
             * Проверяем ,есть ли еще товар с такой вариацией в
             * с данным идентификатором
             */
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
            // если найдено только одно id, значит товаров с такой вариацией
            // больше нет и не отображаем его
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
                      <div class="varimit-popup-output-wrapper">
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
                            <div class="varimit-popup-output-inner">
                            <?php
                            
                            /**
                             * Проверяем значения вариации товаров с одинаковым идентификационным
                             * номером вариации
                             */                        
                              
                              // Убираем сам товар из списка  
                              $arr_id = array();
                              $arr_id[] = $product_id;                             
                              $result_post_in = array_diff( $product_id_arr, $arr_id );


                                $amba = array();
                                foreach($razbros_vari as $v_key => $v_dbet){

                                    foreach($v_dbet as $ke_val => $ke_id){
                                        if($ke_val==$key_vari){
                                            $amba[] = $ke_id;
                                        }    
                                    }
                                }

                                if(empty($amba)){
                                    $amba[] = $product_id;
                                }                          

                                // Сортировка 

                                if (count($amba)>1){                          

                                    $proverka = $etalon.$var_id;                               

                                    $sort_slug = array();
                                    foreach($amba as $amba_id){
                                        $exin = get_post_meta($amba_id, $proverka, false);                                
                                    // $exin[0][1] - slug

                                    $prioritet = varimit_get_prioritet_structure($var_id, $exin[0][1]);

                                        $sort_slug[$prioritet] = $amba_id;
                                        
                                    }  //  foreach  $amba                             

                                    ksort($sort_slug);

                                    $sort_listing = array();
                                    foreach($sort_slug as $sorting){
                                        $sort_listing[] = $sorting;
                                    }                           
          
                                } elseif(count($amba)==1) {
                                    $sort_listing[] = $amba[0];
                                } // if $amba

                                $args = array(
                                'post_type' => 'product',                                    
                               'include' => $sort_listing,
                               'orderby' => 'post__in',
                               'suppress_filters' => 'false',
                               'posts_per_page' => -1,
                                    
                                );
                                
                            $posts = get_posts($args);
                               
                            foreach( $posts as $post ){
                                    setup_postdata($post);                         
                                    
                                ?>
                                <?php
                           
                                    // Получения данных о значении вариации                          
                                    $arr_res =  varimit_get_mini_name_values(  $var_id, $post->ID  );                     

                                if ( ($arr_res[0][2]!==$select_list[2])&&(!empty($arr_res) ) ){      
                                    // Получение изображения            
                                        $url_img = varimit_get_mini_img_values( $arr_res[0][1] );
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
                            }	// foreach $post
                            wp_reset_postdata();                   
                        ?>
                       </div>
                       </div>
                    </div> <!-- varimit-popup-output -->

                    <?php // Попап для мобильных ?>
                    <div class="varimit-left-output" id ="left_<?php echo esc_attr( $var_id ); ?>">
                    
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

                        <div class="varimit_left_mini_content">                          
                        <?php                       
                          $args_left = array(
                            'post_type' => 'product',                                                                                         
                           'include' => $sort_listing,
                           'orderby' => 'post__in',
                           'suppress_filters' => 'false', 
                           'posts_per_page' => -1,                       
                                
                            );
                            
                            $posts_left = get_posts($args_left);
                           
                            foreach( $posts_left as $post_mini ){ 
                                setup_postdata($post_mini);                        
                                    ?>                       
                                    <?php
                                   
                                    // Получения данных о значении вариации                          
                                    $arr_res =  varimit_get_mini_name_values(  $var_id, $post_mini->ID  );                     
        
                                if ( ($arr_res[0][2]!==$select_list[2])&&(!empty($arr_res) ) ){      
                                    // Получение изображения            
                                    $url_img = varimit_get_mini_img_values( $arr_res[0][1] );         
                                    ?>                           
                                    <div class="varimit_left_inner">
                                    
                                    <a href="<?php echo get_permalink( $post_mini->ID ); ?>">
                                    <span class="varimit_left_img-wrap">
                                        <img id="mimi_url_list_left" src="<?php echo $url_img[0]['urlvalue'];?>" alt="">
                                    </span>
                                    <p>
                                    <?php                                                                     
                                        echo $arr_res[0][2];
                                        echo "<br>";                               
                                    ?>
                                    </p>
                                    </a>
                                    </div>   <!-- varimit-left-output -->      
                                <?php 
                                } // if           				
                            }	// foreach $post_mini                    
              
                        wp_reset_postdata();                   
                    ?>
                    </div> <!-- varimit_left_mini_content -->
                </div> <!-- varimit-left-output -->
        
              </div> <!-- varimit-output-single-product-inner -->
              <?php
                } // if $select_list[2] 
            ?>  
            <?php
            } // 'notselect'!==$select_list[1]
                   
        } // if ($ker_val==$proverka)&&($mak_prov == "false")
      } // foreach  $vr_dbet as $ker_val =>$ker_id

    } // foreach($razbros_vari as $vr_dbet){
  } //  if (str_contains( $key_vari, $etalon))
} // foreach ($meta_values as $key_vari => $val){

} //if(!empty($razbros_vari)){

} // function 
?>