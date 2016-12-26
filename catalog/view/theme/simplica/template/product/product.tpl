<?php echo $header; ?>

<?php
/*
$text_size_table = 'Таблица размеров';
$text_help_is_needed = 'Если Вам необходима дополнительная поддержка, пожалуйста, свяжитесь с нашей Клиентской службой по email:';
$text_prev = 'Предыдущее';
$text_next = 'Далее';
$text_material = 'материал';
$text_message_1 = 'Оповестить меня, когда он снова будет доступен.';
$text_add_to_wishlist = 'В список желаний';
$text_added_to_wishlist = 'Этот товар добавлен в Ваш список желаний';
$text_delivery_info = 'Вы можете найти информацию о доставке и возвате';
$text_zdes = 'здесь';
$text_send_to_frend = 'Отправить другу';
$text_no_product = 'Этот товар недоступен в настоящее время.';
$text_send_me_msg = 'Оповестить меня, когда он снова будет доступен.';
$text_confirm = 'Подтвердить';
$text_error_email = 'Пожалуйста, введите Email';
$text_politic = 'Подтверждая, Вы соглашаетесь с нашей</span> <a class="b-notifyme_form-privacy_link" href="privacy-policy.html" id="privacyPolicyNL" target="_blank" title="Политика конфиденциальности">Политика конфиденциальности</a>';
*/
//$email = 'mail@plazamilano.com';
?>

