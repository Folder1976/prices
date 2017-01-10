<?php
// поправить текст в переменных:
$text_password_reset = 'Напомнить пароль';

// новые текстовые переменные:
$text_through_social_networks = 'Через соц сети';



//echo "<pre>";  print_r(var_dump( $currencies )); echo "</pre>";

//echo "<pre>";  print_r(var_dump( $url_no_lang )); echo "</pre>"; //УРЛ без языка
//echo "<pre>";  print_r(var_dump( $language_href )); echo "</pre>"; //Префикс выбранного языка
//echo "<pre>";  print_r(var_dump( $language_code )); echo "</pre>"; //Код выбранного языка
//echo "<pre>";  print_r(var_dump( $_SESSION ["currency"] )); echo "</pre>"; // выбранная валюта
//echo "<pre>";  print_r(var_dump( $currencies )); echo "</pre>"; // Список валют
/*
$url_no_lang - тут УРЛ без языка
$languages - список языков
$countries - список стран
$currencies - Список валют
$currency - Базовы шаблон валюты
$language_href - Префикс выбранного языка
$language_code - Код выбранного языка
$currency_text, $country_language_text, $text_select_currency - Заголовки
$_SESSION ["currency"] - выбранная валюта
*/









if($_SERVER['REQUEST_URI'] == '/'){
    $curr_href = 'index.php?currency=';
}else{
    if(strpos($_SERVER['REQUEST_URI'],'?') !== false){
        $curr_href =  $_SERVER['REQUEST_URI'].'&currency=';
    }else{
        $curr_href =  $_SERVER['REQUEST_URI'].'?currency=';
    } 
}

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

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

<link href="catalog/view/theme/simplica/js/lib/jquery-ui/jquery-ui.css" rel="stylesheet">
<link href="catalog/view/theme/simplica/js/lib/jquery-ui/jquery-ui.theme.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="catalog/view/theme/simplica/stylesheet/owl.carousel.css" />

<link rel="stylesheet" type="text/css" href="catalog/view/theme/simplica/stylesheet/style.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/simplica/stylesheet/style.develop.css" />

<link rel="shortcut icon" href="catalog/view/theme/simplica/img/favicon.ico" type="image/x-icon">
<!-- 
<link rel="shortcut icon" href="catalog/view/theme/simplica/img/favicon.png" type="image/png">
<link rel="shortcut icon" href="catalog/view/theme/simplica/img/favicon.gif" type="image/gif">
-->

