<?php
/**
 * Модуль вывода вариации в карточке товра
 */
  /**
  * Вывод вариации в карточке товара, через хук
  */
  add_action( 'woocommerce_single_product_summary','varimit_display_in_single_product',15 ); 
  function varimit_display_in_single_product() {
    global $wp_query;        
    $product_id = $wp_query->post->ID;  
    $post_in_arr = get_option('post_in_arr'); 

    if (in_array($product_id, $post_in_arr)) {
        if( is_product_category() || is_product() ) {    
        ?>
            <div class="varimit-output-single-product">           
                <?php       

                varimit_display_variation_single_product($product_id);                                           
                /**
                 * Функция отображения вариации в карточке товара
                 */
                // varimit_display_list_variation_in_cart();        
                ?>
            </div>
        
        <?php
        }
    }    
  } 

/**
* Функция вывода ссылок на попап вариативных товаров
*  
*/
function varimit_display_variation_single_product($product_id) {             

    // Извлекаем все мета поля данного товара в виде массива   
    $meta_values = get_post_meta( $product_id, '', false );

    // Получаем идентификатор вариации
    $product_iden_vari = get_post_meta( $product_id, '_varimit_iden', false ); 
   
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
                       
                            echo "<b>". esc_html( $name_variation[0]['namevari'] ) ."</b>";
                            echo "<br>";
                           
                            echo esc_html( $select_list[2] );                       
                       
                        ?>
                        </div> <!-- varimit-output-single-product-inner-left -->
               
                        <?php varimit_svg_right(); ?>

                    <div class="varimit-popup-output" id ="modal_<?php echo esc_attr( $var_id ); ?>">
                      <div class="varimit-popup-output-wrapper">
                        <div class="varimit-popup-output-title">
                      <?php echo "<b>". esc_html( $name_variation[0]['namevari'] ) ."</b>"; ?>
                        </div> <!-- varimit-popup-output-title -->

                            <?php varimit_display_svg_desktop($var_id ); ?>

                            <div class="varimit-popup-output-inner">
                            <?php
                            
                            /**
                             * Проверяем значения вариации товаров 
                             * с одинаковым идентификационным
                             * номером вариации
                             */                       
                             
                            $amba = varimit_delete_self_product($product_id_arr,$product_id,$razbros_vari,$key_vari);                       

                            // Сортировка 

                            $sort_listing = varimit_sort_ids_for_query($var_id,$amba);

                               $args = array(
                               'post_type' => 'product',                                    
                               'post__in' => $sort_listing,
                               'orderby' => 'post__in',                               
                               'posts_per_page' => 50,
                                    
                                );                          
                            $query = new WP_Query( $args );

                            if ( $query->have_posts() ) {
                                while ( $query->have_posts() ) {
                                    $query->the_post();
                                    $post_desk_id = get_the_ID(); 
                                    // Получения данных о значении вариации                          
                                    $arr_res =  varimit_get_mini_name_values(  $var_id, $post_desk_id );                                     
                                   
                                ?>
                                
                               <?php varimit_display_product_desktop($arr_res,$select_list, $post_desk_id); ?>
                                <?php  		     
                                }	// while
                            }	// if

                            wp_reset_postdata();                   
                        ?>
                       </div> <!-- varimit-popup-output-inner -->
                       </div> <!-- varimit-popup-output-wrapper -->
                    </div> <!-- varimit-popup-output -->

                    <?php // Попап для мобильных ?>
                    <div class="varimit-left-output" id ="left_<?php echo esc_attr( $var_id ); ?>">
                    
                    <div class="varimit-popup-output-title"> 
                    <?php echo "<b>". esc_html( $name_variation[0]['namevari'] ) ."</b>"; ?>
                    </div> <!-- varimit-popup-output-title -->

                        <?php varimit_display_svg_mini($var_id); ?> 

                        <div class="varimit_left_mini_content">                          
                        <?php                       
                          $args_left = array(
                           'post_type' => 'product',                                                                                         
                           'post__in' => $sort_listing,
                           'orderby' => 'post__in',                           
                           'posts_per_page' => 50,                       
                                
                            );                          
                     
                            $query_left = new WP_Query( $args_left );

                            if ( $query_left->have_posts() ) {
                                while ( $query_left->have_posts() ) {
                                    $query_left->the_post();
                                    // Получения данных о значении вариации  
                                    $post_mini_id = get_the_ID();                        
                                    $arr_res =  varimit_get_mini_name_values(  $var_id, $post_mini_id  );                     
                                ?>                            
                            <?php varimit_display_product_mini($arr_res,$select_list, $post_mini_id ) ?>

                                <?php          				
                                }	// while                    
                            } //
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

/**
 * Модуль сортировки
 */
function varimit_sort_ids_for_query($var_id,$amba){
    if (count($amba)>1){   

        $etalon = '_varimit__product_value_';

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

    return $sort_listing;
}

/**
* Проверяем значения вариации товаров 
* с одинаковым идентификационным
* номером вариации
*/
function varimit_delete_self_product($product_id_arr,$product_id,$razbros_vari,$key_vari){
      // Убираем сам товар из списка  
      $arr_id = array();
      $arr_id[] = $product_id;                                  

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
    return $amba;     
}

/**
 * SVG desktop
 */

 function varimit_display_svg_desktop($var_id ){
     ?>
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
 }

/**
*   SVG mini
*/

function varimit_display_svg_mini($var_id){
    ?>
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
}

/**
 * Отображение вариации в мобильной версии
 */

 function varimit_display_product_mini($arr_res,$select_list, $post_mini_id ){
    
    if ( ($arr_res[0][2]!==$select_list[2])&&(!empty($arr_res) ) ){      
        // Получение изображения            
        $url_img = varimit_get_mini_img_values( $arr_res[0][1] );         
        ?>                           
        <div class="varimit_left_inner">
        
            <a href="<?php echo get_permalink( $post_mini_id ); ?>">
            <span class="varimit_left_img-wrap">
                <img id="mimi_url_list_left" src="<?php echo esc_url($url_img[0]['urlvalue']);?>" alt="">
            </span>
            <p>
            <?php                                                                     
                echo esc_html($arr_res[0][2]);
                echo "<br>";                               
            ?>
            </p>
            </a>
        </div>   <!-- varimit-left-output -->      
    <?php 
        } // if 
 }

 /**
  *   Отображение вариации в десктоп
  */

  function varimit_display_product_desktop($arr_res,$select_list, $post_desk_id){
   
    if ( ($arr_res[0][2]!==$select_list[2])&&(!empty($arr_res) ) ){      
        // Получение изображения            
            $url_img = varimit_get_mini_img_values( $arr_res[0][1] );
            ?>                                    

            <?php 
            // Ссылка на товар
            ?>
            <a href="<?php echo get_permalink( $post_desk_id ); ?>">

                <div class="varimit-mini-list">
                    <div class="varimit-mini-list-img">

                    <img id="mimi_url_list" src="<?php echo esc_url($url_img[0]['urlvalue']);?>" alt="">
                                                                                
                    </div> <!-- varimit-mini-list-img -->
                    <div class="varimit-mini-list-title">
                    <?php
                        // Название значения вариации                                                                     
                        echo esc_html($arr_res[0][2]);
                        echo "<br>";   
                    ?>
                    </div> <!-- varimit-mini-list-title -->
                </div> <!-- varimit-mini-list --> 
            </a>  
        <?php            				
    } // if  
   
  }

  /**
   * SVG right
   */

function varimit_svg_right(){
    ?>
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
    <?php
}   
?>