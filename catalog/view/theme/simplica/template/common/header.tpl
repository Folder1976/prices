<?php
/*
$text_email = 'E-mail';
$text_password_reset = 'Востановление пароля';
$text_i_remember_password = 'Помню пароль';
$text_reestablish = 'Востановить';
$text_name = 'Имя';
$text_register_new_buyer = 'Регистрация нового пользователя';
$text_register_new_wholesale_buyer = 'Регистрация оптового покупателя';
$text_sign_up = 'Зарегистрироваться';
$text_cabinet = 'Кабинет';
$text_enter_in_account = 'Войти в аккаунт';
$text_back_to_shopping = 'Вернуться к покупкам';
$text_go_back = 'Назад';

$text_error_name = 'Имя должно быть от 3 до 32 символов!';
$text_error_email = 'E-mail адрес введен неверно!';
$text_error_password = 'Введите пароль';
$text_error_password_confirm = 'Введите пароль ещё раз';
$text_error_form_valid = 'Не все поля заполнены верно!';

$text_cart = 'Ваша корзина';
$text_wishlist = 'Список желаний';
$text_service_center = 'Клиентская служба';
*/
/*
Осталось без перевода:
2) помоему это не задействовано (смысл переводить?) : "Вы в Украина", "Верный язык?", "Верная страна?", "Оставить", "Изменить"
*/

?>
<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<!-- <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" /> -->
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/simplica/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<link href="/catalog/view/theme/simplica/stylesheet/jquery-ui.css" rel="stylesheet">
<link href="/catalog/view/theme/simplica/stylesheet/style.css" rel="stylesheet">
<!-- <link href="/catalog/view/theme/simplica/stylesheet/style_mobile.css" rel="stylesheet"> -->
<link href="/catalog/view/theme/simplica/stylesheet/develop.css" rel="stylesheet">
<link href="/catalog/view/theme/simplica/stylesheet/develop_mobile.css" rel="stylesheet">
<script src="/catalog/view/javascript/common.js" type="text/javascript"></script>
<!-- <script src="catalog/view/theme/simplica/js/jquery-ui.js" type="text/javascript"></script> -->
<!-- <script src="catalog/view/theme/simplica/js/klarna.js" type="text/javascript"></script> -->
<!-- <script src="catalog/view/theme/simplica/js/app_lib.js" type="text/javascript"></script> -->
<link rel="stylesheet" href="/catalog/view/theme/simplica/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="/catalog/view/theme/simplica/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script src="/catalog/view/theme/simplica/js/owl.carousel.min.js" type="text/javascript"></script>


<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

</head>

