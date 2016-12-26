<?php echo $header; ?>

<?php
$text_cart = 'Корзина';
$text_order = 'Заказать';
$text_confirmation_order = 'Подтверждение заказа';
$text_wishlist = 'В список желаний';
$text_in_stock = 'В наличии';
$text_delivery_method = 'Способ доставки';
$text_delivery_country = 'Страна доставки';
$text_delivery = 'Доставка';
$text_summary_information_on_ordering = 'Итоговая информация о заказе';
$text_total = 'Итого';
$text_back_to_shopping = 'Вернуться к покупкам';
$text_help_is_needed = 'Нужна помощь?';
$text_write_to_us = 'Написать нам';
$text_faq = 'ЧАСТО ЗАДАВАЕМЫЕ ВОПРОСЫ';
$text_send_email = 'Пожалуйста, отправьте нам email, и мы скоро с Вами свяжемся.';
$text_size = 'Размер:';
$text_color = 'Цвет:';
$text_order_q = 'Вопрос%20по%20заказа';

$column_name = 'Товар';       // есть переменная column_name = 'Название' - переименовать на 'Товар'

$column_duti = 'Пошлины';     // эта колонка скрыта, но текст в ней есть... так что не знаю удалять или переводить...

$text_conditional_preliminary_confirmation = 'Условное предварительное подтверждение';  // этот текст сейчас скрыт. нужно переводить?


$faq_array = array ();   // Сюда засунуть фак
//$faq_array['href'];
//$faq_array['title'];


/*
header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";  print_r(var_dump( $_SESSION )); echo "</pre>";
*/


/*
Осталось без перевода:
1) "Размещая заказ, Вы принимаете наши" и дальше идет перечисление ссылок на различные условия ("Условия продажи", "Политику конфиденциальности")
Наверно для этого текста нужно предусмотреть возможность изменения через админку? Если да, то необходимость перевода внутри шаблона отпадает...
*/


?>


<main role="main" class="l-main_checkout">
  <ol class="b-checkout_progress_indicator">
    <li class="b-checkout_progress_indicator-step b-checkout_progress_indicator-step--active"><a href="/index.php?route=checkout/cart"><?php echo $text_cart; ?></a></li>
    <li class="b-checkout_progress_indicator-step" onclick="$('.js-submit-button').click();"><span><?php echo $text_order; ?></span></li>
    <li class="b-checkout_progress_indicator-step "><span><?php echo $text_confirmation_order; ?></span></li>
  </ol>
  <div class="l-checkout_cart">

<!-- Левая колонка. START -->
    <div class="l-checkout_cart-left">
      <div class="b-number_of_items">
        <h3 class="b-number_of_items-title">
          <?php echo $heading_title; ?>
        </h3>
        <?php if ($error_warning) { ?>
        <p><?php echo $error_warning; ?></p>
        <?php } ?>
      </div>

