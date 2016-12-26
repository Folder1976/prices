<?php echo $header; ?>

<main role="main" class="l-main_checkout">
  <ol class="b-checkout_progress_indicator">
    <li class="b-checkout_progress_indicator-step b-checkout_progress_indicator-step--active">Корзина</li>
    <li class="b-checkout_progress_indicator-step ">Заказать</li>
    <li class="b-checkout_progress_indicator-step ">Подтверждение заказа</li>
  </ol>
  <div class="l-checkout_cart">

<!-- Левая колонка. START -->
    <div class="l-checkout_cart-left">
      <div class="b-number_of_items">
        <h3 class="b-number_of_items-title">
          <?php echo $heading_title; ?>
        </h3>
      </div>

<!-- Содержимое корзины. START -->
      <div class="b-cart_table">  

        <div class="b-cart_table-list" id="cart">

          <div class="b-cart_table-header js-cart_table-header">
            <span class="b-cart_table-cols b-cart_table-header_col_product">Товар</span>
            <span class="b-cart_table-cols b-cart_table-header_col_qty"><?php echo $column_quantity; ?></span>
            <span class="b-cart_table-cols b-cart_table-header_col_price"><?php echo $column_price; ?></span>
            <span class="b-cart_table-cols b-cart_table-header_col_duti h-hidden">Пошлины</span>
            <span class="b-cart_table-cols b-cart_table-header_col_total_price"><?php echo $column_total; ?></span>
          </div>

        <?php foreach ($products as $product) { ?>
          <div class="b-cart_table-line_body">
            <div class="b-cart_table-rows">
              <div class="b-cart_table-cols b-cart_table-body_col_image">
                <div class="b-cart_table-body_col_image-image">
                  <img class="b-product_image" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>">
                </div>
              </div>
              <div class="b-cart_table-cols b-cart_table-body_col_edit_details">
                <a class="b-cart_table-body_col_edit_details-edit_poput_link " title="Редактировать"></a>
                <div class="js-edit_product-popup"></div>
              </div>
            </div>
            <div class="b-cart_table-rows">

              <div class="b-cart_table-cols b-cart_table-body_col_product">
                <div class="b-cart_table-body_col_product-details">
                  <div class="b-cart_table-body_col_product-product_name">
                    <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" class="b-cart_table-body_col_product-product_name-link">
                      <?php echo $product['name']; ?>
                    </a>
                  </div>
                  <div class="b-cart_table-body_col_product-sku">
                    <span class="b-cart_table-body_col_product-sku-label"><?php echo $column_model; ?>: </span>
                    <span class="b-cart_table-body_col_product-sku-value">
                      <?php echo $product['model']; ?>
                    </span>
                  </div>

                  <?php if ($product['option']) { ?>
                    <?php foreach($product['option'] as $option) { ?>
                    <div class="b-cart_table-body_col_product-attribute m-color">
                      <span class="b-cart_table-body_col_product-attribute-label"><?php echo $option['name'];?></span>
                      <span class="b-cart_table-body_col_product-attribute-value">
                          <?php echo $option['value']?>
                      </span>
                    </div>
                    <?php } ?>
                  <?php } ?>
                </div>

                <div class="b-cart_table-body_col_product-user_actions">
                  <a class="b-add_to_wishlist_button js-add_to_wishlist" href="" title="В список желаний">
                    В список желаний
                  </a>
                  <button class="b-remove_product_button" value="Удалить" onclick="cart.remove('<?php echo $product["cart_id"]; ?>');">
                    <span class="b-remove_product_button-text"><?php echo $button_remove; ?></span>
                  </button>                                       
                </div>

                <div class="b-cart_table-body_col_product-quantity_details">
                  <ul class="b-product_availability_list">      
                    <li class="b-product_availability_list-is_in_stock">В наличии</li>   
                    <li class="b-product_availability_list-on_order"></li>       
                    <li class="b-product_availability_list-not_available h-hidden"></li>   
                  </ul>
                </div>
              </div>


              <div class="b-cart_table-cols b-cart_table-body_col_qty">
                <div class="b-cart_table-body_col_qty-item_quantity">
                  <span class="b-cart_table-body_col_qty-item_quantity-minus js-quantity-minus" data-key="<?php echo $product['cart_id']; ?>"></span>
                  <input name="dwfrm_cart_shipments_i0_items_i0_quantity"
                         type="text"
                         size="4"
                         maxlength="6"
                         value="<?php echo $product['quantity']; ?>"
                         class="js-item_qty b-cart_table-body_col_qty-item_quantity-qty">
                  <span class="b-cart_table-body_col_qty-item_quantity-plus js-quantity-plus" data-key="<?php echo $product['cart_id']; ?>"></span>
                </div>
              </div>

              <div class="b-cart_table-cols b-cart_table-body_col_price">
                <div class="b-cart_table-body_col_price-item_price">
                  <span class="b-cart_table-body_col_price-item_price-value"><?php echo $product['price']; ?></span>
                </div>
              </div>

              <div class="b-cart_table-cols b-cart_table-body_col_total_price">
                <div class="b-cart_table-body_col_total_price-item_total_price">                  
                  <span class="b-cart_table-body_col_total_price-item_total_price-value"><?php echo $product['total']; ?></span> 
                </div>
              </div>

            </div>
          </div>

        <?php } ?>

        </div>
      </div>
