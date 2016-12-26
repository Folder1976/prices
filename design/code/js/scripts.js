// head-menu
$(document).ready(function() {
	$('.menu-button').on('click', function(){
		$('.tablet-menu').slideToggle();
	});
	$('.close-tablet-menu').on('click', function(){
		$('.tablet-menu').slideToggle();
	});
});
// end head-menu

// checkbox  and radio
jQuery(function($){
	$('input[type=radio], input[type=checkbox]').iCheck();
});
// end checkbox and radio

//  select
jQuery(function($){
	$("select").selectBoxIt();
});
// end select

//placeholder ie
$(document).ready(function() {
	/* Placeholder for IE */
	if($.support.msie) { // Условие для вызова только в IE
		$("form").find("input[type='text']").each(function() {
			var tp = $(this).attr("placeholder");
			$(this).attr('value',tp).css('color','#A9A9A9');
		}).focusin(function() {
			var val = $(this).attr('placeholder');
			if($(this).val() == val) {
				$(this).attr('value','').css('color','#747b80');
			}
		}).focusout(function() {
			var val = $(this).attr('placeholder');
			if($(this).val() == "") {
				$(this).attr('value', val).css('color','#A9A9A9');
			}
		});
		/* Protected send form */
		$("form").submit(function() {
			$(this).find("input[type='text']").each(function() {
				var val = $(this).attr('placeholder');
				if($(this).val() == val) {
					$(this).attr('value','');
				}
			})
		});
	}
});
//end placeholder ie

// main menu
jQuery(function($){
	var titles = $(".filter-link");
	var content = $(".drop-filter-box");

	titles.on("click touchstart", function(e) {
		if ($(this).next(".drop-filter-box")
				.is(":visible")) {
			$(this).next(".drop-filter-box")
				.slideUp('fast')
		} else {
			content.slideUp()
				.eq($(this).index(".filter-link"))
				.slideDown('fast')
		}
	});
});
// end main menu

//tab
jQuery(function($){
	var tabContainers = $('div.tab-cont > div');
	tabContainers.hide().filter(':first').show();
	$('div.tab-link a').click(function () {
		tabContainers.hide();
		tabContainers.filter(this.hash).show()
		$('div.tab-link a').removeClass('active');
		$(this).addClass('active');
		return false;
	}).filter(':first').click();
});

jQuery(function($){
	var tabContainers = $('div.tab-cont2 > div');
	tabContainers.hide().filter(':first').show();
	$('div.tab-link2 a').click(function () {
		tabContainers.hide();
		tabContainers.filter(this.hash).show()
		$('div.tab-link2 a').removeClass('active');
		$(this).addClass('active');
		return false;
	}).filter(':first').click();
});
//end tab

// tablet-menu
$(document).ready(function() {
	$('.tab-cont2 .left-side ul li a').on('click', function(){
		$('.tab-cont2 .left-side ul li a').removeClass('active');
		$(this).toggleClass('active');
	});
	$('.tab-cont2 .left-side ul li a').on('click', function(){
		$('.drop-menu-column').removeClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-1').on('click', function(){
		$('.drop-menu-column.item-1').addClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-2').on('click', function(){
		$('.drop-menu-column.item-2').addClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-3').on('click', function(){
		$('.drop-menu-column.item-3').addClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-4').on('click', function(){
		$('.drop-menu-column.item-4').addClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-5').on('click', function(){
		$('.drop-menu-column.item-5').addClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-6').on('click', function(){
		$('.drop-menu-column.item-6').addClass('active');
	});
	$('.tab-cont2 .left-side ul li a.item-7').on('click', function(){
		$('.drop-menu-column.item-7').addClass('active');
	});
});
// end tablet-menu

// filter-drop-box
$(document).ready(function() {
	$('.filter-button').on('click', function(){
		$('.filter-drop').slideToggle('medium');
	});
	$('.filter-drop .yellow-button').on('click', function(){
		$('.filter-drop').slideToggle('medium');
	});
});
// end filter-drop-box

// scroll
jQuery(function($){
	$('.scrollblock').jScrollPane({
		showArrows: true,
		autoReinitialise: true
	});
});
// end scroll

// popular
jQuery(function($){
	$('.sort-mobile-box a.item-1').on('click', function(){
		$(this).addClass('active');
		$('.sort-mobile-box a.item-2').removeClass('active');
		$('.product').removeClass('long');
	});
	$('.sort-mobile-box a.item-2').on('click', function(){
		$(this).addClass('active');
		$('.sort-mobile-box a.item-1').removeClass('active');
		$('.product').addClass('long');
	});
});
// end popular