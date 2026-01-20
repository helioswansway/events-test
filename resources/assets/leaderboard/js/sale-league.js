$(function(){


    $('.js-view-sale-types').click(function(){

        var leaderboard_id = $(this).attr('item-id');
        var competition_id = $(this).attr('competition-id');

        $.ajax({
            url: '/leaderboard/sales-type?leaderboard_id='   + leaderboard_id +'&competition_id=' + competition_id,

                success:function(response){
                    console.log(response)

                    $('.pop-up-wrapper').fadeIn(100).html(response);
                    //Closes Book Appointment Wrapper
                    $('.pop-up-close').click(function(){
                        $('.pop-up-wrapper').hide();
                        $('.pop-up-wrapper').html("");
                    });


                }
        });

        //$('.pop-up-wrapper').fadeIn(800).html(response);
    })


});
