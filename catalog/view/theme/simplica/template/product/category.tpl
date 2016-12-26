<?php echo $header; ?>
<?php

//$text_clear_all = 'Очистить все';
    
//header("Content-Type: text/html; charset=UTF-8");
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
?>
    <main role="main">
        <noscript>
            <div class="b-js_off_alert">
                <p class="b-js_off_alert-copy">В Вашем браузере выключена функция Javascript. Пожалуйста, включите её, чтобы задействовать все возможности сайта.</p>
            </div>
        </noscript>
        <div class="h-hidden b-cookies_off js-disabled-cookies">
            <p class="b-cookies_off-copy">Ваш браузер в настоящее время не поддерживает Cookies. Пожалуйста, настройте Ваш браузер для приёма Cookies и проверьте, не блокирует ли их другая программа.</p>
        </div>
        <div class="l-primary_content">
            <div class="content-slot b-slot-grid_header">
                <div class="js-category-banner"></div>
            </div>
            <div class="l-search_result-options">
                <div class="l-search_result-wrapper">
                    <div class="l-filter_dropdown js-refinement_visibility">

                        <!-- Хлебные крошки. START -->
                        <div class="l-breadcrumb">
                            <ul class="b-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                                <?php $count = 0; ?>
                                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                                    <li class="b-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" <?php if ($count == 0) { echo ' style="display: none;"';} ?>>
                                        <a  class="b-breadcrumb-link" href="<?php echo $breadcrumb['href']; ?>" itemprop="item" title="<?php echo $breadcrumb['text']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
                                        <meta content="<?php echo $count++; ?>">
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- Хлебные крошки. END -->


                        <!-- Фильтры. START -->
                        <div class="b-refinement_dropdown">
                            <span class="b-refinement_dropdown-title js-custom-toggler" data-slide=".js-min_refinement_selector" data-toggle-class="h-minimized" data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-toggled" data-close-element=".b-filter-close_button"><?php echo $text_filter; ?></span>
                            <div class="b-refinement_dropdown-flyout js-min_refinement_selector js-custom-toggler-slide h-minimized">
                                <div class="b-refinement_containter">
                                    <div class="b-refinement_containter-sub">
                                        <div class="l-secondary_content l-refinements">
                                            <h2 class="h-hidden"><?php echo $text_search_detail; ?></h2>
                                            <span class="b-refinement-header">Купить Женское</span>
<?php
function print_children_list ( $list, $selected_attributes_alias, $category_alias,$language_href) {
    echo '<ul class="b-refinement-list">';

    foreach ( $list as $item ) {
        echo '<li class="b-refinement-item">';
        //echo '<a class="b-refinement-link " href="'.$item['keyword'].'">'.$item['name'].'</a>';
        $item['keyword'] = str_replace('-','@',$item['keyword']); 
        if ( strlen($selected_attributes_alias) > 0 AND strlen($item['keyword']) > 0 AND strpos($selected_attributes_alias, $item['keyword']) !== false) { 
            echo '<a class="b-refinement-link b-refinement-link--active" href="'.str_replace($item['keyword'].'-','',$selected_attributes_alias).$category_alias.'">'.$item['name'].'</a>';
        } else {
            if(!isset($manufacturer_main_category)){ 
                echo '<a class="b-refinement-link " href="/'.$language_href.$item['keyword'].'-'.$selected_attributes_alias.$category_alias.'">'.$item['name'].'</a>';
            }else{
                echo '<a class="b-refinement-link " href="/'.$language_href.$selected_attributes_alias.'-'.$item['keyword'].'">'.$item['name'].'</a>';
            }
        } 
        
        if ( isset($item['children']) && count($item['children']) != 0 ) {
            print_children_list( $item['children'] , $selected_attributes_alias, $category_alias,$language_href);
        }

        echo '</li>';
    }

    echo '</ul>';

    return;
}