<span class="h-hidden">
    <div class="b-table-size_popup js-table-size_popup">
        <div class="b-size_guide">

            <p class="b-size_guide-title"><?php echo $text_size_table; ?></p>
            <p class="b-size_guide-text">
                <?php echo $text_help_is_needed.' '.$email; ?></p>

            <?php foreach($options_table as $name_options_group => $options_group) { ?>
            <p class="b-size_guide-title"><?php echo $name_options_group; ?></p>
            <table class="b-size_guide-table">
                <tbody>
                    <?php foreach($options_group as $val) { ?>

                    <?php
                    $tmp = $options_group;
                    reset($tmp);
                    next($tmp);
                    $first_key_data = key($tmp);
                    ?>

                    <tr>
                        <?php foreach($val as $k => $v) { ?>
                            <?php if ($options_group[$first_key_data][$k]) { ?>
                            <td><?php echo $v; ?></td>
                            <?php } ?>
                        <?php } ?>
                    </tr>

                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>

        </div>
    </div>
</span>


<main role="main" class="l-pdp js-pdp_main" itemscope="" itemtype="http://schema.org/Product"> 

    <div class="l-pdp_primary_content js-pdp_primary_content">
        <div class="b-product_header">

            <!-- Хлебные крошки. START -->
            <ul class="b-product_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <?php $count = 0; ?>
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li class="b-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" <?php if ($count == 0) { echo ' style="display: none;"';} ?>>
                        <a  class="b-breadcrumb-link js-breadcrumb_refinement-link" href="<?php echo $breadcrumb['href']; ?>" itemprop="item" title="<?php echo $breadcrumb['text']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
                        <meta content="<?php echo $count++; ?>">
                    </li>
                <?php } ?>
            </ul>
            <!-- Хлебные крошки. END -->

            <div class="b-product_nav">
                <a class="b-product_nav-link_prev" href="#" title="">
                    <span class="b-product_nav-text_prev"><?php echo $text_prev; ?></span>
                </a>
                <a class="b-product_nav-link_next" href="#" title="">
                    <span class="b-product_nav-text_next"><?php echo $text_next; ?></span>
                </a>
            </div>
        </div>



        <div class="l-product_images_container">
            <div class="l-product_images_container-wrap js-product_images_container-zoom">
                <div class="js-thumb_slider b-product_thumbnails">
                    <ul class="b-product_thumbnails-list">
                        <li class="b-product_thumbnail" data-img-popup="<?php echo $thumb; ?>">
                            <a href="<?php echo $_SERVER['REDIRECT_URL']; ?>#slide0">
                                <img alt="<?php echo $heading_title; ?>" class="b-product_thumbnail-image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>">
                            </a>
                        </li>
                        <?php $count = 0; ?>
                        <?php foreach ($images as $img) { ?>
                        <li class="b-product_thumbnail" data-img-popup="<?php echo $img['popup'];?>">
                            <a href="<?php echo $_SERVER['REDIRECT_URL'].'#slide'.++$count; ?>">
                                <img alt="<?php echo $heading_title; ?>" class="b-product_thumbnail-image" src="<?php echo $img['thumb'];?>" title="<?php echo $heading_title; ?>">
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="b-product_primary_image owl-carousel js-owl-carousel">
                    <div class="product-image" data-hash="slide0">
                            <img alt="<?php echo $heading_title; ?>" class="b-product_image js-thumb_image_zoom" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>">
                    </div>
                    <?php $count = 0; ?>
                    <?php foreach ($images as $img) { ?>
                    <div class="product-image" data-hash="slide<?php echo ++$count; ?>">
                            <img alt="<?php echo $heading_title; ?>" class="b-product_image js-thumb_image_zoom" src="<?php echo $img['popup'];?>" title="<?php echo $heading_title; ?>">
                    </div>
                    <?php } ?>
                </div>
                <div class="h-hidden js-fancybox-img">
                    <div class="b-product_primary_image">
                    <div class="product-image js-container_main_image">
                            <img alt="<?php echo $heading_title; ?>" class="b-product_image js-fancybox-img js-thumb_image_zoom" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>">
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- /l-product_images_container -->

        <div class="l-product-details js-product_detail js-product_detail-fixed-images" id="product">
            <div class="l-product-details-wrapper">
                <div class="b-product_content js-product_content">
                    <h1 class="b-product_container-title"><span class="b-product_name"><?php echo $heading_title; ?></span></h1>
                    <h2 class="b-product_container-price">
                        <div style="" class="b-product_price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                            <h4 style="" class="b-product_price-standard ">
                            <?php if ($price) { ?>
                                <?php if (!$special) { ?>
                                    <?php echo $price; ?>
                                <?php }else{ ?>
                                    <span class="b-product_price--old"><?php echo $price; ?></span>
                                    <span class="b-product_price--new"><?php echo $special; ?></span>
                                <?php } ?>
                            <?php } ?>
                            </h4>

                            <meta itemprop="price" content="<?php echo $price; ?>">
                            <meta itemprop="priceCurrency" content="EUR">
                            <meta itemprop="availability" itemtype="http://schema.org/ItemAvailability" content="http://schema.org/InStock">
                        </div>
                    </h2>
                    <div class="js-product_number h-hidden">
                        Товар <span itemprop="productID"><?php echo $model; ?></span>
                    </div>

                    <div class="js-product_variations b-product_variations--pdp" data-current="{}">
                        <div class="b-variation">
                            
                            <ul class="b-variation-list">
                                
                                
                                <li class="b-variation-item">
                                    <div class="b-variation-dropdown">
                                        <div class="b-variation-value">
                                            <span class="b-variation-title"><?php echo $text_brand; ?></span>
                                            <span class="b-variation-brand_link"> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></span>
                                        </div>
                                    </div>
                                </li>
                            
                          

                                <?php if ($attribute_colors) { ?>
                                <li class="b-variation-item">
                                    <div class="b-variation-dropdown">
                                        <div class="b-variation-value color">

                                            <span class="b-variation-title"><?php echo $text_color; ?></span> <span class="js_color-description">
                                                <?php
                                                $line = '';
                                                foreach($attribute_colors as $color){
                                                    $line .= $color['name'] .', ';
                                                }
                                                echo trim($line,', ');
                                                ?>
                                            </span>
                                            
                                            <!--ul class="js-swatches b-swatches_color">
                                                <?php foreach ($attribute_groups as $attribute_group) { ?>
                                                <li class="b-swatches_color-item b-swatches_color-item-selected">
                                                    <a class="js-swatches_color-link js-swatches_color-link-selected b-swatches_color-link-selected b-swatches_color-link"
                                                       data-lgimg="{&quot;url&quot;:&quot;http://demandware.edgesuite.net/sits_pod25/dw/image/v2/AAGA_PRD/on/demandware.static/-/Sites-15/default/dwa582dcac/images/zoom/F61D5TFMME1_S8031_0.jpg?sw=804&amp;sh=1200&amp;sm=fit&quot;, &quot;title&quot;:&quot;ПЛАТЬЕ А-СИЛУЭТА ИЗ ШЕРСТЯНОГО ТВИДА&quot;, &quot;alt&quot;:&quot;ПЛАТЬЕ А-СИЛУЭТА ИЗ ШЕРСТЯНОГО ТВИДА&quot;, &quot;hires&quot;:&quot;http://demandware.edgesuite.net/sits_pod25/dw/image/v2/AAGA_PRD/on/demandware.static/-/Sites-15/default/dwa582dcac/images/zoom/F61D5TFMME1_S8031_0.jpg?sw=1571&amp;sh=2000&amp;sm=fit&quot;}"
                                                       data-thumbs=".js-thumbs-F61D5TFMME1S8031"
                                                       href="/%D0%B6%D0%B5%D0%BD%D1%81%D0%BA%D0%BE%D0%B5/%D0%BE%D0%B4%D0%B5%D0%B6%D0%B4%D0%B0/%D0%BF%D0%BB%D0%B0%D1%82%D1%8C%D1%8F/%D0%BF%D0%BB%D0%B0%D1%82%D1%8C%D0%B5-%D0%B0-%D1%81%D0%B8%D0%BB%D1%83%D1%8D%D1%82%D0%B0-%D0%B8%D0%B7-%D1%88%D0%B5%D1%80%D1%81%D1%82%D1%8F%D0%BD%D0%BE%D0%B3%D0%BE-%D1%82%D0%B2%D0%B8%D0%B4%D0%B0-%D1%87%D0%B5%D1%80%D0%BD%D1%8B%D0%B9-F61D5TFMME1S8031.html"
                                                       style="background-color: #000000;"
                                                       title="Черный"></a>
                                                </li>
                                                <?php } ?>
                                            </ul-->
                                            
                                        </div>
                                    </div>
                                </li>
                                <?php } ?>


                                <?php if ($options) { ?>
                                <li class="b-variation-item b-variation-item--size">
                                    <div class="b-variation-dropdown">
                                        <div class="b-variation-value Size">
                                            <div class="b-variation-title">
                                                <?php echo $text_size; ?>
                                            </div>
                                            <div class="b-variation-size_chart_link js-table-size_popup_link" data-href="#">
                                                <span><?php echo $text_select_size_help; ?></span>
                                            </div>
                                            
                                                <?php foreach ($options as $option) { ?>

                                                    <?php if ($option['type'] == 'select') { ?>
                                                    <?php //'select' поке нету - не делаю, но "заготовка" пусть пока побудет?>
                                                    <?php } ?>

                                                    <?php if ($option['type'] == 'radio') { ?>
                                                    <label class="control-label"><?php //echo $option['name']; ?></label>
                                                    <ul class="b-swatches_size js-swatches" id="input-option<?php echo $option['product_option_id']; ?>">
                                                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                        <?php if($option_value['quantity'] <= 0) { ?>
                                                        <li class="b-swatches_size-item emptyswatch m-unselectable">
                                                        <?php }else{ ?>
                                                        
                                                            <?php if(isset($_GET['option'][(int)$option['product_option_id']]) AND $_GET['option'][(int)$option['product_option_id']] == $option_value['product_option_value_id']){?>
                                                                <li class="b-swatches_size-item b-swatches_size-item-selected">
                                                            <?php }else{ ?>
                                                                <li class="b-swatches_size-item emptyswatch">
                                                            <?php } ?>
                                                
                                                        <?php } ?>

                                                            <input type="radio"
                                                                   name="option[<?php echo $option['product_option_id']; ?>]"
                                                                   value="<?php echo $option_value['product_option_value_id']; ?>"
                                                                   class="b-swatches_size-radio"
                                                                   id="option_<?php echo $option['product_option_id']; ?>_value_<?php echo $option_value['product_option_value_id']; ?>" 
                                                                   <?php if($option_value['quantity'] <= 0) { echo 'disabled'; } ?>
                                                                   <?php if(isset($_GET['option'][(int)$option['product_option_id']]) AND $_GET['option'][(int)$option['product_option_id']] == $option_value['product_option_value_id']){ echo ' checked ';}?>
                                                                   />

                                                            <label for="option_<?php echo $option['product_option_id']; ?>_value_<?php echo $option_value['product_option_value_id']; ?>"
                                                                   class="b-swatches_size-link"><?php echo $option_value['name']; ?></label>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php } ?>

                                                <?php } //end foreach ($options as $option) ?>
                                            



<!--
                                                <li class="b-swatches_size-item emptyswatch js-unselectable m-unselectable">
                                                <li class="b-swatches_size-item emptyswatch">
                                                <li class="b-swatches_size-item b-swatches_size-item-selected">
-->
                                            <!-- =======Original price============================================== -->
                                            <?php if ($price) { ?>
                                                <ul class="list-unstyled">
                                                  <?php if (!$special) { ?>
                                                  <li style="display: none;">
                                                    <h2><?php echo $price; ?></h2>
                                                  </li>
                                                  <?php } else { ?>
                                                  <li style="display: none;"><span class="b-product_price--old"><?php echo $price; ?></span></li>
                                                  <li style="display: none;">
                                                    <h2><span class="b-product_price--new"><?php echo $special; ?></span></h2>
                                                  </li>
                                                  <?php } ?>
                                                  <?php if ($tax) { ?>
                                                  <li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
                                                  <?php } ?>
                                                  <?php if ($points) { ?>
                                                  <li style="display: none;"><?php echo $text_points; ?> <?php echo $points; ?></li>
                                                  <?php } ?>
                                                  <?php if ($discounts) { ?>
                                                  <li>
                                                    <hr>
                                                  </li>
                                                  <?php foreach ($discounts as $discount) { ?>
                                                  <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
                                                  <?php } ?>
                                                  <?php } ?>
                                                </ul>
                                            <?php } ?>
          
                                           <!-- =======Original option============================================== -->
                                            <div id="product">
                                                <?php if ($options) { ?>
                                                <hr style="display: none;">
                                                <h3 style="display: none;"><?php echo $text_option; ?></h3>
                                                <?php //foreach ($options as $option) { ?>
                                                <?php if ($option['type'] == 'select') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                                  <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                                                    <option value=""><?php echo $text_select; ?></option>
                                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                    <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                                    <?php if ($option_value['price']) { ?>
                                                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                    <?php } ?>
                                                    </option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                                <?php //} ?>
                                                <?php if ($option['type'] == 'radio') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                                  <div id="input-option<?php echo $option['product_option_id']; ?>">
                                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                    <div class="radio">
                                                      <label>
                                                        <?php if($option_value['quantity'] <= 0){?>
                                                            [нет на складе]&nbsp; 
                                                        <?php } ?>
                                                        
                                                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                                        <?php echo $option_value['name']; ?>
                                                        <?php if ($option_value['price']) { ?>
                                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                        <?php } ?>
                                                      </label>
                                                    </div>
                                                    <?php } ?>
                                                  </div>
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'checkbox') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                                  <div id="input-option<?php echo $option['product_option_id']; ?>">
                                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                                        <?php if ($option_value['image']) { ?>
                                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
                                                        <?php } ?>
                                                        <?php echo $option_value['name']; ?>
                                                        <?php if ($option_value['price']) { ?>
                                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                        <?php } ?>
                                                      </label>
                                                    </div>
                                                    <?php } ?>
                                                  </div>
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'image') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                                  <div id="input-option<?php echo $option['product_option_id']; ?>">
                                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                    <div class="radio">
                                                      <label>
                                                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                                                        <?php if ($option_value['price']) { ?>
                                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                        <?php } ?>
                                                      </label>
                                                    </div>
                                                    <?php } ?>
                                                  </div>
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'text') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'textarea') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                                  <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'file') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                                  <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                                                  <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'date') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                                  <div class="input-group date">
                                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span></div>
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'datetime') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                                  <div class="input-group datetime">
                                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span></div>
                                                </div>
                                                <?php } ?>
                                                <?php if ($option['type'] == 'time') { ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                                  <div class="input-group time">
                                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </span></div>
                                                </div>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php if ($recurrings) { ?>
                                                <hr>
                                                <h3><?php echo $text_payment_recurring ?></h3>
                                                <div class="form-group required">
                                                  <select name="recurring_id" class="form-control">
                                                    <option value=""><?php echo $text_select; ?></option>
                                                    <?php foreach ($recurrings as $recurring) { ?>
                                                    <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
                                                    <?php } ?>
                                                  </select>
                                                  <div class="help-block" id="recurring-description"></div>
                                                </div>
                                                <?php } ?>
                                                <div class="form-group" style="display: none;">
                                                  <label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
                                                  <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
                                                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                                                  <br />
                                                  <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block" style="display: none;"><?php echo $button_cart; ?></button>
                                                </div>
                                                <?php if ($minimum > 1) { ?>
                                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
                                                <?php } ?>
                                              </div>
                                            <!-- ===================================================== -->         
                                           
                                            <!-- =====Original Key================================================ -->         
                                            <div class="btn-group" style="display: none;">
                                                <button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i></button>
                                                <!--button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></button-->
                                            </div>
        
                                            
                                            <!--ul class="js-swatches b-swatches_size">
                                                <?php foreach ($sizes as $size) { ?>
                                                <li class="b-swatches_size-item emptyswatch">
                                                    <a class="js-swatchanchor js-togglerhover b-swatches_size-link"
                                                       data-togglerhover-slider=".js_low-in-stock-msg"
                                                       data-variantattribute="size"
                                                       href="#"
                                                       title="36"><?php echo $size['size_name']; ?><span class="b-variation-few_left_message js_low-in-stock-msg" data-attr-value="<?php echo $size['size_id']; ?>"></span></a>
                                                </li>
                                                <?php } ?>
                                            </ul-->
                                        </div>
                                    </div>
                                    <div class="b-variation-error_message js-error_variations">
                                        <?php echo $text_select_size; ?>
                                    </div>
                                </li>
                                <?php } //end if ($options) ?>
                               
                            </ul>
                        </div>
                    </div>

