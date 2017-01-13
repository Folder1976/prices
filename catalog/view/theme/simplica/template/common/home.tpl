<?php echo $header; ?>

<?php
$text_viewed_products = 'Вы просматривали';




//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<pre>";  print_r(var_dump( $viewed_products )); echo "</pre>";

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

            <div class="b-upcoming-prod b-upcoming-prod_type2">
              <div class="b-upcoming-prod__title">
                <span>Набирающие популярность</span>
              </div>

              <div class="b-upcoming-prod__content">
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
              </div>  <!-- end b-upcoming-prod__content -->

            </div>  <!-- end b-upcoming-prod -->
          </div>  <!-- end g-row -->

          <div class="g-row">
            <div class="b-block-product b-block-product_popular">
              <div class="b-block-product__title">
                <span>Популярные телефоны</span>
              </div>
              <div class="b-block-product__content">
                <ul>
                  <li>
                    <div class="b-block-product__img">
                      <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                    </div>
                    <a href="product.html">[Подлинная] VONTAR MX-4K RK3229 Rockchip </a>
                    <span class="b-block-product__price">$ 25.50</span>
                  </li>
                  <li>
                    <div class="b-block-product__img">
                      <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                    </div>
                    <a href="product.html">[Подлинная] VONTAR MX-4K RK3229 Rockchip </a>
                    <span class="b-block-product__price">$ 25.50</span>
                  </li>
                  <li>
                    <div class="b-block-product__img">
                      <img src="catalog/view/theme/simplica/img/product/foto_pop2.png" alt="">
                    </div>
                    <a href="product.html">Оригинал Teclast X3 Pro Tablet PC Intel Skyl</a>
                    <span class="b-block-product__price">$ 25.50</span>
                  </li>
                  <li>
                    <div class="b-block-product__img">
                      <img src="catalog/view/theme/simplica/img/product/foto_pop2.png" alt="">
                    </div>
                    <a href="product.html">Оригинал Teclast X3 Pro Tablet PC Intel Skyl</a>
                    <span class="b-block-product__price">$ 25.50</span>
                  </li>
                  <li>
                    <div class="b-block-product__img">
                      <img src="catalog/view/theme/simplica/img/product/foto_pop3.png" alt="">
                    </div>
                    <a href="product.html">Оригинал МИ Xiaomi Redmi 3 S 3гб 5mps</a>
                    <span class="b-block-product__price">$ 25.50</span>
                  </li>
                  <li>
                    <div class="b-block-product__img">
                      <img src="catalog/view/theme/simplica/img/product/foto_pop3.png" alt="">
                    </div>
                    <a href="product.html">Оригинал МИ Xiaomi Redmi 3 S 3гб 5mps</a>
                    <span class="b-block-product__price">$ 25.50</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>  <!-- end g-row -->

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
                    <li><a href="#js-block-product_tabs-2">Детские товары</a></li>
                    <li><a href="#js-block-product_tabs-3">Электроника</a></li>
                    <li><a href="#js-block-product_tabs-4">Спорт и активный отдых</a></li>
                    <li><a href="#js-block-product_tabs-5">Бытовая техника</a></li>
                    <li><a href="#js-block-product_tabs-6">Парфюмерия</a></li>
                  </ul>
                </div>
                <div id="js-block-product_tabs-1">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto1.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                      <span class="b-product-carousel__price">$ 39.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto2.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                      <span class="b-product-carousel__price">$ 42.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto3.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto4.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto1.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                      <span class="b-product-carousel__price">$ 39.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto2.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                      <span class="b-product-carousel__price">$ 42.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto3.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto4.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                  </div>
                </div>
                <div id="js-block-product_tabs-2">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto1.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                      <span class="b-product-carousel__price">$ 39.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto2.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                      <span class="b-product-carousel__price">$ 42.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto3.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto4.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto1.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                      <span class="b-product-carousel__price">$ 39.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto2.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                      <span class="b-product-carousel__price">$ 42.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto3.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto4.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                  </div>
                </div>
                <div id="js-block-product_tabs-3">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto1.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                      <span class="b-product-carousel__price">$ 39.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto2.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                      <span class="b-product-carousel__price">$ 42.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto3.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto4.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto1.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
                      <span class="b-product-carousel__price">$ 39.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto2.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X98 Air/X98 Plus II 9.7 дюймов Intel Cherry Trail</a>
                      <span class="b-product-carousel__price">$ 42.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto3.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                    <div class="b-product-carousel__item">
                      <div class="b-product-carousel__img">
                        <img src="catalog/view/theme/simplica/img/product/foto4.png" alt="">
                      </div>
                      <a href="product.html" class="b-product-carousel__link">14 дюймов 8 ГБ оперативной памяти и 256 ГБ SSD ноутбук ноутбука с Intel Celeron</a>
                      <span class="b-product-carousel__price">$ 75.99</span>
                    </div>

                  </div>
                </div>
                <div id="js-block-product_tabs-4">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel"></div>
                </div>
                <div id="js-block-product_tabs-5">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel"></div>
                </div>
                <div id="js-block-product_tabs-6">
                  <div class="b-product-carousel owl-carousel js-product_owl-carousel"></div>
                </div>
              </div>
            </div>
          </div>  <!-- end g-row -->

          <div class="g-row">
            <div class="b-block-product">
              <div class="b-block-product__title">
                <span><?php echo $text_viewed_products; ?></span>
              </div>
              <div class="b-block-product__content">
                <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                  <?php foreach ($viewed_products as $prod) { ?>
                  <div class="b-product-carousel__item">
                    <div class="b-product-carousel__img">
                      <img src="/image/<?php if ( $prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                    </div>
                    <a href="product.html" class="b-product-carousel__link"><?php echo $prod['name']; ?></a>
                    <span class="b-product-carousel__price"><?php echo $prod['price']; ?></span>
                  </div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>  <!-- end g-row -->

        </div>  <!-- end g-col-center -->

        <div class="g-clear"></div>

        <div class="g-row">
          <div class="b-block-product b-most-viewed-products">
            <div class="b-block-product__title">
                <span>Самые просматриваемые товары</span>
            </div>
            <div class="b-block-product__content">
              <div class="b-product-carousel owl-carousel js-most-viewed-carousel">

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">[Подлинная] VONTAR MX-4K RK3229 Rockchip</a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop2.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X3 Pro Tablet PC Intel Skyl</a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop3.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал МИ Xiaomi Redmi 3 S</a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал Teclast X3 Pro Tablet PC Intel Sky</a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">[Подлинная] VONTAR MX-4K RK3229 Rockchip </a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop3.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал МИ Xiaomi Redmi 3 S</a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">[Подлинная] VONTAR MX-4K RK3229 Rockchip </a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">[Подлинная] VONTAR MX-4K RK3229 Rockchip </a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop3.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал МИ Xiaomi Redmi 3 S</a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>


                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="catalog/view/theme/simplica/img/product/foto_pop1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">[Подлинная] VONTAR MX-4K RK3229 Rockchip </a>
                  <span class="b-product-carousel__price">$ 25.50</span>
                </div>

              </div>
            </div>
          </div>
        </div>  <!-- end g-row -->

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