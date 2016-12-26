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

// select
jQuery(function($){
	$("select").selectBoxIt();
});
// end select

//placeholder ie
$(document).ready(function() {
	/* Placeholder for IE */
	if($.support.msie) { // Óñëîâèå äëÿ âûçîâà òîëüêî â IE
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
				.slideUp('fast');
				
			$(this).css('border-bottom','none');
			$('.filter-box-wrap2').css("height", "28px");
			
		} else {
			
			$('.filter-link').each(function(index){
				$(this).css('border-bottom','none');
			});
			
			content.slideUp()
				.eq($(this).index(".filter-link"))
				.slideDown('fast');
				$(this).css('border-bottom','2px solid #F8AA1C');
				$('.filter-box-wrap2').css("height", "400px");
				if ( $(this).index(".filter-link") - filter_i > 3 ) {
					$('.drop-filter-box').removeClass('drop-filter-box__left');
					$('.drop-filter-box').removeClass('drop-filter-box__right');
					$('.drop-filter-box').addClass('drop-filter-box__right');
				} else {
					$('.drop-filter-box').removeClass('drop-filter-box__left');
					$('.drop-filter-box').removeClass('drop-filter-box__right');
					$('.drop-filter-box').addClass('drop-filter-box__left');
				};
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


//Filter send
	$(document).on('click', '.yellow-button', function(){
		form.submit();    
	});

// filter-drop-box
$(document).ready(function() {
	$('.filter-button').on('click', function(){
		$('.filter-line').slideToggle('medium');
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

//Click on NO-Link target
$(document).on('click', '.links', function(event){
	var link = $(this).data('link');
//debugger;
	if (event.target.tagName != 'A' && $(event.target).hasClass('as_link') == false) {
		location.href = link;
	}
	
});
$(document).on('click', '.links_blank', function(event){
	var link = $(this).data('link');
//debugger;	
	if (event.target.tagName != 'A' && $(event.target).hasClass('as_link') == false) {
		window.open(link, '_blank');    
	}
	
});
//end Click on NO-Link target

//Click .filter-box
$(document).ready(function() {
	$('.filter-box').on('click', function(){
		if ($('#filter_information').is(':hidden')) {
			$('#filter_information').css("display", "block");
		} else {
			$('#filter_information').css("display", "none");
		};
		//$('#filter_information').delay(3000).fadeOut(); 
	});
});
//end Click .filter-box

//scroll .filter-box-wrap
var filter_i=0;
$(document).ready(function() {
	var arr = [];
	var sum_w = 0;
	$('.filter-box').each(function(i,elem) {
		var w = $(this).width()+22;
		arr.push(w);
		sum_w += w;
	});
	if ($(window).width() > 1298) {
		$('.filter-box-wrap3').width(sum_w+11);
	}

	$('.filter-box-wrap-arrow-left').on('click', function(){
		if ($('.filter-box-wrap3').position().left < 0) {
			filter_i--;
			$('.filter-box-wrap3').css({'left':'+='+arr[filter_i]+'px'});
		}
	});
	$('.filter-box-wrap-arrow-right').on('click', function(){
		if ($('.filter-box-wrap3').position().left > -($('.filter-box-wrap3').width() - $('.filter-box-wrap2').width() - 10 )) {
			$('.filter-box-wrap3').css({'left':'-='+arr[filter_i]+'px'});
			filter_i++;
		}
	});

	window.onscroll = function() {
		if ($(window).width() > 1298) {
			$('#filter_information').css("display", "none");
			$('.drop-filter-box').css("display", "none");
			$('.filter-box-wrap2').css("height", "28px");
		}
	};

	$(document).mouseup(function (e){
		var div = $('#filter_information');
		if (!div.is(e.target)
		    && div.has(e.target).length === 0) {
			div.hide();
		}
		var div = $('.drop-filter-box');
		if (!div.is(e.target)
		    && div.has(e.target).length === 0) {
			div.hide();
			$('.filter-box-wrap2').css("height", "28px");
		}
	});

});
//end scroll .filter-box-wrap



// account
$(document).ready(function() {
	$('.dropdown').on('click', function(event){
		//$('.dropdown-menu').hide();
		$(this).siblings('.dropdown-menu').slideToggle();
	});
	$('.ic-info').hover(function(event){
		$(this).siblings('.pop-up-info').slideToggle();
	});
});
// end accound