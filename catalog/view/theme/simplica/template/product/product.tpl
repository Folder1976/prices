<?php echo $header; ?>

<?php
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<pre>";  print_r(var_dump( $content_megareviews )); echo "</pre>";
?>

<div class="b-popup b-prod-img-popup js-popup-prod-img mfp-hide">
  <div class="b-prod-img-popup__title">
    <h2 class="b-prod-info__title"><?php echo $heading_title; ?></h2>
    <div class="b-prod-info__block-price">
      <span>
      <?php
      if ( $model_price['max_price'] == $model_price['min_price'] ) {
        echo $model_price['max_price'];
      } else {
        echo $model_price['max_price'].' - '.$model_price['min_price'];
      }
      ?>
      </span>
      <div class="b-prod-info__btn-buy">
        <a href="#" class="g-btn">Где купить ></a>
      </div>
    </div>
  </div>

  <div class="b-prod-img-popup__content">
    <div class="b-prod-img">

      <div class="b-prod-img__brand">
        <img src="img/brands/brand_acer.png" alt="">
      </div>

      <div class="b-prod-img__main-image">
        <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="js-main-image">
      </div>

      <div class="b-prod-img__thumb-list-wrapper">
        <div class="b-prod-img__thumb-list js-prod_popup-thumb-list"></div>
      </div>

    </div>
  </div>
