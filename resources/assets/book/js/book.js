$(function(){
    $('.js-models a img').click(function(){
       // alert(0);
        $(this).toggleClass('active');
    });

    $('.js-car-interest a').click(function(){
        $('.js-car-interest a').removeClass('active');
        $(this).toggleClass('active');
    });

    $('.js-execs .js-exec').click(function(){
        $('.js-execs .js-exec').removeClass('active');
         $(this).toggleClass('active');
     });


     $('.js-time div').click(function(){
         if($(this).hasClass('selected-time')){

         }else{
            $('.js-time div').removeClass('active');
            $(this).toggleClass('active');
         }
     });


     $('.js-date').click(function(){
        $('.js-date').removeClass('active');
         $(this).toggleClass('active');
     });

     $('.v-reg input').focus(function(){
        $('.v-reg span').addClass('slide-up');
        $('.js-get-vehicle').removeClass('hide');
     });

    $('.v-make input').focus(function(){
       $('.v-make span').addClass('slide-up');
    });

    $('.v-mileage input').focus(function(){
        $('.v-mileage span').addClass('slide-up');
     });

    $('.v-make input').blur(function(){
        if ($(this).val() == '') { // check if value changed
            $('.v-make span').removeClass('slide-up');
        }
     });

     $('.v-mileage input').blur(function(){
        if ($(this).val() == '') { // check if value changed
            $('.v-mileage span').removeClass('slide-up');
        }
     });

     $('.v-reg input').blur(function(){
        if ($(this).val() == '') { // check if value changed
            $('.v-reg span').removeClass('slide-up');
        }

        if ($(this).val() != '') {
            $('.js-part-exchange').removeClass('active');
        }

     });

     $('.js-part-exchange').click(function(){
        $('.v-reg span').removeClass('slide-up');
        $('.v-reg input').val('');
        $('.show-vehicle-details').empty();
        $(this).addClass('active');
     });

});

