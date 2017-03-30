<?php echo $header; ?>

<?php
$text_select_delive_adress = 'Выбрать из списка сохраненных адресов';
$text_cart = 'Корзина';
$text_order = 'Заказать';
$text_confirmation_order = 'Подтверждение заказа';
$text_delivery_information = 'Информация о доставке';
$text_summary_information_on_ordering = 'Итоговая информация о заказе';
$text_help_is_needed = 'Нужна помощь?';
$text_write_to_us = 'Написать нам';
$text_faq = 'ЧАСТО ЗАДАВАЕМЫЕ ВОПРОСЫ';
$text_send_email = 'Пожалуйста, отправьте нам email, и мы скоро с Вами свяжемся.';

$text_email = 'Email';
$text_email_placeholder = 'Например, name@email.com';
$text_password = 'Пароль';
$text_password_placeholder = 'Пароль';
$text_password_confirm = 'Повтор пароля';
$text_password_confirm_placeholder = 'Пароль ещё раз';
$text_name = 'Имя';
$text_name_placeholder = 'Имя';
$text_last_name = 'Фамилия';
$text_last_name_placeholder = 'Фамилия';
$text_address1 = 'Адрес';
$text_address1_placeholder = 'Адрес 1 - например, ul. Pushkina, 62';
$text_address2 = 'Адрес 2';
$text_address2_placeholder = 'Адрес 2 - например, ul. Pushkina, 62';
$text_fields_zip = 'Индекс';
$text_fields_zip_placeholder = 'Например, 150000';
$text_city = 'Город';
$text_city_placeholder = 'Например, Moskva';
$text_country = 'Страна';
$text_fields_phone = 'Номер телефона';
$text_fields_phone_placeholder = 'Номер телефона';

$text_have_questions = 'Если у Вас остались вопросы по Вашему заказу Вы можете связаться с нами';
$text_live_chat = 'Live chat';
$text_email_us = 'E-mail us';

$text_delivery_info = 'Информация о доставке';
$text_delivery_edit = 'Редактировать';

$text_payment_details = 'Ваши детали оплаты';
$text_credit_card_number = 'Номер';
$text_credit_card_number_placeholder = 'Номер';
$text_credit_card_expiration = 'Дата окончания: ';
$text_month = 'Месяц';
$text_month_mm = 'ММ';
$text_january = 'Январь';
$text_february = 'Февраль';
$text_march = 'Март';
$text_april = 'Апрель';
$text_may = 'Май';
$text_june = 'Июнь';
$text_july = 'Июль';
$text_august = 'Август';
$text_september = 'Сентябрь';
$text_october = 'Октябрь';
$text_november = 'Ноябрь';
$text_december = 'Декабрь';
$text_year = 'Год';
$text_year_yyyy = 'ГГГГ';
$text_credit_card_cvn = 'CVV/CID/CVC';
$text_credit_card_cvn_placeholder = 'CVV/CID/CVC';
$text_what_is_it = 'Что это?';
$text_what_is_cvn = 'Что такое проверочный код карты (CVN)?';
$text_what_is_cvn_text = 'Для MasterCard и Visa введите последние три цифры на полосе с подписью.';
$text_credit_card_name = 'Имя на карте';
$text_credit_card_name_placeholder = 'Имя на карте';
$text_agreement = 'Пожалуйста, имейте ввиду, что Ваши данные собираются и обрабатываются TLG. Это совершается в Ваших интиресах и необходимо для Вашей покупки. Вы можете быть уверены, что Ваши данные содержаться в полной конфиденциальности и безопасност. Для дополнительной информации, пожалуйста, ознакомтесь с политикой конфиденциальности.';

$text_error_name = 'Пожалуйста, введите имя';
$text_error_last_name = 'Пожалуйста, введите фамилию';
$text_error_email = 'E-mail адрес введен неверно!';
$text_error_password = 'Введите пароль';
$text_error_password_confirm = 'Введите пароль еще раз';
$text_error_addres1 = 'Пожалуйста, введите адрес';
$text_error_addres2 = 'Пожалуйста, введите адрес';
$text_error_fields_zip = 'Пожалуйста, введите индекс';
$text_error_city = 'Пожалуйста, введите город';
$text_error_fields_phone = 'Пожалуйста, введите номер телефона';