<!-- Содержимое корзины. END -->

<!-- Способ доставки. START -->
      <div class="b-cart_shipping_method js-shipping-anchor" id="shippingAnchor">
        <h3 class="b-cart_shipping_method-title">
          Способ доставки
        </h3>
        <div class="b-cart_shipping_method-select_block">
          <div class="b-cart_shipping_method-error_message h-hidden"></div>
          <div class="f-field f-field-select js-shipping_selector">
            <label class="f-label" for="dwfrm_singleshipping_shippingAddress_addressFields_country">
              <span class="f-label-value">Страна доставки</span>
            </label>
            <div class="f-field-wrapper">
              <div class="f-select-wrapper">
                <select class="f-select country" id="dwfrm_singleshipping_shippingAddress_addressFields_country" name="dwfrm_singleshipping_shippingAddress_addressFields_country">
                  <?php //foreach () { ?>
                  <option value="AU">Австралия</option>
                  <option value="AT">Австрия</option>
                  <option value="AL">Албания</option>
                  <option value="DZ">Алжир</option>
                  <?php //} ?>
                </select>
              </div>
              <span class="f-error_message">
                <span class="f-error_message-block"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="b-cart_shipping_method-info h-hidden"></div>
        <div class="b-cart_shipping_method-list">

        <?php //foreach() { ?>
          <div class="b-cart_shipping_method-list_wrapper">
            <div class="b-cart_shipping_method-radio f-field f-field-radio">
              <input class="f-radio" name="dwfrm_singleshipping_shippingAddress_shippingMethodID" id="shipping-method-EXPRESS_UA" checked="checked" value="EXPRESS_UA" type="radio">
              <label class="f-label" for="shipping-method-EXPRESS_UA">
                <span class="f-label-value">Express</span>
              </label>
            </div>
            <div class="b-cart_shipping_method-label">Планируемая дата доставки: 14-11-2016</div>
            <div class="b-cart_shipping_method-value">
              <span class="b-cross_shipping-cost">€30,00</span>
            </div>
          </div>
        <?php //} ?>

        </div>
        <div class="b-cart_shipping_method-no_shipping"></div>
      </div>
<!-- Способ доставки. END -->

<!-- Способ оплаты. START -->
      <div class="b-cart_payment_method">
        <h3 class="b-cart_payment_method-title">Способ оплаты</h3>
        <div class="b-cart_payment_method-list">
     </div>
      </div>
<!-- Способ оплаты. END -->

<!-- Промо-код. START -->
      <div class="b-cart_coupon_code">
        <div class="b-cart_coupon_code-title">Промо-код</div>
        <div class="b-cart_coupon_code-wrapper">
          <div class="b-cart_coupon_code-left">
            <div class="b-cart_coupon_code-code">
              <div class="f-field f-field-textinput">
                <div class="f-field-wrapper">
                  <input id="dwfrm_cart_couponCode" name="dwfrm_cart_couponCode" class="f-textinput" value="" type="text">
                  <span class="f-error_message">
                    <span class="f-error_message-block"></span>
                  </span>
                  <span class="f-warning_message">
                    <span class="f-warning_message-block">
                      <span class="f-warning_text"></span>
                    </span>
                  </span>
                </div>
              </div>
            </div>
            <div class="f-form-error_message js-coupon_error"></div>
          </div>
          <div class="b-cart_coupon_code-right">
            <button class="b-cart_coupon_code-button">Применить</button>
          </div>
          <div class="b-cart_coupon_code-applied"></div>
        </div>
      </div>
