$(function(){


    setTimeout(function() {
        $('.js-display-message').fadeOut(1000);
        $('.js-display-message').addClass('hide');
    }, 6000);

    $('.js-display-message, .js-close').click(function(){
        $(this).fadeOut(100);
    });

});