$text_error_credit_card_number = 'Пожалуйста, введите номер, как указано на карте';
$text_error_month = 'Это поле обязательно';
$text_error_year = 'Это поле обязательно';
$text_error_credit_card_cvn = 'Пожалуйста, введите Ваш код безопасности';
$text_error_credit_card_name = 'Пожалуйста, введите Ваше имя, как указано на карте';
$text_error_agreement = 'Это обязательное для заполнения поле!';

$text_order_q = 'Вопрос%20по%20заказа';


//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//krumo(get_defined_vars());

?>






    <main class="b-checkout">
      <div class="g-container">

        <div class="b-checkout-nav">
          <ol>
            <li><span>Корзина</span></li>
            <li class="active"><span>Подтвердить имя</span></li>
          </ol>
        </div>

      </div>  <!-- end g-container -->

      <div class="b-checkout-form">
        <form action="#">


          <div class="b-beige-block">
            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="name">Ваше имя, фамилия</label>
                </div>
                <div class="f-field">
                  <input type="text" class="f-input" name="name" id="name" value="">
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="address_email">Email</label>
                </div>
                <div class="f-field">
                  <input type="text" class="f-input" name="address_email" id="address_email" value="">
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="fields_phone">Телефон</label>
                </div>
                <div class="f-field">
                  <input type="text" class="f-input" name="phone" id="fields_phone" value="">
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                <label for="city">Город</label> / <label for="address1">Адрес</label>
                </div>
                <div class="f-field-group">
                  <div class="f-field">
                    <input type="text" class="f-input" name="city" id="city" value="">
                  </div>
                  <div class="f-field">
                    <input type="text" class="f-input" name="address1" id="address1" value="">
                  </div>
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="comment">Коментарии</label>
                </div>
                <div class="f-field">
                  <input type="text" class="f-input" name="comment" id="comment" value="">
                </div>
              </div>
            </div>
          </div>


          <div class="b-white-block">
            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label b-group__title">
                  <label>Способ оплаты</label>
                </div>
                <div class="f-field-group_radio">
                  <div class="f-field-wrapper f-field-wrapper_radio">
                    <div class="f-field_radio">
                      <input type="radio" name="payment_metod" id="payment_metod_1" value="" class="f-radio">
                        <div class="f-label">
                          <label for="payment_metod_1"><span class="ic-checkout-credit-card"></span> Картой</label>
                        </div>
                    </div>
                  </div>
                  <div class="f-field-wrapper f-field-wrapper_radio">
                    <div class="f-field_radio">
                      <input type="radio" name="payment_metod" id="payment_metod_2" value="" class="f-radio">
                        <div class="f-label">
                          <label for="payment_metod_2"><span class="ic-checkout-money"></span> Наличными</label>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label b-group__title">
                  <label>Способ Доставки</label>
                </div>
                <div class="f-field-group_radio">
                  <div class="f-field-wrapper f-field-wrapper_radio">
                    <div class="f-field_radio">
                      <input type="radio" name="delivery_metod" id="delivery_metod_1" value="" class="f-radio">
                        <div class="f-label">
                          <label for="delivery_metod_1"><span class="ic-checkout-delivery_1"></span> Самовывоз</label>
                        </div>
                    </div>
                  </div>
                  <div class="f-field-wrapper f-field-wrapper_radio">
                    <div class="f-field_radio">
                      <input type="radio" name="delivery_metod" id="delivery_metod_2" value="" class="f-radio">
                        <div class="f-label">
                          <label for="delivery_metod_2"><span class="ic-checkout-delivery_2"></span> Доставка на дом</label>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="b-checkout-form__summary">
              <div class="b-total">
                <div class="b-total__cost">
                  <span><?php echo $totals[2]['title'].': '.$totals[2]['text']; ?></span>
                </div>
                <div class="b-total__delivery">
                  <span>Цена за доставку <?php echo $totals[1]['text'] ;?></span>
                </div>
              </div>

              <div class="b-checkout__button">
                <form action="/<?php echo $language_href; ?>index.php?route=checkout/checkout" method="post">
                  <!-- <a href="#" class="g-btn">Продолжить</a> -->
                  <button class="g-btn js-submit-button" name="submit" value="0">
                    Продолжить
                  </button>
                </form>
              </div>

              <div class="b-checkout-form__summary-bottom">
                <div class="b-back_to_shopping">
                  <a href="/<?php echo $language_href; ?>index.php?route=checkout/cart">< Вернуться назад</a>
                </div>
                <div class="b-checkout__clear">
                  <a href="javascript:void(0)" onclick="cart.clear()">Очистить корзину <span class="ic-delete"></span></a>
                </div>
                <div class="g-clear"></div>
              </div>
            </div>
          </div>


        </form>
      </div>

    </main>


















































