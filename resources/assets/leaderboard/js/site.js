$(function(){


    setTimeout(function() {

        $('.js-display-message').fadeOut(1000);
        $('.js-display-message').addClass('hide');
    }, 6000);

    $('.js-display-message, .js-close').click(function(){
        $(this).fadeOut(100);
    });


        // Stick save bottom when reach location
    // Browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 0,
    // Browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    // Duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    // Grab the "back to top" link
    $back_to_top = $('.js-btn-holder');

    /**/
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $('.js-btn-holder').addClass('js-btn-stick') : $('.js-btn-holder').removeClass('js-btn-stick cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) {
            $('.js-btn-holder').addClass('cd-fade-out');
        }
    });



});


