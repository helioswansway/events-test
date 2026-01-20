$(function(){

    //Confirm Appointment
        $('.js-create-sale').click(function(){

            var book_id             =   $(this).attr('book-id');
            var exec_id             =   $(this).attr('exec-id');
            var dealership_id       =   $(this).attr('dealership-id');
            var appointment_id      =   $(this).attr('appointment-id');

            //alert(part_exchange_no + " - "+ part_exchange_yes)

            $.ajax({
                url: '/exec/prospects/create-sale?book_id=' + book_id
                                +'&exec_id='   + exec_id
                                +'&dealership_id='   + dealership_id
                                +'&appointment_id='   + appointment_id,

                    success:function(response){
                        console.log(response)

                        $('.pop-up-wrapper').fadeIn(800).html(response);

                        //Closes Book Appointment Wrapper
                        $('.pop-up-close').click(function(){
                            $('.pop-up-wrapper').fadeOut(1000);
                            $('.pop-up-wrapper').html("");
                        });

                        $('.js-part-exchange_yes').click(function(){
                            $('.js-span').removeClass('hide');
                        });

                        $('.js-part-exchange_no').click(function(){
                            $('.js-span').addClass('hide');
                            $('.js-registration').val('');
                        });


                        store_sale();

                    }
            });

        });
    //END

    //Confirm Appointment
        $('.js-view-sale').click(function(){

            var sale_id             =   $(this).attr('sale-id');


            //alert(part_exchange_no + " - "+ part_exchange_yes)

            $.ajax({
                url: '/exec/prospects/show-sale?sale_id=' + sale_id,

                    success:function(response){
                        console.log(response)

                        $('.pop-up-wrapper').fadeIn(800).html(response);

                        //Closes Book Appointment Wrapper
                        $('.pop-up-close').click(function(){
                            $('.pop-up-wrapper').fadeOut(1000);
                            $('.pop-up-wrapper').html("");
                        });

                        $('.js-part-exchange_yes').click(function(){
                            $('.js-span').removeClass('hide');
                        });

                        $('.js-part-exchange_no').click(function(){
                            $('.js-span').addClass('hide');
                            $('.js-registration').val('');
                        });


                        update_sale();

                    }
            });

        });
    //END

    //Stores an Appointment Function
        function store_sale(){
            $('.js-submit-sale').click(function(){

                //Values to save to the appointments table
                var dealership_id       =   $('.js-dealership-id').attr('dealership-id');
                var appointment_id      =   $('.js-appointment-id').attr('appointment-id');
                var book_id             =   $('.js-book-id').attr('book-id');
                var exec_id             =   $('.js-exec-id').attr('exec-id');
                var event_id            =   $('.js-event-id').attr('event-id');
                var order_number        =   $('#order_number').val();
                var from_appointment    =   $('#from_appointment').val();
                var sale_type           =   $('#sale_type').val();

                if($('#sold_vehicle').is(":checked")){ var sold_vehicle = 1}else{ var sold_vehicle = 0}
                if($('#finance').is(":checked")){ var finance = 1}else{ var finance = 0}
                if($('#paint_protection').is(":checked")){ var paint_protection = 1}else{ var paint_protection = 0}
                if($('#smart').is(":checked")){ var smart = 1}else{ var smart = 0}
                if($('#gap').is(":checked")){ var gap = 1}else{ var gap = 0}
                if($('#warranty').is(":checked")){ var warranty = 1}else{ var warranty = 0}

                var part_exchange       =   $("input[name='part_exchange']:checked").val();
                var registration        =   $('#registration').val();

                //This is to make sure any warnings disapear if any times are entered
                $('body').mousedown(function() {
                    $('.js-order-number').removeClass('border-danger').next('.js-error').html('');
                    $('.js-from-appointment').removeClass('border-danger').next('.js-error').html('');
                    $('.js-sale-type').removeClass('border-danger').next('.js-error').html('');
                    $('.js-registration').removeClass('border-danger').next('.js-error').html('');
                    $('.js-submit-sale').removeClass('disabled');
                    $('.js-exchange-error').removeClass('border-danger').html('');
                });


                if($('.js-registration').val() == ""){
                    $('.js-registration').addClass('border-danger').next('.js-error').html('Please enter a registration');
                }

                var part_exchange_val       =   $("input[name='part_exchange']:checked")

                //It will stop times being saved if fields are empty
                if(order_number == "" || from_appointment == "" || sale_type == "" || part_exchange_val.length == 0){
                    $('.js-submit-sale').addClass('disabled');

                    if(part_exchange_val.length == 0){
                        $('.js-exchange-error').html('Part exchange needs to be selected');

                    }else{
                        $('.js-exchange-error').html('');
                    }

                    if(order_number == ""){
                        $('.js-order-number').addClass('border-danger').next('.js-error').html('Order Number needs to be selected');

                    }else{
                        $('.js-order-number').removeClass('border-danger').next('.js-error').html('')
                    }

                    if(from_appointment == ""){
                        $('.js-from-appointment').addClass('border-danger').next('.js-error').html('From Appointment needs to be selected');
                    }else{
                        $('.js-from-appointment').removeClass('border-danger').next('.js-error').html('')
                    }
                    if(sale_type == ""){
                        $('.js-sale-type').addClass('border-danger').next('.js-error').html('Sale Type needs to be selected');
                    }else{
                        $('.js-sale-type').removeClass('border-danger').next('.js-error').html('')
                    }
                //Ends Validation

                }else{

                    /*
                    alert( book_id
                            + " - " + dealership_id
                            + " - " + exec_id
                            + " - " + event_id
                            + " - " + order_number
                            + " - " + from_appointment
                            + " - " + appointment_id
                            + " - "+  sale_type
                            + " - "+  sold_vehicle

                            + " - " + finance
                            + " - " + paint_protection
                            + " - " + smart
                            + " - "+  gap
                            + " - "+  warranty
                            + " - "+  registration
                            + " - "+  part_exchange
                        );
                    */



                    fetch('/exec/sales/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            dealership_id: dealership_id,
                            appointment_id: appointment_id,
                            event_id: event_id,
                            book_id: book_id,
                            exec_id: exec_id,
                            order_number: order_number,
                            from_appointment: from_appointment,
                            sale_type: sale_type,
                            sold_vehicle: sold_vehicle,
                            finance: finance,
                            paint_protection: paint_protection,
                            smart: smart,
                            gap: gap,
                            warranty: warranty,
                            registration: registration,
                            part_exchange: part_exchange
                        }),
                    })
                    .then((response) => response.json())
                    .then((response) => {

                            //console.log(response);
                            $('.pop-up-wrapper').fadeOut(1500);
                            $('.js-message').fadeIn(1500);

                            /**/
                            setTimeout(function(){
                                return location.reload();
                            }, 1000);


                    })
                    .catch(error => console.log('Error:' + error))

                }


            });
        }
    //END

    //Updates Sale Function
        function update_sale(){
            $('.js-save-sale').click(function(){

                var sale_id             =   $(this).attr('sale-id');

                //Values to save to the appointments table
                var dealership_id       =   $('.js-dealership-id').attr('dealership-id');
                var appointment_id      =   $(this).attr('appointment-id');
                var book_id             =   $('.js-book-id').attr('book-id');
                var exec_id             =   $('.js-exec-id').attr('exec-id');
                var event_id            =   $(this).attr('event-id');
                var order_number        =   $('#order_number').val();
                var from_appointment    =   $('#from_appointment').val();
                var sale_type           =   $('#sale_type').val();

                if($('#sold_vehicle').is(":checked")){ var sold_vehicle = 1}else{ var sold_vehicle = 0}
                if($('#finance').is(":checked")){ var finance = 1}else{ var finance = 0}
                if($('#paint_protection').is(":checked")){ var paint_protection = 1}else{ var paint_protection = 0}
                if($('#smart').is(":checked")){ var smart = 1}else{ var smart = 0}
                if($('#gap').is(":checked")){ var gap = 1}else{ var gap = 0}
                if($('#warranty').is(":checked")){ var warranty = 1}else{ var warranty = 0}

                var part_exchange       =   $("input[name='part_exchange']:checked").val();
                var registration        =   $('#registration').val();

                //This is to make sure any warnings disapear if any times are entered
                $('body').mousedown(function() {
                    $('.js-order-number').removeClass('border-danger').next('.js-error').html('');
                    $('.js-from-appointment').removeClass('border-danger').next('.js-error').html('');
                    $('.js-sale-type').removeClass('border-danger').next('.js-error').html('');
                    $('.js-registration').removeClass('border-danger').next('.js-error').html('');
                    $('.js-submit-sale').removeClass('disabled');
                    $('.js-exchange-error').removeClass('border-danger').html('');
                });


                if($('.js-registration').val() == ""){
                    $('.js-registration').addClass('border-danger').next('.js-error').html('Please enter a registration');
                }

                var part_exchange_val       =   $("input[name='part_exchange']:checked")

                //It will stop times being saved if fields are empty
                if(order_number == "" || from_appointment == "" || sale_type == "" || part_exchange_val.length == 0){
                    $('.js-submit-sale').addClass('disabled');

                    if(part_exchange_val.length == 0){
                        $('.js-exchange-error').html('Part exchange needs to be selected');

                    }else{
                        $('.js-exchange-error').html('');
                    }

                    if(order_number == ""){
                        $('.js-order-number').addClass('border-danger').next('.js-error').html('Order Number needs to be selected');

                    }else{
                        $('.js-order-number').removeClass('border-danger').next('.js-error').html('')
                    }

                    if(from_appointment == ""){
                        $('.js-from-appointment').addClass('border-danger').next('.js-error').html('From Appointment needs to be selected');
                    }else{
                        $('.js-from-appointment').removeClass('border-danger').next('.js-error').html('')
                    }
                    if(sale_type == ""){
                        $('.js-sale-type').addClass('border-danger').next('.js-error').html('Sale Type needs to be selected');
                    }else{
                        $('.js-sale-type').removeClass('border-danger').next('.js-error').html('')
                    }
                //Ends Validation

                }else{

                    /*
                    alert( book_id
                            + " - " + dealership_id
                            + " - " + exec_id
                            + " - " + event_id
                            + " - " + order_number
                            + " - " + from_appointment
                            + " - " + appointment_id
                            + " - "+  sale_type
                            + " - "+  sold_vehicle

                            + " - " + finance
                            + " - " + paint_protection
                            + " - " + smart
                            + " - "+  gap
                            + " - "+  warranty
                            + " - "+  registration
                            + " - "+  part_exchange
                        );
                    */



                    fetch('/exec/sales/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            sale_id: sale_id,
                            dealership_id: dealership_id,
                            appointment_id: appointment_id,
                            event_id: event_id,
                            book_id: book_id,
                            exec_id: exec_id,
                            order_number: order_number,
                            from_appointment: from_appointment,
                            sale_type: sale_type,
                            sold_vehicle: sold_vehicle,
                            finance: finance,
                            paint_protection: paint_protection,
                            smart: smart,
                            gap: gap,
                            warranty: warranty,
                            registration: registration,
                            part_exchange: part_exchange
                        }),
                    })
                    .then((response) => response.json())
                    .then((response) => {

                            //console.log(response);
                            $('.pop-up-wrapper').fadeOut(1500);
                            $('.js-message').fadeIn(1500);

                            /**/
                            setTimeout(function(){
                                return location.reload();
                            }, 1000);


                    })
                    .catch(error => console.log('Error:' + error))

                }


            });
        }
    //END


    //Edit Prospect Date Time
        $('.js-edit-sale-time').on('click', function(){


            var appointment_id      =   $(this).attr('appointment-id');
            var date                =   $(this).attr('date');

            $.ajax({
                url: '/exec/prospects/show-date-time?appointment_id=' +  appointment_id
                                                +'&date='+date,

                success:function(response){
                    console.log(response)
                    $('.pop-up-wrapper').fadeIn(800).html(response);
                    //Closes Book Appointment Wrapper
                    $('.pop-up-close').click(function(){
                        $('.pop-up-wrapper').fadeOut(1000);
                        $('.pop-up-wrapper').html("");
                    });

                    fetch_dates()

                    click_time()

                    update_date_time()
                }

            });

        });
    //END

    //Appointment Date field
    function fetch_dates(){
        $('.js-appointment-date').click(function(e){
            //e.preventDefault();

            //It will display the below with the available dates when .js-appointment-date is clicked
            $('.js-appointment-dates-wraper').fadeIn('slow', function(){
                //it will add the span value to the field when clicked
                $('.js-appointment-dates-wraper span').click(function(e){
                    e.preventDefault();

                    $('.js-appointment-time').val(''); // it removes value if any
                    var date_selected = $(this).attr('date'); //the current span date value
                    $('.js-appointment-date').val(date_selected); //Appends the selected date to the fields
                    $('.js-appointment-dates-wraper').fadeOut('slow'); //Fades Out the dates container

                    var date = $(this).attr("date");
                    var date_id = $(this).attr("date-id");
                    var event_id = $(this).attr("event-id");

                    $('#date').attr('date', date );
                    $('#date').attr('date-id', date_id );
                    $('#date').attr('event-id', event_id );

                })
            });

            // Gets Current Event ID
            var eventId = $('#event_id').attr("event-id");
            //Fetch dates through ajax call and appends to "".js-appointment-dates-wraper"
            fetch_date(eventId);

        });
    }

    //Gets the date based on the event_id
    function fetch_date(event_id){

        $.ajax({
            url: '/exec/appointments/get-dates?event_id='+event_id,
                success:function(response){
                    $('.js-appointment-dates-wraper').html(response);

                }
            });
    }

    //When user clicks on .js-appointment-time field
    function click_time(){
        //On click Displays time slots on wrapper
        $('.js-appointment-time').click(function(){

            $(this).keydown(function() {
                //code to not allow any changes to be made to input field
                return false;
            });

            var date_id = $('#date').attr("date-id"); //Gets the selected date_id
            fetch_time_slots(date_id)

            //############################################
            //  Updates appointment
            //update_appointment()
            //End
            //############################################
        });

    }

    //Gets time slots based on the date_id
    /**/
    function fetch_time_slots(date_id){
        $.ajax({
            url: '/exec/appointments/get-time-slots?date_id='+date_id,
                success:function(response){
                    // alert(0);
                    $('.js-appointment-time-wraper').html(response);
                    //It will display the below with the available times when .js-appointment-time is clicked
                    $('.js-appointment-time-wraper').fadeIn('slow', function(){

                        //it will add the span value to the field when clicked
                        $('.js-appointment-time-wraper span').click(function(){
                            //the current span time value
                            var time_selected = $(this).attr('value');

                            $('#event_time').attr('time-id', $(this).attr('slot-id'));
                            $('#time').attr('time-id', $(this).attr('slot-id'));

                            $('.js-appointment-time').val(time_selected);
                            $('.js-appointment-time-wraper').fadeOut('slow');
                        })
                    });


                }
        });
    }

    //Updates Date Time Function
    function update_date_time(){

        $('.js-update-date-time').click(function(){

            //Values to save to the appointments table
            var time_id             =   $('.js-appointment-time').attr('time-id');
            var date                =   $('.js-appointment-date').attr('date');
            var appointment_id      =   $(this).attr('appointment-id');

            fetch('/exec/prospects/update-date-time', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    date: date,
                    time_id: time_id,
                    appointment_id: appointment_id
                }),
            })
            .then((response) => response.json())
            .then((response) => {

                    //console.log(response);
                    $('.pop-up-wrapper').fadeOut(1500);
                    $('.js-message').fadeIn(1500);

                    /**/
                    setTimeout(function(){
                        return location.reload();
                    }, 500);



            })
            .catch(error => console.log('Error:' + error))

        });
    }

});