<!-- =====Original =========== -->
                <div class="form-group" style="display: none;">
                  <label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
                  <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                  <br />
                  <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block" style="display: none;"><?php echo $button_cart; ?></button>
                </div>
<!-- =====Original =========== -->

                    <div class="js-notifyme_form-wrapper h-hidden">
                        <form class="b-notifyme_form js-notifyme_container" novalidate="novalidate">
                            <span class="b-notifyme_form-message_not_available"><?php echo $text_no_product; ?></span> <span class="b-notifyme_form-message_notify"><?php echo $text_send_me_msg; ?></span>
                            <div class=" f-field f-field-email js-notifyme_email f-state-required" data-required-text="<?php echo $text_error_email; ?>" data-valid-text="">
                                <label class="f-label" for="dwfrm_notifyme_email"><span class="f-label-value">Email</span></label>
                                <div class="f-field-wrapper">
                                    <input class="f-email f-state-required" id="dwfrm_notifyme_email" maxlength="50" name="dwfrm_notifyme_email" type="email"> <span class="f-error_message"><span class="f-error_message-block"></span></span> <span class="f-warning_message"><span class="f-warning_message-block"><span class="f-warning_text"></span></span></span>
                                </div>
                            </div><input name="pid" type="hidden" value="F61D5TFMME1S8031"> <button class="b-notifyme_form-submit js-notify_me_submit" type="button"><span><?php echo $text_confirm; ?></span></button>
                            <div class="b-notifyme_form-privacy">
                                <span><?php echo $text_politic; ?>
                            </div>
                        </form>
                    </div>
                    <div class="b-product_add_to_cart">
                        <!--form action="" class="js-form_pdp" id="dwfrm_product_addtocart_d0nlllyfdaqo" method="post" name="dwfrm_product_addtocart_d0nlllyfdaqo" novalidate="novalidate">
                            <div class="inventory h-hidden">
                                <div class="quantity">
                                    <input class="input-text js-product_quantity" data-available="0" id="Quantity" maxlength="3" name="Quantity" size="2" type="hidden" value="1">
                                </div>
                            </div><input id="cartAction" name="cartAction" type="hidden" value="add"> <input class="js-product_id" id="pid" name="pid" type="hidden" value="F61D5TFMME1S8031"> <input class="js-product_price-value" name="price" type="hidden" value="0.0">
                            <button onclick="cart.add('<?php echo $product_id;?>');"
                                    class="js-add_to_cart b-product_add_to_cart-submit"
                                    title="В корзину"
                                   
                                    value="<?php echo $text_bay; ?>"><?php echo $text_bay; ?></button>
                        </form-->
                    
                    
                    
                         <button class="js-add_to_cart b-product_add_to_cart-submit"
                                 title="В корзину"
                                 value="<?php echo $text_bay; ?>"><?php echo $text_bay; ?></button>
                                    
                    </div>
                    <!--  end details block -->
                    
                    
                    <div class="b-add_to_wishlist js-add_to_wishlist" onclick="wishlist.add('<?php echo $product_id; ?>');">>
                        <?php echo $text_add_to_wishlist; ?>
                    </div>
                    <div class="b-add_to_wishlist-added_message js-added_to_wishlist" >
                        <?php echo $text_added_to_wishlist; ?>
                    </div>
                </div>
                <div class="b-product_share">
                    <span class="b-product_share-text"></span>
                    <div class="b-product_share-content">
                        <a class="js-send_to_friend b-product_share-send_to_friend" href="" title="<?php echo $text_send_to_frend;?>"><span><?php echo $text_send_to_frend;?></span></a>
                        <div class="social-share-bar" data-popup="menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600">
                            <a class="social-share-button facebook" data-share="facebook" href="" target="_blank" title="Facebook"></a>
                            <a class="social-share-button twitter" data-share="twitter" href="" target="_blank" title="Twitter"></a>
                            <a class="social-share-button js-social_pinterest pinterest" data-share="pinterest" href="javascript:;" title="Pinterest"></a>
                            <a class="social-share-button googleplus" data-share="googleplus" href="" target="_blank" title="Google+"></a>
                        </div>
                    </div>
                </div>
                <div class="b-customer_service_button">
                    <a class="js-pdp_need_help_link" href="customer-care" title="Customer Service"><?php echo $text_need_help; ?></a>
                </div>
                <div class="js-pdp_need_help_link_container h-minimized">
                    <div class="b-content_asset b-content_asset--pdp-need-help content-asset">
                        <div class="pdp-need-help">
                            <p class="pdp-need-help-title"><?php echo $text_need_help; ?></p>
                            <p><?php echo $text_contact_to_us; ?></p><br>
                            <div align="center">
                                <a href=""><button class="button" type="button"><?php $text_contact_us; ?></button></a>
                            </div><br>
                            <p class="pdp-need-help-title"><?php echo $text_client_service;?></p>
                        </div>
                    </div><!-- End content-asset pdp-need-help -->
                </div>
            </div>
            <div class="b-product_tabs js-product_tabs ui-tabs ui-widget ui-corner-all">
                <ul class="b-product_tabs-menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                    <li aria-controls="tab1" aria-expanded="true" aria-labelledby="ui-id-1" aria-selected="true" class="b-product_tabs-item b-product_tabs-item_1 ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0">
                        <a class="b-product_tabs-link ui-tabs-anchor" href="#tab1" id="ui-id-1" role="presentation" tabindex="-1"><?php echo $tab_description; ?></a>
                    </li>
                    <li aria-controls="tab2" aria-expanded="false" aria-labelledby="ui-id-2" aria-selected="false" class="b-product_tabs-item b-product_tabs-item_2 ui-state-default ui-corner-top" role="tab" tabindex="-1">
                        <a class="b-product_tabs-link ui-tabs-anchor" href="#tab2" id="ui-id-2" role="presentation" tabindex="-1"><?php echo $text_using_product; ?></a>
                    </li>
                    <li aria-controls="tab3" aria-expanded="false" aria-labelledby="ui-id-3" aria-selected="false" class="b-product_tabs-item b-product_tabs-item_3 ui-state-default ui-corner-top" role="tab" tabindex="-1">
                        <a class="b-product_tabs-link ui-tabs-anchor" href="#tab3" id="ui-id-3" role="presentation" tabindex="-1"><?php echo $text_delivery_and_return; ?></a>
                    </li>
                </ul>
                <div aria-hidden="false" aria-labelledby="ui-id-1" class="b-product_tabs-content b-product_tabs-details b-product_tabs-content_1 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tab1" role="tabpanel">
                    <div class="b-product_long_description">
                        <?php echo $description; ?>
                    </div>
                    <span class="b-product_tabs-label"><?php echo $text_material; ?></span>
                    <div class="b-product_material">
                        <br>
                    </div>
                    <div class="b-product_master_id">
                        <?php echo $text_model.' '.$sku; ?>
                    </div>
                </div>
                <?php if(isset($description_detail) AND strlen($description_detail) > 0) { ?>
                <div aria-hidden="true" aria-labelledby="ui-id-2" class="b-product_tabs-content b-product_tabs-content_2 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tab2" role="tabpanel" style="display: none;">
                    <div class="b-care_details-content js-care_details-content">
                        <?php echo $description_detail; ?>
                    </div>
                </div>
                <?php } ?>
                <div aria-hidden="true" aria-labelledby="ui-id-3" class="b-product_tabs-content b-product_tabs-content_3 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tab3" role="tabpanel" style="display: none;">
                    <?php echo $text_delivery_info; ?> <a href="shippinginfo" target="_blank"><b><?php echo $text_zdes; ?></b></a>
                </div>
            </div>
        </div>
    </div>

