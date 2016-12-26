<?php echo $header; ?>

<main role="main" class="l-main_customer_service">
    <div class="l-customer_service">
        <div class="l-customer_service-top">

            <div class="html-slot-container b-slot--customer-service-top">
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

            <div class="b-customer_service_navigation-mob-button js-toggler"
                 data-slide=".js-l-customer_service-left"
                 data-toggle-class="h-minimized-customer_service-left"
                 data-toggle-elem-class="h-toggled"></div>
            <div class="l-customer_service-left js-l-customer_service-left h-minimized-customer_service-left">
                <div class="b-customer_service_navigation">
                    <?php echo $leftmenu; ?>
                 </div>
            </div>

            <div class="l-customer_service-right">

                <div class="js-customer_service_content b-customer_service_content">
                    <h1 class="b-customer_service_content-title"><?php echo $text_contact_us; ?></h1>
                    <div class="b-content_asset b-content_asset--contact-form-text content-asset">
                        <div class="content">
                            <?php echo $text_for_contact ?>
                            
                        </div>
                        <div class="b-customer_service_content">
                            <form action="<?php echo $action; ?>" method="post" class="js-contactus_form b-customer_service_content-form" novalidate="novalidate">

                                <div class=" f-field f-field-textinput f-type-firstname f-state-required" data-required-text="<?php echo $error_form_name; ?>">
                                    <label class="f-label" for="firstname">
                                        <span class="f-label-value"><?php echo $entry_name; ?></span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <input id="firstname" name="name" class="f-textinput f-state-required" maxlength="50" value="<?php echo $name; ?>" type="text">
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_firstname"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class=" f-field f-field-textinput f-type-lastname f-state-required" data-required-text="<?php echo $error_form_lastname;?>">
                                    <label class="f-label" for="lastname">
                                        <span class="f-label-value"><?php echo $entry_lastname; ?></span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <input id="lastname" name="lastname" class="f-textinput f-state-required" maxlength="50" value="<?php echo $lastname; ?>" type="text">
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_lastname"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class=" f-field f-field-email f-type-email f-state-required" data-required-text="<?php echo $error_form_email; ?>">
                                    <label class="f-label" for="email">
                                        <span class="f-label-value"><?php echo $entry_email;?></span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <input id="email" name="email" class="f-email f-state-required" maxlength="50" value="" type="email">
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_email"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class=" f-field f-field-textinput f-type-ordernumber" data-required-text="<?php echo $error_form_ordernum; ?>">
                                    <label class="f-label" for="ordernumber">
                                        <span class="f-label-value"><?php echo $entry_ordernum; ?></span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <input id="ordernumber" name="ordernumber" class="f-textinput  " maxlength="2147483647" value="<?php echo $ordernumber; ?>" type="text">
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_ordernumber"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class=" f-field f-field-select f-type-myquestion f-state-required" data-required-text="<?php echo $error_form_theme; ?>">
                                    <label class="f-label" for="myquestion">
                                        <span class="f-label-value">
                                            <?php echo $entry_theme; ?>
                                        </span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <div class="f-select-wrapper">
                                            <select class="f-select f-state-required" id="myquestion" name="myquestion">
                                                <?php foreach ($contact_theme as $theme) { ?>
                                                    <option class="f-select_option" value="<?php echo $theme['key'];?>"><?php echo $theme['value'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                      
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_myquestion"></span>
                                        </span>
                                    </div>
                                </div>  

                                <div class="f-field f-field-textarea f-type-comment f-state-required" data-required-text="<?php echo $error_form_message; ?>">
                                    <label class="f-label" for="input-enquiry">
                                        <span class="f-label-value"><?php echo $entry_message; ?></span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <textarea id="input-enquiry" name="input-enquiry" class="f-textarea f-state-required" data-character-limit="3000" maxlength="3000"></textarea><div class="char-count"><?php echo $text_form_message_count; ?></div>
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_input-enquiry"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="f-field f-field-select f-type-country f-state-required" data-required-text="<?php echo $error_form_country; ?>">
                                    <label class="f-label" for="countries_country">
                                        <span class="f-label-value"><?php echo $entry_country; ?></span>
                                    </label>
                                    <div class="f-field-wrapper">
                                        <div class="f-select-wrapper">
                                            <select class="f-select country f-state-required" id="countries_country" name="countries_country">
                                                <option class="f-select_option" value="" selected="selected" disabled=""><?php echo $entry_chose_country; ?></option>
                                                <?php foreach ($countries as $country) { ?>
                                                    <option class="f-select_option" value="<?php echo $country['iso_code_2'];?>" ><?php echo $country['name'];?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <span class="f-error_message">
                                            <span class="f-error_message-block js-error_countries_country"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="b-contact_us_mandatory_field"></div>
                                <div class="b-customer_service_content-asset">
                                    <div class="b-content_asset b-content_asset--contact_us content-asset">
                                    </div><!-- End content-asset contact_us -->
                                </div>

                                <button type="submit" value="<?php echo $entry_send; ?>" name="contactus_send" class="b-customer_service_content-submit_button js-contactus_submit">
                                    <?php echo $button_submit; ?>
                                </button>       
                            </form>
                        </div>

                    </div>
                </div>




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
