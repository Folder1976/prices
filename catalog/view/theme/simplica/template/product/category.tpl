<?php echo $header; ?>
<?php
// поправить текст в переменных:
$text_sort = 'Выводить: ';


    
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";



?>





<div class="b-popup b-business-card-popup js-popup-business-card mfp-hide">
  <div class="b-popup__content">
    <div class="b-business-card">

      <div class="b-business-card__top">
        <div class="b-business-card__schedule">
          <p><span class="ic-business-card-schedule"></span>График работы</p>
          <p class="js-ajax-worktime"></p>
        </div>
        <div class="b-business-card__name js-ajax-shop-name">
        </div>
        <div class="b-business-card__phones">
          <p><span class="ic-business-card-phones"></span>Номера телефона:</p>
          <p class="js-ajax-phone"></p>
        </div>
      </div>

      <div class="b-business-card__address">
        <div class="g-span-select b-business-card__address-select js-span-select">
          <span class="g-span-select__title"></span>
          <ul class="g-span-select__ul g-span-select__hidden js-ajax-addresses">
          </ul>
        </div>
      </div>

      <div class="b-business-card__send-message">
        <a href="#" class="b-business-card__send-message-btn">Отправить сообщение</a>
      </div>

      <div class="b-business-card__tabs js-business-card__tabs">
        <ul>
          <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#js-business-card_tabs-2">Показать карту</a></li>
          <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#js-business-card_tabs-1">Все филиалы</a></li>
        </ul>

        <!-- Все филиалы -->
        <div id="js-business-card_tabs-1" class="b-business-card_tabs-branches">
          <ul class="js-ajax-addresses-list">
          </ul>
        </div>

        <!-- Показать карту -->
        <div id="js-business-card_tabs-2" class="b-business-card_tabs-map">
          <img src="catalog/view/theme/simplica/img/map.jpg" alt="">
        </div>
      </div>

    </div>
  </div>
