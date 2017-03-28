<?php echo $header; ?>

<?php
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";

?>

    <main class="b-checkout">
      <div class="g-container">

      <div class="b-checkout-nav">
        <ol>
          <li class="active"><span>Корзина</span></li>
          <li><span>Подтвердить имя</span></li>
        </ol>
      </div>

      <h2><span>Корзина</span></h2>

      <div class="b-table">
        <div class="b-table__row_title">
          <div class="b-col__img">Фото</div>
          <div class="b-col__description">Описание</div>
          <div class="b-col__shop">Магазин</div>
          <div class="b-col__price">Цена</div>
          <div class="b-col__summa">Сумма</div>
          <div class="b-col__quantity">Количество</div>
          <div class="b-col__delivery">Доставка</div>
          <div class="b-col__delete"></div>
        </div>

        <?php foreach ($products as $product) { ?>
        <div class="b-table__row">
          <div class="b-col__img">
            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>">
          </div>
          <div class="b-col__description">
            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          </div>
          <div class="b-col__shop">
            <img src="img/product/shop.png" alt="">
          </div>
          <div class="b-col__price">
            <div class="b-price">
              <span class="b-price__number"><?php echo $product['price']; ?></span>
            </div>
          </div>
          <div class="b-col__summa">
            <div class="b-summa">
              <span class="b-summa__number"><?php echo str_replace(array(' ', $currency['SymbolRight'], $currency['SymbolLeft']),'',$product['total']); ?></span>
            </div>
          </div>
          <div class="b-col__quantity">
            <span class="b-quantity__minus js-quantity-minus" data-key="<?php echo $product['cart_id']; ?>">-</span>
            <input type="text"
                   class="b-quantity__input"
                   value="<?php echo $product['quantity']; ?>"
                   data-maxqty="<?php echo $product['in_stock']; ?>">
            <?php if ($product['quantity'] >= $product['in_stock']) { ?>
            <span class="b-quantity__plus js-quantity-plus h-disabled" data-key="<?php echo $product['cart_id']; ?>">+</span>
            <?php } else { ?>
            <span class="b-quantity__plus js-quantity-plus" data-key="<?php echo $product['cart_id']; ?>">+</span>
            <?php } ?>
          </div>
          <div class="b-col__delivery">
            400р
          </div>
          <div class="b-col__delete" onclick="cart.remove('<?php echo $product["cart_id"]; ?>');">
            <span class="ic-delete"></span><span class="b-col__delete-text"><?php echo $button_remove; ?></span>
          </div>
        </div>
        <?php } ?>

      </div>  <!-- end b-table -->

      <div class="b-checkout-summary">
        <div class="b-checkout-summary__left">
          <ul class="b-checkout-summary__price-list">
            <li>
              <span class="key">Subtotal</span>
              <span class="val">$13.95</span>
            </li>
            <li>
              <span class="key">Sales Tax</span>
              <span class="val">$1.24</span>
            </li>
            <li>
              <span class="key">Delivery Free</span>
              <span class="val">$0.00</span>
            </li>
            <li>
              <span class="key">Tip</span>
              <span class="val">$2.28</span>
            </li>
            <li class="total">
              <span class="key">Total</span>
              <span class="val">$17.47</span>
            </li>
          </ul>
        </div>
        <div class="b-checkout-summary__right">
          <span class="b-title">Итог (без доставки): </span>
            <span class="b-price">
              <span class="b-price__number"><?php echo $totals[0]['text']?></span>
            </span>
        </div>
        <div class="g-clear"></div>
        <div class="b-checkout-summary__bottom">
          <div class="b-checkout__button">
            <a href="/<?php echo $language_href; ?>index.php?route=checkout/checkout" class="g-btn">Подтвердить</a>
          </div>
          <div class="b-back_to_shopping">
            <a href="/<?php echo $language_href; ?>index.php">< Вернуться назад</a>
          </div>
          <div class="b-checkout__clear">
            <a href="#">Очистить корзину <span class="ic-delete"></span></a>
          </div>
        </div>
      </div>


      </div>  <!-- end g-container -->
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
 
  

// Плюс/минус для товара START
function updateTotal(){
  //$('.f-radio').trigger('change');
  //.b-coll__summa .b-summa__number
  var total_summ = 0;
  $('.b-col__summa .b-summa__number').each(function(i,elem) {
    var str_summ = $(this).html();
    str_summ = str_summ.replace('<?php echo $currency['SymbolLeft'];?>', '');
    str_summ = str_summ.replace('<?php echo $currency['SymbolRight'];?>', '');
    total_summ = total_summ + parseFloat(str_summ);
  });
  total_summ = Math.round(total_summ * 100) / 100;
  $('.b-checkout-summary__right .b-price span').html('<?php echo $currency['SymbolLeft'];?>' + total_summ + '<?php echo $currency['SymbolRight'];?>');

  var total = 0;
  $('.b-quantity__input').each(function(i,elem) {
    total = total + parseInt($(this).val());
  });
  $('.b-header-cart__quantity').html(total);
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
  var str_price = $(this).closest('.b-table__row').find('.b-price__number').html();
  str_price = str_price.replace('<?php echo $currency['SymbolLeft'];?>', '');
  str_price = str_price.replace('<?php echo $currency['SymbolRight'];?>', '');
 var price = parseFloat(str_price);

  $(this).siblings('input').val(v);
  
  var summ = v * price;
  //summ = summ.number(true,2);
  
  $(this).closest('.b-table__row').find('.b-col__summa .b-summa__number').html('<?php echo $currency['SymbolLeft'];?>' + summ + '<?php echo $currency['SymbolRight'];?>');
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
  var str_price = $(this).closest('.b-table__row').find('.b-price__number').html();
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
  $(this).closest('.b-table__row').find('.b-col__summa .b-summa__number').html('<?php echo $currency['SymbolLeft'];?>' + summ + '<?php echo $currency['SymbolRight'];?>');
  cart.update(k, v);
  updateTotal();
});
// Плюс/минус для товара END

</script>



<?php echo $footer; ?> 