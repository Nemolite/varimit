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

    global $wp_query;
    // Получаем id продукта
    $product = wc_get_product( $wp_query->post );
    $id = $product->get_id(); 

    // Извлекаем все мета поля данного товара в виде массива
    $key = ''; 
    $single =false; 
    $meta_values = get_post_meta( $id, $key, $single );


    // Получаем идентификатор вариации
    $iden_vari = varimit_get_iden_from_products( $id );

    // Получаем массив id продуктов с данным идентификатором
    if (isset($iden_vari)&&$iden_vari!==''){
      $product_id_arr = varimit_get_array_id_product($iden_vari);
    }

     // Убираем сам товар из списка и переиндексируем 
     $arr_id = array();
     $arr_id[] = $id;                             
     $products_id_iden_arr = array_values(array_diff( $product_id_arr, $arr_id ));

    // show($products_id_iden_arr);
/*
     foreach($products_id_iden_arr as $id_pr){
        $display_name = varimit_get_name_product_on_id($id_pr);
        echo $id_pr."=".$display_name;
        echo "<br>";
     }
*/
    //show($meta_values);
    /**
     * Начало проверечного кусочка кода ()  _varimit__product_value 
     */
    
    $sovpad_arr=array();
$cabunker = 0;
   foreach ($meta_values as $varimit_product_value => $varimit_product_value_meta_box){
    if (strpos($varimit_product_value, '_varimit__product_value') !== false) {
    //   show($varimit_product_value);      

       $cabunker++;

       foreach($varimit_product_value_meta_box as $values_box){
         
        // show(unserialize($values_box));
         /**
          * Ищем совпадения по значению вариации
          * Входные параметры
          * $varimit_product_value Имя мета поля
          * $products_id_iden_arr - массив товаров с одинаковым идентификатором вариации 
          * (что бы не перебирать все товары)
          * $id - этого товара   
          *
          * Если зачения вариации этого товара совпадет со значением вариации остальных товаров 
          * то вернет true
          * если нет то false
          * Результат записываем в двумерный массив $sovpad_arr[][]
          */
          $sovpad_arr[$varimit_product_value]  = varimit_check_id_in_products_iden($varimit_product_value, $products_id_iden_arr, $id ); 


         
       }
     }
   }

// show($sovpad_arr);

foreach($products_id_iden_arr as $velue_bert_id){

    foreach ($sovpad_arr as $value_meta_boxes) {
        foreach ($value_meta_boxes as $key_id_formated => $value_locic) {
           if(($velue_bert_id==$key_id_formated)&&($value_locic=="true") ){
               $alegon[$velue_bert_id]++;
           }
       
         }
      
    }
}
    // show($alegon);
     $news_pere = array();
foreach($alegon as $k_id_modul => $lociminal){
    if (($cabunker-1)==$lociminal){
        $news_pere[] = $k_id_modul;
    }
}
  

   // show($news_pere);

        foreach($sovpad_arr as $nonen => $value_wer){
           
            foreach( $value_wer as $key_idf => $value_idf){

                foreach($news_pere as $valwes){

               
                  if( ($key_idf==$valwes)&&( $value_idf=="false") ){

                   $absser[$nonen] = $valwes;

                   }
                }
         
            }
        }   

    /**
     * Конец прверченого кусочкка кода
     */ 
    
    // Извлекаем значение индентификатора вариации
    $varimit_iden = get_post_meta( $id, '_varimit_iden', true );

    // Находим все товары, которые имеют такой же идентификатор
    $arr_id_iden = varimit_get_product_union_iden( $varimit_iden ); 
    //show($arr_id_iden);



    // С данным мета полем будем рабоать
    $etalon = '_varimit__product_value_';

    // Перебираем мета поля и из них выбираем только _varimit__product_value_{id}
    foreach ($meta_values as $key => $val){
         if (str_contains( $key, $etalon)) {

           foreach($absser as $kesq => $vurq){
                if ($kesq == $key) {
                    $arr_inner_ci[] = $vurq;
                }
           }
            $select_list = unserialize($val[0]);                    

            // Извлекаем id вариации
            $var_id = $select_list[0];

            // Получаем имя вариации по id
            if( !is_array($var_id) ) {
                $name_variation = varimit_get_data_variation_cart($var_id);
            }

            /**
             * Испрользуя Функцию получения совпадающих вариации
             * получаем массив id продуктов которые имеют вариации 
             */  
            $arr_var_check = varimit_get_array_variation_for_product( $var_id );
           
            // Отсекаем тех которые не входят в данный идентификатор вариации
            $for_post_in = array_intersect( $arr_id_iden, $arr_var_check );

            /**
             * Проверка , если только один id то вероятно это сам товар
             * Если так , то выставляем маркер false
             */

            if ( 1===count($for_post_in) ) {
                  $marker_one = "false";                 
            } else {
                $marker_one = "true"; 
            }           
           
            /**
             * Проверяем значение имени массива, если массив раннеее был выбран, и
             * позже удален не пропускаем в обработку
             * А также не пропускаем если марке false 
             */
            if( ('notselect'!==$select_list[1])
                &&("true"==$marker_one)
                &&(!empty($arr_inner_ci) )
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
                            
                               // Получаем совпадения вариации
                              $post_in_arr = varimit_get_array_variation_for_product( $var_id );
                              
                              // Отсекаем тех кто не подходит по идентификатору
                              $for_post_in = array_intersect( $arr_id_iden, $post_in_arr );
                              
                              // Убираем сам товар из списка  
                              $arr_id = array();
                              $arr_id[] = $id;                             
                              $result_post_in = array_diff( $for_post_in, $arr_id );                          
             

                                $args = array(
                                'post_type' => 'product',
                                'numberposts' => -1,  
                                'include' => $arr_inner_ci,
                              //  'include' => $result_post_in,        
                                    
                                );
                                
                                $posts = get_posts($args);
                               
                                foreach( $posts as $post ){
                                    setup_postdata($post);                                   
                          
                                    
                            ?>
                            <?php
                            // Получения данных о значении вариации
                            $arr_res =  varimit_get_mini_name_values(  $var_id, $post->ID  );
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
                            'include' => $arr_inner_ci,
                          //  'post__in' => $result_post_in,        
                                
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
    } 
  } 
  
 
?>