<!-- Промо-код. END -->

      <form class="b-cart_pre_order-wrapper">
        <div class="b-cart_pre_order-wrapper h-hidden" data-model-basket="preOrder">
          <h3 class="b-cart_pre_order-title">Условное предварительное подтверждение</h3>
        </div>
      </form>

      <div class="l-checkout_button_bottom">
        <form action="index.php?route=checkout/checkout" method="post" name="dwfrm_cart">
          <div class="l-checkout_button">
            <button class="b-checkout_button" name="dwfrm_checkout_submitStep" value="0">
              Заказать
            </button>
          </div>
        </form>
      </div>

      <div class="l-continue_shopping_cart">
        <a class="b-back_to_shopping" href="/">
          <span class="b-back_to_shopping-message">Вернуться к покупкам</span>
        </a>
      </div>

    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-checkout_cart-right js-checkout_order_summary" style="">
      <div class="b-summary_list"> 
        <h2 class="b-summary_list-title">Итоговая информация о заказе</h2>

        <?php foreach ($totals as $total) { ?>
        <div class="b-summary_list-line b-summary_list-your_cart">
          <span class="b-summary_list-label"><?php echo $total['title']; ?></span>
          <span class="b-summary_list-value"><?php echo $total['text']; ?></span>
        </div>
        <?php } ?>

      </div>

      <form action="index.php?route=checkout/checkout" method="post" name="dwfrm_cart">
        <div class="l-checkout_button">
          <button class="b-checkout_button" name="dwfrm_checkout_submitStep" value="0">
            Заказать
          </button>
        </div>
      </form>

      <div class="b-checkout_content_block">
        <div class="b-checkout_content_block-info">
          <div class="b-content_asset b-content_asset--customer-service-help-contact-checkout content-asset">
            <h2>Размещая заказ, Вы принимаете наши <a href="#" target="_blank">Условия продажи</a> и <a href="#" target="_blank">Политику конфиденциальности.</a> <span class="ru">Если доставка осуществляется в РФ, Вы также соглашаетесь с <a href="#">Условиями и Положениями DHL.</a></span></h2>
            <br> 
            <h3 class="b-checkout_content_block-toggle_title b-checkout_content_block-toggle_title--open js-checkout_contact_us_block_tt"
                data-hide=".js-faq-questions_block_tt"
                data-toggles=".js-checkout_contact_us_block">Нужна помощь?</h3>

            <div class="js-checkout_contact_us_block">
              <div class="b-checkout_content_block-table">
                <div class="b-checkout_content_block-table-col">
                  <div class="b-checkout_content_block-title">Написать нам</div>
                  <br>
                  <div class="b-checkout_content_block-icon_block">
                    <a class="b-checkout_content_block-icon_mail" href="#">
                    </a>
                  </div>
                </div>
              </div>

              <div class="b-checkout_content_block-text">
                <p>Пожалуйста, отправьте нам email, и мы скоро с Вами свяжемся.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="b-checkout_content_block">
        <div class="b-checkout_content_block-faq">
          <div class="b-content_asset b-content_asset--faq-checkout-checkout content-asset">
            <div class="content">
              <h3 class="b-checkout_content_block-toggle_title b-checkout_content_block-toggle_title--close js-faq-questions_block_tt"
                  data-toggles=".js-faq-questions_block"
                  data-hide=".js-checkout_contact_us_block_tt">ЧАСТО ЗАДАВАЕМЫЕ ВОПРОСЫ</h3>

              <ul class="h-hidden b-checkout_content_block-faq_questions js-faq-questions_block">
                <li class="row b-checkout_content_block-faq_questions-li"><a class="b-checkout_content_block-faq_questions-link" id="question-4" href="#">Должен ли я зарегистрироваться, чтобы оформить заказ?</a></li>
                <li class="ru b-checkout_content_block-faq_questions-li"><a class="b-checkout_content_block-faq_questions-link" id="question-7" href="#">Моя подпись необходима?</a></li>
                <li class="row b-checkout_content_block-faq_questions-li"><a class="b-checkout_content_block-faq_questions-link" id="question-5" href="#">Останется ли моя личная информация конфиденциальной?</a></li>
                <li class="ru b-checkout_content_block-faq_questions-li"><a class="b-checkout_content_block-faq_questions-link" id="question-1" href="#">Могу ли я добавить изделия к уже существующему заказу?</a></li>
                <li class="b-checkout_content_block-faq_questions-li"><a class="b-checkout_content_block-faq_questions-link" id="question-6" href="#">Могу ли я изменить адрес доставки после того, как заказ был отправлен?</a></li>
              </ul>

            </div>
          </div>
        </div>
      </div>

    </div>
<!-- Правая колонка. END -->

  </div>

</main>


<script>
// выпадающие блоки в правой колонке START
closeTTBlock = function(t) {
  $(t).removeClass('b-checkout_content_block-toggle_title--open').addClass('b-checkout_content_block-toggle_title--close');
  $($(t).data('toggles')).addClass('h-hidden');
}
openTTBlock = function(t) {
  $(t).removeClass('b-checkout_content_block-toggle_title--close').addClass('b-checkout_content_block-toggle_title--open');
  $($(t).data('toggles')).removeClass('h-hidden');
  closeTTBlock($($(t).data('hide')));
}
$('.js-faq-questions_block_tt, .js-checkout_contact_us_block_tt').on('click', function(){
  if ( $(this).hasClass('b-checkout_content_block-toggle_title--close') ) {
    openTTBlock($(this));
  } else {
    closeTTBlock($(this));
  }
});
// выпадающие блоки в правой колонке END

$('.js-quantity-minus').on('click', function(){
  var v = parseInt($(this).siblings('input').val()) - 1;
  var k = $(this).data('key');
  $(this).siblings('input').val(v);
  cart.update(k, v);
});

$('.js-quantity-plus').on('click', function(){
  var v = parseInt($(this).siblings('input').val()) + 1;
  var k = $(this).data('key');
  $(this).siblings('input').val(v);
  cart.update(k, v);
});


</script>


<?php
//header("Content-Type: text/html; charset=UTF-8");
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<style> pre header {display: none;}</style>";
?>

<?php echo $footer; ?> 