</div>



    <main class="b-category">
      <!-- Хлебные крошки. START -->
      <div class="b-breadcrumb">
      <?php $count = 0; ?>
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php if ($count == 0) { ?>
          <a href="<?php echo $breadcrumb['href']; ?>" title=""><span class="ic-home"></span><?php echo $breadcrumb['text']; ?></a>
        <?php } else { ?>
          <span>&nbsp;>&nbsp;</span><a href="<?php echo $breadcrumb['href']; ?>" title="<?php echo $breadcrumb['text']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
      <?php $count++;} ?>
      </div>
      <!-- Хлебные крошки. END -->

      <div class="g-container">

        <div class="g-col-left">

          <div class="b-filter__title">  <!-- Фильтры START -->
            <h3>Подбор по параметрам <span class="ic-arrow-down-white"></span></h3>
          </div>

          <div class="b-filter js-popup-filter">
            <div class="b-filter-block b-filter-block_price b-filter-block_open">
              <div class="b-filter-block__title js-filter-block-toggle">Цена</div>
              <div class="b-filter-block__content">

              <div class="f-group-wrap_2col">
                <div class="f-group">
                  <div class="f-field-wrapper">
                    <div class="f-label">
                      <span class="f-label-value">от</span>
                    </div>
                    <div class="f-field">
                      <input type="text"
                             name="price_min"
                             value=""
                             placeholder=""
                             class="f-input">
                    </div>
                  </div>
                </div>

                <div class="f-group">
                  <div class="f-field-wrapper">
                    <div class="f-label">
                      <span class="f-label-value">до</span>
                    </div>
                    <div class="f-field">
                      <input type="text"
                             name="price_max"
                             value=""
                             placeholder=""
                             class="f-input">
                    </div>
                  </div>
                </div>

                <div class="f-group">
                  <div class="f-field-wrapper">
                    <div class="f-label">
                      <span class="f-label-value">грн</span>
                    </div>
                  </div>
                </div>
              </div>

              </div>
            </div>  <!-- end b-filter-block -->


            <?php if ( isset($manufacturers) AND count($manufacturers) > 0 AND is_array($manufacturers)) { ?>
            <div class="b-filter-block b-filter-block_open">
              <div class="b-filter-block__title js-filter-block-toggle"><?php echo $text_manufacturer; ?></div>
              <div class="b-filter-block__content">
                <ul class="f-group-wrap_2col"><?php // тут можно проставить классы: f-group-wrap_1col, f-group-wrap_2col, f-group-wrap_3col. ?>

                <?php foreach ($manufacturers as $attribut) { ?>

                  <li class="f-group">
                    <div class="f-field-wrapper f-field-wrapper_checkbox">
                      <div class="f-field">
                        <input type="checkbox"
                               name="<?php echo 'option_'.$attribut['code'].'_value_'.$attribut['manufacturer_id']; ?>"
                               id="<?php echo 'option_'.$attribut['code'].'_value_'.$attribut['manufacturer_id']; ?>"
                               value=""
                               <?php if ( strpos($selected_attributes_alias, $attribut['code']) !== false) { echo ' checked ';} ?>
                               class="f-checkbox">
                        <div class="f-label">
                          <label for="<?php echo 'option_'.$attribut['code'].'_value_'.$attribut['manufacturer_id']; ?>">
                            <?php if ( strpos($selected_attributes_alias, $attribut['code']) !== false) { ?>
                              <a href="<?php echo str_replace($attribut['code'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                            <?php } else { ?>
                              <a href="<?php echo $attribut['code'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                            <?php } ?>
                            </label>
                        </div>
                      </div>
                    </div>
                  </li>

                <?php } ?>
                </ul>
              </div>
            </div>  <!-- end b-filter-block -->
            <?php } ?>


            <?php if ( isset($product_attributes) AND count($product_attributes) > 0 AND is_array($manufacturers)) { ?>
            <?php foreach ($product_attributes as $prod_attr) { ?>
            <div class="b-filter-block b-filter-block_open">
              <div class="b-filter-block__title js-filter-block-toggle"><?php echo $prod_attr['attribute_group_name']; ?></div>
              <div class="b-filter-block__content">
                <ul class="f-group-wrap_2col"><?php // тут можно проставить классы: f-group-wrap_1col, f-group-wrap_2col, f-group-wrap_3col. ?>

                <?php foreach ($prod_attr['attributes'] as $attribut) { ?>

                  <li class="f-group">
                    <div class="f-field-wrapper f-field-wrapper_checkbox">
                      <div class="f-field">
                        <input type="checkbox"
                               name="<?php echo 'option_'.$prod_attr['attribute_group_id'].'_value_'.$attribut['attribute_id']; ?>"
                               id="<?php echo 'option_'.$prod_attr['attribute_group_id'].'_value_'.$attribut['attribute_id']; ?>"
                               value=""
                               <?php if ( strpos($selected_attributes_alias, $attribut['attribute_id']) !== false) { echo ' checked ';} ?>
                               class="f-checkbox">
                        <div class="f-label">
                          <label for="<?php echo 'option_'.$prod_attr['attribute_group_id'].'_value_'.$attribut['attribute_id']; ?>">
                            <?php if ( strpos($selected_attributes_alias, $attribut['attribute_id']) !== false) { ?>
                              <a href="<?php echo str_replace($attribut['attribute_id'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                            <?php } else { ?>
                              <a href="<?php echo $attribut['attribute_id'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                            <?php } ?>
                            </label>
                        </div>
                      </div>
                    </div>
                  </li>

                <?php } ?>
                </ul>
              </div>
            </div>  <!-- end b-filter-block -->
            <?php } ?>
            <?php } ?>

          </div>  <!-- end b-filter -->
        </div>  <!-- end g-col-left -->

        <div class="g-col-center">


<!--           <div class="g-row">
            <div class="b-business-card">
              <div class="b-business-card__top">
                <div class="b-business-card__schedule">
                  <p><span class="ic-location-big"></span>График работы</p>
                  <p>ПН - СБ 10:00  20:00</p>
                  <p>ВС 10:00  17:00</p>
                </div>
                <div class="b-business-card__btn-send-message">
                  <a href="#">Написать собщение</a>
                </div>
                <div class="b-business-card__name">
                  Maximum
                </div>
              </div>
              <div class="b-business-card__phone-number">
                <span class="ic-phone"></span> <span class="b-business-card__show-number js-open-popup-link" data-mfp-src=".js-popup-business-card">Показать номер</span>
              </div>
            </div>
          </div> -->  <!-- end g-row -->


          <?php if ( isset($category_page_products) && count($category_page_products) > 0 ) { ?>
          <div class="g-row">
            <div class="b-product-carousel-wrapper">
              <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                <?php foreach ( $category_page_products as $prod) { ?>
                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>">
                  </div>
                  <a href="/<?php echo $language_href; ?><?php echo $prod['href']; ?>" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                  <span class="b-product-carousel__price"><?php echo /*$currencies[$_SESSION ['currency']]['symbol_left'].' '.*/sprintf("%.2f", $prod['price'])/*.' '.$currencies[$_SESSION ['currency']]['symbol_right']*/; ?></span>
                </div>
                <?php } ?>

              </div>
            </div>
          </div>  <!-- end g-row -->
          <?php } ?>

          <div class="b-products-container__title">
            <h2>Мобильные телефоны</h2>
          </div>

          <div class="b-products-container__sort-row">

            <div class="b-filter-header b-filter-header_mob js-open-popup-link" data-mfp-src=".js-popup-filter">
              <span class="ic-mob-filter"></span>
              <span>Фильтрация</span>
            </div>

            <div class="b-view-header">
              <div class="b-change_view__list js-change_view">
                <span class="ic-view_list active" data-view="list"></span>
                <span class="ic-view_grid-3" data-view="grid-3"></span>
                <span class="ic-view_grid-4" data-view="grid-4"></span>
              </div>
            </div>

            <div class="b-count-product">3125 Найдено</div>

            <div class="b-sort-header">
              <?php echo $text_sort; ?>
              <div class="g-span-select js-span-select">
                <span class="g-span-select__title">от дешевых к дорогим</span>
                <ul class="g-span-select__ul g-span-select__hidden js-popup-sort">
                <?php foreach ($sorts as $sorts) { ?>
                  <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                    <li class="active"><a href="/<?php echo ltrim($selected_attributes_alias.$category_alias,'-'); ?><?php echo substr_replace($sorts['href'],'?',0,1); ?>"><?php echo $sorts['text']; ?></a></li>
                  <?php } else { ?>
                    <li><a href="/<?php echo ltrim($selected_attributes_alias.$category_alias,'-'); ?><?php echo substr_replace($sorts['href'],'?',0,1); ?>""><?php echo $sorts['text']; ?></a></li>
                  <?php } ?>
                <?php } ?>
                </ul>
              </div>
            </div>

            <div class="b-sort-header b-sort-header_mob js-open-popup-link" data-mfp-src=".js-popup-sort">
              <span class="ic-mob-sotr"></span>
              <span>Сортировать</span>
            </div>

          </div>  <!-- end b-products-container__sort-row -->

          <div class="g-row">
            <div class="b-products-container">

              <div class="b-products-container__content b-products-container__content_list js-view-content">

              <?php foreach ($products as $product) { ?>
                <div class="b-prod__wrapper">
                  <div class="b-prod">
                    <div class="b-prod__title"><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                    <div class="b-prod__options">
                      <span class="b-prod__options-color"></span>
                      <?php if ($product['options']) { ?>
                      <ul class="b-prod__options-list">
                        <?php foreach ($product['options'] as $option) { ?>
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <li class="b-prod__options-list-item"><?php echo $option_value['name']; ?></li>
                        <?php } ?>
                        <?php } ?>
                      </ul>
                      <?php } ?>
                      <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" class="g-btn b-prod__btn_buy">Купить</a>
                      <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" class="b-prod__comments-link">Отзывы (<?php echo $product['total_comments']; ?>)</a>
                    </div>
                    <div class="b-prod__photo">
                      <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
                    </div>
                    <div class="b-prod__brand-img">
                      <a href="javascript:void(0)" class="js-business-card-href js-open-popup-link" data-shop-id="<?php echo $product['shop_id']; ?>" data-shop-name="<?php echo $product['shop_name']; ?>" data-mfp-src=".js-popup-business-card">
                        <img src="/image/<?php if ( $product['manufacturer_image'] != NULL ) { echo $product['manufacturer_image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $product['name']; ?>">
                      </a>
                    </div>
                    <div class="b-prod__links">
                      <ul>
                        <li><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><span class="ic-prod_more"></span>Подробнее</a></li>
                        <li><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><span class="ic-prod_photos"></span>Все фото (<?php echo $product['total_images']; ?>)</a></li>
                        <li><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><span class="ic-prod_video"></span>Все видео (<?php echo count($product['videos']); ?>)</a></li>
                        <li><button type="button" class="f-button" title="" onclick="wishlist.add('<?php echo $product['product_id'];?>');">В закладки</button></li>
                      </ul>
                      <div class="b-prod__color">
                        <span style="background: #474747;"></span>
                      </div>
                      <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" class="b-prod__links-more-btn">Подробнее</a>
                    </div>
                    <div class="b-prod__price-block">
                      <div class="b-price">
                        <span class="b-price__number">9999 - 20000</span> <span class="b-price__currency">грн</span>
                      </div>
                    </div>
                  </div>
                </div>  <!-- end b-prod__wrapper -->
              <?php } ?>

              </div>  <!-- end b-products-container__content -->

              <div class="b-products-container__pagination">
              <?php echo $pagination; ?>
