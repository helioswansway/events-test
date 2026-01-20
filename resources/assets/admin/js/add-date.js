$(function(){
    /**Event links located on the side */
    $('.js-add-date').click(function(){

        var dealership_id   =  $(this).attr('item'); //Gets the dealership_id
        var event_id        = $('#event_id').val(); //Gets the event_id


        location.href = '/dashboard/events/configure/'+event_id+'/'+dealership_id+'/dates';

    });


    //Adds a plus date after the last one
    $('.js-plus-date').click(function(){

       // var dealership_id =  $(this).attr('item'); //Gets the dealership_id
        var dealership_id   =  $('#dealership_id').val(); //Gets the dealership_id
        var event_id        = $('#event_id').val(); //Gets the event_id
        //var date_id         = $('#date_id').val(); //Gets the date_id
        //alert(dealership_id + " " + event_id + " " + date_id);
        $.ajax({
            url: '/dashboard/events/plus-date',
            method:'get',
            data: {
                dealership_id: dealership_id,
                event_id: event_id,
            },
                success:function(response){
                   //console.log(response);
                   location.href = '/dashboard/events/configure/'+event_id+'/'+dealership_id+'/dates';
                }
        });


    });

    //Adds a minus date after the Fist one
    $('.js-minus-date').click(function(){

        // var dealership_id =  $(this).attr('item'); //Gets the dealership_id
         var dealership_id   =  $('#dealership_id').val(); //Gets the dealership_id
         var event_id        = $('#event_id').val(); //Gets the event_id
        // var date_id        = $('#date_id').val(); //Gets the date_id


         $.ajax({
             url: '/dashboard/events/minus-date',
             method:'get',
             data: {
                 dealership_id: dealership_id,
                 event_id: event_id,
             },
                 success:function(response){
                    // console.log(response);
                    location.href = '/dashboard/events/configure/'+event_id+'/'+dealership_id+'/dates';
                 }
         });


     });


    //Saves dates
    $('.js-save-date').click(function(){
        var from            = $('#from').val(); //Gets the date from the #from field
        var to              = $('#to').val(); //Gets the date from the #to field
        var dealership_id   =  $('#dealership_id').val(); //Gets the dealership_id
        var event_id        = $('#event_id').val(); //Gets the event_id

        //Removes .border-danger and .js-error on body mousedown
        $('body').mousedown(function() {
            $('.js-from-date').removeClass('border-danger').next('.js-error').html('');
            $('.js-to-date').removeClass('border-danger').next('.js-error').html('');
        });

        if(from == "" || to == ""){
                if(from == ""){
                    $('.js-from-date').addClass('border-danger').next('.js-error').html('From date need to be added');
                }else{
                    $('.js-from-date').removeClass('border-danger').next('.js-error').html('')
                }
                if(to == ""){
                    $('.js-to-date').addClass('border-danger').next('.js-error').html('To date need to be added');
                }else{
                    $('.js-to-date').removeClass('border-danger').next('.js-error').html('')
                }

        }else{
                $('.js-from-date').removeClass('border-danger');
                $('.js-to-date').removeClass('border-danger');
                $('.js-error').html('');

                $.ajax({
                    url: '/dashboard/events/add-date',
                    method:'get',
                    data: {
                        from: from,
                        to: to,
                        dealership_id: dealership_id,
                        event_id: event_id,
                    },
                        success:function(response){
                            location.href = '/dashboard/events/configure/'+event_id+'/'+dealership_id+'/dates';
                        }
                });
        }

    });


});