<body class="<?php echo $class; ?> s-search m-not_authenticated_user" id="p-search">

    <noscript>
        <div class="b-js_off_alert">
            <p class="b-js_off_alert-copy"><?php echo $text_alert_copy; ?></p>
        </div>
    </noscript>
    <div class="h-hidden b-cookies_off js-disabled-cookies">
        <p class="b-cookies_off-copy"><?php echo $text_cookies_off_copy;?></p>
    </div>
    <span class="h-hidden">
        <div class="b-login_popup js-login_popup">
            <div class="b-login_popup-flyout">

                <div class="b-login_block js-login_block">
                    <h3 class="b-login_account-title"><?php echo $text_login; ?></h3>

                    <div class="b-login_block-auth-social">
                        <span class="b-login_auth-social__item auth-social__item_vk"></span>
                        <span class="b-login_auth-social__item auth-social__item_fb"></span>
                        <span class="b-login_auth-social__item auth-social__item_gp"></span>
                    </div>

                    <div class="b-login_block-auth-form js-login_block-auth-form">
                        <p class="b-login_account-info"><?php echo $text_login_enter; ?></p>
                        <form action="/<?php echo $language_href; ?>index.php?route=account/login" class="b-login_account-form js-login_account-form" id="dwfrm_login" method="post" name="dwfrm_login" novalidate="novalidate">
                            <div class="js-error_form f-form_error_message"></div>
                            <fieldset class="b-login_account-form_fildset">
                                <div class="js-fields_for_iframe b-login_account-fields_for_iframe">
                                    <div class="f-field f-field-email f-type-username f-state-required" data-required-text="<?php echo $text_email_required; ?>" data-valid-text="">
                                        <label class="f-label" for="input-email"><span class="f-label-value"><?php echo $text_email;?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-email f-state-required" id="input-email" maxlength="50" name="email" placeholder="<?php echo $text_email; ?>" type="email">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block js-error_input-email"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="f-field f-field-password b-account_registration-password_field f-state-required" data-required-text="<?php echo $text_pass_required; ?>" data-valid-text="">
                                        <label class="f-label" for="input-password"><span class="f-label-value"><?php echo $text_pass; ?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-password f-state-required" id="input-password" maxlength="25" name="password" placeholder="<?php echo $text_pass; ?>" type="password">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block  js-error_input-password"></span>
                                            </span>
                                        </div>
                                        <span class="b-login_account-forgot_password js_show_block"
                                              data-show-block=".js-login_block-forgotten-pass"
                                              data-hide-block=".js-login_block-auth-form"><?php echo $text_forgotten_pass; ?></span>
                                    </div>
                                </div>
                                <div class="b-login_account-form_row">
                                    <button class="b-login_account-login_button js-login-submit" name="dwfrm_login_login" type="submit" value="<?php echo $text_enter_to_account; ?>"><?php echo $text_enter; ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="b-login_block-forgotten-pass js-login_block-forgotten-pass h-hidden">
                        <p class="b-login_account-info"><?php echo $text_password_reset; ?></p>
                        <form action="">
                            <div class="js-error_form f-form_error_message"></div>
                            <fieldset>
                                <div class="b-login_account-fields_for_iframe">
                                    <div class="f-field">
                                        <label class="f-label" for="input-email-forgotten"><span class="f-label-value"><?php echo $text_email; ?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-email f-state-required" id="input-email-forgotten" maxlength="50" name="email_forgotten" placeholder="<?php echo $text_email; ?>" type="email">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block js-error_input-email-forgotten"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-login_account-form_row">
                                    <button class="b-login_account-forgotten_pass_back js_show_block"
                                            data-show-block=".js-login_block-auth-form"
                                            data-hide-block=".js-login_block-forgotten-pass"
                                            onclick="return false"><?php echo $text_i_remember_password; ?></button>
                                    <button class="b-login_account-forgotten_pass_button js-forgotten-submit" name="dwfrm_forgotten_pass" type="submit" value=""><?php echo $text_reestablish; ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="b-login_block-registration-user">
                        <span class="js_show_block"
                              data-show-block=".b-registration_block"
                              data-hide-block=".b-login_block"><?php echo $text_register_new_buyer; ?></span>
                    </div>

                    <div class="b-login_block-registration-user">
                        <span><a href="/<?php echo $language_href; ?>index.php?route=account/register&opt"><?php echo $text_register_new_wholesale_buyer; ?></a></span>
                    </div>

                </div>

                <div class="b-registration_block js-registration_block h-hidden">
                    <h3 class="b-login_account-title"><?php echo $text_register; ?></h3>

                    <div class="b-registaration_block-registration">
                        <form action="/<?php echo $language_href; ?>index.php?route=account/register" method="POST">
                            <div class="js-error_form f-form_error_message"></div>
                            <fieldset>
                                <div class="b-login_account-fields_for_iframe">
                                    <div class="f-field">
                                        <label class="f-label" for="input-reg-email"><span class="f-label-value"><?php echo $text_email; ?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-email f-state-required" id="input-reg-email" maxlength="50" name="email" placeholder="<?php echo $text_email; ?>" type="email">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block js-error_input-reg-email"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="f-field f-field-password b-account_registration-password_field">
                                        <label class="f-label" for="input-reg-password"><span class="f-label-value"><?php echo $text_pass; ?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-password f-state-required" id="input-reg-password" maxlength="25" name="password" placeholder="<?php echo $text_pass; ?>" type="password">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block js-error_input-reg-password"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="f-field f-field-password b-account_registration-password_field">
                                        <label class="f-label" for="input-reg-password2"><span class="f-label-value"><?php echo $text_pass; ?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-password f-state-required" id="input-reg-password2" maxlength="25" name="confirm" placeholder="<?php echo $text_pass; ?>" type="password">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block js-error_input-reg-password2"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="f-field">
                                        <label class="f-label" for="input-reg-name"><span class="f-label-value"><?php echo $text_name; ?></span></label>
                                        <div class="f-field-wrapper">
                                            <input class="f-email" id="input-reg-name" maxlength="25" name="firstname" placeholder="<?php echo $text_name; ?>" type="text">
                                            <span class="f-error_message">
                                                <span class="f-error_message-block js-error_input-reg-name"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-login_account-form_row">
                                    <button class="b-login_account-registaration_button js-registaration-submit" name="dwfrm_registration" type="submit" value=""><?php echo $text_sign_up; ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="b-registaration_block-auth">
                        <span class="b-registaration_block-auth__title"><?php echo $text_enter; ?> : </span>
                        <span class="b-registaration_auth-social__item auth-social__item_vk"></span>
                        <span class="b-registaration_auth-social__item auth-social__item_fb"></span>
                        <span class="b-registaration_auth-social__item auth-social__item_gp"></span>
                        <span class="b-registaration_auth-social__item auth-social__item_login js_show_block"
                              data-show-block=".b-login_block"
                              data-hide-block=".b-registration_block"></span>
                    </div>
                </div>
            </div>
        </div>
    </span>

