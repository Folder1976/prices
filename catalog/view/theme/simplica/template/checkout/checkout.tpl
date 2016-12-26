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

$faq_array = array ();   // Сюда засунуть фак
//$faq_array['href'];
//$faq_array['title'];



?>

<main role="main" class="l-main_checkout">

<input type="text" class="h-hidden" value="2" id="step">

<ol class="b-checkout_progress_indicator">
    <li class="b-checkout_progress_indicator-step js-indication-step-1"><a href="/index.php?route=checkout/cart"><?php echo $text_cart; ?></a></li>
    <li class="b-checkout_progress_indicator-step js-indication-step-2 b-checkout_progress_indicator-step--active"><span><?php echo $text_order; ?></span></li>
    <li class="b-checkout_progress_indicator-step js-indication-step-3"><span><?php echo $text_confirmation_order; ?></span></li>
  </ol>
  <div class="l-checkout_cart">

<!-- Левая колонка. START -->
    <div class="l-checkout_cart-left">
      <?php if ($error_warning) { ?>
      <div class="alert alert-danger .f-field-wrapper">
        <span class="f-error_message">
          <i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        </span>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>

  <!-- Форма авторзации START -->
      <div class="panel-collapse collapse js-step-2" id="collapse-checkout-option">
        <div class="panel-body"></div>
      </div>
  <!-- Форма авторзации END -->

<?php

//header("Content-Type: text/html; charset=UTF-8");
//echo "<pre>";  print_r(var_dump( $customer_info )); echo "</pre>";
?>

  <!-- Информация о доставке START -->
      <div class="b-checkout_shipping_address js-step-2">
        <h3 class="b-checkout_shipping_address-title"><?php echo $text_delivery_information; ?></h3>
        <div class="b-checkout_shipping_address-wrapper">

    <?php if($logged) { ?>
          <div class="f-field f-field-textinput f-state-required">
              <div class="f-select-wrapper" id="select_address">

                <select class="f-select country js-state-required" id="delivery_address" name="delivery_address">
                    <option value="0"><?php echo $text_select_delive_adress; ?></option>
                    <?php if(isset($customer_info['addresses']) AND is_array($customer_info['addresses'])){ ?>
                        <?php foreach ($customer_info['addresses'] as $result) { ?>
                            <option value="<?php echo $result['address_id']; ?>"><?php echo $result['city'].', '.$result['address_1'].', '.$result['address_2']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </div>
              <span class="f-error_message">
                <span class="f-error_message-block js-error_country"></span>
              </span>
          </div>
            <script>
                $(document).on('change', '#delivery_address', function(){
                        
                    $.ajax({
                        url: 'index.php?route=checkout/checkout/get_address',
                        type: 'post',
                        data: $('#select_address select'),
                        dataType: 'json',
                        beforeSend: function() {
                            
                        },
                        complete: function() {
                            
                        },
                        success: function(json) {
                            
                            //console.log(json);
                            
                            if (json['success'] == 1) {
                                
                                $('#first_name').val(json['firstname']);
                                $('#last_name').val(json['lastname']);
                                $('#address1').val(json['address_1']);
                                $('#address2').val(json['address_2']);
                                $('#fields_zip').val(json['postcode']);
                                $('#city').val(json['city']);
                                $('#country').val(json['iso_code_2']);
                                 
                            }
                            
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                });
        
            </script>
    <?php } ?>


          <div class="f-field f-field-email f-state-required">
            <label class="f-label" for="address_email">
              <span class="f-label-value"><?php echo $text_email; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="address_email"
                     name="address_email"
                     class="f-email f-state-required js-state-required"
                     placeholder="<?php echo $text_email_placeholder; ?>"
                     value="<?php echo isset($customer_info['email']) ? $customer_info['email'] : ''; ?>"
                     type="email">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_address_email"></span>
              </span>
            </div>
          </div>
<?php if( !$logged ) { ?>
          <div class="f-field f-field-password f-state-required">
            <label class="f-label" for="password">
              <span class="f-label-value"><?php echo $text_password; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="password"
                     name="password"
                     class="f-password f-state-required js-state-required"
                     placeholder="<?php echo $text_password_placeholder; ?>"
                     value="<?php echo isset($customer_info['email']) ? $customer_info['email'] : ''; ?>"
                     type="password">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_password"></span>
              </span>
            </div>
          </div>

          <div class="f-field f-field-password f-state-required">
            <label class="f-label" for="confirm">
              <span class="f-label-value"><?php echo $text_password_confirm; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="confirm"
                     name="confirm"
                     class="f-password f-state-required js-state-required"
                     placeholder="<?php echo $text_password_confirm_placeholder; ?>"
                     value="<?php echo isset($customer_info['email']) ? $customer_info['email'] : ''; ?>"
                     type="password">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_confirm"></span>
              </span>
            </div>
          </div>
<?php } ?>
          <div class="f-field f-field-textinput f-state-required">
            <label class="f-label" for="first_name">
              <span class="f-label-value"><?php echo $text_name; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="first_name"
                     name="first_name"
                     class="f-textinput f-state-required js-state-required"
                     placeholder="<?php echo $text_name_placeholder; ?>"
                     value="<?php echo isset($customer_info['firstname']) ? $customer_info['firstname'] : ''; ?>"
                     type="text"
                     maxlength="35">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_first_name"></span>
              </span>
            </div>
          </div>

          <div class="f-field f-field-textinput f-state-required">
            <label class="f-label" for="last_name">
              <span class="f-label-value"><?php echo $text_last_name; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="last_name"
                     name="last_name"
                     class="f-textinput f-state-required js-state-required"
                     placeholder="<?php echo $text_last_name_placeholder; ?>"
                     value="<?php echo isset($customer_info['lastname']) ? $customer_info['lastname'] : ''; ?>"
                     type="text"
                     maxlength="35">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_last_name"></span>
              </span>
            </div>
          </div>

          <div class="f-field f-field-textinput f-state-required">
            <label class="f-label" for="address1">
              <span class="f-label-value"><?php echo $text_address1; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="address1"
                     name="address1"
                     class="f-textinput f-state-required js-state-required"
                     placeholder="<?php echo $text_address1_placeholder; ?>"
                     value="<?php //echo isset($customer_info['firstname']) ? $customer_info['firstname'] : ''; ?>"
                     type="text"
                     maxlength="35">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_address1"></span>
              </span>
            </div>
          </div>

          <!--div class="f-field f-field-textinput f-state-required">
            <label class="f-label" for="address2">
              <span class="f-label-value"><?php echo $text_address2; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="address2"
                     name="address2"
                     class="f-textinput f-state-required js-state-required"
                     placeholder="<?php echo $text_address2_placeholder; ?>"
                     value="<?php //echo isset($customer_info['firstname']) ? $customer_info['firstname'] : ''; ?>"
                     type="text"
                     maxlength="35">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_address2"></span>
              </span>
            </div>
          </div-->
        <input id="address2"
                     name="address2"
                     class="f-textinput js-state-required"
                     placeholder="<?php echo $text_address2_placeholder; ?>"
                     value=""
                     type="hidden"
                     maxlength="35">
                     
          <div class="f-field f-field-textinput f-state-required">
            <label class="f-label" for="fields_zip">
              <span class="f-label-value"><?php echo $text_fields_zip; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="fields_zip"
                     name="fields_zip"
                     class="f-textinput f-state-required js-state-required"
                     placeholder="<?php echo $text_fields_zip_placeholder; ?>"
                     value="<?php //echo isset($customer_info['firstname']) ? $customer_info['firstname'] : ''; ?>"
                     type="text"
                     maxlength="100">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_fields_zip"></span>
              </span>
            </div>
          </div>

          <div class="f-field f-field-textinput f-state-required">
            <label class="f-label" for="city">
              <span class="f-label-value"><?php echo $text_city; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input id="city"
                     name="city"
                     class="f-textinput f-state-required js-state-required"
                     placeholder="<?php echo $text_city_placeholder; ?>"
                     value="<?php //echo isset($customer_info['firstname']) ? $customer_info['firstname'] : ''; ?>"
                     type="text"
                     maxlength="50">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_city"></span>
              </span>
            </div>
          </div>

          <div class="f-field f-field-textinput">
            <label class="f-label" for="country">
              <span class="f-label-value"><?php echo $text_country; ?></span>
            </label>
            
            
            <div class="f-field-wrapper">
              <div class="f-select-wrapper">
                
                <?php foreach($countries as $country) { ?>
                    <?php if($country_code == $country['iso_code_2']) { ?>
                    <input type="hidden" name="country" class="f-textinput country js-state-required" value="<?php echo $country['iso_code_2'];?>">
                    <label class="f-label country_lable"><?php echo $country['name'];?></label>
                    <?php } ?>
                <?php } ?>
                  
                <!--select class="f-select country js-state-required" id="country" name="country">
                  <?php foreach($countries as $country) { ?>
                  <option value="<?php echo $country['iso_code_2'];?>"><?php echo $country['name'];?></option>
                  <?php } ?>
                </select-->
              </div>
              <!--span class="f-error_message">
                <span class="f-error_message-block js-error_country"></span>
              </span-->
            </div>
          </div>

          <div class="f-field f-field-select f-type-phonecode f-state-required">
            <label class="f-label" for="fields_phoneCode">
              <span class="f-label-value"><?php echo $text_fields_phone; ?></span>
            </label>
            <div class="f-field-wrapper">
              <span class="f-error_message">
                <span class="f-error_message-block js-error_fields_phoneCode"></span>
              </span>
            </div>
          </div>
          <div class="f-field f-field-textinput f-type-phone f-state-required">
            <div class="f-field-wrapper">
              <input id="fields_phone"
                     name="fields_phone"
                     class="f-textinput phone f-state-required js-state-required"
                     placeholder="<?php echo $text_fields_phone_placeholder; ?>"
                     maxlength="20"
                     value="<?php echo isset($customer_info['telephone']) ? $customer_info['telephone'] : ''; ?>"
                     type="text">
              <span class="f-field_description"></span>
              <span class="f-error_message">
                <span class="f-error_message-block js-error_fields_phone"></span>
              </span>
            </div>
          </div>



        </div>
      </div>
  <!-- Информация о доставке END -->



      <div class="b-checkout_shipping_address js-step-3 h-hidden">
        <p><?php echo $text_have_questions; ?></p>
        <div class="b-checkout_payment-title--center">
          <div class="b-checkout_content_block-icon_block">
            <div class="b-checkout_content_block-icon_block-title"><?php echo $text_live_chat; ?></div>
            <a class="b-checkout_content_block-icon_mail" href="mailto:info@plazamilano.com?Subject=<?php echo $text_order_q; ?>"></a>
          </div>
          <div class="b-checkout_content_block-icon_block">
            <div class="b-checkout_content_block-icon_block-title"><?php echo $text_email_us; ?></div>
            <a class="b-checkout_content_block-icon_mail" href="mailto:info@plazamilano.com?Subject=<?php echo $text_order_q; ?>"></a>
          </div>
        </div>
      </div>

      <div class="b-checkout_payment js-step-3 h-hidden">
        <h3 class="b-checkout_shipping_address-title"><?php echo $text_delivery_info; ?></h3>
        <div class="b-checkout_shipping_address--summary js-checkout_shipping_address_summary"></div>
        <span class="b-checkout_shipping_address--summary-edit js-indication-step-2 js-prev-step"><?php echo $text_delivery_edit; ?></span>
      </div>

  <!-- Детали оплаты START -->
      <div class="b-checkout_payment js-step-3 h-hidden">
        <h3 class="b-checkout_payment-title"><?php echo $text_payment_details; ?></h3>
        <div class="b-checkout_payment-wrapper">
          <div id="PaymentMethod_CREDIT_CARD" class="b-checkout_payment-payment_method_expanded">

            <div class="b-checkout_payment-number_card">

              <div class="f-field f-field-textinput f-state-required">
                <label class="f-label" for="creditCard_number">
                  <span class="f-label-value"><?php echo $text_credit_card_number; ?></span>
                </label>
                <div class="f-field-wrapper">
                  <input id="creditCard_number"
                         name="creditCard_number"
                         class="f-textinput ccnumber f-state-required js-state-required"
                         placeholder="<?php echo $text_credit_card_number_placeholder; ?>"
                         value=""
                         type="text"
                         maxlength="20"
                         minlength="0">
                  <span class="f-error_message">
                    <span class="f-error_message-block js-error_creditCard_number"></span>
                  </span>
                </div>
              </div>
              <div class="b-cardtypes">
                <ul>
                    <li class="b-cardtypes-mastercard off js-cardtype"></li>
                    <li class="b-cardtypes-visa off js-cardtype"></li>
                    <li class="b-cardtypes-amex off js-cardtype"></li>
                    <li class="b-cardtypes-master off js-cardtype"></li>
                </ul>
              </div>

            </div>
            <span class="f-label"><?php echo $text_credit_card_expiration; ?><span class="required-indicator">*</span></span>
            <div class="b-checkout_payment-exp_date">
              <div class="b-checkout_payment-exp_date-month">
                <div class="f-field f-field-select month f-state-required">
                  <label class="f-label" for="creditCard_month">
                    <span class="f-label-value"><?php echo $text_month; ?></span>
                  </label>
                  <div class="f-field-wrapper">
                    <div class="f-select-wrapper">
                      <select class="f-select f-state-required js-state-required" id="creditCard_month" name="creditCard_month">
                        <option selected="selected" disabled=""><?php echo $text_month_mm; ?></option>
                        <option value="1"><?php echo $text_january; ?></option>
                        <option value="2"><?php echo $text_february; ?></option>
                        <option value="3"><?php echo $text_march; ?></option>
                        <option value="4"><?php echo $text_april; ?></option>
                        <option value="5"><?php echo $text_may; ?></option>
                        <option value="6"><?php echo $text_june; ?></option>
                        <option value="7"><?php echo $text_july; ?></option>
                        <option value="8"><?php echo $text_august; ?></option>
                        <option value="9"><?php echo $text_september; ?></option>
                        <option value="10"><?php echo $text_october; ?></option>
                        <option value="11"><?php echo $text_november; ?></option>
                        <option value="12"><?php echo $text_december; ?></option>
                      </select>
                    </div>
                    <span class="f-error_message">
                      <span class="f-error_message-block js-error_creditCard_month"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="b-checkout_payment-exp_date-year">  
                <div class="f-field f-field-select f-type-dynamic_year f-state-required">
                  <label class="f-label" for="creditCard_year">
                    <span class="f-label-value"><?php echo $text_year; ?></span>
                  </label>
                  <div class="f-field-wrapper">
                    <div class="f-select-wrapper">
                      <select class="f-select f-state-required js-state-required" id="creditCard_year" name="creditCard_year">
                        <option selected="selected" disabled=""><?php echo $text_year_yyyy; ?></option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                      </select>
                    </div>
                    <span class="f-error_message">
                      <span class="f-error_message-block js-error_creditCard_year"></span>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="f-field f-field-textinput b-checkout_payment-cvn_block-field f-state-required">
              <label class="f-label" for="creditCard_cvn">
                <span class="f-label-value"><?php echo $text_credit_card_cvn; ?></span>
              </label>
              <div class="f-field-wrapper">
                <input id="creditCard_cvn"
                       name="creditCard_cvn"
                       class="f-textinput f-state-required js-state-required"
                       placeholder="<?php echo $text_credit_card_cvn_placeholder; ?>"
                       value=""
                       type="text"
                       maxlength="100">
                <span class="f-error_message">
                  <span class="f-error_message-block js-error_creditCard_cvn"></span>
                </span>
              </div>
              <div class="b-checkout_payment-cvn_block-cvn_tip">
                <div class="g-tooltip g-tooltip--up">
                  <span class="g-tooltip-link"><?php echo $text_what_is_it; ?></span>
                  <span class="g-tooltip-content">    
                    <div class="b-content_asset b-content_asset--checkout-security-code content-asset">
                      <p style="margin: 5px; font-weight: bold;"><img alt="Номер CVN" class="imgright" src="/catalog/view/theme/simplica/img/cvnimage.png" width="180" height="241"><?php echo $text_what_is_cvn; ?></p>
                      <p style="margin: 5px;"><?php echo $text_what_is_cvn_text; ?></p>
                    </div>
                  </span> 
                </div>
              </div>
            </div>

            <div class="b-checkout_payment-name_card">
              <div class="f-field f-field-textinput f-state-required">
                <label class="f-label" for="creditCard_owner">
                  <span class="f-label-value"><?php echo $text_credit_card_name; ?></span>
                </label>
                <div class="f-field-wrapper">
                  <input id="creditCard_owner"
                         name="creditCard_owner"
                         class="f-textinput f-state-required js-state-required"
                         placeholder="<?php echo $text_credit_card_name_placeholder; ?>"
                         value=""
                         type="text"
                         maxlength="40"
                         minlength="4">
                  <span class="f-error_message">
                    <span class="f-error_message-block js-error_creditCard_owner"></span>
                  </span>
                </div>
              </div>
            </div>

            <div class=" f-field f-field-checkbox">
              <div class="f-field-wrapper">
                <input name="agreement"
                       id="agreement"
                       class="f-checkbox f-state-required js-state-required"
                       value="true"
                       type="checkbox">
                <label class="f-label" for="agreement">
                  <span class="f-label-value"><?php echo $text_agreement; ?></span>
                </label>
                <span class="f-error_message">
                  <span class="f-error_message-block js-error_agreement"></span>
                </span>
              </div>
            </div>

          </div>
        </div>
      </div>
  <!-- Детали оплаты END -->



      <div class="l-checkout_button_bottom">
        
          <div class="l-checkout_button">
            <button class="b-checkout_button js-next-step" name="checkout_submitStep" value="0">
              <?php echo $text_order; ?>
            </button>
          </div>
        
      </div>

    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-checkout_cart-right js-checkout_order_summary" style="">
      <div class="b-summary_list"> 
        <h2 class="b-summary_list-title"><?php echo $text_summary_information_on_ordering; ?></h2>

        <?php foreach ($totals as $total) { ?>
        <div class="b-summary_list-line b-summary_list-your_cart">
          <span class="b-summary_list-label"><?php echo $total['title']; ?></span>
          <span class="b-summary_list-value"><?php echo $total['text']; ?></span>
        </div>
        <?php } ?>

      </div>

      <div class="l-checkout_button">
        <button class="b-checkout_button js-next-step" name="submitStep">
          <?php echo $text_order; ?>
        </button>
      </div>

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
    
  $(document).on('change', '.f-textinput', function(){
    
       
                             
    
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
</script>

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

<div class="container h-hidden">

  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_option; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-checkout-option">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php if (!$logged && $account != 'guest') { ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_account; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php } else { ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_payment_address; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php } ?>
        <?php if ($shipping_required) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_shipping_address; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-shipping-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_shipping_method; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-shipping-method">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php } ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_payment_method; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-method">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_confirm; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-checkout-confirm">
            <div class="panel-body"></div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>






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