<?php if ( isset($products) && count($products) > 0 ) { ?>
    <div class="b-product_you-may-also-like">
        <div class="b-product_you-may-also-like-heading"><?php echo $text_related; ?></div>

        <div class="l-recommendations">
            <div class="l-product_carousel">
                <div class="" data-settings="">
                    <ul class="l-product_carousel-list">
                        <?php foreach ($products as $product) { ?>
                        <li>
                            <div class="b-product_tile b-product_tile--1" data-product-name="<?php echo $product['name']; ?>">
                                <div class="b-product-hover_box">
                                    <a class="b-product_image-wrapper" href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>">
                                    <img alt="<?php echo $product['name']; ?>" class="b-product_image" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" data-altimage="<?php echo $product['thumb_second']; ?>" >
                                    </a>

                                    <div class="b-productile_hover">
                                        <div class="b-productile_hover-inner">
                                            <div class="b-productile_hover-middle_box">
                                                <div class="b-productile_hover-middle_box_inner">
                                                    <div class="b-product_variations--plp">
                                                        <div class="b-variation">
                                                            <ul class="b-variation-list">
                                                                <li class="b-variation-item b-variation-item--size">
                                                                    <div class="b-variation-dropdown">
                                                                        <div class="b-variation-value Size">
                                                                            <div class="b-variation-title">
                                                                                <?php echo $text_select_size; ?>
                                                                            </div>
                                                                            <div class="b-variation-size_chart_link">
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
                                                                                            <a href="<?php echo $product['href']; ?>?option[<?php echo $option['product_option_id']; ?>]=<?php echo $option_value['product_option_value_id']; ?>" class="b-swatches_size-link"><?php echo $option_value['name']; ?></a>
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
                                                                            <span class="b-variation-title">цвет</span> <span>Черный</span>
                                                                            <ul class="b-swatches_color">
                                                                                <li class="b-swatches_color-item b-swatches_color-item-selected">
                                                                                    <a class="b-swatches_color-link-selected b-swatches_color-link" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" style="background-color: #000000;" title="Черный"></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="b-product_name product_name" href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="b-product_name product_name" href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>


                                <div class="b-product_price" style="">
                                    <h4 class="b-product_price-standard" style=""><?php echo $product['price']; ?></h4>
                                </div>

                            </div>

                        </li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
<?php } ?>

</main>


<script>
// карусель для фото товара START
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    singleItem: true,
    items: 1,
    URLhashListener: true
});
// карусель для фото товара END