<script>
  // Валидация формы. START
$('input.js-state-required, select.js-state-required').on('blur', function(){
    var id = $(this).attr('id');
    var val = $(this).val();
    if (val == null) {
      val = '';
    }

    function setErrorMessage(el, mess) {
        $('.js-error_'+el).html(mess);
        if (mess == '') {
            $('.js-error_'+el).closest('.f-field').removeClass('f-state-error').addClass('f-state-valid');
        }else {
            $('.js-error_'+el).closest('.f-field').removeClass('f-state-valid').addClass('f-state-error');
        }
    }

    switch(id) {
        case 'first_name':
            var rv_name = /^[a-zA-Zа-яА-Я]+$/;
            if(val.length > 2 && val != '' && rv_name.test(val)) {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_name; ?>');
            }
        break;
        case 'last_name':
            var rv_name = /^[a-zA-Zа-яА-Я]+$/;
            if(val.length > 2 && val != '' && rv_name.test(val)) {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_last_name; ?>');
            }
        break;
        case 'address_email':
            var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if(val.length > 2 && val != '' && rv_email.test(val)) {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_email; ?>');
            }
            
            $.ajax({
                type: 'post',
                url: 'index.php?route=account/account/validationEmail',
                data: 'email='+val,
                dataType: 'text',
                cache: false,
                success: function(html) {
                  console.log(html);
                  //debugger;
                    
                    if (html == '0'){
                        setErrorMessage(id, '<?php echo $text_error_email; ?>');
                    }
                
                }
            });
            
        break;
        case 'password':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_password; ?>');
            }
        case 'confirm':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_password_confirm; ?>');
            }
        break;
        case 'address1':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_addres1; ?>');
            }
        break;
        case 'fields_zip':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_fields_zip; ?>');
            }
        break;
        case 'city':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_city; ?>');
            }
        break;
        case 'fields_phone':
            //var rv_phone = ?????;
            //if(val.length > 2 && val != '' && rv_phone.test(val)) {
            if(val.length > 2 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_fields_phone; ?>');
            }
        break;
        case 'creditCard_number':
            if(val.length > 2 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_credit_card_number; ?>');
            }
        break;
        case 'creditCard_month':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_month; ?>');
            }        
        case 'creditCard_year':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_year; ?>');
            }
        break;
        case 'creditCard_cvn':
            if(val.length > 1 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_credit_card_cvn; ?>');
            }
        break;
        case 'creditCard_owner':
            if(val.length > 1 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_credit_card_name; ?>');
            }
        break;
        case 'agreement':
            if ( $(this).prop("checked") ) {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_agreement; ?>');
            }
        break;
    }
});
// Валидация формы. END

// переход к следующему/предыдущему шагу START
function nextStep() {
  var s = $('#step').val();
  $('#step').val(parseInt(s) + 1);
  $('#step').change();
}
function prevStep() {
  var s = $('#step').val();
  if ( s > 2 ) {
    $('#step').val(parseInt(s) - 1);
    $('#step').change();
  }
}


$('.js-next-step').on('click', function(){
  nextStep();
});
$('.js-prev-step').on('click', function(){
  prevStep();
});

$('.js-indication-step-2').on('click', function(){
  prevStep();
});
$('.js-indication-step-3').on('click', function(){
  nextStep();
});

