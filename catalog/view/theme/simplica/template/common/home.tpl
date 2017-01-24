<?php echo $header; ?>

<?php
$text_customer_viewed_products = 'Вы просматривали';
$text_popular_products = 'Самые просматриваемые товары';




//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<pre>";  print_r(var_dump( $main_page_products )); echo "</pre>";
//echo "<pre>";  print_r(var_dump( $main_product_sorted_by_categs )); echo "</pre>";




?>
    <main class="b-main">
      <div class="g-container">

        <div class="g-col-left">
          <div class="b-banners">

            <div class="b-banners__block">
              <a href="#">
                <img src="catalog/view/theme/simplica/img/banners/left-banner1.jpg" alt="">
              </a>
            </div>

            <div class="b-banners__block">
              <a href="#">
                <img src="catalog/view/theme/simplica/img/banners/left-banner2.png" alt="">
              </a>
            </div>

          </div>
        </div>

        <div class="g-col-center">
          <div class="g-row b-home-top-row">
            <div class="b-home-slider owl-carousel js-owl-home-slider">
              <?php foreach ($large_banners as $baner) { ?>
              <div class="b-home-slider__item">
                <a href="<?php echo $baner['baner_url']; ?>">
                  <img src="/image/banners/mainpage_large/<?php echo $baner['baner_pic']; ?>" alt="<?php echo $baner['baner_title']; ?>">
                </a>
              </div>
              <?php } ?>
            </div>  <!-- end b-home-slider -->


            <?php if ( isset($medium_banners) && count($medium_banners) > 0 ) { ?>
            <div class="b-upcoming-prod b-upcoming-prod_type1">
            <?php } else { ?>
            <div class="b-upcoming-prod b-upcoming-prod_type2">
              <div class="b-upcoming-prod__title">
                <span>Набирающие популярность</span>
              </div>
            <?php } ?>

              <div class="b-upcoming-prod__content">

                <?php if ( isset($medium_banners) && count($medium_banners) > 0 ) { ?>
                <?php foreach ($medium_banners as $baner) { ?>
                <div class="b-upcoming-prod__banner">
                  <a href="<?php echo $baner['baner_url']; ?>" class="b-upcoming-prod__block-link">
                    <img src="/image/banners/mainpage_medium/<?php echo $baner['baner_pic']; ?>" alt="<?php echo $baner['baner_title']; ?>">
                    <pre class="b-upcoming-prod__block-text" style="color: <?php echo $baner['baner_text_color']; ?>"><?php echo $baner['baner_text']; ?></pre>
                  </a>
                </div>
                <?php } ?>
                <?php } else { ?>

                <?php for ($i = 0; $i < 7; $i++) { ?>
                <div class="b-upcoming-prod__block">
                  <a href="product.html" class="b-upcoming-prod__block-link">
                    <div class="b-upcoming-prod__block-text">
                      Женские пальто больших размеров
                      <img src="catalog/view/theme/simplica/img/product/violanti.png" alt="">
                      <div class="b-upcoming-prod__block-price">$ 25.50</div>
                    </div>
                    <div class="b-upcoming-prod__block-img">
                      <img src="catalog/view/theme/simplica/img/product/7384-02.png" alt="">
                    </div>
                  </a>
                </div>
                <?php } ?>
                <?php } ?>

              </div>  <!-- end b-upcoming-prod__content -->

            </div>  <!-- end b-upcoming-prod -->

          </div>  <!-- end g-row -->




          <!-- Популярные за день -->
          <?php if ( isset($last_viewed_products_day) ) { ?>
          <div class="g-row">
            <div class="b-block-product b-block-product_popular">
              <div class="b-block-product__title">
                <span>Популярные за день</span>
              </div>
              <div class="b-block-product__content">
                <ul>
                  <?php foreach ( $last_viewed_products_day as $prod ) { ?>
                  <li>
                    <div class="b-block-product__img">
                      <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                    </div>
                    <a href="<?php echo $prod['original_url']; ?>"><?php echo $prod['name']; ?></a>
                    <span class="b-block-product__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>  <!-- end g-row -->
          <?php } ?>

          <!-- Популярные за неделю -->
          <?php if ( isset($last_viewed_products_week) ) { ?>
          <div class="g-row">
            <div class="b-block-product b-block-product_popular">
              <div class="b-block-product__title">
                <span>Популярные за неделю</span>
              </div>
              <div class="b-block-product__content">
                <ul>
                  <?php foreach ( $last_viewed_products_week as $prod ) { ?>
                  <li>
                    <div class="b-block-product__img">
                      <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                    </div>
                    <a href="<?php echo $prod['original_url']; ?>"><?php echo $prod['name']; ?></a>
                    <span class="b-block-product__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>  <!-- end g-row -->
          <?php } ?>

          <!-- Популярные за месяц -->
          <?php if ( isset($last_viewed_products_month) ) { ?>
          <div class="g-row">
            <div class="b-block-product b-block-product_popular">
              <div class="b-block-product__title">
                <span>Популярные за месяц</span>
              </div>
              <div class="b-block-product__content">
                <ul>
                  <?php foreach ( $last_viewed_products_month as $prod ) { ?>
                  <li>
                    <div class="b-block-product__img">
                      <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                    </div>
                    <a href="<?php echo $prod['original_url']; ?>"><?php echo $prod['name']; ?></a>
                    <span class="b-block-product__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>  <!-- end g-row -->
          <?php } ?>




          <div class="g-row">
            <div class="b-block-category">
              <div class="b-block-category__title">
                <span>По категориям</span>
              </div>
              <ul>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-apple"></span>
                  </div>
                  <a href="category.html">Apple</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-auto"></span>
                  </div>
                  <a href="category.html">Auto</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-bags"></span>
                  </div>
                  <a href="category.html">Bags & Luggage</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-boolks"></span>
                  </div>
                  <a href="category.html">Boolks & Magazines</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-children"></span>
                  </div>
                  <a href="category.html">Children</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-entertainment"></span>
                  </div>
                  <a href="category.html">Entertainment</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-finance"></span>
                  </div>
                  <a href="category.html">Finance</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-flowers"></span>
                  </div>
                  <a href="category.html">Flowers & Gifts</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-freebies"></span>
                  </div>
                  <a href="category.html">Freebies</a>
                </li>
                <li>
                  <div class="b-block-category__img">
                    <span class="ic-freebies2"></span>
                  </div>
                  <a href="category.html">Freebies</a>
                </li>
              </ul>
            </div>
          </div>  <!-- end g-row -->

          <div class="g-row">
            <div class="b-block-product b-block-product_tabs">
              <div class="b-block-product__title">
                <span>Вам может понравиться</span>
              </div>
              <div class="b-block-product__content js-block-product_tabs">
                <div class="g-scroll-line js-scroll-line">
                  <ul>
                    <li><a href="#js-block-product_tabs-1">Все</a></li>
                    <?php $count_cat = 2; ?>
                    <?php foreach ( $main_product_sorted_by_categs as $cat ) { ?>
                    <li><a href="#js-block-product_tabs-<?php echo $count_cat++; ?>"><?php echo $cat['name']; ?></a></li>
                    <?php } ?>
                  </ul>
                </div>
                <div id="js-block-product_tabs-1">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                    <?php foreach ( $main_page_products as $prod ) { ?>
                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                      </div>
                      <a href="<?php echo $prod['href']; ?>" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                      <span class="b-product-carousel__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                    </div>
                    <?php } ?>

                  </div>
                </div>
                <?php $count_cat = 2; ?>
                <?php foreach ( $main_product_sorted_by_categs as $cat ) { ?>
                <div id="js-block-product_tabs-<?php echo $count_cat++; ?>">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                    <?php foreach ( $cat['products'] as $prod ) { ?>
                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                      </div>
                      <a href="<?php echo $prod['href']; ?>" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                      <span class="b-product-carousel__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                    </div>
                    <?php } ?>

                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>  <!-- end g-row -->

          <?php if ( $popular_products ) { ?>
          <!-- Самые просматриваемые товары -->
          <div class="g-row">
            <div class="b-block-product">
              <div class="b-block-product__title">
                <span><?php echo $text_popular_products; ?></span>
              </div>
              <div class="b-block-product__content">
                <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                  <?php foreach ($popular_products as $prod) { ?>
                  <div class="b-product-carousel__item">
                    <div class="b-product-carousel__img">
                      <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                    </div>
                    <a href="<?php echo $prod['href']; ?>" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                    <span class="b-product-carousel__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                  </div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>  <!-- end g-row -->
          <?php } ?>

        </div>  <!-- end g-col-center -->

        <div class="g-clear"></div>

        <?php if ( $customer_viewed_products ) { ?>
        <!-- Вы просматривали -->
        <div class="g-row">
          <div class="b-block-product b-most-viewed-products">
            <div class="b-block-product__title">
                <span><?php echo $text_customer_viewed_products; ?></span>
            </div>
            <div class="b-block-product__content">
              <div class="b-product-carousel owl-carousel js-most-viewed-carousel">

                <?php foreach ($customer_viewed_products as $prod) { ?>
                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                  </div>
                  <a href="<?php echo $prod['href']; ?>" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                  <span class="b-product-carousel__price"><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span>
                </div>
                <?php } ?>

              </div>
            </div>
          </div>
        </div>  <!-- end g-row -->
        <?php } ?>

      </div>  <!-- end g-container -->

      <div class="b-brands">
        <div class="g-container">
          <div class="b-brands__title">
            <span>Бренды и магазины</span>
            <a class="b-brands__link" href="/brands_and_shops">Показать все >></a>
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

      <div class="b-benefits">
        <div class="g-container">
          <div class="b-benefits__title">
            <span>Преимущества</span>
          </div>
          <div class="b-benefits__content">

            <div class="b-benefits__block">
              <div class="b-benefits__block-img">
                <img src="catalog/view/theme/simplica/img/benefits/tablet.png" alt="">
              </div>
              <span class="b-benefits__block-title">Удобно</span>
              <p class="b-benefits__block-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
            </div>

            <div class="b-benefits__block-more js-remove-this">Показать ещё</div>

            <div class="b-benefits__block">
              <div class="b-benefits__block-img">
                <img src="catalog/view/theme/simplica/img/benefits/tag.png" alt="">
              </div>
              <span class="b-benefits__block-title">Без комиссий</span>
              <p class="b-benefits__block-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
            </div>

            <div class="b-benefits__block">
              <div class="b-benefits__block-img">
                <img src="catalog/view/theme/simplica/img/benefits/time.png" alt="">
              </div>
              <span class="b-benefits__block-title">Экономия времени</span>
              <p class="b-benefits__block-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
            </div>

          </div>
        </div>
      </div>
    </main>


<?php echo $footer; ?>