// Увеличение фото товара (миниатюры). START
$('.js-thumb_slider').on('click', 'li', function(){
    $('.js-thumb_slider li').removeClass('b-product_thumbnail-selected');
    $(this).addClass('b-product_thumbnail-selected');
    $('.js-fancybox-img').attr('src', $(this).data('img-popup'));
});
$('.js-thumb_slider li:first').click();
// Увеличение фото товара (миниатюры). END
</script>


<link rel="stylesheet" href="/catalog/view/theme/simplica/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="/catalog/view/theme/simplica/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Увеличение фото товара (главное фото). START
    $('.js-pdp_main').on('click', '.js-thumb_image_zoom', function(){
        var c = $('.js-product_images_container-zoom');
        var functionCloseImageZoom = function () {
            $.fancybox.close();
        };
        $.fancybox.open({
            content: c,
            type: 'html',
            padding: 0,
            margin: 0,
            wrapCSS: 'b-product_image_zoomed',
            leftRatio: 0,
            topRatio: 0,
            tpl: {
                closeBtn : '<span class="fancybox-close"></span>'
            },
            afterLoad: function(){
                $('.js-owl-carousel').addClass('h-hidden');
                $('.js-fancybox-img') .removeClass('h-hidden');
                $('html').addClass('html_fancybox_opened');
                $('.js-product_images_container-zoom').removeClass('l-product_images_container-wrap');
                $('.js-container_main_image').bind('click', functionCloseImageZoom);
            },
            afterClose: function(){
                $('.js-owl-carousel').removeClass('h-hidden');
                $('.js-fancybox-img') .addClass('h-hidden');
                $('html').removeClass('html_fancybox_opened');
                $('.js-product_images_container-zoom').addClass('l-product_images_container-wrap');
                $('.js-product_images_container-zoom').show();
                //$('.js-thumb_image_zoom').css('margin-top', 0);
                $('.js-container_main_image').unbind('click', functionCloseImageZoom);
            }
        });
    });

    $('.js-container_main_image').on('mousemove', function(e){
        if ( $('html').hasClass('html_fancybox_opened') ) {
            c = $('.js-container_main_image img');
            var d = 0;
            c.height() > window.innerHeight && (d = parseInt((c.height() - window.innerHeight) * parseFloat(e.clientY / window.innerHeight)));
            c.css('margin-top', - d + 'px');
        }
    });
    // Увеличение фото товара (главное фото). END



    // Выбор опций товара. START
    $('.js-swatches').on('change', 'input', function(){
        $(this).closest('.js-swatches').find('input:radio').closest('li').removeClass('b-swatches_size-item-selected').addClass('emptyswatch');
        $(this).closest('.js-swatches').find('input:radio:checked').closest('li').addClass('b-swatches_size-item-selected').removeClass('emptyswatch');
    });
    // Выбор опций товара. END


    // popup для таблицы с размерами. START
    $('.js-table-size_popup_link').on('click', function(){
        var c = $('.js-table-size_popup');

        $.fancybox.open({
            content: c,
            type: 'html',
            padding: 0,
            margin: 0,
            // autoSize: false,
            autoSize: true,
            // width: 300,
            // height: 440,
            // minHeight: 440,
            wrapCSS: 'b-table-size-popup',
            tpl: {
                closeBtn : '<span class="fancybox-close"></span>'
            }
        });
    });
    // popup для таблицы с размерами. END