$('#step').on('change', function(){
    
  var s = $('#step').val();
  switch(s) {
    case '2':
      $('.js-step-2').removeClass('h-hidden');
      $('.js-step-3').addClass('h-hidden');
      $('.js-indication-step-2').addClass('b-checkout_progress_indicator-step--active');
      $('.js-indication-step-3').removeClass('b-checkout_progress_indicator-step--active');
    break;
    case '3':
      $('.js-step-2 input.js-state-required, .js-step-2 select.js-state-required').blur();
       
      if ( $('.js-step-2 .f-state-valid').length == ($('.js-step-2 input.f-state-required').length) ) {
        // переходим на следующий шаг:
        $('.js-step-2').addClass('h-hidden');
        $('.js-step-3').removeClass('h-hidden');
        $('.js-indication-step-3').addClass('b-checkout_progress_indicator-step--active');
        $('.js-indication-step-2').removeClass('b-checkout_progress_indicator-step--active');
        var address_summary = '<p>' + $('#first_name').val() + ' ' + $('#last_name').val()  + '</p>' +
                              '<p>' + $('.country_lable').html() + '</p>' +
                              '<p>' + $('#fields_zip').val() + ', ' + $('#city').val() + ', ' + $('#address1').val() + '</p>' + 
                              '<?php echo $text_fields_phone;?> ' + $('#fields_phone').val() + '</p>';
        $('.js-checkout_shipping_address_summary').html(address_summary);
      } else {
        // НЕ переходим на следующий шаг:
        alert('Не все поля заполнены верно!');
        prevStep();
      }
    break;
    case '4':
      $('.js-step-3 input.js-state-required, .js-step-3 select.js-state-required').blur();
      if ($('.js-step-3 .f-state-valid').length == $('.js-step-3 .js-state-required').length) {
        // переходим на следующий шаг:
        //alert('Дописать отправку формы....');
        //$('#step').val(3);
        //debugger;
        
        
         var email = $('#address_email').val();
         var password = $('#password').val();
         var confirm = $('#confirm').val();
         var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var address1 =  $('#address1').val();
        var address2 = $('#address2').val();
        var postcode = $('#fields_zip').val();
        var city = $('#city').val();
        var country_code = $('#country').val();
        var fields_phone = $('#fields_phone').val();
        
        $.ajax({
          type: 'post',
          url: 'index.php?route=checkout/confirm',
          data: 'fields_phone='+fields_phone+'&email='+email+'&password='+password+'&confirm='+confirm+'&first_name='+first_name+'&last_name='+last_name+'&address1='+address1+'&address2='+address2+'&postcode='+postcode+'&city='+city+'&country_code='+country_code,
          dataType: 'html',
          cache: false,
          beforeSend: function() {
            $('#button-confirm').button('loading');
          },
          complete: function() {
            $('#button-confirm').button('reset');
          },
          success: function(html) {
            //console.log(html);
            //debugger;
            //$('.l-main_checkout').html(html);
            //$('a[href=\'#collapse-checkout-confirm\']').trigger('click');
            location = '/index.php?route=checkout/success';
          }
        });
        
      } else {
        // НЕ переходим на следующий шаг:
        alert('Не все поля заполнены верно!');
        prevStep();
      }
    break;
  }
});
// переход к следующему/предыдущему шагу END


</script>








<script type="text/javascript"><!--
$(document).on('change', 'input[name=\'account\']', function() {
	if ($('#collapse-payment-address').parent().find('.panel-heading .panel-title > *').is('a')) {
		if (this.value == 'register') {
			$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_account; ?> <i class="fa fa-caret-down"></i></a>');
		} else {
			$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');
		}
	} else {
		if (this.value == 'register') {
			$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_account; ?>');
		} else {
			$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_address; ?>');
		}
	}
});

