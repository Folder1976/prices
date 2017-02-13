<?php
// текстовые переменные:
$text_order = 'Мои заказы';
$text_edit = 'Профиль';
$text_history = 'История просмотров';
$text_messages = 'Мои сообщения';
$text_reviews = 'Мои отзывы';
$text_questions = 'Мои вопросы';
$text_more = 'Еще...';
?>

<div class="b-acc-top">
  <a href="<?php echo $href_history; ?>" class="b-acc-top__item"><span class="ic-acc-history"></span> <?php echo $text_history; ?></a>
  <a href="<?php echo $href_order; ?>" class="b-acc-top__item"><span class="ic-acc-order"></span> <?php echo $text_order; ?></a>
  <a href="<?php echo $href_messages; ?>" class="b-acc-top__item active"><span class="ic-acc-message"></span> <?php echo $text_messages; ?></a>
  <a href="<?php echo $href_reviews; ?>" class="b-acc-top__item"><span class="ic-acc-reviews"></span> <?php echo $text_reviews; ?></a>
  <a href="<?php echo $href_questions; ?>" class="b-acc-top__item"><span class="ic-acc-questions"></span> <?php echo $text_questions; ?></a>
  <a href="<?php echo $href_edit; ?>" class="b-acc-top__item"><span class="ic-acc-profile"></span> <?php echo $text_edit; ?></a>
  <span class="b-acc-top__item js-custom-toggler js-acc-top__hidden-items-title"
        data-slide=".js-acc-top__hidden-items"
        data-toggle-class="g-minimized"
        data-toggle-elem-class="g-popup-open"
        data-close-element=".js-footer-popup-close"><?php echo $text_more; ?></span>
  <div class="b-acc-top__hidden-items g-minimized js-acc-top__hidden-items">
  </div>
</div>





<script>
// Топ-меню в "Личном кабинете" START
function hide_a() {
  var el = $('.b-acc-top > a:visible:last');

  // выносим ссылку в выпадающую менюшку
  var el_text = el.html();
  var el_href = el.attr('href');
  $('.js-acc-top__hidden-items').prepend(el.clone());

  // скрывает последнюю ссылку в топ-меню
  el.hide();
};

function show_a() {
  // показываем ссылки
  var el = $('.b-acc-top > a:hidden:first');
  el.show();

  // удаляем дубль-ссылку в выпадающей менюшке
  $('.js-acc-top__hidden-items a:first').remove();
}

function mobTabs() {
  // сумарная ширина всех ссылок топ-меню
  var width_a = 0;
  $('.b-acc-top > a:visible').each(function() {
    width_a += $(this).width();
    width_a += parseInt($(this).css('padding-left'));
    width_a += parseInt($(this).css('padding-right'));
  });
  // если уже есть скрытые ссылки, то к общей ширине нужно приплюсовать и пункт "Ещё..."
  if ( $('.js-acc-top__hidden-items a').length > 0 ) {
    width_a += $('.js-acc-top__hidden-items-title').width();
  }

  var width_line = $('.b-acc-top').width();  // ширина контейнера для топ-меню
  var width_hidden_a = $('.b-acc-top > a:hidden:first').width();  // ширина скрытой ссылки топ-меню

  // если нет места для всех ссылок - прячем последнюю сылку
  if ( width_a > width_line ) {
    hide_a();
  }
  // если есть место для скрытой ссылки - показываем первую скрытую ссылку
  if ( !!width_hidden_a && width_a+width_hidden_a < width_line  ) {
    show_a();
  }

  if ( $('.js-acc-top__hidden-items a').length > 0 ) {
    $('.js-acc-top__hidden-items-title').show();
  } else {
    $('.js-acc-top__hidden-items-title').hide();
  }
};

$(window).resize(function(){
  mobTabs();
});

setTimeout(function () {
  mobTabs();mobTabs();mobTabs();mobTabs();
}, 50);
// Топ-меню в "Личном кабинете" END
</script>
