//$('.js-dropdown-menu').hide();
$(function(){
    //user dropdown
    $('.js-user-nav').click(function(){
        $('.js-sub-menu').delay(0).slideToggle(250);
        $('.js-sub-menu').mouseleave(function(e){
            e.preventDefault();
            $(this).delay(250).slideUp(200);
        });
    });
});