<!-- подключаем jQuery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
if (typeof jQuery == 'undefined') {
  document.write(unescape("%3Cscript src='js/lib/jquery-3.1.0.min.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>


<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<script src="/catalog/view/javascript/common.js" type="text/javascript"></script>

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

<body class="<?php echo $class; ?>">

<div class="b-popup b-account-popup js-popup-account mfp-hide">
  <div class="b-popup__title"><?php echo $text_login; ?></div>
  <div class="b-popup__content">
    <div class="b-auth-form">
      <form action="/<?php echo $language_href; ?>index.php?route=account/login" method="post">
        <div class="f-group">
          <div class="f-field-wrapper">
            <input type="text"
                   class="f-input"
                   name="login"
                   value=""
                   placeholder="Логин"
                   required="required"
                   pattern="^[a-zA-Zа-яА-Я0-9]{3,}$"
                   title="минимум 3 символа (a-z, A-Z, а-я, А-Я, 0-9)">
          </div>
        </div>
        <div class="f-group">
          <div class="f-field-wrapper">
            <input type="password"
                   class="f-input"
                   name="password"
                   value=""
                   placeholder="Пароль"
                   required="required">
          </div>
        </div>
        <div class="b-auth-social">
          <div class="b-auth-social__title"><?php echo $text_through_social_networks; ?></div>
          <div class="b-auth-social__content">
          <?php foreach ($adapters as $title => $adapter) { ?>
            <a href="<?php echo $adapter->getAuthUrl(); ?>"><span class="ic-<?php echo $title; ?>"></span></a>
          <?php } ?>
          </div>
        </div>
        <div class="f-group b-auth-form__button-wrap">
          <button class="f-button" type="submit"><?php echo $text_enter; ?></button>
        </div>
      </form>
    </div>
  </div>
  <div class="b-popup__footer">
    <span class="g-span-link_dotted"><a href="index.php?route=account/register"><?php echo $text_register; ?></a></span>
    <span class="g-span-link_dotted"><a href="index.php?route=account/forgotten"><?php echo $text_password_reset; ?></a></span>
  </div>
</div>


  <div class="page-wrapper">

    <header class="b-header">
      <div class="b-header__top-line"></div>

      <div class="b-header-top">
        <div class="g-container g-flex-container">

          <div class="b-header-account g-tablet-show js-open-popup-link" data-mfp-src=".js-popup-account">
            <span class="ic-account"></span>
            <span class="b-header-account__title">Профиль</span>
          </div>

          <a href="/" class="b-logo"><img src="catalog/view/theme/simplica/img/logo.png" alt="Prices.md"></a>

          <div class="b-header-top__setings g-tablet-hidden">
            <div class="b-header-top__setings-lang">
              <select name="lang" id="lang" class="b-select">
              <?php foreach ($languages as $lang) { ?>
                <option value="<?php echo $lang['code']; ?>" <?php if ($lang['code'] == $language_code) { echo 'selected'; } ?>><?php echo $lang['code']; ?></option>
              <?php } ?>
              </select>
            </div>
            <div class="b-header-top__setings-cur">
              <select name="cur" id="cur" class="b-select" onChange="window.location.replace($(this).val());">
              <?php foreach ($currencies as $index => $currency) { ?>
                <option value="<?php echo $curr_href.$index; ?>" <?php if ($currency['code'] == $_SESSION ["currency"]) { echo 'selected'; } ?>><?php echo $currency['symbol_left'].' '.$currency['symbol_right'].' '.$currency['title']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>

          <ul class="b-header-top__menu g-tablet-hidden">
            <?php foreach ($menu as $item) { ?>
            <li><a href="/<?php echo $item['keyword']; ?>"><?php echo $item['title']; ?></a></li>
            <?php } ?>
          </ul>

          <div class="b-header-cart g-tablet-show">
            <a href="<?php echo shopping_cart; ?>">
              <span class="b-header-cart__quantity">2</span>
              <span class="ic-cart"></span>
              <span class="b-header-cart__title">Корзина</span>
            </a>
          </div>

        </div>
      </div>

      <div class="b-header__news">
        <div class="g-container">
          <div class="b-header__news-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
        </div>
      </div>

      <div class="b-header__middle">
        <div class="b-location">
          <span class="ic-location"></span>
          <span class="b-location__city">Киев</span>
        </div>
        <div class="b-weather">
          <img src="catalog/view/theme/simplica/img/weather.png" alt="weather">
        </div>
      </div>

      <div class="b-header__bottom">
        <div class="g-container">
          <div class="g-col-left b-menu js-mob-menu">
            <div class="b-button-nav js-open-mob-menu-link" data-mfp-src=".js-popup-mob-menu">
              <div class="b-button-nav__wrap">
                <span class="ic-menu"></span>
                <span class="b-button-nav__title">Категирии</span>
                <span class="ic-arrow-down"></span>
              </div>
            </div>
            <nav class="b-nav-level-1 js-nav-level-1 js-popup-mob-menu">
              <div class="b-nav__mob-header">
                <div class="b-nav__mob-header-title">
                  <a href="/"><span class="ic-mob-menu-home"></span>Главная</a>
                </div>
                <div class="b-nav__mob-tabs js-nav__mob-tabs">
                  <span class="active" data-tabs=".b-nav__mob-tabs-1">Категории</span>
                  <span data-tabs=".b-nav__mob-tabs-2">Настройки</span>
                </div>
                <hr>
              </div>
              <div class="b-nav__mob-tabs-1">
                <ul>
                  <?php foreach ($categories as $category) { ?>
                  <li>
                    <?php if (isset($category['children'])) { ?>
                      <div class="b-nav__item"><?php echo $category['name']; ?></div>
                      <div class="b-nav-level-2">
                        <div class="b-nav-level-2__title"><?php echo $category['name']; ?></div>
                        <div class="b-nav-level-2__list">
                          <?php foreach (array_chunk($category['children'], 10) as $cat) { ?>
                          <ul>
                            <?php foreach ($cat as $child2) { ?>
                              <li><a href="<?php echo $child2['href']; ?>"><?php echo $child2['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                          <?php } ?>
                        </div>
                      </div>
                    <?php } else { ?>
                      <div class="b-nav__item b-nav__item_link">
                        <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                      </div>
                    <?php } ?>
                  </li>
                <?php } ?>
                </ul>
                <div class="b-nav__ul-title g-tablet-show">
                  <span>Другое</span>
                </div>
                <ul class="g-tablet-show">
                  <?php foreach ($menu as $item) { ?>
                  <li>
                    <div class="b-nav__item b-nav__item_link">
                      <a href="/<?php echo $item['keyword']; ?>"><?php echo $item['title']; ?></a>
                    </div>
                  </li>
                  <?php } ?>
                </ul>
              </div>
              <div class="b-nav__mob-tabs-2 b-nav__mob-setings">
                <div class="b-nav__mob-setings-item">
                  <div class="b-nav__mob-setings-item-title">Выбор языка</div>
                  <div class="f-group-wrap_3col">

                    <?php foreach ($languages as $lang) { ?>
                    <div class="f-group">
                      <div class="f-field-wrapper f-field-wrapper_radio">
                        <div class="f-field">
                          <input type="radio"
                                 name="lang"
                                 id="<?php echo $lang['code']; ?>"
                                 value="" 
                                 class="f-radio"
                                 <?php if ($lang['code'] == $language_code) { echo ' checked'; } ?>>
                          <div class="f-label">
                            <label for="<?php echo $lang['code']; ?>"><?php echo $lang['code']; ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>

                  </div>
                </div>
                <div class="b-nav__mob-setings-item">
                  <div class="b-nav__mob-setings-item-title">Выбор валюты</div>
                  <div class="f-group-wrap_3col">

                    <?php foreach ($currencies as $index => $currency) { ?>
                    <div class="f-group">
                      <div class="f-field-wrapper f-field-wrapper_radio">
                        <div class="f-field">
                          <input type="radio"
                                 name="cur"
                                 id="<?php echo $currency['code']; ?>"
                                 value="" 
                                 class="f-radio"
                                 <?php if ($currency['code'] == $_SESSION ["currency"]) { echo ' checked'; } ?>>
                          <div class="f-label">
                            <label for="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>

                  </div>
                </div>
              </div>
            </nav>
          </div>

          <div class="g-col-center">
            <div class="b-search">
              <form action="#" method="post">
                <div class="f-form-wrap">
                  <div class="g-span-select b-search__select js-span-select js-span-select-search">
                    <span class="g-span-select__title">Все</span>
                    <ul class="g-span-select__ul g-span-select__hidden js-popup-sort">

                      <li class="active" data-value="1">Все</li>
                      <?php foreach ($categories as $category) { ?>
                      <li data-value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></li>
                      <?php } ?>

                    </ul>
                  </div>
                  <input type="text" class="b-search__input" name="search_input" value="">
                  <button class="b-search__button" type="submit"><span class="ic-search"></span></button>
                </div>
              </form>
            </div>
          </div>

          <div class="g-col-right">
            <div class="b-header-box-cart-account">
              <div class="b-header-cart">
                <a href="<?php echo shopping_cart; ?>">
                  <span class="b-header-cart__quantity">2</span>
                  <span class="ic-cart"></span>
                  <span class="g-tablet-hidden b-header-cart__title">Корзина</span>
                </a>
              </div>
              <div class="b-header-account js-open-popup-link" data-mfp-src=".js-popup-account">
                <span class="ic-account"></span>
                <span class="g-tablet-hidden b-header-account__title">Профиль</span>
              </div>
            </div>
          </div>

          <div class="g-clear"></div>
        </div>
      </div>

      <div class="g-clear"></div>

    </header>

<script>
$('#lang').on('change, input[name=lang]', function() {
  window.location.replace("<?php if ($url_no_lang == '/') { echo $url_no_lang; } else { echo $url_no_lang.'/'; }?>" + $(this).val());
});
</script>





<?php
//header("Content-Type: text/html; charset=UTF-8");
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
?>