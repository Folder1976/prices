<?php

$text_selected_currency = $currencies[$_SESSION['default']['currency']]['title'];

 
if($_SERVER['REQUEST_URI'] == '/'){
    $curr_href = 'index.php?currency=';
}else{
    if(strpos($_SERVER['REQUEST_URI'],'?') !== false){
        $curr_href =  $_SERVER['REQUEST_URI'].'&currency=';
    }else{
        $curr_href =  $_SERVER['REQUEST_URI'].'?currency=';
    } 
}


//echo "<pre>";  print_r(var_dump( $viewed_products )); echo "</pre>";

?>


    <div class="page-buffer"></div>
  </div>  <!-- end page-wrapper -->

  <footer class="b-footer">

    <div class="b-footer-fixed">
      <div class="g-container">

        <ul class="b-footer-fixed__col_left">

          <li>
            <div class="b-footer-fixed__text js-custom-toggler"
                 data-slide=".js-footer-popup-location"
                 data-toggle-class="g-minimized"
                 data-toggle-elem-class="g-popup-open"
                 data-close-element=".js-footer-popup-close">
              <span>Вся Украина</span><span class="ic-popup-link"></span>
            </div>
            <div class="b-footer-popup g-minimized js-footer-popup-location">
              <div class="b-footer-popup__header">
                <h3 class="b-footer-popup__title">Вся Украина</h3>
                <div class="b-footer-popup__btn-close js-footer-popup-close"><span class="ic-popup-close"></span></div>
                <div class="b-footer-popup__btn-clear"><span class="ic-clear"></span> Очистить</div>
              </div>
              <div class="b-footer-popup__content">
                test content
              </div>
            </div>
          </li>

          <li>
            <div class="b-footer-fixed__text js-custom-toggler"
                 data-slide=".js-footer-popup-history"
                 data-toggle-class="g-minimized"
                 data-toggle-elem-class="g-popup-open"
                 data-close-element=".js-footer-popup-close">
              <span class="ic-history"></span><span><?php echo count($viewed_products); ?> история</span><span class="ic-popup-link"></span>
            </div>
            <div class="b-footer-popup b-footer-popup_history g-minimized js-footer-popup-history">
              <div class="b-footer-popup__header">
                <h3 class="b-footer-popup__title">Недавно просмотренные модели</h3>
                <div class="b-footer-popup__btn-close js-footer-popup-close"><span class="ic-popup-close"></span></div>
                <div class="b-footer-popup__btn-clear"><span class="ic-clear"></span> Очистить</div>
              </div>
              <div class="b-footer-popup__content">

                <?php foreach ($viewed_products as $prod) { ?>
                <div class="b-footer-popup__content-block">
                  <div class="b-footer-popup__content-block-img">
                    <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>">
                  </div>
                  <div class="b-footer-popup__content-block-title">
                    <a href="product.html"><?php echo $prod['name']; ?></a>
                  </div>
                  <ul class="b-footer-popup__content-block-list">
                    <li><span><?php echo $prod['price']; ?></span><a href="<?php echo $prod['manufacturer_href']; ?>"><?php echo $prod['manufacturer']; ?></a></li>
                  </ul>
                </div>
                <?php } ?>

              </div>
            </div>
          </li>

          <li>
            <div class="b-footer-fixed__text js-custom-toggler"
                 data-slide=".js-footer-popup-compare"
                 data-toggle-class="g-minimized"
                 data-toggle-elem-class="g-popup-open"
                 data-close-element=".js-footer-popup-close">
              <span class="ic-refresh"></span><span>Сравнение моделей</span><span class="ic-popup-link"></span>
            </div>
            <div class="b-footer-popup g-minimized js-footer-popup-compare">
              <div class="b-footer-popup__header">
                <h3 class="b-footer-popup__title">Сравнение моделей</h3>
                <div class="b-footer-popup__btn-close js-footer-popup-close"><span class="ic-popup-close"></span></div>
                <div class="b-footer-popup__btn-clear"><span class="ic-clear"></span> Очистить</div>
              </div>
              <div class="b-footer-popup__content">
                test content
              </div>
            </div>
          </li>
        </ul>

        <ul class="b-footer-fixed__col_right">
          <li>
            <div class="b-footer-fixed__text">
              <span class="ic-unknown-topic"></span>
            </div>
          </li>
          <li>
            <div class="b-footer-fixed__text">
              <span class="ic-x"></span>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="g-container">
      <ul class="b-footer-nav">

        <li class="b-footer-nav__block">
          <div class="b-footer-nav__block-title">
            <span>Product</span>
          </div>
          <ul>
            <li><a href="#">Popular</a></li>
            <li><a href="#">Trending</a></li>
            <li><a href="#">Catalog</a></li>
            <li><a href="#">Features</a></li>
          </ul>
        </li>

        <li class="b-footer-nav__block">
          <div class="b-footer-nav__block-title">
            <span>Info</span>
          </div>
          <ul>
            <li><a href="#">Support</a></li>
            <li><a href="#">Developers</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="#">Ger Started </a></li>
          </ul>
        </li>

        <li class="b-footer-nav__block">
          <div class="b-footer-nav__block-title">
            <span>Company</span>
          </div>
          <ul>
            <li><a href="#">Press Releases</a></li>
            <li><a href="#">Mission</a></li>
            <li><a href="#">Strategy</a></li>
            <li><a href="#">Works</a></li>
          </ul>
        </li>

        <li class="b-footer-nav__block">
          <div class="b-footer-nav__block-title">
            <span>Contact</span>
          </div>
          <ul>
            <li><a href="#">Popular</a></li>
            <li><a href="#">Trending</a></li>
            <li><a href="#">Catalog</a></li>
            <li><a href="#">Features</a></li>
          </ul>
        </li>

        <li class="b-footer-nav__block">
          <div class="b-footer-nav__block-title">
            <span>Learn More</span>
          </div>
          <ul>
            <li><a href="#">Support</a></li>
            <li><a href="#">Developers</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="#">Ger Started </a></li>
          </ul>
        </li>

      </ul>

      <div class="b-footer__bottom">
        <span>&copy; 2016 <a href="/">Prices</a>. All rights reserved.</span>
      </div>
    </div>
  </footer> 

<script src="catalog/view/theme/simplica/js/lib/jquery-ui/jquery-ui.js"></script>
<script src="catalog/view/theme/simplica/js/lib/owl.carousel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.js"></script>
<script src="catalog/view/theme/simplica/js/lib/jquery.magnific-popup.min.js"></script>

<script src="catalog/view/theme/simplica/js/scripts.js" type="text/javascript"></script>


</body></html>