<!-- Содержимое корзины. START -->
      <div class="b-cart_table">  

        <div class="b-cart_table-list" id="cart">

          <div class="b-cart_table-header js-cart_table-header">
            <span class="b-cart_table-cols b-cart_table-header_col_product"><?php echo $column_name; ?></span>
            <span class="b-cart_table-cols b-cart_table-header_col_qty"><?php echo $column_quantity; ?></span>
            <span class="b-cart_table-cols b-cart_table-header_col_price"><?php echo $column_price; ?></span>
            <span class="b-cart_table-cols b-cart_table-header_col_duti h-hidden"><?php echo $column_duti; ?></span>
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
              <!--div class="b-cart_table-cols b-cart_table-body_col_edit_details">
                <a class="b-cart_table-body_col_edit_details-edit_poput_link " title="Редактировать"></a>
                <div class="js-edit_product-popup"></div>
              </div-->
            </div>
            <div class="b-cart_table-rows">

              <div class="b-cart_table-cols b-cart_table-body_col_product">
                <div class="b-cart_table-body_col_product-details">
                  <div class="b-cart_table-body_col_product-product_name">
                    <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" class="b-cart_table-body_col_product-product_name-link">
                      <?php echo $product['name']; ?>
                      <?php if (!$product['stock']) { ?>
                        <span class="text-danger">***</span>
                      <?php } ?>
                    </a>
                  </div>
                  <div class="b-cart_table-body_col_product-sku">
                    <span class="b-cart_table-body_col_product-sku-label"><?php echo $column_model; ?>: </span>
                    <span class="b-cart_table-body_col_product-sku-value">
                      <?php echo $product['model']; ?>
                    </span>
                  </div>

                  <?php if ($product['attributes']) { ?>
                    <?php foreach($product['attributes'] as $attribute) { ?>
                    <?php if($attribute['attribute_group_id'] == 15){ ?>
                      <div class="b-cart_table-body_col_product-attribute m-color">
                        <span class="b-cart_table-body_col_product-attribute-label"><?php echo $text_color;?></span>
                        <span class="b-cart_table-body_col_product-attribute-value">
                            <?php echo $attribute['attribute'][0]['name']?>
                        </span>
                      </div>
                    <?php } ?>
                    <?php } ?>
                  <?php } ?>
                <?php if ($product['option']) { ?>
                    <?php foreach($product['option'] as $option) { ?>
                    <div class="b-cart_table-body_col_product-attribute m-color">
                      <span class="b-cart_table-body_col_product-attribute-label"><?php echo $text_size;//$option['name'];?></span>
                      <span class="b-cart_table-body_col_product-attribute-value">
                          <?php echo $option['value'];?>
                      </span>
                    </div>
                    <?php } ?>
                  <?php } ?>
                </div>

                <div class="b-cart_table-body_col_product-user_actions">
                  <a class="b-add_to_wishlist_button js-add_to_wishlist" href="" title="<?php echo $text_wishlist; ?>">
                    <span class="b-add_to_wishlist_button-text"><?php echo $text_wishlist; ?></span>
                  </a>
                  <button class="b-remove_product_button" value="<?php echo $button_remove; ?>" onclick="cart.remove('<?php echo $product["cart_id"]; ?>');">
                    <span class="b-remove_product_button-text"><?php echo $button_remove; ?></span>
                  </button>                                       
                </div>

                <div class="b-cart_table-body_col_product-quantity_details">
                  <ul class="b-product_availability_list">      
                    <li class="b-product_availability_list-is_in_stock"><?php echo $text_in_stock; ?></li>   
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
                         data-maxqty="<?php echo $product['in_stock']; ?>"
                          maxlength="6"
                         value="<?php echo $product['quantity']; ?>"
                         class="js-item_qty b-cart_table-body_col_qty-item_quantity-qty">
                  <span class="b-cart_table-body_col_qty-item_quantity-plus js-quantity-plus <?php if ($product['quantity'] == $product['in_stock']) echo 'h-disabled'; ?>" data-key="<?php echo $product['cart_id']; ?>"></span>
                </div>
              </div>

              <div class="b-cart_table-cols b-cart_table-body_col_price">
                <div class="b-cart_table-body_col_price-item_price">
                  <span class="b-cart_table-body_col_price-item_price-value"><?php echo $product['price']; ?></span>
                </div>
              </div>

              <div class="b-cart_table-cols b-cart_table-body_col_total_price">
                <div class="b-cart_table-body_col_total_price-item_total_price">                  
                  <span class="b-cart_table-body_col_total_price-item_total_price-value js-product-total-price"><?php echo $product['total']; ?></span> 
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
          <?php echo $text_delivery_method; ?>
        </h3>
        <div class="b-cart_shipping_method-select_block">
          <div class="b-cart_shipping_method-error_message h-hidden"></div>
          <div class="f-field f-field-select js-shipping_selector">
            <label class="f-label" for="dwfrm_singleshipping_shippingAddress_addressFields_country">
              <span class="f-label-value"><?php echo $text_delivery_country; ?></span>
            </label>
            <div class="f-field-wrapper">
              <div class="f-select-wrapper">
                <select class="f-select country" id="delivery_address" name="dwfrm_singleshipping_shippingAddress_addressFields_country">
                  <?php foreach($countries as $country) { ?>
                  <option value="<?php echo $country['iso_code_2'];?>"
                  <?php if($country_code == $country['iso_code_2']){ echo 'selected';} ?>
                  ><?php echo $country['name'];?></option>
                  <?php } ?>
                </select>
              </div>
              <span class="f-error_message">
                <span class="f-error_message-block"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="b-cart_shipping_method-info h-hidden"></div>
        <div class="b-cart_shipping_method-list" id="shipping_method-list">

        <?php //foreach () { ?>
          <!--div class="b-cart_shipping_method-list_wrapper">
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
          </div-->
        <?php //} ?>

        </div>
        <div class="b-cart_shipping_method-no_shipping"></div>
      </div>
