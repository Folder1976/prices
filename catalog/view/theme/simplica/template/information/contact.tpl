<?php echo $header; ?>

<main role="main" class="l-main-information g-container">

  <div class="l-main-information__header">
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
  </div>

  <div class="html-slot-container b-slot--customer-service-top" style="display: none;">
      <div class="b-customer_service-sub_header" style="padding-left:31%">
          <div class="b-customer_service-sub_header-sub_title">
              <div class="b-customer_service-sub_header-right">
                  <div class="b-customer_service-sub_header-title"><?php echo $text_contact; ?></div>
                  <div class="b-customer_service-sub_header-sub_title"><?php echo $text_info; ?></div>
                  <a class="b-customer_service-sub_header-link" href="index.php?route=information/contact"><?php echo $email; ?></a>
              </div>
          </div>
      </div>
  </div>

  <div class="l-main-information__content">
    <div class="b-customer_service_navigation-mob-button js-toggler"
         data-slide=".js-l-customer_service-left"
         data-toggle-class="h-minimized-customer_service-left"
         data-toggle-elem-class="h-toggled"></div>
    <div class="l-main-information__left js-l-customer_service-left h-minimized-customer_service-left">
      <div class="b-customer-service-navigation">
        <?php echo $leftmenu; ?>
      </div>
    </div>

    <div class="l-main-information__right">
      <h1><?php echo $text_contact_us; ?></h1>
      <div class="content">
        <?php echo $text_for_contact ?>
      </div>
      <div class="b-account-form">
        <form action="<?php echo $action; ?>" method="post" class="js-contactus_form b-customer_service_content-form">

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="firstname"><?php echo $entry_name; ?></label>
              </div>
              <div class="f-field">
                <input type="text"
                       name="name"
                       value="<?php echo $name; ?>"
                       placeholder="<?php echo $entry_name; ?>"
                       id="firstname"
                       class="f-input"
                       maxlength="50"
                       required="required"
                       pattern=".{3,}"
                       title="минимум 3 символа" />
              </div>
            </div>
          </div>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="lastname"><?php echo $entry_lastname; ?></label>
              </div>
              <div class="f-field">
                <input type="text"
                       name="lastname"
                       value="<?php echo $lastname; ?>"
                       placeholder="<?php echo $entry_lastname; ?>"
                       id="lastname"
                       class="f-input"
                       required="required"
                       pattern=".{3,}"
                       title="минимум 3 символа" />
              </div>
            </div>
          </div>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="input-email"><?php echo $entry_email; ?></label>
              </div>
              <div class="f-field">
                <input type="email"
                       name="email"
                       value="<?php echo $email; ?>"
                       placeholder="<?php echo $entry_email; ?>"
                       id="email"
                       class="f-input"
                       required="required"
                       pattern=".{3,}"
                       title="минимум 3 символа" />
              </div>
            </div>
          </div>

          <div class="f-group">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="input-email"><?php echo $entry_ordernum; ?></label>
              </div>
              <div class="f-field">
                <input type="text"
                       name="ordernumber"
                       value="<?php echo $ordernumber; ?>"
                       placeholder="<?php echo $entry_ordernum; ?>"
                       id="ordernumber"
                       class="f-input" />
              </div>
            </div>
          </div>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="myquestion"><?php echo $entry_theme; ?></label>
              </div>
              <div class="f-field">
                <select name="myquestion" id="myquestion" class="f-select">
                  <?php foreach ($contact_theme as $theme) { ?>
                    <option value="<?php echo $theme['key'];?>"><?php echo $theme['value'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="input-enquiry"><?php echo $entry_message; ?></label>
              </div>
              <div class="f-field">
                <textarea id="input-enquiry" name="input-enquiry" class="f-textarea" data-character-limit="3000" maxlength="3000"></textarea><div class="char-count"><?php echo $text_form_message_count; ?></div>
              </div>
            </div>
          </div>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="countries_country"><?php echo $entry_country; ?></label>
              </div>
              <div class="f-field">
                <select name="countries_country" id="countries_country" class="f-select">
                  <option value=""><?php echo $entry_chose_country; ?></option>
                  <?php foreach ($countries as $country) { ?>
                    <option value="<?php echo $country['iso_code_2'];?>" ><?php echo $country['name'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>


            <div class="b-contact_us_mandatory_field"></div>
            <div class="b-customer_service_content-asset">
                <div class="b-content_asset b-content_asset--contact_us content-asset">
                </div><!-- End content-asset contact_us -->
            </div>

            <button type="submit" value="<?php echo $entry_send; ?>" name="contactus_send" class="f-button js-contactus_submit">
                <?php echo $button_submit; ?>
            </button>       
        </form>
      </div>

    </div>
  </div>

</main>







<script>
    $(document).ready(function() {
        // Валидация формы
        $('input#firstname, input#lastname, input#email, textarea#input-enquiry, select#countries_country').on('blur', function(){
            var id = $(this).attr('id');
            var val = $(this).val();

            function setErrorMessage(el, mess) {
                $('.js-error_'+el).html(mess);
                if (mess == '') {
                    $('.js-error_'+el).closest('.f-field').removeClass('f-state-error').addClass('f-state-valid');
                }else {
                    $('.js-error_'+el).closest('.f-field').removeClass('f-state-valid').addClass('f-state-error');
                }
            }

            switch(id) {
                case 'firstname':
                    var rv_name = /^[a-zA-Zа-яА-Я]+$/;
                    if(val.length > 2 && val != '' && rv_name.test(val)) {
                        setErrorMessage(id, '');
                    } else {
                        setErrorMessage(id, '<?php echo $error_name; ?>');
                    }
                break;
                case 'lastname':
                    var rv_name = /^[a-zA-Zа-яА-Я]+$/;
                    if(val.length > 2 && val != '' && rv_name.test(val)) {
                        setErrorMessage(id, '');
                    } else {
                        setErrorMessage(id, '<?php echo $error_lastname; ?>');
                    }
                break;
                case 'email':
                    var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                    if(val.length > 2 && val != '' && rv_email.test(val)) {
                        setErrorMessage(id, '');
                    } else {
                        setErrorMessage(id, '<?php echo $error_email; ?>');
                    }
                break;
                case 'input-enquiry':
                    if(val.length > 10 && val != '') {
                        setErrorMessage(id, '');
                    } else {
                        setErrorMessage(id, '<?php echo $error_enquiry; ?>');
                    }
                break;
                case 'countries_country':
                    if(val != '' && val != null) {
                        setErrorMessage(id, '');
                    } else {
                        setErrorMessage(id, '<?php echo $error_countries_country; ?>');
                    }
                break;
            }
        });

        // Textarea:
        $('textarea#input-enquiry').on('keyup', function(){
            $('.char-remain-count').html(3000 - $(this).val().length);
        });

        // проверяем все поля перед отправкиой формы
        // если есть ошибки - скролим страницу до первого поля с ошибкой
        function scrollToElement(theElement) {
            var selectedPosX = 0;
            var selectedPosY = 0;
            if (theElement != null) {
                selectedPosX += $(theElement).offset().left;
                selectedPosY += $(theElement).offset().top - $('.b-header_main-top').height();
            }
            window.scrollTo(selectedPosX,selectedPosY);
        }

        $('.js-contactus_submit').on('click', function(e){
            
            $('input#firstname, input#lastname, input#email, textarea#input-enquiry, select#countries_country').blur();
            if ($('.f-state-valid').length == 5) {
                return true;  // отправка формы
            } else {
                scrollToElement( $('.f-state-error').first() );
                return false;
            }
        });


    });
</script>

<?php echo $footer; ?>
