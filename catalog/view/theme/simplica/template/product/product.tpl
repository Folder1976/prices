<?php echo $header; ?>

<?php
//echo "<pre>";  print_r(var_dump( $_GET['_route_'] )); echo "</pre>";
?>

<div class="b-popup b-prod-img-popup js-popup-prod-img mfp-hide">
  <div class="b-prod-img-popup__title">
    <h2 class="b-prod-info__title"><?php echo $heading_title; ?></h2>
    <div class="b-prod-info__block-price">
      <span>657.00 - 1106.55 MDL</span>
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



    <main class="b-product">
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
                <a href="#"><span class="ic-fb-grey"></span></a>
                <a href="#"><span class="ic-twitter-grey"></span></a>
                <a href="#"><span class="ic-linked-in-grey"></span></a>
                <a href="#"><span class="ic-pininterest-grey"></span></a>
                <div class="b-compare-btn">
                  <a href="#">Сравнить</a>
                </div>
              </div>
            </div>
          </div>  <!-- end g-col-left_prod -->

          <div class="g-col-right g-col-right_prod">

              <div class="b-prod-info">

                <h2 class="b-prod-info__title"><?php echo $heading_title; ?></h2>

                <div class="b-prod-info__block">
                  <div class="b-prod-info__block-price">
                    <span>657.00 - 1106.55 MDL</span>
                    <div class="b-rating" data-count_r="5" data-width_star="10">
                      <div style="width: 70%"></div>
                    </div>
                  </div>
                  <div class="b-prod-info__block-summary">
                    <span class="b-offers">40 предложений</span>
                    <span class="b-recall">1 отзыв</span>
                    <span class="b-send-recall">Оставить отзыв</span>
                  </div>
                </div>  <!-- end b-prod-info__block -->

                <div class="b-prod-info__content">
                  <div class="g-row">
                    <div class="b-prod-info__content-key">ДРУГИЕ ХАРАКЕРИСТКИ</div>
                    <div class="b-prod-info__content-val"></div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Hyper-Threading (HT):</div>
                    <div class="b-prod-info__content-val">-</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Коеффициент умножения:</div>
                    <div class="b-prod-info__content-val">26</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Максимальная полоса пропускания памяти:</div>
                    <div class="b-prod-info__content-val">17 Гб/c</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Сокет:</div>
                    <div class="b-prod-info__content-val">LGA1155</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Тепловыделение:</div>
                    <div class="b-prod-info__content-val">65 Вт</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Техпроцесс</div>
                    <div class="b-prod-info__content-val">32нм</div>
                  </div>

                  <div class="b-prod-info__content-more js-prod-info__content-more">Ещё</div>

                  <div class="g-row">
                    <div class="b-prod-info__content-key">Максимальная полоса пропускания памяти:</div>
                    <div class="b-prod-info__content-val">17 Гб/c</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Сокет:</div>
                    <div class="b-prod-info__content-val">LGA1155</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Тепловыделение:</div>
                    <div class="b-prod-info__content-val">65 Вт</div>
                  </div>
                  <div class="g-row">
                    <div class="b-prod-info__content-key">Техпроцесс</div>
                    <div class="b-prod-info__content-val">32нм</div>
                  </div>
                </div>  <!-- end b-prod-info__content -->

                <div class="b-prod-info__btn-buy">
                  <a href="#" class="g-btn">Где купить ></a>
                </div>
              </div>

          </div>  <!-- end g-col-right_prod -->

          <div class="g-clear"></div>

        <div class="b-breadcrumb b-breadcrumb_mob">
          <a href="index.html"><span class="ic-home"></span></a><span>&nbsp;>&nbsp;</span>
          <a href="category.html">Комплектующие</a><span>&nbsp;>&nbsp;</span>
          <a href="category.html">Материнские платы</a><span>&nbsp;>&nbsp;</span>
          <a href="product.html">Original Letv Le 1 Pro 5.5</a>
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

        <div class="g-row">
          <div class="b-block-product">
            <div class="b-block-product__title">
              <span>Видео</span>
            </div>
            <div class="b-block-product__content">
              <div class="b-video__main">
                <img src="img/video/homepageimage.png" alt="">
              </div>
              <div class="b-video__list">
                <ul>
                  <li>
                    <img src="img/video/homepageimage-------5.png" alt="">
                    <h3 class="b-video__list-title">Топ 5 элитных домов на колесах</h3>
                    <p class="b-video__list-author">Авто тайм</p>
                  </li>
                  <li>
                    <img src="img/video/homepageimage-------5.png" alt="">
                    <h3 class="b-video__list-title">Топ 5 элитных домов на колесах</h3>
                    <p class="b-video__list-author">Авто тайм</p>
                  </li>
                  <li>
                    <img src="img/video/homepageimage-------5.png" alt="">
                    <h3 class="b-video__list-title">Топ 5 элитных домов на колесах</h3>
                    <p class="b-video__list-author">Авто тайм</p>
                  </li>
                </ul>
              </div>
              <div class="g-clear"></div>
            </div>
          </div>
        </div>  <!-- end g-row -->

        <div class="g-row">
          <div class="b-block-product">
            <div class="b-block-product__title">
              <span>Похожие товары</span>
            </div>
            <div class="b-block-product__content">
              <div class="b-product-carousel owl-carousel js-product_owl-carousel">

                <div class="b-product-carousel__item">
                  <div class="b-product-carousel__img">
                    <img src="img/product/foto1.png" alt="">
                  </div>
                  <a href="product.html" class="b-product-carousel__link">Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ Оригинал ONDA V820w X86 Intel Z3735F Quad Core 2 ГБ 32 ГБ</a>
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

        <div class="b-prod__tabs js-prod_tabs">
          <div class="g-scroll-line js-scroll-line">
            <ul>
              <li><a href="/<?php echo $_GET['_route_']; ?>#js-block-product_tabs-1">Характеристики</a></li>
              <li><a href="/<?php echo $_GET['_route_']; ?>#js-block-product_tabs-2">Предложения</a></li>
              <li><a href="/<?php echo $_GET['_route_']; ?>#js-block-product_tabs-3">Отзывы 173</a></li>
              <li><a href="/<?php echo $_GET['_route_']; ?>#js-block-product_tabs-4">Вопросы и ответы</a></li>
            </ul>
          </div>

          <!-- Характеристики -->
          <div id="js-block-product_tabs-1" class="b-tab-characteristics">
            <ul>
              <li class="title">Графика</li>
              <li><span class="key">Графическое ядро</span><span class="val">Intel HD graphics</span></li>
              <li><span class="key">Интегрированное графическое ядро</span><span class="val">+</span></li>
              <li><span class="key">Интегрированное графическое ядро</span><span class="val">+</span></li>
              <li class="title">Графика</li>
              <li><span class="key">ИКоличество ядер</span><span class="val">2</span></li>
              <li><span class="key">Частота процессора</span><span class="val">2600 мгц</span></li>
              <li><span class="key">Частота процессора</span><span class="val">2600 мгц</span></li>
              <li class="title">Графика</li>
              <li><span class="key">Графическое ядро</span><span class="val">Intel HD graphics</span></li>
              <li><span class="key">Интегрированное графическое ядро</span><span class="val">+</span></li>
              <li><span class="key">Интегрированное графическое ядро</span><span class="val">+</span></li>
              <li class="title">Графика</li>
              <li><span class="key">ИКоличество ядер</span><span class="val">2</span></li>
              <li><span class="key">ИКоличество ядер</span><span class="val">2</span></li>
              <li><span class="key">Частота процессора</span><span class="val">2600 мгц</span></li>
            </ul>
          </div>  <!-- end Характеристики -->

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
                <img src="img/product/shop.png" alt="">
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
                  <span class="ic-phone"></span><span class="b-show-number js-remove-this">Показать номер</span> <span class="b-number">123-45-67</span>
                </div>
              </div>
              <div class="b-col__delivery">
                <span class="ic-delivery2"></span>&nbsp;<span>400р</span>
              </div>
              <div class="b-col__distance">20 км</div>
              <div class="b-col__button">
                <a href="#">Заказать</a>
              </div>
            </div>  <!-- end b-table__row -->

            <div class="b-table__row">
              <div class="b-col__shop">
                <img src="img/product/shop.png" alt="">
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
                  <span class="ic-phone"></span><span class="b-show-number js-remove-this">Показать номер</span> <span class="b-number">123-45-67</span>
                </div>
              </div>
              <div class="b-col__delivery">
                <span class="ic-delivery2"></span>&nbsp;<span>400р</span>
              </div>
              <div class="b-col__distance">20 км</div>
              <div class="b-col__button">
                <a href="#">Заказать</a>
              </div>
            </div>  <!-- end b-table__row -->

            <div class="b-table__row">
              <div class="b-col__shop">
                <img src="img/product/shop.png" alt="">
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
                  <span class="ic-phone"></span><span class="b-show-number js-remove-this">Показать номер</span> <span class="b-number">123-45-67</span>
                </div>
              </div>
              <div class="b-col__delivery">
                <span class="ic-delivery2"></span>&nbsp;<span>400р</span>
              </div>
              <div class="b-col__distance">20 км</div>
              <div class="b-col__button">
                <a href="#">Заказать</a>
              </div>
            </div>  <!-- end b-table__row -->
          </div>  <!-- end Предложения -->

          <!-- Отзывы -->
          <div id="js-block-product_tabs-3" class="b-tab-reviews">

            <div class="b-reviews">
              <div class="b-reviews__date">01 сентября 2016</div>
              <div class="b-reviews__author">
                <div class="b-reviews__author-foto_mob"><img src="img/reviews/man-mob.jpg" alt=""></div>
                <div class="b-reviews__author-name">Sergei ddd</div>
                <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
              </div>
              <div class="b-reviews__content">
                <div class="b-reviews__rating">
                  <div class="b-rating" data-count_r="5" data-width_star="14">
                    <div style="width: 70%"></div>
                  </div>
                </div>
                <div class="b-reviews__message_plus">
                <div class="b-reviews__message-title"><h4>Достоинства</h4> <span class="ic-reviews_plus_mob"></span></div>
                  <p>Безусловно, камера: в дневное время снимает на уровне Флагманов 15-16 года, в ночное уже похуже;</p>
                </div>
                <div class="b-reviews__message_minus">
                  <div class="b-reviews__message-title"><h4>Недостатки</h4> <span class="ic-reviews_minus_mob"></span></div>
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                </div>
              </div>
              <div class="b-reviews__buttons">
                <a href="#" class="b-reviews__answer">Ответить</a>
              </div>
              <div class="g-clear"></div>
              <div class="b-reviews__bottom">
              <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
              </div>
            </div>  <!-- end b-reviews -->

            <div class="b-reviews">
              <div class="b-reviews__date">01 сентября 2016</div>
              <div class="b-reviews__author">
                <div class="b-reviews__author-foto_mob"><img src="img/reviews/man-mob.jpg" alt=""></div>
                <div class="b-reviews__author-name">Sergei ddd</div>
                <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
              </div>
              <div class="b-reviews__content">
                <div class="b-reviews__rating">
                  <div class="b-rating" data-count_r="5" data-width_star="14">
                    <div style="width: 80%"></div>
                  </div>
                </div>
                <div class="b-reviews__message_plus">
                  <div class="b-reviews__message-title"><h4>Достоинства</h4> <span class="ic-reviews_plus_mob"></span></div>
                  <p>Безусловно, камера: в дневное время снимает на уровне Флагманов 15-16 года, в ночное уже похуже;</p>
                </div>
                <div class="b-reviews__message_minus">
                  <div class="b-reviews__message-title"><h4>Недостатки</h4> <span class="ic-reviews_minus_mob"></span></div>
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                </div>
              </div>
              <div class="b-reviews__buttons">
                <a href="#" class="b-reviews__answer">Ответить</a>
              </div>
              <div class="g-clear"></div>
              <div class="b-reviews__bottom">
                <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
              </div>
            </div>  <!-- end b-reviews -->

            <div class="b-add-message">

              <form action="">
                <div class="f-field-wrapper f-field-wrapper_textarea">
                  <textarea name="question_reviews" class="f-textarea" placeholder="Добавить отзыв"></textarea>
                </div>
                <div class="f-group">
                  <button type="submit" class="f-button">Добавить отзыв</button>
                </div>
              </form>

            </div>  <!-- end b-add-message -->

          </div>  <!-- end Отзывы -->

          <!-- Вопросы и ответы -->
          <div id="js-block-product_tabs-4" class="b-tab-reviews b-tab-questions">

            <div class="b-question">
              <div class="b-question__question-block">
                <p>Безусловно, камера: в дневное время снимает на уровне Флагманов 15-16 года, в ночное уже похуже;</p>
                <div class="b-reviews__buttons">
                  <a href="#" class="b-reviews__answer">Ответить</a>
                </div>
              </div>

              <div class="b-question__answer-block">
                <div class="b-question__answer-message">
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                  <div class="b-question__answer-message-bottom">
                    <a href="javascript:void(0)" class="b-question__answer-all-message js-show-all-answer">
                      <span class="ic-two-arrow-down"></span>Показать ещё ответы (2)
                    </a>
                    <div class="b-reviews__bottom">
                      <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
                    </div>
                    <div class="b-reviews__date">01 сентября 2016</div>
                  </div>
                </div>
                <div class="b-reviews__author">
                  <div class="b-reviews__author-name">Sergei ddd</div>
                  <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
                </div>
              </div>  <!-- end b-question__answer-block -->

              <div class="b-question__answer-block g-hidden">
                <div class="b-question__answer-message">
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                  <div class="b-question__answer-message-bottom">
                    <div class="b-reviews__bottom">
                      <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
                    </div>
                    <div class="b-reviews__date">01 сентября 2016</div>
                  </div>
                </div>
                <div class="b-reviews__author">
                  <div class="b-reviews__author-name">Sergei ddd</div>
                  <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
                </div>
              </div>  <!-- end b-question__answer-block -->

              <div class="b-question__answer-block g-hidden">
                <div class="b-question__answer-message">
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                  <div class="b-question__answer-message-bottom">
                    <div class="b-reviews__bottom">
                      <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
                    </div>
                    <div class="b-reviews__date">01 сентября 2016</div>
                  </div>
                </div>
                <div class="b-reviews__author">
                  <div class="b-reviews__author-name">Sergei ddd</div>
                  <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
                </div>
              </div>  <!-- end b-question__answer-block -->

              <div class="b-reviews__buttons">
                <a href="#" class="b-reviews__answer">Ответить</a>
              </div>
            </div>  <!-- end b-question -->

            <div class="b-question">
              <div class="b-question__question-block">
                <p>Безусловно, камера: в дневное время снимает на уровне Флагманов 15-16 года, в ночное уже похуже;</p>
                <div class="b-reviews__buttons">
                  <a href="#" class="b-reviews__answer">Ответить</a>
                </div>
              </div>

              <div class="b-question__answer-block">
                <div class="b-question__answer-message">
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                  <div class="b-question__answer-message-bottom">
                    <a href="javascript:void(0)" class="b-question__answer-all-message js-show-all-answer">
                      <span class="ic-two-arrow-down"></span>Показать ещё ответы (2)
                    </a>
                    <div class="b-reviews__bottom">
                      <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
                    </div>
                    <div class="b-reviews__date">01 сентября 2016</div>
                  </div>
                </div>
                <div class="b-reviews__author">
                  <div class="b-reviews__author-name">Sergei ddd</div>
                  <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
                </div>
              </div>  <!-- end b-question__answer-block -->

              <div class="b-question__answer-block g-hidden">
                <div class="b-question__answer-message">
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                  <div class="b-question__answer-message-bottom">
                    <div class="b-reviews__bottom">
                      <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
                    </div>
                    <div class="b-reviews__date">01 сентября 2016</div>
                  </div>
                </div>
                <div class="b-reviews__author">
                  <div class="b-reviews__author-name">Sergei ddd</div>
                  <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
                </div>
              </div>  <!-- end b-question__answer-block -->

              <div class="b-question__answer-block g-hidden">
                <div class="b-question__answer-message">
                  <p>Динамик, Звук на слабую 4-ку. было бы здорово, если было два динамика (где-то читал, что можно через root сделать верхний динамик рабочим не только для звонков, а, например, для прослушивания музыки, но я не стал этого делать); гигабйтов, доступ</p>
                  <div class="b-question__answer-message-bottom">
                    <div class="b-reviews__bottom">
                      <p>Отзыв полезен? <a href="#" class="b-reviews__answer-useful">Да</a> / <a href="#" class="b-reviews__answer-not-useful">Нет</a></p>
                    </div>
                    <div class="b-reviews__date">01 сентября 2016</div>
                  </div>
                </div>
                <div class="b-reviews__author">
                  <div class="b-reviews__author-name">Sergei ddd</div>
                  <div class="b-reviews__author-foto"><img src="img/reviews/man-dark-avatar-318-9118.png" alt=""></div>
                </div>
              </div>  <!-- end b-question__answer-block -->

              <div class="b-reviews__buttons">
                <a href="#" class="b-reviews__answer">Ответить</a>
              </div>
            </div>  <!-- end b-question -->

            <div class="b-question">
              <div class="b-question__question-block">
                <p>Безусловно, камера: в дневное время снимает на уровне Флагманов 15-16 года, в ночное уже похуже;</p>
                <div class="b-reviews__buttons">
                  <a href="#" class="b-reviews__answer">Ответить</a>
                </div>
                <div class="b-question__no-answer">0 ответов</div>
              </div>

              <div class="b-reviews__buttons">
                <a href="#" class="b-reviews__answer">Ответить</a>
              </div>
            </div>  <!-- end b-question -->

            <div class="b-question">
              <div class="b-question__question-block">
                <p>Безусловно, камера: в дневное время снимает на уровне Флагманов 15-16 года, в ночное уже похуже;</p>
                <div class="b-reviews__buttons">
                  <a href="#" class="b-reviews__answer">Ответить</a>
                </div>
                <div class="b-question__no-answer">0 ответов</div>
              </div>

              <div class="b-reviews__buttons">
                <a href="#" class="b-reviews__answer">Ответить</a>
              </div>
            </div>  <!-- end b-question -->

            <div class="b-add-message">

              <form action="">
                <div class="f-field-wrapper f-field-wrapper_textarea">
                  <textarea name="question_message" class="f-textarea" placeholder="Добавить вопрос"></textarea>
                </div>
                <div class="f-group">
                  <button type="submit" class="f-button">Добавить вопрос</button>
                </div>
              </form>

            </div>  <!-- end b-add-message -->

          </div>  <!-- end Вопросы и ответы -->

        </div>  <!-- end b-prod__tabs -->

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
                  <li><a href="category.html"><img src="img/brands/brand_acer.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_canon.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_d-link.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_lenovo.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_asus.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_samsung.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_canon.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_samsung.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_acer.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_asus.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_d-link.png" alt=""></a></li>
                  <li><a href="category.html"><img src="img/brands/brand_lenovo.png" alt=""></a></li>
              </ul>
            </div>
          </div>
        </div>

    </main>













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



<?php echo $footer; ?>