</div>

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


    <main class="b-product">
      <!-- Хлебные крошки. START -->
      <div class="b-breadcrumb">
      <?php $count = 0; ?>
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php if ($count == 0) { ?>
          <a href="<?php echo $language_href; ?><?php echo $breadcrumb['href']; ?>" title=""><span class="ic-home"></span><?php echo $breadcrumb['text']; ?></a>
        <?php } else { ?>
          <span>&nbsp;>&nbsp;</span><a href="<?php echo $language_href; ?><?php echo $breadcrumb['href']; ?>" title="<?php echo $breadcrumb['text']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
      <?php $count++;} ?>
      </div>
      <!-- Хлебные крошки. END -->

      <div class="g-container">

          <div class="g-col-left g-col-left_prod">
            <div class="g-row">
              <div class="b-prod-img">

                <h2 class="b-prod-img__title"><?php echo $heading_title; ?></h2>

                <div class="b-prod-img__brand">
                  <img src="img/brands/brand_acer.png" alt="">
                </div>

                <div class="b-prod-img__main-image js-open-popup-link" data-mfp-src=".js-popup-prod-img">
                  <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="js-main-image">
                </div>

                <div class="b-prod-img__carousel owl-carousel js-prod_owl-carousel js-prod_thumb-list">

                  <?php foreach ($images as $img) { ?>
                  <div class="b-prod-img__item">
                    <img src="<?php echo $img['thumb'];?>" alt="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" data-img="<?php echo $img['thumb'];?>">
                  </div>
                  <?php } ?>

                </div>

              </div>
            </div>  <!-- end g-row -->
            <div class="g-row">
              <div class="b-col-left-prod__bottom">
                <a href="/<?php echo $language_href; ?>#"><span class="ic-fb-grey"></span></a>
                <a href="/<?php echo $language_href; ?>#"><span class="ic-twitter-grey"></span></a>
                <a href="/<?php echo $language_href; ?>#"><span class="ic-linked-in-grey"></span></a>
                <a href="/<?php echo $language_href; ?>#"><span class="ic-pininterest-grey"></span></a>
                <div class="b-compare-btn">
                  <a href="/<?php echo $language_href; ?>#">Сравнить</a>
                </div>
              </div>
            </div>
          </div>  <!-- end g-col-left_prod -->

          <div class="g-col-right g-col-right_prod">

              <div class="b-prod-info">

                <h2 class="b-prod-info__title"><?php echo $heading_title; ?></h2>

                <div class="b-prod-info__block">
                  <div class="b-prod-info__block-price">
                    <span>
                    <?php
                    if ( $model_price['max_price'] == $model_price['min_price'] ) {
                      echo $model_price['max_price'];
                    } else {
                      echo $model_price['max_price'].' - '.$model_price['min_price'];
                    }
                    ?>
                    </span>
                    <div class="b-rating" data-count_r="5" data-width_star="10">
                      <div style="width: 70%"></div>
                    </div>
                  </div>
                  <div class="b-prod-info__block-summary">
                    
                    <button type="button" data-toggle="tooltip" class="btn btn-default" title="" onclick="wishlist.add('<?php echo $product_id;?>');" data-original-title="В закладки">В ЗАКЛАДКИ</button>
                    
                    <span class="b-offers">40 предложений</span>
                    <span class="b-recall">Отзывы (<?php echo $total_comments; ?>)</span>
                    <span class="b-send-recall">Оставить отзыв</span>
                  </div>
                </div>  <!-- end b-prod-info__block -->

                <!-- Атрибуты -->
                <?php if ( isset($attribute_groups) ) { ?>
                <?php $count_attr = 0; ?>
                <div class="b-prod-info__content">
                  <?php foreach( $attribute_groups as $group ) { ?>
                  <div class="g-row">
                    <div class="b-prod-info__content-key"><?php echo $group['name']; ?></div>
                    <div class="b-prod-info__content-val"></div>
                  </div>
                    <?php foreach( $group['attribute'] as $attribut ) { ?>
                    <div class="g-row">
                      <div class="b-prod-info__content-key"><?php echo $attribut['name']; ?></div>
                      <div class="b-prod-info__content-val"><?php echo $attribut['text']; ?></div>
                    </div>

                      <?php if ($count_attr++ > 7) { ?>
                      <div class="b-prod-info__content-more js-prod-info__content-more">Ещё</div>
                      <?php } ?>

                    <?php } ?>

                  <?php } ?>
                </div>  <!-- end b-prod-info__content -->
                <?php } ?>


                <div class="b-prod-info__btn-buy">
                  <a href="/<?php echo $language_href; ?>#" class="g-btn">Где купить ></a>
                </div>
              </div>

          </div>  <!-- end g-col-right_prod -->

          <div class="g-clear"></div>

        <div class="b-breadcrumb b-breadcrumb_mob">
          <a href="/<?php echo $language_href; ?>index.html"><span class="ic-home"></span></a><span>&nbsp;>&nbsp;</span>
          <a href="/<?php echo $language_href; ?>category.html">Комплектующие</a><span>&nbsp;>&nbsp;</span>
          <a href="/<?php echo $language_href; ?>category.html">Материнские платы</a><span>&nbsp;>&nbsp;</span>
          <a href="/<?php echo $language_href; ?>product.html">Original Letv Le 1 Pro 5.5</a>
        </div>

        <div class="b-prod-other-info">
          <ul>
            <li>
              <span class="ic-delivery"></span>
              <h4>Доставка</h4>
              <p>По Кишиневу</p>
            </li>
            <li>
              <span class="ic-piggy-bank"></span>
              <h4>Оплата</h4>
              <p>Наличными, Безналичним</p>
            </li>
            <li>
            <span class="ic-trolley"></span>
              <h4>В регионах</h4>
              <p>Cамовывоз из точки выдачи</p>
            </li>
            <li>
            <span class="ic-medal"></span>
              <h4>Гарантия</h4>
              <p>12 месяцев официальной</p>
            </li>
          </ul>
        </div>  <!-- end b-prod-other-info -->

        <!-- Видео -->
        <?php if ( isset($videos) && count($videos) > 0 ) { ?>
        <div class="g-row">
          <div class="b-block-product">
            <div class="b-block-product__title">
              <span>Видео</span>
            </div>
            <div class="b-block-product__content">
              <div class="b-video__main"><?php echo htmlspecialchars_decode($videos[0]['video']); ?></div>
              <div class="b-video__list">
                <ul>
                  <?php foreach($videos as $video) { ?>
                  <li>
                    <div class="b-video__list-mini"><?php echo htmlspecialchars_decode($video['video']); ?></div>
                    <h3 class="b-video__list-title">Топ 5 элитных домов на колесах</h3>
                    <p class="b-video__list-author">Авто тайм</p>
                  </li>
                  <?php } ?>
                </ul>
              </div>
              <div class="g-clear"></div>
            </div>
          </div>
        </div>  <!-- end g-row -->
        <?php } ?>

        <?php if ( $products ) { ?>
        <!-- Похожие товары -->
        <div class="g-row">
          <div class="b-block-product">
            <div class="b-block-product__title">
              <span>Похожие товары</span>
            </div>
            <div class="b-block-product__content">
              <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                <?php foreach ($products as $prod) { ?>
                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="<?php echo $prod['thumb']; ?>" alt="<?php echo $prod['name']; ?>">
                  </div>
                  <a href="/<?php echo $language_href; ?><?php echo $prod['href']; ?>" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                  <span class="b-product-carousel__price"><?php echo $prod['price']; ?></span>
                </div>
                <?php } ?>

              </div>
            </div>
          </div>
        </div>  <!-- end g-row -->
        <?php } ?>



        <div class="b-prod__tabs js-prod_tabs">
          <div class="g-scroll-line js-scroll-line">
            <ul>
              <?php if ( isset($attribute_groups) ) { ?>
              <li><a href="/<?php echo $language_href; ?><?php echo $_GET['_route_']; ?>#js-block-product_tabs-1">Характеристики</a></li>
              <?php } ?>
              <li><a href="/<?php echo $language_href; ?><?php echo $_GET['_route_']; ?>#js-block-product_tabs-2">Предложения</a></li>
              <li><a href="/<?php echo $language_href; ?><?php echo $_GET['_route_']; ?>#js-block-product_tabs-3">Отзывы</a></li>
            </ul>
          </div>


          <!-- Характеристики -->
          <?php if ( isset($attribute_groups) ) { ?>
          <div id="js-block-product_tabs-1" class="b-tab-characteristics">
            <ul>
              <?php foreach( $attribute_groups as $group ) { ?>
              <li class="title"><?php echo $group['name']; ?></li>
                <?php foreach( $group['attribute'] as $attribut ) { ?>
                <li><span class="key"><?php echo $attribut['name']; ?></span><span class="val"><?php echo $attribut['text']; ?></span></li>
                <?php } ?>
              <?php } ?>
            </ul>
          </div>  <!-- end Характеристики -->
          <?php } ?>


          <!-- Предложения -->
          <div id="js-block-product_tabs-2" class="b-tab-prices">
            <div class="b-table__row_title">
              <div class="b-col__shop">Магазин</div>
              <div class="b-col__description">Описание</div>
              <div class="b-col__price">Цена</div>
              <div class="b-col__delivery">Доставка</div>
              <div class="b-col__distance">От центра</div>
              <div class="b-col__button">&nbsp;</div>
            </div>

            <div class="b-table__row">
              <div class="b-col__shop">
                <img src="/image/catalog/shop.png" alt="">
              </div>
              <div class="b-col__description">
                <span class="b-color" style="background: #474747;"></span>
                <p>Original Letv Le 1 Pro  5.5 2560x1440 Snapdragon 810</p>
              </div>
              <div class="b-col__price">
                <div class="b-price">
                  <span class="b-price__number">25 000</span> <span class="b-price__currency">руб</span>
                </div>
                <div class="b-phone-number">
                  <span class="ic-phone"></span><span class="b-show-number js-open-popup-link js-business-card-href"
                                                      data-shop-id="<?php echo 10/*$shop_id*/; ?>"
                                                      data-shop-name="<?php echo 'depo.md'/*$shop_name*/; ?>"
                                                      data-mfp-src=".js-popup-business-card">Показать номер</span>
                </div>
              </div>
              <div class="b-col__delivery">
                <span class="ic-delivery2"></span>&nbsp;<span>400р</span>
              </div>
              <div class="b-col__distance">20 км</div>
              <div class="b-col__button">
                <a href="/<?php echo $language_href; ?>">Заказать</a>
              </div>
            </div>  <!-- end b-table__row -->

            <div class="b-table__row">
              <div class="b-col__shop">
                <img src="/image/catalog/shop.png" alt="">
              </div>
              <div class="b-col__description">
                <span class="b-color" style="background: #474747;"></span>
                <p>Original Letv Le 1 Pro  5.5 2560x1440 Snapdragon 810</p>
              </div>
              <div class="b-col__price">
                <div class="b-price">
                  <span class="b-price__number">25 000</span> <span class="b-price__currency">руб</span>
                </div>
                <div class="b-phone-number">
                  <span class="ic-phone"></span><span class="b-show-number js-open-popup-link js-business-card-href"
                                                      data-shop-id="<?php echo 10/*$shop_id*/; ?>"
                                                      data-shop-name="<?php echo 'depo.md'/*$shop_name*/; ?>"
                                                      data-mfp-src=".js-popup-business-card">Показать номер</span>
                </div>
              </div>
              <div class="b-col__delivery">
                <span class="ic-delivery2"></span>&nbsp;<span>400р</span>
              </div>
              <div class="b-col__distance">20 км</div>
              <div class="b-col__button">
                <a href="/<?php echo $language_href; ?>">Заказать</a>
              </div>
            </div>  <!-- end b-table__row -->

            <div class="b-table__row">
              <div class="b-col__shop">
                <img src="/image/catalog/shop.png" alt="">
              </div>
              <div class="b-col__description">
                <span class="b-color" style="background: #474747;"></span>
                <p>Original Letv Le 1 Pro  5.5 2560x1440 Snapdragon 810</p>
              </div>
              <div class="b-col__price">
                <div class="b-price">
                  <span class="b-price__number">25 000</span> <span class="b-price__currency">руб</span>
                </div>
                <div class="b-phone-number">
                  <span class="ic-phone"></span><span class="b-show-number js-open-popup-link js-business-card-href"
                                                      data-shop-id="<?php echo 10/*$shop_id*/; ?>"
                                                      data-shop-name="<?php echo 'depo.md'/*$shop_name*/; ?>"
                                                      data-mfp-src=".js-popup-business-card">Показать номер</span>
                </div>
              </div>
              <div class="b-col__delivery">
                <span class="ic-delivery2"></span>&nbsp;<span>400р</span>
              </div>
              <div class="b-col__distance">20 км</div>
              <div class="b-col__button">
                <a href="/<?php echo $language_href; ?>">Заказать</a>
              </div>
            </div>  <!-- end b-table__row -->
          </div>  <!-- end Предложения -->

          <!--  Отзывы -->
          <div id="js-block-product_tabs-3" class="b-tab-reviews">
          <?php if ($mr_tab) echo '<div class="tab-pane" id="tab-review">'.$content_megareviews.'</div>'; ?>
          </div>
          <!-- end  Отзывы -->

        </div>  <!-- end b-prod__tabs -->

        <div class="js-mob-prod-tabs"></div>

        <div class="g-row">
          <div class="b-block-product">
            <div class="b-block-product__title">
              <span>Популярные телефоны</span>
            </div>
            <div class="b-block-product__content">
              <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                  <span class="b-product-carousel__price">$ 39.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto2.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                  <span class="b-product-carousel__price">$ 42.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto3.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                  <span class="b-product-carousel__price">$ 75.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto4.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                  <span class="b-product-carousel__price">$ 75.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                  <span class="b-product-carousel__price">$ 39.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto2.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                  <span class="b-product-carousel__price">$ 42.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto3.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                  <span class="b-product-carousel__price">$ 75.99</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto4.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                  <span class="b-product-carousel__price">$ 75.99</span>
                </div>

              </div>
            </div>
          </div>
        </div>  <!-- end g-row -->

      </div>  <!-- end g-container -->

      <div class="b-brands">
          <div class="g-container">
            <div class="b-brands__title">
              <span>Популярные бренды</span>
              <a class="b-brands__link" href="brands.html">Показать все >></a>
            </div>
            <div class="b-brands__content">
              <ul>
                <?php foreach ($shops as $shop) { ?>
                  <li><a href="/<?php echo $shop['href']; ?>"><img src="<?php echo $shop['image']; ?>" alt="<?php echo $shop['name']; ?>"></a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>

    </main>


<!-- ==================================================================================== -->
<!-- =====Коментарии=============================================================================== -->
<!-- ==================================================================================== -->
<!-- ==================================================================================== -->
         
        

<!-- =====Старый коментарий=============================================================================== -->
<!-- ==================================================================================== -->
      <div style="display:none;">
          <?php if ($mr_tab || (!$mr_status && $review_status)) { ?>
            <div class="tab-pane" id="tab-review">
              <form class="form-horizontal" id="form-review">
                <div id="review"></div>
                <h2><?php echo $text_write; ?></h2>
                <?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                <?php echo $captcha; ?>
                <div class="buttons clearfix">
                  <div class="pull-right">
                    <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                  </div>
                </div>
                <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            </div>
            <?php } ?>


     ***************     

          <?php if ($review_status || $mr_status) { ?>
          <div class="rating">
            <p>
              <?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if ($rating < $i) { ?>
              <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
              <?php } else { ?>
              <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
              <?php } ?>
              <?php } ?>
              <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click');if($('#megareviews_box').length>0)$('html,body').animate({scrollTop: $('#megareviews_box').offset().top}, 500);return false;"><?php echo $reviews; ?></a> /
              <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $text_write; ?></a></p>
            <hr>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style" data-url="<?php echo $share; ?>"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
            <!-- AddThis Button END -->
          </div>
          <?php } ?>
        </div>
