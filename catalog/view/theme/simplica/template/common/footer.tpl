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


//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<pre>";  print_r(var_dump( $blog_main_categories )); echo "</pre>";

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
              <span class="ic-history"></span><span><?php echo count($customer_viewed_products); ?> история</span><span class="ic-popup-link"></span>
            </div>
            <div class="b-footer-popup b-footer-popup_history g-minimized js-footer-popup-history">
              <div class="b-footer-popup__header">
                <h3 class="b-footer-popup__title">Недавно просмотренные модели</h3>
                <div class="b-footer-popup__btn-close js-footer-popup-close"><span class="ic-popup-close"></span></div>
                <div class="b-footer-popup__btn-clear"><span class="ic-clear"></span> Очистить</div>
              </div>
              <div class="b-footer-popup__content">

                <?php foreach ($customer_viewed_products as $prod) { ?>
                <div class="b-footer-popup__content-block">
                  <div class="b-footer-popup__content-block-img">
                    <img src="/image/<?php if ($prod['image'] != '' ) { echo $prod['image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                  </div>
                  <div class="b-footer-popup__content-block-title">
                    <a href="/<?php echo $language_href; ?><?php echo $prod['href']; ?>"><?php echo $prod['name']; ?></a>
                  </div>
                  <ul class="b-footer-popup__content-block-list">
                    <li><span><?php echo $currencies[$_SESSION ['currency']]['symbol_left'].' '.sprintf("%.2f", $prod['price']).' '.$currencies[$_SESSION ['currency']]['symbol_right']; ?></span><a href="/<?php echo $language_href; ?><?php echo $prod['manufacturer']; ?>"><?php echo $prod['manufacturer']; ?></a></li>
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
            <div class="b-footer-popup b-footer-popup_compare g-minimized js-footer-popup-compare">
              <div class="b-footer-popup__header">
                <h3 class="b-footer-popup__title"><a href="/<?php echo $language_href; ?>index.php?route=product/compare">Сравнение моделей</a></h3>
                <div class="b-footer-popup__btn-close js-footer-popup-close"><span class="ic-popup-close"></span></div>
                <div class="b-footer-popup__btn-clear js-compare-clear"><span class="ic-clear"></span> Очистить</div>
              </div>
              <div class="b-footer-popup__content">
                <?php if ( isset($compare_products) && count($compare_products) > 0 ) { ?>

                  <?php foreach ($compare_products as $prod) { ?>
                  <div class="b-footer-popup__content-block">
                    <div class="b-footer-popup__content-block-img">
                      <img src="<?php if ($prod['thumb']) { echo $prod['thumb']; }else{ echo '/image/no_image.png';} ?>" alt="<?php echo $prod['name']; ?>">
                    </div>
                    <div class="b-footer-popup__content-block-title">
                      <a href="<?php echo $prod['href']; ?>"><?php echo $prod['name']; ?></a>
                    </div>
                    <ul class="b-footer-popup__content-block-list">
                      <li><span><?php echo $prod['price']; ?></span><a href="/<?php echo $language_href; ?><?php echo $prod['manufacturer']; ?>"><?php echo $prod['manufacturer']; ?></a></li>
                    </ul>
                    <div class="b-footer-popup__content-block-delete">
                      <a href="javascript:void(0)" title="Удалить из сравнения" class="js-remove-compare" data-remove-link="<?php echo $prod['remove']; ?>"><span class="ic-delete"></span></a>
                    </div>
                  </div>
                  <?php } ?>

                <?php } else { ?>
                  <p>Нет товаров для сравнения</p>
                <?php } ?>
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

        <?php foreach($blog_main_categories as $blog_group) { ?>
        <?php if ( isset($blog_group['children']) ) { ?>
        <li class="b-footer-nav__block">
          <div class="b-footer-nav__block-title">
            <span><?php echo $blog_group['name']; ?></span>
          </div>
          <ul>
            <?php foreach($blog_group['children'] as $link) { ?>
            <li><a href="/<?php echo $language_href; ?><?php echo $link['keyword']; ?>"><?php echo $link['title']; ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php } ?>

      </ul>

      <div class="b-footer__bottom">
        <span><?php echo $powered; ?></span>
      </div>
    </div>
  </footer> 

<script>
$(document).ready(function () {
  $('.js-remove-compare').on('click', function () {
     //debugger;
     var b = $(this).closest('.b-footer-popup__content-block');

      $.ajax({
          url: $(this).data('remove-link'),
          type: 'post',
          dataType: 'json',
          beforeSend: function () {
          },
          complete: function () {
              $(b).remove();
          },
          success: function (data) {
            console.log(data);
            
              //if (data['error']) {}

              //if (data['success']) {}

              //$(this).parent().remove();
          }
      });
  });

  $('.js-compare-clear').on('click', function(){
    $('.js-remove-compare').each(function(){
          $(this).click();
      });
  });
});

</script>


<script src="/catalog/view/theme/simplica/js/lib/jquery-ui/jquery-ui.js"></script>
<script src="/catalog/view/theme/simplica/js/lib/owl.carousel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.js"></script>
<script src="/catalog/view/theme/simplica/js/lib/jquery.magnific-popup.min.js"></script>
<script src="/catalog/view/theme/simplica/js/scripts.js" type="text/javascript"></script>

</body></html>