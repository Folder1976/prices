// start js
$(document).ready(function() {
// debugger;

// popup
  $('.js-open-popup-link').magnificPopup({
    type:'inline'
  });

// tabs
  $( function() {
    $( ".js-block-product_tabs" ).tabs();
  } );

// owl-carousel fix (for jQuery3+)
$.fn.andSelf = function() {
  return this.addBack.apply(this, arguments);
}
// для удаления элемента (используется, например, при клике на "показать номер")
$('.js-remove-this').on('click', function() {
  $(this).remove();
});

// owl carousel
$('.js-owl-home-slider').owlCarousel({
  autoplay: true,
  //autoplayHoverPause: true,
  loop: true,
  margin: 10,
  autoHeight: true,
  nav: true,
  navText: ['<span class="ic-arrow-prev"></span>','<span class="ic-arrow-next"></span>'],
  items: 1
});
$('.js-product_owl-carousel').owlCarousel({
  loop: false,
  margin: 0,
  nav: true,
  navText: ['<span class="ic-arrow-prev2"></span>','<span class="ic-arrow-next2"></span>'],
  items: 5,
  responsive:{
    1200: {
      items: 5
    },
    700: {
      items: 4
    },
    400: {
      items: 3
    },
    0: {
      items: 2
    }
  }
});
$('.js-most-viewed-carousel').owlCarousel({
  loop: true,
  margin: 0,
  nav: true,
  navText: ['<span class="ic-arrow-prev"></span>','<span class="ic-arrow-next"></span>'],
  items: 5,
  responsive:{
    1200: {
      items: 5
    },
    700: {
      items: 4
    },
    400: {
      items: 3
    },
    0: {
      items: 2
    }
  }
});
$('.js-brand_owl-carousel').owlCarousel({
  loop: false,
  margin: 0,
  nav: true,
  navText: ['<span class="ic-arrow-prev2"></span>','<span class="ic-arrow-next2"></span>'],
  items: 5,
  responsive:{
    1200: {
      items: 5
    },
    700: {
      items: 4
    },
    400: {
      items: 3
    },
    0: {
      items: 2
    }
  }
});

// "Выпадалка". START
$('.js-custom-toggler').each(function() {
  var s = $(this).data("slide");
  var h = $(this).data("toggle-class");
  var t = $(this).data("toggle-elem-class");
  var close = $(this).data("close-element");
  var e = $(this);

  $(s).addClass('js-custom-toggler-slide');

  funcOpenCustomWindow = function (a,b,c,d) {
      $('.js-custom-toggler').each(function(){
          var close = $(this).data("close-element");
          $(close).click();
      });
      $(a).addClass(b);
      $(c).removeClass(d);
  }

  funcCloseCustomWindow = function (a,b,c,d) {
      $(a).removeClass(b);
      $(c).addClass(d);
  }

  $(close).on('click', function(){
      funcCloseCustomWindow(e,t,s,h);
  });

  $(this).on('click', function(){
      if ( $(this).hasClass(t) ) {
          funcCloseCustomWindow(e,t,s,h);
      } else {
          funcOpenCustomWindow(e,t,s,h);
      }
  });
});

$(document).mouseup(function (e){
    if ( $(e.target).closest('.js-custom-toggler-slide').length === 0 && $(e.target).closest('.js-custom-toggler').length === 0 ) {
        $('.js-custom-toggler').each(function(){
            var close = $(this).data("close-element");
            $(close).click();
        });
    }
});
// "Выпадалка". END

// Моб. меню START
function closeMobMenu() {
  $('.js-nav-level-1').removeClass('g-tablet-show');
  $('.js-mob-menu li').removeClass('b-nav-level-2__open');
  $('.js-mob-menu').removeClass('js-mob-menu_open');

  // $('.b-nav__mob-tabs-1').addClass('active');
  // $('.b-nav__mob-tabs-2').removeClass('active');
}
function openMobMenu() {
  $('.js-nav-level-1').addClass('g-tablet-show');
  $('.js-mob-menu').addClass('js-mob-menu_open');
  $('.js-nav__mob-tabs').find('span:first').click();
}
$('.js-mob-menu').on('click', function(e){
  if ( $(window).width() <= 900 ) {
    if ( $(e.target).closest('.js-nav-level-1').length > 0 ) {
      $(e.target).closest('li').toggleClass('b-nav-level-2__open');
    } else {
      if ( $('.js-mob-menu').hasClass('js-mob-menu_open') ) {
        closeMobMenu();
      } else {
        openMobMenu();
      }
    }
  }
});
$(window).resize(function(){
  if ( $(window).width() > 900 ) {
    $('.js-mob-menu').addClass('b-menu').removeClass('b-menu_mob');
  } else {
    $('.js-mob-menu').addClass('b-menu_mob').removeClass('b-menu');
  }
});
$(window).resize();
$(document).mouseup(function (e){
  if ( $(e.target).closest('.js-mob-menu').length === 0 ) {
    closeMobMenu();
  }
});

$('.js-nav__mob-tabs').on('click', 'span', function(){
  $('.js-nav__mob-tabs span').removeClass('active');
  $(this).addClass('active');

  $('.js-nav__mob-tabs span').each(function(){
    var t = $(this).data('tabs');
    $(t).removeClass('active');
  });

  var tab = $(this).data('tabs');
  $(tab).addClass('active');
});
// Моб. меню END

// g-span-select START
$('.js-span-select').on('click', function(e){
  if ( e.target.nodeName == 'SPAN' || e.target == this ) {
    $(this).closest('div').find('ul').toggleClass('g-span-select__hidden');
    return;
  };
  // if ( e.target.nodeName == 'LI' ) {
  //   var v = $(e.target).data('value');
  //   $(this).closest('div').find('input').val(v);
  //   $(this).find('span').html( $(e.target).html() );
  //   $(this).find('ul').toggleClass('g-span-select__hidden');
  //   $(this).find('li').removeClass('active');
  //   $(e.target).addClass('active');
  // }
});

$('.js-span-select-search').on('click', 'li', function(){
  $('.js-span-select-search .g-span-select__title').html( $(this).html() );
  $(this).parent().toggleClass('g-span-select__hidden');
});

$(document).mouseup(function (e){
    if ( $(e.target).closest('.js-span-select').length === 0 ) {
        $('.js-span-select ul').addClass('g-span-select__hidden');
    }
});
// g-span-select end






















// CATEGORY

// выпадалка для блоков фильтра (в category)
$('.js-filter-block-toggle').on('click', function() {
  $(this).parent().toggleClass('b-filter-block_open');
});

// показываем номер телефона (в category - визитка)
$('.js-business-card__show-number').on('click', function() {
  $(this).remove();
});

// меняет вид сетка/список START
$('.js-change_view').on('click', 'span', function (e) {
  var cv = '.js-change_view';
  var view_content = '.js-view-content';
  var view_content_css = 'b-products-container__content_';
  var view = $(this).data('view');

  $(cv + ' span').removeClass('active');
  $(this).addClass('active');

  $(cv + ' span').each(function(){
    var v = $(this).data('view');
    $(view_content).removeClass( view_content_css + v );
  });

  $(view_content).addClass( view_content_css + view );
});
// меняет вид сетка/список END

// адаптив для фильтров START
$(window).resize(function(){
  if ( $(window).width() > 1190 ) {
    $('.js-popup-filter').removeClass('mfp-hide');
  } else {
    $('.js-popup-filter').addClass('mfp-hide');
  }
});
// адаптив для фильтров END




















// PRODUCT

// показываем больше характеистик при клике на "Ещё"
$('.js-prod-info__content-more').on('click', function() {
  $(this).remove();
});

// tabs ("Характеристики", "Отзывы", "Фото, видео" и т.д.)
$( function() {
  $( ".js-prod_tabs" ).tabs();
});

// tabs ("Задать вопрос", "Оставить отзыв")
// $( function() {
//   $( ".js-add-message_tabs" ).tabs();
// });


// показать все ответы на вопрос
$('.js-show-all-answer').on('click', function() {
  $(this).closest('.b-question').children('.b-question__answer-block').removeClass('g-hidden');
  $(this).remove();
});


// звезды рейтинга (для товара, для отзывов) START
jQuery(".b-rating").hover(
function(){ /* при наведении мыши на блок с рейтингом, динамически добавляем блок с подсветкой выбранной оценки */
    jQuery(this).append("<span></span>");
},
function()
{ /* при уходе с рейтинга, удаляем блок с подсветкой */
    jQuery(this).find("span").remove();
});

var rating;

jQuery(".b-rating").mousemove (  /* устанавливаем ширину блока с подсветкой таким образом, чтобы была выделена оценка, находящаяся под курсором мыши */
function(e){
    if (!e) e = window.event;
    if (e.pageX){
           x = e.pageX;
            } else if (e.clientX){
            x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
        }
        var posLeft = 0;
        var obj = this;
        var count_r = $(this).data('count_r');  /* число возможных оценок */
        var width_star = $(this).data('width_star');  /* ширина одной оценки, в данном случае одной звезды */
       while (obj.offsetParent)
        {
            posLeft += obj.offsetLeft;
            obj = obj.offsetParent;
        }
        var offsetX = x-posLeft,
            modOffsetX = count_r*offsetX%this.offsetWidth;
            rating = parseInt(count_r*offsetX/this.offsetWidth);
        if(modOffsetX > 0) rating+=1;
        jQuery(this).find("span").eq(0).css("width",rating*width_star+"px");
});

jQuery(".b-rating").click ( /* по клику на блоке можно определить какую оценку поставил пользователь */
function()
{
    alert("Я ставлю "+rating);
    return false;
});
// звезды рейтинга (для товара, для отзывов) END



// слайдер для главного фото START
$('.js-prod_owl-carousel').owlCarousel({
  loop: false,
  margin: 10,
  nav: true,
  navText: ['<span class="ic-arrow-prev2"></span>','<span class="ic-arrow-next2"></span>'],
  items: 6,
  responsive:{
    1200: {
      items: 6
    },
    600: {
      items: 6
    },
    0: {
      items: 1
    }
  }
});
$('.js-prod_thumb-list .b-prod-img__item').clone().appendTo('.js-prod_popup-thumb-list');
$('.js-prod_thumb-list, .js-prod_popup-thumb-list').on('mouseover', '.b-prod-img__item img', function(){
  $('.js-main-image').attr('src', $(this).data('img'));
});
// слайдер для главного фото END



































// код ниже - для нагладности (на готовом сайте этот код надо удалить) START
// переключение между двумя разными видами блока "Набирающие популярность"
// $('.b-upcoming-prod__title').on('click', function(){
//   if ( $('.b-upcoming-prod').hasClass('b-upcoming-prod_type1') ) {
//     $('.b-upcoming-prod').addClass('b-upcoming-prod_type2').removeClass('b-upcoming-prod_type1');
//   } else {
//     $('.b-upcoming-prod').addClass('b-upcoming-prod_type1').removeClass('b-upcoming-prod_type2');
//   }
// });
// END




});
// end js