<!-- Способ доставки. END -->



      <form class="b-cart_pre_order-wrapper">
        <div class="b-cart_pre_order-wrapper h-hidden" data-model-basket="preOrder">
          <h3 class="b-cart_pre_order-title"><?php echo $text_conditional_preliminary_confirmation; ?></h3>
        </div>
      </form>

      <div class="l-checkout_button_bottom">
        <form action="index.php?route=checkout/checkout" method="post" name="dwfrm_cart">
          <div class="l-checkout_button">
            <button class="b-checkout_button js-submit-button" name="dwfrm_checkout_submitStep" value="0">
              <?php echo $text_order; ?>
            </button>
          </div>
        </form>
      </div>

      <div class="l-continue_shopping_cart">
        <a class="b-back_to_shopping" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">
           <span class="b-back_to_shopping-message"><?php echo $text_back_to_shopping; ?></span>
        </a>
      </div>

    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-checkout_cart-right js-checkout_order_summary" style="">
      <div class="b-summary_list"> 
        <h2 class="b-summary_list-title"><?php echo $text_summary_information_on_ordering; ?></h2>
        <?php //foreach ($totals as $total) { ?>
        <div class="b-summary_list-line b-summary_list-your_cart">
          <span class="b-summary_list-label"><?php echo $totals[0]['title']; ?></span>
          <span class="b-summary_list-value js-total-summ" id="summa"><?php echo $totals[0]['text']; ?></span>
        </div>
        <div class="b-summary_list-line b-summary_list-your_cart">
          <span class="b-summary_list-label"><?php echo $text_delivery; ?></span>
          <span class="b-summary_list-value js-total-summ" id="delivery_summ">-</span>
        </div>
        <div class="b-summary_list-line b-summary_list-your_cart">
          <span class="b-summary_list-label"><?php echo $text_total; ?></span>
          <span class="b-summary_list-value js-total-summ" id="total"><?php echo $totals[0]['text']; ?></span>
        </div>
        <?php //} ?>

      </div>

      <form action="index.php?route=checkout/checkout" method="post" name="dwfrm_cart">
        <div class="l-checkout_button">
          <button class="b-checkout_button" name="dwfrm_checkout_submitStep" value="0">
            <?php echo $text_order; ?>
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
                data-toggles=".js-checkout_contact_us_block"><?php echo $text_help_is_needed; ?></h3>

            <div class="js-checkout_contact_us_block">
              <div class="b-checkout_content_block-table">
                <div class="b-checkout_content_block-table-col">
                  <div class="b-checkout_content_block-title"><?php echo $text_write_to_us; ?></div>
                  <br>
                  <div class="b-checkout_content_block-icon_block">
                    <a class="b-checkout_content_block-icon_mail" href="mailto:info@plazamilano.com?Subject=<?php echo $text_order_q; ?>">
                    </a>
                  </div>
                </div>
              </div>

              <div class="b-checkout_content_block-text">
                <p><?php echo $text_send_email; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php if ( $faq_array ) { ?>
      <div class="b-checkout_content_block">
        <div class="b-checkout_content_block-faq">
          <div class="b-content_asset b-content_asset--faq-checkout-checkout content-asset">
            <div class="content">
              <h3 class="b-checkout_content_block-toggle_title b-checkout_content_block-toggle_title--close js-faq-questions_block_tt"
                  data-toggles=".js-faq-questions_block"
                  data-hide=".js-checkout_contact_us_block_tt"><?php echo $text_faq; ?></h3>

              <ul class="h-hidden b-checkout_content_block-faq_questions js-faq-questions_block">

                <?php foreach( $faq_array as $faq ) { ?>
                <li class="row b-checkout_content_block-faq_questions-li">
                  <a class="b-checkout_content_block-faq_questions-link" href="$faq['href']">$faq['title']</a>
                </li>
                <?php } ?>

              </ul>

            </div>
          </div>
        </div>
      </div>
<?php } ?>

    </div>
<!-- Правая колонка. END -->

  </div>

</main>