<!-- ==================================================================================== -->
<!-- ===Конец коментарий================================================================================= -->
<!-- ==================================================================================== -->
<!-- ==================================================================================== -->







<script type="text/javascript">
$(document).ready(function() {
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
//   //Аякс на получение данных по магазину
//   $(document).ready(function() {
//     $.ajax({
//         url: 'index.php?route=product/shops/getShopInfoAjax',
//         type: 'post',
//         data: "shop_id=5",
//         dataType: 'json',
//         beforeSend: function() {
//         	console.log('loading msg');
//         },
//         complete: function() {
//           console.log('reset msg');
//         },
//         success: function(json) {
//             console.log(json);
// 		    },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
//         }
//     });
// });


// Видео
$('.b-video__list').on('click', 'li', function(){
  var src_video = $(this).find('.b-video__list-mini iframe').attr('src');
  $('.b-video__main iframe').attr('src', src_video);
});
</script>
<script>
   //$(function () {
	$(document).ready(function () {
        $('#review .pagination a').on('click', function () {
            $('#review').fadeOut('slow');

            $('#review').load(this.href);

            $('#review').fadeIn('slow');

            return false;
        });

        $('#review').load('/index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

		
        $("#btn-review").on("click", function () {
           //debugger;
		    
            $.ajax({
                url: '/index.php?route=product/product/write&product_id=170487',
                type: 'post',
                dataType: 'json',
                data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
                beforeSend: function () {
                    $('.success, .warning').remove();
                    $('#button_review').attr('disabled', true);
                    $('#review-title').after('<div class="attention"><img src="//cdn.alta-karter.ru/catalog/view/theme/default/image/loading.gif" alt="" /></div>');
                },
                complete: function () {
                    $('#button_review').attr('disabled', false);
                    $('.attention').remove();
                },
                success: function (data) {
                  console.log(data);
                  
                    if (data['error']) {
                        $('#review-title').after('<div class="warning">' + data['error'] + '</div>');
                    }

                    if (data['success']) {
                        $('#review-title').after('<div class="success">' + data['success'] + '</div>');

                        $('input[name=\'name\']').val('');
                        $('textarea[name=\'text\']').val('');
                        $('input[name=\'rating\']:checked').attr('checked', '');
                        $('input[name=\'captcha\']').val('');
                    }
                }
            });
        });
    });
	
	
	$(document).ready(function(){
	console.log('product_page111');
});
</script>
<?php echo $footer; ?>
