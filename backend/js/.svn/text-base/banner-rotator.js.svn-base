jQuery(function(){
    var slides, autoSlide;
    jQuery('#banner-rotator .main-slide.current').css('opacity', '1.0');
    
    slides = jQuery('#banner-rotator .main-slide').length;
    
    if (slides < 2) {
        jQuery('#slider-control, .slider-arrow').hide();
    } 
    else {
        for (var i = 1; i <= slides; i++) {
            jQuery('#slider-control').append('<div id="marker' + i + '" class="slide-marker">&nbsp;</div>');
        }
        jQuery('#slider-control').css('left',(jQuery('#banner-rotator').width() - jQuery('#slider-control').width()) / 2 + 'px');
    }
    
    jQuery('#slider-control .slide-marker:first').addClass('current');
    
    jQuery('#banner-rotator').delay(1000).animate({
            opacity: 1.00
    }, 1000, 
    function() {
        if (slides > 1) {
            autoSlide = setInterval(function() {
                rotateSlide('slider-right');
                if (jQuery('#slider-control .slide-marker.current').attr('id') === 'marker1') {
                    clearInterval(autoSlide);
                };
            }, 5000);
        }
    });
    
    jQuery('#banner-rotator .slider-arrow').click(function() {
        clearInterval(autoSlide);
        rotateSlide(jQuery(this).attr('id'));
    });
    
    function rotateSlide(callOrigin) {
        jQuery('#banner-rotator .slider-arrow').unbind('click');
        var currentSlide = jQuery('.main-slide').index(jQuery('.main-slide.current')) + 1;
        var nextSlide;
    
        if (callOrigin === 'slider-left') {
            if (currentSlide === 1) {
                nextSlide = slides;
            } 
            else {
                nextSlide = currentSlide-1;
            }
        } 
        else if (callOrigin === 'slider-right') {
            if (currentSlide === slides) {
                nextSlide = 1;
            }   
            else {
                nextSlide = currentSlide+1;
            }
        } 
        else {
            clearInterval(autoSlide);
            nextSlide = callOrigin.replace('marker','');
        };
        
        jQuery('#slider-control .slide-marker').removeClass('current');
        jQuery('#slider-control #marker' + nextSlide).addClass('current');
        jQuery('#banner-rotator #slide'+currentSlide).css('display','none').removeClass('current');
        jQuery('#banner-rotator #slide'+currentSlide).animate({
            opacity: 0.30
        }, 10, function() {
            jQuery('#banner-rotator #slide'+nextSlide).css('display','block').addClass('current').animate({
                opacity: 1.00
            }, 100, function() {
                jQuery('#banner-rotator .slider-arrow').click(function() {
                    clearInterval(autoSlide);
                    rotateSlide(jQuery(this).attr('id'));
                });
            });
        });
    };
    
    jQuery('#slider-control .slide-marker').click(function() {
        rotateSlide(jQuery(this).attr('id'));
    });
});