<?php if (!$logged) { ?>
$(document).ready(function() {
    $.ajax({
        url: 'index.php?route=checkout/login',
        dataType: 'html',
        success: function(html) {
           $('#collapse-checkout-option .panel-body').html(html);

			$('#collapse-checkout-option').parent().find('.panel-heading .panel-title').html('<a href="#collapse-checkout-option" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_option; ?> <i class="fa fa-caret-down"></i></a>');

			$('a[href=\'#collapse-checkout-option\']').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
<?php } else { ?>
$(document).ready(function() {
    $.ajax({
        url: 'index.php?route=checkout/payment_address',
        dataType: 'html',
        success: function(html) {
            $('#collapse-payment-address .panel-body').html(html);

			$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');

			$('a[href=\'#collapse-payment-address\']').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
<?php } ?>

// Checkout
$(document).delegate('#button-account', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/' + $('input[name=\'account\']:checked').val(),
        dataType: 'html',
        beforeSend: function() {
        	$('#button-account').button('loading');
		},
        complete: function() {
			$('#button-account').button('reset');
        },
        success: function(html) {
            $('.alert, .text-danger').remove();

            $('#collapse-payment-address .panel-body').html(html);

			if ($('input[name=\'account\']:checked').val() == 'register') {
				$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_account; ?> <i class="fa fa-caret-down"></i></a>');
			} else {
				$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');
			}

			$('a[href=\'#collapse-payment-address\']').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Login
$(document).delegate('#button-login', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/login/save',
        type: 'post',
        data: $('#collapse-checkout-option :input'),
        dataType: 'json',
        beforeSend: function() {
        	$('#button-login').button('loading');
		},
        complete: function() {
            $('#button-login').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('#collapse-checkout-option .panel-body').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">Ok</button></div>');

				// Highlight any found errors
				$('input[name=\'email\']').parent().addClass('has-error');
				$('input[name=\'password\']').parent().addClass('has-error');
		   }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Register
$(document).delegate('#button-register', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/register/save',
        type: 'post',
        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address textarea, #collapse-payment-address select'),
        dataType: 'json',
        beforeSend: function() {
			$('#button-register').button('loading');
		},
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('#button-register').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
            } else {
                <?php if ($shipping_required) { ?>
                var shipping_address = $('#payment-address input[name=\'shipping_address\']:checked').prop('value');

                if (shipping_address) {
                    $.ajax({
                        url: 'index.php?route=checkout/shipping_method',
                        dataType: 'html',
                        success: function(html) {
							// Add the shipping address
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_address',
                                dataType: 'html',
                                success: function(html) {
                                    $('#collapse-shipping-address .panel-body').html(html);

									$('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });

							$('#collapse-shipping-method .panel-body').html(html);

							$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_method; ?> <i class="fa fa-caret-down"></i></a>');

   							$('a[href=\'#collapse-shipping-method\']').trigger('click');

							$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
							$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
							$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/shipping_address',
                        dataType: 'html',
                        success: function(html) {
                            $('#collapse-shipping-address .panel-body').html(html);

							$('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');

							$('a[href=\'#collapse-shipping-address\']').trigger('click');

							$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
							$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
							$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
                <?php } else { ?>
                $.ajax({
                    url: 'index.php?route=checkout/payment_method',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-payment-method\']').trigger('click');

						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                <?php } ?>

                $.ajax({
                    url: 'index.php?route=checkout/payment_address',
                    dataType: 'html',
                    complete: function() {
                        $('#button-register').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-payment-address .panel-body').html(html);

						$('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Payment Address
$(document).delegate('#button-payment-address', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/payment_address/save',
        type: 'post',
        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select'),
        dataType: 'json',
        beforeSend: function() {
        	$('#button-payment-address').button('loading');
		},
        complete: function() {
			$('#button-payment-address').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                //location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().parent().addClass('has-error');
            } else {
                <?php if ($shipping_required) { ?>
                $.ajax({
                    url: 'index.php?route=checkout/shipping_address',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-shipping-address .panel-body').html(html);

						$('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-shipping-address\']').trigger('click');

						$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                <?php } else { ?>
                $.ajax({
                    url: 'index.php?route=checkout/payment_method',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-payment-method\']').trigger('click');

						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                <?php } ?>

                $.ajax({
                    url: 'index.php?route=checkout/payment_address',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-payment-address .panel-body').html(html);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Shipping Address
$(document).delegate('#button-shipping-address', 'click', function() {
    debugger;
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/save',
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        beforeSend: function() {
			$('#button-shipping-address').button('loading');
	    },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                //location = json['redirect'];
            } else if (json['error']) {
                $('#button-shipping-address').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-shipping-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().parent().addClass('has-error');
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/shipping_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-shipping-address').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-shipping-method .panel-body').html(html);

						$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_method; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-shipping-method\']').trigger('click');

						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');

                        $.ajax({
                            url: 'index.php?route=checkout/shipping_address',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-shipping-address .panel-body').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

                $.ajax({
                    url: 'index.php?route=checkout/payment_address',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-payment-address .panel-body').html(html);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Guest
$(document).delegate('#button-guest', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/guest/save',
        type: 'post',
        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select'),
        dataType: 'json',
        beforeSend: function() {
       		$('#button-guest').button('loading');
	    },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                //location = json['redirect'];
            } else if (json['error']) {
                $('#button-guest').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
            } else {
                <?php if ($shipping_required) { ?>
                var shipping_address = $('#collapse-payment-address input[name=\'shipping_address\']:checked').prop('value');

                if (shipping_address) {
                    $.ajax({
                        url: 'index.php?route=checkout/shipping_method',
                        dataType: 'html',
                        complete: function() {
                            $('#button-guest').button('reset');
                        },
                        success: function(html) {
							// Add the shipping address
                            $.ajax({
                                url: 'index.php?route=checkout/guest_shipping',
                                dataType: 'html',
                                success: function(html) {
                                    $('#collapse-shipping-address .panel-body').html(html);

									$('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });

						    $('#collapse-shipping-method .panel-body').html(html);

							$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_method; ?> <i class="fa fa-caret-down"></i></a>');

							$('a[href=\'#collapse-shipping-method\']').trigger('click');

							$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
							$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/guest_shipping',
                        dataType: 'html',
                        complete: function() {
                            $('#button-guest').button('reset');
                        },
                        success: function(html) {
                            $('#collapse-shipping-address .panel-body').html(html);

							$('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');

							$('a[href=\'#collapse-shipping-address\']').trigger('click');

							$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
							$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
							$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
                <?php } else { ?>
                $.ajax({
                    url: 'index.php?route=checkout/payment_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-guest').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-payment-method\']').trigger('click');

						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                <?php } ?>
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Guest Shipping
$(document).delegate('#button-guest-shipping', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/guest_shipping/save',
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        beforeSend: function() {
        	$('#button-guest-shipping').button('loading');
		},
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                //location = json['redirect'];
            } else if (json['error']) {
                $('#button-guest-shipping').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-danger">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-shipping-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/shipping_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-guest-shipping').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-shipping-method .panel-body').html(html);

						$('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_method; ?> <i class="fa fa-caret-down"></i>');

						$('a[href=\'#collapse-shipping-method\']').trigger('click');

						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$(document).delegate('#button-shipping-method', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/shipping_method/save',
        type: 'post',
        data: $('#collapse-shipping-method input[type=\'radio\']:checked, #collapse-shipping-method textarea'),
        dataType: 'json',
        beforeSend: function() {
        	$('#button-shipping-method').button('loading');
		},
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                //location = json['redirect'];
            } else if (json['error']) {
                $('#button-shipping-method').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-method .panel-body').prepend('<div class="alert alert-danger">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/payment_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-shipping-method').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

						$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-payment-method\']').trigger('click');

						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$(document).delegate('#button-payment-method', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/payment_method/save',
        type: 'post',
        data: $('#collapse-payment-method input[type=\'radio\']:checked, #collapse-payment-method input[type=\'checkbox\']:checked, #collapse-payment-method textarea'),
        dataType: 'json',
        beforeSend: function() {
         	$('#button-payment-method').button('loading');
		},
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                //location = json['redirect'];
            } else if (json['error']) {
                $('#button-payment-method').button('reset');
                
                if (json['error']['warning']) {
                    $('#collapse-payment-method .panel-body').prepend('<div class="alert alert-danger">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/confirm',
                    dataType: 'html',
                    complete: function() {
                        $('#button-payment-method').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-checkout-confirm .panel-body').html(html);

						$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<a href="#collapse-checkout-confirm" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_confirm; ?> <i class="fa fa-caret-down"></i></a>');

						$('a[href=\'#collapse-checkout-confirm\']').trigger('click');
					},
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?>
