$(document).ready(function() {

// Главное меню. START
$('.b-menu_category-item').on('mouseover', function(){
    $(this).children('div.b-menu_category-level_2').show();
});
$('.b-menu_category-item').on('mouseout', function(){
    $(this).children('div.b-menu_category-level_2').hide();
});
// Главное меню. END

// "Выпадалка" для фильтров и сортировки. START
$('.js-custom-toggler').each(function() {
    var s = $(this).data("slide");
    var h = $(this).data("toggle-class");
    var t = $(this).data("toggle-elem-class");
    var close = $(this).data("close-element");
    var e = $(this);

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
    if ( $(e.target).closest('.js-custom-toggler-slide').length === 0 && !$(e.target).hasClass('js-custom-toggler') ) {
        $('.js-custom-toggler').each(function(){
            var close = $(this).data("close-element");
            $(close).click();
        });
    }
});
// "Выпадалка" для фильтров и сортировки. END


// Каталог продукции. Показываем альтернативное изображение для продукции при наведении мышки. START
$('.js-product-hover_box').on('mouseover mouseout', function(){
    var n = $(this).find('img.js-producttile_image');
    var o = n.data("altimage");
    var s = n.attr("src");
    if (o && o.length && (s != o)) {
        var t = s;
        n.attr("src", o);
        n.data("altimage", t);
    }
});
// Каталог продукции. Показываем альтернативное изображение для продукции при наведении мышки. END

// Выпадалка. START
$('.js-toggler').each(function() {
    var s = $(this).data("slide");
    var h = $(this).data("toggle-class");
    var t = $(this).data("toggle-elem-class");
    var close = $(this).data("close-element");
    var e = $(this);

    funcOpenWindow = function (a,b,c,d) {
        $('.js-toggler').each(function(){
            var close = $(this).data("close-element");
            $(close).click();
        });
        $(a).addClass(b);
        $(c).removeClass(d);
    }

    funcCloseWindow = function (a,b,c,d) {
        $(a).removeClass(b);
        $(c).addClass(d);
    }

    $(close).on('click', function(){
        funcCloseWindow(e,t,s,h);
    });

    $(this).on('click', function(){
        if ( $(this).hasClass(t) ) {
            funcCloseWindow(e,t,s,h);
        } else {
            funcOpenWindow(e,t,s,h);
        }
    });
});

$(document).mouseup(function (e){
    if ( $(e.target).closest('.js-toggler-slide').length === 0 && !$(e.target).hasClass('js-toggler')) {
        $('.js-toggler').each(function(){
            var close = $(this).data("close-element");
            $(close).click();
        });
    }
});
// Выпадалка. END

// Табы в product.tpl. START
$('.b-product_tabs-link').on('click', function () {
    $(this).closest('ul').children('li, li a').removeClass('ui-tabs-active ui-state-active');
    $(this).addClass('ui-tabs-active ui-state-active');
    $(this).closest('li').addClass('ui-tabs-active ui-state-active');

    $('.js-product_tabs .b-product_tabs-content').hide();
    var e = $(this).attr("href");
    $(e).show();


    return false;
});
// Табы в product.tpl. END


// Отображение списка товарово (Список/Сетка). START
$('.b-change_view').on('click', '.b-change_view-type', function(){
    if ( !$(this).hasClass('b-change_view-type-active') ) {
        $('.b-change_view-type').removeClass('b-change_view-type-active');
        $(this).addClass('b-change_view-type-active');
        if ( $(this).hasClass('js-two-columns') ) {
            $('.js-search_result-content').removeClass("m-four-columns");
        } else {
            $('.js-search_result-content').addClass("m-four-columns");
        }
    }
});
// Отображение списка товарово (Список/Сетка). END


// Кнопка scroll_to_top. BEGIN
$(window).scroll(function() {
    if($(this).scrollTop() != 0) {
        $('.js-scroll_to_top').addClass('h-opaque');
    } else {
        $('.js-scroll_to_top').removeClass('h-opaque');
    }
});

$('.js-scroll_to_top').on('click', function() {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
});
// Кнопка scroll_to_top. END


// Моб меню. START
$('.js-vertical_menu-button').on('click', function () {
    $('.js-mob-main_navigation').toggle();
});
$('.js-mob-main_navigation').on('click', '.js-mob-category-list-toggle', function(){
    $(this).siblings('ul').toggle();
    $(this).toggleClass('active');
})
$(document).mouseup(function (e){
    if ( $(e.target).closest('.js-mob-main_navigation, .js-vertical_menu-button').length === 0 ) {
        $('.js-mob-main_navigation').hide();
    }
});
// Моб меню. END


});