// Кнопка "Купить" START
$('#button-cart, .js-add_to_cart').on('click', function() {
    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-cart').button('loading');
        },
        complete: function() {
            $('#button-cart').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');
//debugger;
            if (json['error']) {
                if (json['error']['option']) {
                    for (i in json['error']['option']) {
                        var element = $('#input-option' + i.replace('_', '-'));

                        if (element.parent().hasClass('input-group')) {
                            element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                        } else {
                            element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                        }
                    }
                }

                if (json['error']['recurring']) {
                    $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                }

                // Highlight any found errors
                $('.text-danger').parent().addClass('has-error');
            }

            if (json['success']) {
                $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                $('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);

                $('html, body').animate({ scrollTop: 0 }, 'slow');

                $('#cart > ul').load('index.php?route=common/cart/info ul li');

                /* вставил кусок из common.js (чтобы хоть как-то работало - потом падо будет этот ajax пересмотреть ) 
                START */
                    setTimeout(function () {
                         $('#cart .js-cart-total').html(json['total']);
                        $('.b-mini_cart-subtotal_qty').html(json['int_total']);
                        $('.b-mini_cart-subtotal_value').html(json['int_summ_curr']);
                        $('.js-minicart-quantity_value').html(json['int_total']);
                        $('.js-minicart-quantity_value').removeClass('h-hidden');
                    }, 100);

                    $('html, body').animate({ scrollTop: 0 }, 'slow');

                    $('#cart').load('index.php?route=common/cart/info');

                    $('.js-mini_cart').removeClass('h-minimized');
                    setTimeout(function() {
                         $('.js-mini_cart').addClass('h-minimized');
                    }, 5000);
                /* вставил кусок из common.js (чтобы хоть как-то работало - потом падо будет этот ajax пересмотреть ) 
                END */
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
// Кнопка "Купить" END



});

</script>

<?php echo $footer; ?>
