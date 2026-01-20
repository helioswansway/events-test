$(function(){

    //located on the events/configure
    //Current dates Link
    //It will show a pop up with Events Time Slots
    $('.js-save-time').click(function(){
        var dateId =  $(this).attr('date-item'); //Gets the Event date ID
        var dealershipId =  $('#dealership_id').val(); //Gets the Event date ID

        //Adds a Class ".show" to the overlay container
        $('.overlay').addClass('show');
        //Adds a ".overflow" class to the body (it will stop the page to scroll)
        $('body').addClass('overflow');
        //Sets the close button to show
        $('.js-close').show();
        //If  .js-close is clicked it will remove .show and .overflow class from their locations
        //It will hide all time slots if exist any
        $('.js-close').click(function(){
            $('.overlay').removeClass('show');
            $('body').removeClass('overflow');
            $('.js-display-time-slots').html("");
        });

        //if .js-save-time is clicked it will process to safe the time slots
        var event_date_id = dateId; //event_date_id
        var openTime = $('.js-open-time').val(); //The open Time
        var interval = $('.js-interval').val(); // The Interval slot required between a booking
        var closeTime = $('.js-close-time').val(); // The closing time

        //Starts validation
        //Removes .border-danger and .js-error on mousedown
        //This is to make sure any warnings disapear if any times are entered
        $('body').mousedown(function() {
            $('.js-open-time').removeClass('border-danger').next('.js-error').html('');
            $('.js-interval').removeClass('border-danger').next('.js-error').html('');
            $('.js-close-time').removeClass('border-danger').next('.js-error').html('');

        });

        //It will stop times being saved if fields are empty
        if(openTime == "" || interval == "" || closeTime == ""){
            if(openTime == ""){
                $('.js-open-time').addClass('border-danger').next('.js-error').html('Open Time needs to be added');
            }else{
                $('.js-open-time').removeClass('border-danger').next('.js-error').html('')
            }
            if(interval == ""){
                $('.js-interval').addClass('border-danger').next('.js-error').html('Interval Time needs to be added');
            }else{
                $('.js-interval').removeClass('border-danger').next('.js-error').html('')
            }
            if(closeTime == ""){
                $('.js-close-time').addClass('border-danger').next('.js-error').html('Close Time needs to be added');
            }else{
                $('.js-close-time').removeClass('border-danger').next('.js-error').html('')
            }
        //Ends Validation

        }else{
            //It will remove .border-dager class if times are field in
            $('.js-open-time').removeClass('border-danger');
            $('.js-interval').removeClass('border-danger');
            $('.js-close-time').removeClass('border-danger');
            $('.js-error').html(''); //It will set .js-error container to empty

            $('.pop-up-wrapper-spin').removeClass('hide');
            $('body').addClass('overflow');
            //Starts the process of saving time slots to the event date selects
            $.ajax({
                url: '/dashboard/events/add-time',
                method:'get',
                data: {
                    openTime: openTime,
                    interval: interval,
                    closeTime: closeTime,
                    event_date_id: event_date_id,
                    dealership_id: dealershipId,
                },
                success:function(response){
                    //Refreshes the page when process done
                    //When viewing the date event again the times slots will display on the container
                    $('.display-times').html(response);
                    location.reload();
                }
            });
        }




    })

    $('.js-open-time').click(function(){

        $('.js-open-time-wrapper').fadeIn('slow', function(){
            $('.js-open-time-wrapper span').click(function(){
                var s = $(this).attr('value');
                $('.js-open-time').val(s);
                $('.js-open-time-wrapper').fadeOut('slow');

            })
        });

    });

    $('.js-close-time').click(function(){

        $('.js-close-time-wrapper').fadeIn('slow', function(){
            $('.js-close-time-wrapper span').click(function(){
                var s = $(this).attr('value');
                $('.js-close-time').val(s);
                $('.js-close-time-wrapper').fadeOut('slow');

            })
        });

    });

    $('.js-interval').click(function(){
        $('.js-interval-wrapper').fadeIn('slow', function(){
            $('.js-interval-wrapper span').click(function(){
                var s = $(this).attr('value');
                $('.js-interval').val(s);
                $('.js-interval-wrapper').fadeOut('slow');

            })
        });
    });

    $('body').mousedown(function() {
        $('.js-open-time-wrapper, .js-close-time-wrapper, .js-interval-wrapper').fadeOut('slow');
    });


});