<?php if ( isset($_GET['route']) AND 
           ( $_GET['route'] == 'checkout/cart' OR 
             $_GET['route'] == 'checkout/checkout' 
           )
         ) { ?>

    <header class="l-header_checkout">
        <div class="b-primary_logo">
            <a class="b-primary_logo-link" href="/<?php echo $language_href; ?>">
                    lazycat.com.ua
                    <!--img alt="" src="catalog/view/theme/simplica/img/logo.png" title="http://lazycat.com.ua"-->
                    </a>
        </div>
        <ul class="l-header_service_menu-checkout">
            <li class="l-header_service_menu-list">
                <?php if($logged) { ?>
                <div class="b-login_header-link">
                    <a href="/<?php echo $language_href; ?>index.php?route=account/edit"><?php echo $text_cabinet; ?></a>
                </div>
                <?php }else{ ?>
                <div class="b-login_header-link js-login_popup_link">
                    <span class="h-hidden-mob"><?php echo $text_enter_in_account; ?></span>
                    <span class="h-show-mob"><?php echo $text_enter; ?></span>
                </div>
                <?php } ?>
                      
            </li>
            <li class="l-header_service_menu-list">
                <a class="b-back_to_shopping" href="/<?php echo $language_href.$_SERVER['REQUEST_URI']; ?>">
                    <span class="b-back_to_shopping-message">
                        <span class="h-hidden-mob"><?php echo $text_back_to_shopping; ?></span>
                        <span class="h-show-mob"><?php echo $text_go_back; ?></span>
                    </span>
                </a>
            </li>
        </ul>
    </header>

<?php } else { ?>

    <header class="l-header_main">
        <div class="l-header-search">
            <div class="b-header_search">
                <span class="b-header_search-title"><?php echo $text_search; ?></span>
                <div class="b-header_search-form_wrapper">
                    <form action="/<?php echo $language_href; ?>search-results" class="b-simple_search js-min_search js-toggler-slide h-minimized" id="simpleSearch" method="get" name="simpleSearch" novalidate="novalidate" role="search">
                        <fieldset class="b-simple_search-fieldset">
                            <legend class="b-simple_search-legend"><?php echo $text_search_legend; ?></legend>
                            <label class="b-simple_search-label" for="q"><?php echo $text_search; ?></label>
                            <input autocomplete="off" class="b-simple_search-field js-quicksearch js-validate_placeholder h-hidden" id="q" maxlength="100" name="q" placeholder="<?php echo $text_search; ?>" type="text" value="<?php echo $text_search; ?>">
                            <div class="b-simple_search-input js-simple_search_phrase" contenteditable="true" data-text="<?php echo $text_search; ?>"></div>
                            <span class="b-simple_search-suggested js-simple_search_suggest_phrase"></span>
                            <span class="b-simple_search-close_button js-search_clear h-minimized"></span>
                            <button class="b-simple_search-submit-button js-simple_search_submit_button" type="submit" value="Смотреть"><?php echo $text_search_submit_button; ?></button>
                            <div class="b-simple_search-gender_buttons js-simple_search_cat_btn_block">
                                <?php $count = 1; ?>
                                <?php foreach ($categories as $category) { ?>
                                    <button name="search_category" class="b-simple_search-gender_buttons--submit js-simple_search_category_button <?php if($count == 1){ echo 'active';$count = $category['href'];}?>" type="button" value="<?php echo $language_href.$category['href']; ?>"><?php echo $category['name']; ?></button>
                                <?php } ?>
                                <button name="search_category" class="b-simple_search-gender_buttons--submit js-simple_search_category_button" type="button" value="sale"><?php echo $text_sale; ?></button>
                                <button name="search_category" class="b-simple_search-gender_buttons--submit js-simple_search_category_button" type="button" value="brands"><?php echo $text_brands; ?></button>
                            </div>
                            <input class="js-simple_search_category_id" name="cgid" type="hidden" value="<?php echo $count; ?>">
                        </fieldset>
                    </form>
                    <ul class="js-quicksearch_result_container b-search_result h-minimized"></ul>
                    <script id="js-simple_search_item" type="text/template">
                    <li class="b-search_result-item">
                    <a class="b-search_result-product" href="{{url}}">
                    <img class="b-search_result-image" src="{{image}}"/>
                    <span class="b-search_result-title">{{name}}</span>
                    </a>
                    <span class="b-search_result-manufacturer">{{brand}}</span>
                    <span class="b-search_result-price">{{price}}</span>
                    </li>
                    </script>
                </div>
            </div>
        </div>
        <div class="l-header-minicart">
            <!-- Report any requested source code -->
            <!-- Report the active source code -->
            <div class="b-minicart-container js-mini_cart js-toggler-slide h-minimized" id="mini-cart">
                <div class="b-mini_cart">
                    <div id="cart">

                    <?php echo $cart; ?>

                    </div>
                </div>
                <button class="b-header_close_button"></button>
            </div>
        </div>

        <div class="h-hidden" data-is-user-authenticated="false" data-is-user-registered="false" data-is-user-subscribed="false" id="js-app_dynamic_data">
            &nbsp;
        </div>

        <div class="b-wishlist_flyout js-wishlist_flyout_container">
            <div class="b-wishlist_dropdown js-toggler-slide h-minimized">
                <div class="b-wishlist_flyout-block js-wishlist_dropdown-flyout">
                    <button class="b-header_close_button"></button>
                </div>
            </div>
        </div>

        <div class="b-header_main-top">
            <div class="b-header_main-wrapper">
                <div class="js-first-visit-banner b-first_visit_banner js-toggler-slide" style="display: none;">
                    <div class="js-policy_banner b-cookies_informer">
                        <div class="b-cookies_informer-info">
                            <div class="b-content_asset b-content_asset--homepage-cookie-policy content-asset">
                                <!-- dwMarker="content" dwContentID="80ed7d4ac2f997a3f5c4635524" -->
                                <div class="cookie-policy">
                                    <div class="cookie-policy-inner">
                                        <div class="cookie-policy-message">
                                            <div class="b-cookies_informer-title">
                                                Cookies
                                            </div>
                                            <div class="b-cookies_informer-info">
                                                <?php echo $text_cookie_error;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End content-asset homepage-cookie-policy -->
                        </div><span class="b-cookies_informer-close_button js-cookies_informer-close_button">&nbsp;</span>
                    </div>
                    <div class="b-language_informer">
                        <div class="b-language_informer-current">
                            <!-- Вы в Украина -->
                        </div>
                        <div class="b-language_informer-change">
                            Верный язык?&nbsp; Верная страна?&nbsp;
                            <div class="b-language_informer-choise">
                                <span class="js-toggler js-language_informer-link-keep b-language_informer-link" data-slide=".js-first-visit-banner">Оставить</span> | <span class="js-load_modal b-language_informer-link">Изменить</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="b-header_main-content">
                    <div class="b-vertical_menu-button js-vertical_menu-button">
                        menu
                    </div>
                    <div class="b-primary_logo">
                        <a class="b-primary_logo-link" href="/<?php echo $language_href; ?>">
                        lazycat.com.ua
                        <!--img alt="" src="catalog/view/theme/simplica/img/logo.png" title="http://lazycat.com.ua"-->
                        </a>
                        <style>
                            .b-primary_logo{
                                padding-top: 20px;
                                display: block;
                            }
                            .b-primary_logo a{
                                margin-top: 10px;
                                font-size: 30px;
                            }
                    
                        </style>
                    </div>
                    <div class="l-main_navigation">
                        <nav class="b-main_navigation" id="navigation" role="navigation">
                            <ul class="b-menu_category">
                            <?php foreach ($categories as $category) { ?>
                                <li class="b-menu_category-item">
                                    <a href="<?php echo $language_href.$category['href']; ?>"><span class="b-menu_category-link"
                                            <?php if(in_array($category['category_id'], $category_path)) echo ' style="text-decoration:underline;"'; ?>
                                            ><?php echo $category['name']; ?></span></a>
                                    <div class="b-menu_category-level_2">
                                        <div class="b-menu_category-level_2-wrapper">
                                            <ul class="b-menu_category-level_2-list">
                                            <?php if (isset($category['children'])) { ?>
                                            <?php foreach ($category['children'] as $child2) { ?>
                                                <li class="b-menu_category-level_2-item" data-index="1">
                                                    <a href="<?php echo $language_href.$child2['href']; ?>"><span class="b-menu_category-level_2-link"
                                                            <?php if(in_array($child2['category_id'], $category_path)) echo ' style="text-decoration:underline;"'; ?>
                                                            ><?php echo $child2['name']; ?></span></a>
                                                    <div class="b-menu_category-level_3">
                                                        <ul class="b-menu_category-level_3-list">
                                                        <?php if (isset($child2['children'])) { ?>
                                                        <?php foreach ($child2['children'] as $child3) { ?>
                                                            <li class="b-menu_category-level_3-item">
                                                                <a class="b-menu_category-level_3-link" href="<?php echo $language_href.$child3['href']; ?>"
                                                                <?php if(in_array($child3['category_id'], $category_path)) echo ' style="text-decoration:underline;"'; ?>><?php echo $child3['name']; ?></h3></a>
                                                            </li>
                                                        <?php }} ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php }} ?>
                                            </ul>
                                        </div>
                                        <div class="b-close_arrow js-close_arrow"></div>
                                    </div>
                                </li>
                            <?php } ?>
                            
                                <?php if(isset($text_sale)){ ?>
                                <li class="b-menu_category-item">
                                    <?php if(strpos($_SERVER['REQUEST_URI'], 'sale') !== false){?>
                                        <?php
                                            $sale_url = str_replace('sale-','',$_SERVER['REQUEST_URI']);
                                            if($_SERVER['REQUEST_URI'] == 'sale'){
                                                $sale_url = '/'.$language_href;
                                            }
                                        ?>
                                        <a href="<?php echo $sale_url; ?>"><span class="b-menu_category-link"><?php echo $text_sale; ?></span></a>
                                    <?php }else{ ?>
                                        <?php $sale_url = 'sale-'.str_replace($language_href,'',substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI']))); ?>
                                        <?php $sale_url = trim($sale_url, '-'); ?>
                                        
                                        <?php //Если УРЛ содержит уровни
                                            if(strpos($sale_url, '/') !== false){
                                                $tmp = explode('/', $sale_url);
                                                $sale_url = $tmp[0];
                                            }
                                        ?>
                                        
                                        <a href="/<?php echo $language_href.$sale_url; ?>"><span class="b-menu_category-link"><?php echo $text_sale; ?></span></a>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                                <li class="b-menu_category-item">
                                    <a href="/<?php echo $language_href; ?>brands"><span class="b-menu_category-link"><?php echo $text_brands; ?></span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <ul class="l-header_service_menu">
                        <!--li class="l-header_service_menu-item l-header_service_menu-item-search"><span class="b-header_search_icon js-toggler js-search-icon" data-close-element=".js-search_clear" data-move-body="true" data-slide=".js-min_search, .js-search_clear" data-toggle-class="h-minimized" data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-minimized"></span></li-->
                        <li class="l-header_service_menu-item l-header_service_menu-item-login">
                            <?php if($logged) { ?>
                            <a href="/index.php?route=account/edit">
                                <span class="b-login_dropdown-title b-login--logged"></span>
                            </a>
                            <?php }else{ ?>
                            <span class="b-login_dropdown-title js-login_popup_link"></span>
                            <?php } ?>                            
                        </li>
                        <li class="l-header_service_menu-item l-header_service_menu-item-wishlist"><span class="b-wishlist_flyout-title js-toggler b-wishlist_empty js-wishlist_nonauth" data-close-element=".b-header_close_button" data-move-body="true" data-slide=".b-wishlist_dropdown" data-toggle-class="h-minimized" data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-toggled"></span></li>
                        <li class="l-header_service_menu-item l-header_service_menu-item-minicart">
                            <div class="b-minicart">
                                <!-- Report any requested source code -->
                                <!-- Report the active source code -->
                                <div class="b-mini_cart-title js-mini_cart-title js-toggler" data-auto-close-timer="5000" data-close-element=".b-header_close_button" data-move-body="true" data-slide=".js-mini_cart" data-toggle-class="h-minimized" data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-toggled">
                                    

                                    
                                    <span class="b-mini_cart-text b-mini_cart-empty">
                                        <span class="b-minicart-quantity_label"><?php echo $text_shopping_cart;?></span>
                                        <span class="b-minicart-quantity_value js-minicart-quantity_value <?php if ($cart_products_total == 0) { echo 'h-hidden'; } ?>"><?php echo $cart_products_total; ?></span>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfloat"></div>
        </div>
    </header>

    <div class="mob-main_navigation">
        <div class="mob-header-menu-nav js-mob-main_navigation">
            <ul class="mob-menu_category-level_1_list">
                <?php foreach ($categories as $category) { ?>
                <li class="mob-menu_category-level_1_item">
                    <?php if ( !isset($category['children']) || count($category['children']) == 0 ) { ?>
                    <a class="mob-menu_category-level_1_link" href="<?php echo $language_href.$category['href']; ?>"><?php echo $category['name']; ?></a>
                    <?php } else { ?>
                    <span class="mob-menu_category-level_1_parent_text js-mob-category-list-toggle"><?php echo $category['name']; ?></span>
                    <ul class="mob-menu_category-level_2_list" style="display: none">
                        <?php foreach ($category['children'] as $child2) { ?>
                        <li class="mob-menu_category-level_2_item">
                            <?php if ( !isset($child2['children']) || count($child2['children']) == 0 ) { ?>
                            <a class="mob-menu_category-level_2_link" href="<?php echo $language_href.$child2['href']; ?>"><?php echo $child2['name']; ?></a>
                            <?php } else { ?>
                            <span class="mob-menu_category-level_2_parent_text js-mob-category-list-toggle"><?php echo $child2['name']; ?></span>
                            <ul class="mob-menu_category-level_3_list" style="display: none">
                                <?php foreach ($child2['children'] as $child3) { ?>
                                <li class="mob-menu_category-level_3_item">
                                    <a class="mob-menu_category-level_3_link" href="<?php echo $language_href.$child3['href']; ?>"><?php echo $child3['name']; ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php } ?>
                <?php if(isset($text_sale)){ ?>
                <li class="mob-menu_category-level_1_item">
                    <?php if(strpos($_SERVER['REQUEST_URI'], 'sale') !== false){?>
                        <?php
                            $sale_url = str_replace('sale-','',$_SERVER['REQUEST_URI']);
                            if($_SERVER['REQUEST_URI'] == 'sale'){
                                $sale_url = '/'.$language_href;
                            }
                        ?>
                        <a href="<?php echo $sale_url; ?>"><?php echo $text_sale; ?></a>
                    <?php }else{ ?>
                        <?php $sale_url = 'sale-'.str_replace($language_href,'',substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI']))); ?>
                        <?php $sale_url = trim($sale_url, '-'); ?>
                        
                        <?php //Если УРЛ содержит уровни
                            if(strpos($sale_url, '/') !== false){
                                $tmp = explode('/', $sale_url);
                                $sale_url = $tmp[0];
                            }
                        ?>
                        
                        <a href="/<?php echo $language_href.$sale_url; ?>"><?php echo $text_sale; ?></a>
                    <?php } ?>
                    
                </li>
                <?php } ?>
                <li class="mob-menu_category-level_1_item">
                    <a href="/brands"><?php echo $text_brands; ?></a>
                </li>
            </ul>
            <ul class="mob-service_menu">
                <li class="mob-service_menu-item">
                    <a href="/<?php echo $language_href;?>index.php?route=account/edit"><?php echo $text_cart; ?></a>
                </li>
                <li class="mob-service_menu-item">
                    <a href="/<?php echo $language_href;?>index.php?route=account/edit"><?php echo $text_wishlist; ?></a>
                </li>
                <li class="mob-service_menu-item">
                    <a href="/<?php echo $language_href;?>index.php?route=account/edit"><?php echo $text_service_center; ?></a>
                </li>
            </ul>
        </div>
    </div>

<?php } ?>



<script>
// popup для окна авторизации. START
$(document).ready(function() {
    $('.js-login_popup_link').on('click', function(){
        var c = $('.js-login_popup');

        $.fancybox.open({
            content: c,
            type: 'html',
            padding: 0,
            margin: 0,
            autoSize: false,
            width: 300,
            height: 440,
            minHeight: 440,
            wrapCSS: 'b-login-popup',
            tpl: {
                closeBtn : '<span class="fancybox-close"></span>'
            }
        });

        $('.js-login_block').removeClass('h-hidden');
        $('.js-registration_block').addClass('h-hidden');
        $('.js-login_block-auth-form').removeClass('h-hidden');
        $('.js-login_block-forgotten-pass').addClass('h-hidden');
    });
    $('.js_show_block').on('click', function(){
        $($(this).data('show-block')).removeClass('h-hidden');
        $($(this).data('hide-block')).addClass('h-hidden');
    });
});
// popup для окна авторизации. END


// Валидация формы авторизации. START
$('input#input-email, input#input-password, input#input-email-forgotten, input#input-reg-email, input#input-reg-password, input#input-reg-password2, input#input-reg-name').on('blur', function(){
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
        case 'input-reg-name':
            var rv_name = /^[a-zA-Zа-яА-Я]+$/;
            if(val.length > 2 && val != '' && rv_name.test(val)) {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_name; ?>');
            }
        break;
        case 'input-email':
        case 'input-reg-email':
        case 'input-email-forgotten':
            var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if(val.length > 2 && val != '' && rv_email.test(val)) {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_email; ?>');
            }
        break;
        case 'input-password':
        case 'input-reg-password':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_password; ?>');
            }
        break;
        case 'input-reg-password2':
            if(val.length > 0 && val != '') {
                setErrorMessage(id, '');
            } else {
                setErrorMessage(id, '<?php echo $text_error_password_confirm; ?>');
            }
        break;
    }
});
// Валидация формы авторизации. END


// Проверяем все поля перед отправкиой формы. START
$('.js-login-submit').on('click', function(e){
    $('input#input-email, input#input-password').blur();
    if ($('.js-login_block-auth-form .f-state-valid').length == 2) {
        return true;  // отправка формы
    } else {
        //scrollToElement( $('.f-state-error').first() );
        alert('<?php echo $text_error_form_valid; ?>');
        return false;
    }
});
$('.js-forgotten-submit').on('click', function(e){
    $('input#input-email-forgotten').blur();
    if ($('.js-login_block-forgotten-pass .f-state-valid').length == 1) {
        return true;  // отправка формы
    } else {
        //scrollToElement( $('.f-state-error').first() );
        alert('<?php echo $text_error_form_valid; ?>');
        return false;
    }
});
$('.js-registaration-submit').on('click', function(e){
    $('input#input-reg-email, input#input-reg-password, input#input-reg-password2, input#input-reg-name').blur();
    if ($('.js-registration_block .f-state-valid').length == 4) {
        return true;  // отправка формы
    } else {
        //scrollToElement( $('.f-state-error').first() );
        alert('<?php echo $text_error_form_valid; ?>');
        return false;
    }
});
// Проверяем все поля перед отправкиой формы. END

</script>

