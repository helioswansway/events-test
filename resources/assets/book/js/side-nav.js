$(function(){
    $('.js-side-nav-collapse').click(function(){
        $('body').css({'overflow' : 'hidden' })
        $('.js-side-nav-collapse').css({'display' : 'none' });
        $('.sideNav, .sideNave-overlay').addClass('side-nav-full');
        $('.sideNav, .sideNave-overlay').removeClass('side-nav-close');
        $('#mainContent').addClass('main-content-close');
        $('#mainContent').removeClass('main-content-full')
       // $('#mainContent').css({'margin-left': '300px', 'padding-left': '0px'});
        $('.content h1.display-4').removeAttr('style');
        $('header.header-nav .logo').removeAttr('style');
        $('.logo, .js-close').css({'display' : 'block' });

        $('.js-display-message').removeAttr('style');
        $(this).removeAttr('style');
        $(this).hide();
        $('.hide').hide();


    });


    $('#sideNav .js-close').click(function(){
        $('body').css({'overflow' : '' })
        $('.sideNav, .sideNave-overlay').addClass('side-nav-close');
        $('.sideNav, .sideNave-overlay').removeClass('side-nav-full');
        //$('.js-side-nav-collapse').css({'opacity' : '1', 'position' : 'fixed'});
        $('#mainContent').addClass('main-content-full');
        $('#mainContent').removeClass('main-content-close')
        //$('#mainContent').css({'margin-left' : '0px', 'padding-left' : '80px'});
        $('header.header-nav .logo').css('opacity', '1');
        $('.content h1.display-4').css('margin-left', '0px');
        $('.js-side-nav-collapse').fadeIn('slow').css({'left' : '16px' });
        $('.logo, .js-close').css({'display' : 'none' });
        $('.js-display-message').css({'left' : '0px' });
        $('.hide').hide();

    });



});