function print_children_filter_list ( $list, $selected_attributes_alias, $category_alias,$language_href) {
    echo '<ul class="b-refinement-list">';
    
    foreach ( $list as $item ) {
        echo '<li class="b-refinement-item">';
        //echo '<a class="b-refinement-link " href="'.$item['keyword'].'">'.$item['name'].'</a>';
        
        //$item['keyword'] = str_replace('-','@',$item['keyword']); 
        if ( strpos($selected_attributes_alias, $item['keyword']) !== false) { 
            echo '<a class="b-refinement-link b-refinement-link--active" href="/'.$language_href.$item['keyword'].'">'.$item['name'].'</a>';
        } else { 
            echo '<a class="b-refinement-link " href="/'.$language_href.$item['keyword'].'">'.$item['name'].'</a>';
        } 
        
        if ( isset($item['children']) && count($item['children']) != 0 ) {
            print_children_list( $item['children'] , $selected_attributes_alias, $category_alias,$language_href);
        }

        echo '</li>';
    }

    echo '</ul>';   

    return;
}
?>

                                            <?php if ( isset($subcategories) && count($subcategories) > 0 ) { ?>
                                            <div class="b-refinement">
                                                <div class="b-refinement-sub_title js-mob-filter-popup-link"><?php echo $text_category; ?></div>
                                                <div class="js-scrollbar scrollbar-light b-refinement-ul js-mob-filter-popup h-mob-hidden">
                                                    <?php if ( isset($subcategories) AND count($subcategories) > 0) {
                                                        print_children_list($subcategories, $selected_attributes_alias, $category_alias,$language_href);
                                                    } ?>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <?php if ( isset($categories_is_filter) && count($categories_is_filter) > 0 AND $categories_is_filter) { ?>
                                            <?php $list = current($categories_is_filter); ?>
                                            <div class="b-refinement">
                                                <div class="b-refinement-sub_title js-mob-filter-popup-link"><?php echo $list['name']; ?></div>
                                                <div class="js-scrollbar scrollbar-light b-refinement-ul js-mob-filter-popup h-mob-hidden">
                                                    <?php if ( isset($list['children']) AND count($list['children']) > 0) {
                                                        print_children_filter_list($list['children'], $selected_attributes_alias, $category_alias,$language_href);
                                                    } ?>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <?php if ( isset($product_attributes) && count($product_attributes) > 0 ) { ?>
                                            <div class="b-refinement">
                                                <div class="b-refinement-sub_title js-mob-filter-popup-link"><?php echo $text_filter; ?></div>
                                                <div class="js-scrollbar scrollbar-light b-refinement-ul js-mob-filter-popup h-mob-hidden">
                                                    <ul class="b-refinement-list">
                                                    <?php foreach ($product_attributes as $attribut) { ?>
                                                        <li class="b-refinement-item">
                                                            <a class="b-refinement-link " href=""><?php echo $attribut['attribute_group_name']; ?></a>
                                                            <?php if ( isset($attribut['attributes']) && count($attribut['attributes']) > 0 ) { ?>
                                                            <?php foreach ($attribut['attributes'] as $attr) { ?>
                                                            <ul class="b-refinement-list">
                                                                <li class="b-refinement-item">

                                                                <?php if ( strpos($selected_attributes_alias, $attr['filter_name']) !== false) { ?>
                                                                    <a class="b-refinement-link b-refinement-link--active" href="/<?php echo $language_href; ?><?php echo str_replace($attr['filter_name'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attr['name']; ?></a>
                                                                <?php } else { ?>
                                                                    <?php if(isset($manufacturer_main_category)){ ?>
                                                                        <a class="b-refinement-link" href="/<?php echo $language_href; ?><?php echo $selected_attributes_alias.'-'.$attr['filter_name']; ?>"><?php echo $attr['name']; ?></a>
                                                                    <?php }else{ ?>
                                                                        <a class="b-refinement-link" href="/<?php echo $language_href; ?><?php echo $attr['filter_name'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attr['name']; ?></a>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                                </li>
                                                            </ul>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php } ?>


                                            <?php if ( isset($product_attribute_colors) && count($product_attribute_colors) > 0 ) { ?>
                                            <div class="b-refinement">
                                                <div class="b-refinement-sub_title js-mob-filter-popup-link"><?php echo $text_color; ?></div>
                                                <div class="js-scrollbar scrollbar-light b-refinement-ul js-mob-filter-popup h-mob-hidden">
                                                    <ul class="b-refinement-list">
                                                    <?php foreach ($product_attribute_colors['attributes'] as $attribut) { ?>
                                                        <li class="b-refinement-item">
                                                            <?php if ( strpos($selected_attributes_alias, $attribut['filter_name']) !== false) { ?>
                                                                <a class="b-refinement-link b-refinement-link--active" href="/<?php echo $language_href; ?><?php echo str_replace($attribut['filter_name'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                                                            <?php } else { ?>
                                                                <a class="b-refinement-link" href="/<?php echo $language_href; ?><?php echo $attribut['filter_name'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                                                            <?php } ?>

                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <?php if ( isset($manufacturers) AND count($manufacturers) > 0 AND is_array($manufacturers)) { ?>
                                            <div class="b-refinement">
                                                <div class="b-refinement-sub_title js-mob-filter-popup-link"><?php echo $text_manufacturer; ?></div>
                                                <div class="js-scrollbar scrollbar-light b-refinement-ul js-mob-filter-popup h-mob-hidden">
                                                    <ul class="b-refinement-list">
                                                    <?php foreach ($manufacturers as $attribut) { ?>
                                                        <li class="b-refinement-item">
                                                            <?php if ( strpos($selected_attributes_alias, $attribut['code']) !== false) { ?>
                                                                <a class="b-refinement-link b-refinement-link--active" href="/<?php echo $language_href; ?><?php echo str_replace($attribut['code'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                                                            <?php } else { ?>
                                                                <a class="b-refinement-link" href="/<?php echo $language_href; ?><?php echo $attribut['code'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                                                            <?php } ?>

                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php } ?>


                                            <?php if ( isset($sizes) && count($sizes) > 0 ) { ?>
                                            <div class="b-refinement b-refinement--clothingsize">
                                                <?php foreach ($sizes as $size_g) { ?>
                                                <div class="b-refinement-sub_title js-mob-filter-popup-link"><?php echo $size_g['name']; ?></div>
                                                <div class="js-scrollbar scrollbar-light b-refinement-ul js-mob-filter-popup h-mob-hidden">
                                                    <ul class="b-refinement-list">
                                                    <?php foreach ($size_g['product_option_value'] as $size) { ?>
                                                        <li class="b-refinement-item">

                                                            <?php if ( strpos($selected_attributes_alias, $size['name']) !== false) { ?>
                                                                <a class="b-refinement-link b-refinement-link--active" href="/<?php echo $language_href; ?><?php echo str_replace('sz_'.$size['name'].'-','',$selected_attributes_alias.$category_alias); ?>"><?php echo $size['name']; ?></a>
                                                            <?php } else { ?>
                                                                <a class="b-refinement-link" href="/<?php echo $language_href; ?><?php echo 'sz_'.$size['name'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $size['name']; ?></a>
                                                            <?php } ?>

                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>



                                        </div>
                                    </div>
                                    <div class="b-filter-buttons">
                                        <div class="b-filter-button_box">
                                            <span class="b-filter-close_button"><?php echo $text_close; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Фильтры. END -->


                        <!-- Сортировка. START -->
                        <div class="b-refinement_dropdown">
                            <div class="b-sortby_price_select sort-by">
                                <span class="b-refinement_dropdown-title js-custom-toggler" data-slide=".js-min_sortby_selector" data-toggle-class="h-minimized" data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-toggled" data-close-element=".b-filter-close_button"><?php echo $text_sort; ?></span>
                                <div class="b-refinement_price_range-value js-min_sortby_selector js-custom-toggler-slide h-minimized">
                                    <div class="b-refinement_containter">
                                        <?php foreach ($sorts as $sorts) { ?>
                                            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                                <a class="b-sortby_price_range-value_link js-sortby_price-value m-active" href="/<?php echo $language_href; ?><?php echo ltrim($selected_attributes_alias.$category_alias,'-'); ?><?php echo substr_replace($sorts['href'],'?',0,1); ?>"><?php echo $sorts['text']; ?></a>
                                            <?php } else { ?>
                                                <a class="b-sortby_price_range-value_link js-sortby_price-value" href="/<?php echo $language_href; ?><?php echo ltrim($selected_attributes_alias.$category_alias,'-'); ?><?php echo substr_replace($sorts['href'],'?',0,1); ?>"><?php echo $sorts['text']; ?></a>
                                            <?php } ?>
                                        <?php } ?>
                                        <div class="b-filter-buttons">
                                            <div class="b-filter-button_box">
                                                <span class="b-filter-close_button"><?php echo $text_close; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Сортировка. END -->


                        <!-- Отображение списка товарово (Список/Сетка). START -->
                        <div class="b-filter_view-header b-change_view">
                            <ul class="b-change_view-list">
                                <li style="list-style: none; display: inline">
                                    <div class="h-hidden js-view-selector"></div>
                                </li>
                                <li class="b-change_view-item"><span class="b-change_view-type b-change_view-type_four js-four-columns b-change_view-type-active" data-grid-class="m-four-columns"></span></li>
                                <li class="b-change_view-item"><span class="b-change_view-type b-change_view-type_two js-two-columns" data-grid-class="m-two-columns"></span></li>
                            </ul>
                        </div>
                        <!-- Отображение списка товарово (Список/Сетка). END -->

                        <?php
                        //Или категория или отрежем хвост
                        $clear_url = '/';
                        if($category_alias != ''){
                            $clear_url = $category_alias;
                        }else{
                            $tmp = explode('-', $_SERVER["REQUEST_URI"]);
                            $url = $tmp[count($tmp)-1];
                            if(count($tmp) == 1){
                                $clear_url = '';
                            }
                        }
                        ?>
                                 


                        <div class="l-breadcrumb-refinement_container">
                            <div class="js-breadcrumb-refinement_container b-breadcrumb-refinement_container">

                                <?php if ( ((isset($selected_categories)) OR
                                            (isset($selected_attributes_alias) && strlen($selected_attributes_alias) > 0) OR
                                                (isset($selected_sizes) AND count($selected_sizes))) AND 
                                                ($clear_url != '')) { ?>
                                    
                                    <?php if(isset($selected_categories)){ ?>
                                    <?php foreach ($selected_categories as $attr) { ?>
                              
                                        <span class="b-breadcrumb-refinement_value js-breadcrumb-refinement_selected">
                                            <?php echo '['.$attr['name'].']'; ?>
                                            <a class="b-breadcrumb-relax_image js-breadcrumb_refinement-link" href="/<?php echo $language_href; ?><?php echo str_replace(str_replace('-','@',$attr['keyword']).'-','',$selected_attributes_alias).$category_alias; ?>"></a>
                                        </span>
                                    <?php } ?>
                                    <?php } ?>
                                    
                                    <?php if ( isset($manufacturers) AND count($manufacturers) > 0 AND is_array($manufacturers)) { ?>
                                        <?php foreach ($manufacturers as $attr) { ?>
                                            <?php if ( strpos($selected_attributes_alias, $attr['code']) !== false) { ?>
                                                <span class="b-breadcrumb-refinement_value js-breadcrumb-refinement_selected">
                                                    <?php echo $attr['name']; ?>
                                                    <?php
                                                        $tmp = str_replace($attr['code'].'-','',$selected_attributes_alias);
                                                        $tmp = str_replace($attr['code'].'','/',$tmp);
                                                        $tmp = trim($tmp, '-');
                                                        
                                                    ?>
                                                    <a class="b-breadcrumb-relax_image js-breadcrumb_refinement-link" href="/<?php echo $language_href; ?><?php echo $tmp.$category_alias; ?>"></a>
                                                </span>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                
                                    <?php foreach ($selected_sizes as $attr) { ?>
                                        <span class="b-breadcrumb-refinement_value js-breadcrumb-refinement_selected">
                                            <?php echo $text_size.':'.$attr['name']; ?>
                                            <a class="b-breadcrumb-relax_image js-breadcrumb_refinement-link" href="/<?php echo $language_href; ?><?php echo str_replace('sz_'.$attr['name'].'-','',$selected_attributes_alias).$category_alias; ?>"></a>
                                        </span>
                                    <?php } ?>
                                    
                                    <?php foreach ($product_attributes as $attribut) { ?>
                                        <?php foreach ($attribut['attributes'] as $attr) { ?>
                                            <?php if ( strpos($selected_attributes_alias, $attr['filter_name']) !== false) { ?>
                                                <span class="b-breadcrumb-refinement_value js-breadcrumb-refinement_selected">
                                                    <?php echo $attr['name']; ?>
                                                    <a class="b-breadcrumb-relax_image js-breadcrumb_refinement-link" href="/<?php echo $language_href; ?><?php echo str_replace($attr['filter_name'].'-','',$selected_attributes_alias).$category_alias; ?>"></a>
                                                </span>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ( isset($product_attribute_colors) && count($product_attribute_colors) > 0 ) { ?>
                                        <?php foreach ($product_attribute_colors['attributes'] as $attr) { ?>
                                            <?php if ( strpos($selected_attributes_alias, $attr['filter_name']) !== false) { ?>
                                                
                                                <span class="b-breadcrumb-refinement_value js-breadcrumb-refinement_selected">
                                                    <?php echo $attr['name']; ?>
                                                    <a class="b-breadcrumb-relax_image js-breadcrumb_refinement-link" href="/<?php echo $language_href; ?><?php echo str_replace($attr['filter_name'].'-','',$selected_attributes_alias).$category_alias; ?>"></a>
                                                </span>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                   
                                <span class="b-breadcrumb-refinement_value js-clear_search_filters">
                                    <?php echo $text_clear_all; ?>
                                    <a class="b-breadcrumb-relax_image" href="/<?php echo $language_href; ?><?php echo $clear_url; ?>"></a>
                                </span>

                                <?php } ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="content-slot b-slot-grid_header"></div>

            <div class="l-search_result-content js-search_result-content m-search_layout-демонстрация m-four-columns">
                <div class="b-list_item_page js-list_item_page" data-page="1.0">
                    <div class="l-product_tiles">


                        <?php foreach ($products as $product) { ?>
                        <div class="b-product_tile js-product_tile b-product_tile--1" data-itemid="F61D5TFMME1S8031" data-product-name="<?php echo $product['name']; ?>" id="4982d3b862873672c1ef6a361b">
                            <div class="b-product-hover_box js-product-hover_box">
                                <a class="js-producttile_link b-product_image-wrapper" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>">
                                <img alt="<?php echo $product['name']; ?>" class="js-producttile_image b-product_image" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" data-altimage="<?php echo $product['thumb_second']; ?>" >
                                </a>

                                <div class="b-productile_hover">
                                    <div class="b-productile_hover-inner">
                                        <div class="b-productile_hover-middle_box">
                                            <div class="b-productile_hover-middle_box_inner">
                                                <div class="js-product_variations b-product_variations--plp" data-current="{}">
                                                    <div class="b-variation">
                                                        <ul class="b-variation-list">
                                                            <li class="b-variation-item b-variation-item--size">
                                                                <div class="b-variation-dropdown">
                                                                    <div class="b-variation-value Size">
                                                                        <div class="b-variation-title">
                                                                            <?php echo $text_select_size; ?>
                                                                        </div>
                                                                        <div class="b-variation-size_chart_link js-size_chart_link" data-href="/<?php echo $language_href; ?>">
                                                                            <span><?php echo $text_size_help; ?></span>
                                                                        </div>

                                                                    
                                                                    <?php if ($product['options']) { ?>

                                                                        <?php foreach ($product['options'] as $option) { ?>
                                                                            <?php if ($option['type'] == 'radio') { ?>
                                                                            <ul class="b-swatches_size">
                                                                                <?php foreach ($option['product_option_value'] as $option_value) { ?>

                                                                                <?php if($option_value['quantity'] <= 0) { ?>
                                                                                <li class="b-swatches_size-item emptyswatch m-unselectable">
                                                                                    <span class="b-swatches_size-link"><?php echo $option_value['name']; ?></span>
                                                                                </li>
                                                                                <?php }else{ ?>
                                                                                <li class="b-swatches_size-item emptyswatch">
                                                                                    <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>?option[<?php echo $option['product_option_id']; ?>]=<?php echo $option_value['product_option_value_id']; ?>" class="b-swatches_size-link"><?php echo $option_value['name']; ?></a>
                                                                                </li>
                                                                                <?php } ?>

                                                                                <?php } ?>
                                                                            </ul>

                                                                            <?php } ?>
                                                                        <?php } ?>

                                                                    <?php }else{ ?>
                                                                        <div class="b-swatches_size-item emptyswatch"><?php echo $text_onesize; ?></div>
                                                                    <?php } ?>

                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="b-variation-item">
                                                                <div class="b-variation-dropdown">
                                                                    <div class="b-variation-value color">
                                                                        <span class="b-variation-title">цвет</span> <span class="js_color-description">Черный</span>
                                                                        <ul class="js-swatches b-swatches_color">
                                                                            <li class="b-swatches_color-item b-swatches_color-item-selected">
                                                                                <a class="js-swatches_color-link js-swatches_color-link-selected b-swatches_color-link-selected b-swatches_color-link" data-lgimg="{&quot;url&quot;:&quot;http://demandware.edgesuite.net/sits_pod25/dw/image/v2/AAGA_PRD/on/demandware.static/-/Sites-15/default/dwa582dcac/images/zoom/F61D5TFMME1_S8031_0.jpg?sw=804&amp;sh=1200&amp;sm=fit&quot;, &quot;title&quot;:&quot;ПЛАТЬЕ А-СИЛУЭТА ИЗ ШЕРСТЯНОГО ТВИДА&quot;, &quot;alt&quot;:&quot;ПЛАТЬЕ А-СИЛУЭТА ИЗ ШЕРСТЯНОГО ТВИДА&quot;, &quot;hires&quot;:&quot;http://demandware.edgesuite.net/sits_pod25/dw/image/v2/AAGA_PRD/on/demandware.static/-/Sites-15/default/dwa582dcac/images/zoom/F61D5TFMME1_S8031_0.jpg?sw=1571&amp;sh=2000&amp;sm=fit&quot;}"
                                                                                   data-thumbs=".js-thumbs-F61D5TFMME1S8031" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" style="background-color: #000000;" title="Черный"></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <a class="js-producttile_name b-product_name product_name" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="js-producttile_name b-product_name product_name" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>


                            <div class="b-product_price" style="">
                                <h4 class="b-product_price-standard" style="">
                                    <?php if ($product['price']) { ?>
                                          <?php if (!$product['special']) { ?>
                                          <?php echo $product['price']; ?>
                                          <?php } else { ?>
                                          <span class="b-product_price--old"><?php echo $product['price']; ?></span> <span class="b-product_price--new"><?php echo $product['special']; ?></span>
                                          <?php } ?>
                                          <?php if ($product['tax']) { ?>
                                          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                          <?php } ?>
                                        
                                    <?php } ?>
                                </h4>
                            </div>

                            <div class="b-product_labels"></div><!-- i.e. for category pages and productlistings, is multiple -->

                            <div class="b-stars" id="pr_snippet_category_eb4a072633fc70c126cf01c646">
                                <script type="text/javascript">
                                //if (typeof POWERREVIEWS != "undefined") { 
                                //POWERREVIEWS.display.snippet({write : function(content) { jQuery('#pr_snippet_category_eb4a072633fc70c126cf01c646').append(content); }}, 
                                //{
                                //pr_page_id : 'F61D5TFMME1S8031', 
                                //pr_snippet_min_reviews : '0'
                                //}
                                //)
                                //}
                                </script>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            
            <?php echo $pagination; ?>
            
        </div>
        
    </main>

<!-- <link href="/catalog/view/theme/simplica/stylesheet/jquery.scrollbar.css" rel="stylesheet"> -->
<!-- <script src="catalog/view/theme/simplica/js/jquery.scrollbar.min.js" type="text/javascript"></script> -->
<script>
    //$('.js-scrollbar').scrollbar();
</script>


<script>
    $('.js-mob-filter-popup-link').on('click', function(){
        $(this).siblings('.js-mob-filter-popup').toggleClass('h-mob-hidden');
    });
</script>


<?php
//header("Content-Type: text/html; charset=UTF-8");
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<style> pre header {display: none;}</style>";
?>

<?php echo $footer; ?>