<!--                 <div class="b-pagination">
                  <a href="category.html" class="b-pagination__prev"><span class="ic-arrow-prev3"></span> <span class="g-mob-hidden">Назад</span></a>
                  <a href="category.html" class="b-pagination__next"><span class="g-mob-hidden">Вперед</span> <span class="ic-arrow-next3"></span></a>
                  <ul class="b-pagination__list">
                    <li class="active"><span>1</span></li>
                    <li><a href="category.html">2</a></li>
                    <li><a href="category.html">3</a></li>
                    <li><a href="category.html">4</a></li>
                    <li><a href="category.html">5</a></li>
                    <li><a href="category.html">6</a></li>
                    <li><a href="category.html">7</a></li>
                  </ul>
                </div> -->
              </div>
            </div>
          </div>  <!-- end g-row -->

        </div>  <!-- end g-col-center -->

        <div class="g-clear"></div>

      </div>  <!-- end g-container -->

      <div class="b-benefits b-seo-text">
        <div class="g-container">
          <?php echo $description; ?>
        </div>
      </div>

    </main>

<script>
// визитка магазина
$('.js-business-card-href').on('click', function(){
  var shop_id = $(this).data('shop-id');
  var shop_name = $(this).data('shop-name');

  $.ajax({
      url: 'index.php?route=product/shops/getShopInfoAjax',
      type: 'post',
      data: "shop_id="+shop_id,
      dataType: 'json',
      beforeSend: function() {
        //console.log('loading msg');
        var loading_msg = 'Загружаю...';
        $('.js-ajax-phone').html(loading_msg);
        $('.js-ajax-worktime').html(loading_msg);
        $('.js-ajax-shop-name').html(loading_msg);
        $('.js-ajax-addresses').html('<li>'+loading_msg+'</li>');
        $('.js-ajax-addresses li:first-child').click().click();
        $('.js-ajax-addresses-list').html('<li>'+loading_msg+'</li>');
      },
      complete: function() {
        console.log('reset msg');
      },
      success: function(json) {
          //console.log(json);
          $('.js-ajax-phone').html(json['phone']);
          $('.js-ajax-worktime').html(json['worktime']);
          $('.js-ajax-shop-name').html(shop_name);

          // список филиалов для select
          var html = '';
          $.each(json['addresses'], function(index, value){
            html = html + '<li>';
            html= html + value['country_name'] + ', ' + value['city_name'] + ', ' + value['address'];
            html = html + '</li>';
          });
          $('.js-ajax-addresses').html(html);
          $('.js-ajax-addresses li:first-child').click().click();

          // список филиалов для вкладки "все филиалы"
          var html = '';
          $.each(json['addresses'], function(index, value){
            html = html + '<li>';
            html = html + '<span>' + value['country_name'] + ', ' + value['city_name'] + '</span>';
            html = html + '<span>' + value['address'] + '</span>';
            html = html + '<a href="tel:' + value['phone'] + '">Tel:' + value['phone'] + '</a>';
            html = html + '</li>';
          });
          $('.js-ajax-addresses-list').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
  });
});


  //Аякс на получение данных по магазину
  // $(document).ready(function() {
  //   $.ajax({
  //       url: 'index.php?route=product/shops/getShopInfoAjax',
  //       type: 'post',
  //       data: "shop_id=5",
  //       dataType: 'json',
  //       beforeSend: function() {
  //       	console.log('loading msg');
  //       },
  //       complete: function() {
  //         console.log('reset msg');
  //       },
  //       success: function(json) {
  //           console.log(json);
  //           $('.js-ajax-phone').html(json['phone']);
  //     },
  //       error: function(xhr, ajaxOptions, thrownError) {
  //           alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
  //       }
  //   });
  // });
</script>

<?php echo $footer; ?>