<script>
  //Обновим доставку
  $(document).ready(function(){
      $('#delivery_address').trigger('change');
  });
  
  //Смена страны и доставки
 $(document).on('change', '#delivery_address', function(){
    
    var country_code = $(this).val();
    
      $.ajax({
          type: 'post',
          url: 'index.php?route=checkout/delivery/getDeliveryOnCountryId',
          data: 'country_code='+country_code,
          dataType: 'json',
          cache: false,
          success: function(json) {
            
            //console.log(json);
            //debugger;
            
            var html = '';
            var count = 0;
            $.each(json, function( index, value ) {
                
                html = html + '<div class="b-cart_shipping_method-list_wrapper"><div class="b-cart_shipping_method-radio f-field f-field-radio">';
                
                html = html + '<input class="f-radio" name="Address_shippingMethodID" id="shipping-method-'+value.delivery_id+'" ';
                html = html + 'value="'+value.delivery_id+'" ';
                html = html + 'data-price="'+value.price+'" ';
                html = html + 'data-curs="'+value.value+'" ';
                html = html + 'data-realprice="'+value.realprice+'" ';
                html = html + 'data-realprice-s="'+value.real_simbol_left+value.realprice+value.real_simbol_right+'" ';
                html = html + 'data-simbol_left="'+value.real_simbol_left+'" ';
                html = html + 'data-simbol-right="'+value.real_simbol_right+'" ';
                html = html + 'data-price_all="'+value.symbol_left+value.price+value.symbol_right+'" ';
                html = html + 'type="radio"';
                if(count < 1)  html = html + ' checked="checked"';
                html = html + '>';
                html = html + '<label class="f-label" for="shipping-method-'+value.delivery_id+'"><span class="f-label-value">'+value.name+'</span></label></div>';
                html = html + '<div class="b-cart_shipping_method-label">'+value.text+'</div><div class="b-cart_shipping_method-value">';
                html = html + '<span class="b-cross_shipping-cost">'+value.symbol_left+value.price+value.symbol_right+'</span></div></div>';
                
                count = count + 1;
                
            });
            
            $('#shipping_method-list').html(html);
            setTimeout(function(){$('.f-radio').trigger('change');},500);
                       
          }
      });
 });
 
 //Выбор доставки
 $(document).on('change', '.f-radio', function(){
    //debugger;
    
    var radio = $('input[name="Address_shippingMethodID"]:checked').val();
    
    var str_price = $('#summa').html();
    str_price = str_price.replace('<?php echo $currency['SymbolLeft'];?>', '');
    str_price = str_price.replace('<?php echo $currency['SymbolRight'];?>', '');

  
    var sum = parseFloat(str_price, 10);
    var delivery_sum = $('#shipping-method-'+radio).data('realprice');
    var simbol_price = $('#shipping-method-'+radio).data('realprice-s');
    
    $('#delivery_summ').html(simbol_price);
    $('#total').html($('#shipping-method-'+radio).data('simbol_left')+(parseFloat(delivery_sum) + parseFloat(sum))+$('#shipping-method-'+radio).data('simbol-right'));
    
 });
 
  
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


// Плюс/минус для товара START
function updateTotal(){
  $('.f-radio').trigger('change');
};

$('.js-quantity-minus').on('click', function(){
  var v = parseInt($(this).siblings('input').val()) - 1;
  var max = $(this).parent('div').children('input').data('maxqty');
  if ( v >= max) {
    $(this).parent('div').children('.js-quantity-plus').addClass('h-disabled');
  } else {
    $(this).parent('div').children('.js-quantity-plus').removeClass('h-disabled');
  }
  var k = $(this).data('key');
  var str_price = $(this).closest('.b-cart_table-rows').find('.b-cart_table-body_col_price-item_price-value').html();
  str_price = str_price.replace('<?php echo $currency['SymbolLeft'];?>', '');
  str_price = str_price.replace('<?php echo $currency['SymbolRight'];?>', '');
 var price = parseFloat(str_price);

  $(this).siblings('input').val(v);
  
  var summ = v * price;
  //summ = summ.number(true,2);
  
  $(this).closest('.b-cart_table-rows').find('.js-product-total-price').html('<?php echo $currency['SymbolLeft'];?>' + summ + '<?php echo $currency['SymbolRight'];?>');
  if (v == 0) {
    cart.remove(k);
  } else {
    cart.update(k, v);
  }
  updateTotal();
});

$('.js-quantity-plus').on('click', function(){
  //debugger;
  var v = parseInt($(this).siblings('input').val()) + 1;
  var max = $(this).parent('div').children('input').data('maxqty');
  if ( v >= max) {
    $(this).addClass('h-disabled');
  } else {
    $(this).removeClass('h-disabled');
  }
  if (v > max) {
    return false;
  }
  var k = $(this).data('key');
  var str_price = $(this).closest('.b-cart_table-rows').find('.b-cart_table-body_col_price-item_price-value').html();
 //debugger;
  str_price = str_price.replace('<?php echo $currency['SymbolLeft'];?>', '');
  str_price = str_price.replace('<?php echo $currency['SymbolRight'];?>', '');
  
  var price = parseFloat(str_price);

  if (v > max) {
     v = max;
  }
 
   var summ = v * price;
 // summ = summ.number(true,2);
 
  $(this).siblings('input').val(v);
  $(this).closest('.b-cart_table-rows').find('.js-product-total-price').html('<?php echo $currency['SymbolLeft'];?>' + summ + '<?php echo $currency['SymbolRight'];?>');
  cart.update(k, v);
  updateTotal();
});
// Плюс/минус для товара END

</script>



<?php echo $footer; ?> 