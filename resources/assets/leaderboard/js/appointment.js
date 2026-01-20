$(function(){
    //$("input[type='text'], input[type='email']").attr("autocomplete", "off");



    //Hides Wrapper
    $('.pop-up-wrapper').hide();

    $('#vehicle_reg').attr('disabled', true);
    $('#post_code').attr('disabled', true);
    // /$('#email').attr('disabled', true);
    $('#home_phone').attr('disabled', true);
    $('#mobile').attr('disabled', true);


    $('body').mousedown(function() {
        $('.js-appointment-time-wraper').fadeOut();
        $('.js-appointment-dates-wraper').fadeOut();
        $('.js-appointment-customer-wraper').fadeOut();
    });



    //Gets the event
    $.ajax({
        url: '/exec/appointments/event',
            success:function(response){
                $('.js-appointment-event').html(response);

        }
    });


    //Appointment Time field


    //#############################################
    //#############################################
    //Gets customer information
    //#############################################
    //#############################################
        $(document).on('keyup', '.js-appointment-customer', function(e){
            e.preventDefault();
            //It will initially empty the fields
            $('#vehicle_reg').val('');
            $('#post_code').val('');
            $('#email').val('');
            $('#home_phone').val('');
            $('#mobile').val('');

            //it displays the container once User starts to type
            $('.js-appointment-customer-wraper').fadeIn('slow', function(){

                $('.js-appointment-customer-wraper span').click(function(e){
                    e.preventDefault();
                    var id              = $(this).attr('cust-id');
                    var vehicle_reg     = $(this).attr('vehicle-reg');
                    var post_code       = $(this).attr('post-code');
                    var home_phone      = $(this).attr('home-phone');
                    var mobile          = $(this).attr('mobile');
                    var email           = $(this).attr('email');
                    var name            = $(this).attr('name');

                    $('#book_id').attr('book-id', id );
                    $('#book_id').val(name);
                    $('#vehicle_reg').val(vehicle_reg);
                    $('#post_code').val(post_code);
                    $('#email').val(email);
                    $('#home_phone').val(home_phone);
                    $('#mobile').val(mobile);

                    $('.js-appointment-customer-wraper').fadeOut('slow');

                })
            });

            //The value the user is searching for
            var term = $(this).val().toLowerCase();
            var eventId = $('#event_id').attr('event-id');

            fetch_customer_data(term, eventId);

        });


        //Returns customers based on term search and Event Id
        function fetch_customer_data(term, eventId){
            $.ajax({
                url: '/exec/appointments/customer-search?term='+ term +'&event_id='+eventId,
                    success:function(response){
                        //console.log(response)
                        $('.js-appointment-customer-wraper').html(response);
                    }
            });
        }

    //#############################################
    //ENDS CUSTOMER INFORMATION
    //#############################################


//#############################################
//#############################################
//Gets Appointments Date
//#############################################
//#############################################

    //Making a Booking
        $('.js-book-appointment').on('click', function(event){

            var date                = $('#date').val(); //Gets Event Date
            var time                = $(this).attr('time'); //Gets The Time
            var time_id             = $(this).attr('time-id'); //Gets Time ID
            var exec_id             = $(this).attr('exec-id'); //Gets Time ID

            $.ajax({
                url: '/exec/appointments/create-appointment?exec_id='+exec_id,

                success:function(response){
                    //console.log(response)
                    $('.pop-up-wrapper').fadeIn(1000);
                    $('.pop-up-wrapper').html(response);

                    $('.js-appointment-date').val(date);
                    $('.js-appointment-time').val(time);
                    $('.js-appointment-time').attr('time-id', time_id );


                    //Closes Book Appointment Wrapper
                    $('.js-refresh').click(function(){
                        setTimeout(function(){
                            return location.reload();
                        }, 500);
                    })

                    //Closes Book Appointment Wrapper
                    $('.pop-up-close').click(function(){
                        $('.pop-up-wrapper').fadeOut(1000);
                        $('.pop-up-wrapper').html("");
                    });

                    //############################################
                    // Submits the form (Stores/Creates appointment)
                        store_appointment()
                    //End
                    //############################################

                    //############################################
                    // Selects vehicles
                    selectVehicle()
                    //End
                    //############################################

                }
            });
        });
    //END


    //Exec Book Appointment
        $('.js-exec-book-appointment').on('click', function(event){

            var book_id     = $(this).attr('book-id'); //Gets current book_id

            $.ajax({
                url: '/exec/prospects/create-appointment?book_id='    + book_id,

                success:function(response){
                    console.log(response)
                    $('.pop-up-wrapper').fadeIn(1000);
                    $('.pop-up-wrapper').html(response);


                    //Closes Book Appointment Wrapper
                    $('.js-refresh').click(function(){
                        setTimeout(function(){
                            return location.reload();
                        }, 500);
                    })

                    fetch_dates()

                    //Closes Book Appointment Wrapper
                    $('.pop-up-close').click(function(){
                        $('.pop-up-wrapper').fadeOut(1000);
                        $('.pop-up-wrapper').html("");
                    });

                    //############################################
                    // Submits the form (Stores/Creates appointment)
                        store_appointment()
                    //End
                    //############################################

                    //############################################
                    // Selects vehicles
                    selectVehicle()
                    //End
                    //############################################

                    //On click Displays time slots on wrapper
                    click_time()

                }
            });
        });
    //END

    //Editing a booking
        $('.js-edit-appointment').click(function(){
            var time_id    =  $(this).attr('time-id'); //Booking time ID
            var date_id    =  $('#date').attr('date-id');


            $.ajax({
                    url: '/exec/appointments/edit-appointment?time_id='    + time_id,

                        success:function(response){
                            //console.log(response)

                            $('.pop-up-wrapper').fadeIn(1000);
                            $('.pop-up-wrapper').html(response);

                            $('.js-refresh').click(function(){
                                setTimeout(function(){
                                    return location.reload();
                                }, 500);
                            })

                            update_appointment()
                            fetch_dates()

                        //############################################
                        // Selects vehicles
                        selectVehicle()
                        //End
                        //############################################

                        //On click Displays time slots on wrapper
                        click_time()

                        //Closes Book Appointment Wrapper
                        $('.pop-up-close').click(function(){
                            $('.pop-up-wrapper').fadeOut(1000);
                            $('.pop-up-wrapper').html("");
                        });
                    }
            });
        });
    //END Editing


    //Stores Appointment Function
    function store_appointment(){

        $('.js-submit-appointment').click(function(){

            var vehicles        =   $('.js-select-vehicles img.active');
            var vehicles        =   $.map(vehicles, e => $(e).attr('data-vehicle'))
            var interest        =   $('#model_interest').val(); // Model Interest

            //Values to save to the appointments table
            var event_id        =   $('#date').attr('event-id');
            var book_id         =   $('#book_id').attr('book-id');
            var date            =   $('#date').val();
            var time_id         =   $('#event_time').attr('time-id');
            var preference      =   $('#preference').val();
            var drink           =   $('#drink').val();
            var notes           =   $('#notes').val();
            var exec_id         =   $('#exec_id').attr('exec-id');

            //It makes sure any warnings disapear if any times are entered
            $('body').mousedown(function() {
                $('.js-appointment-date').removeClass('border-danger').next('.js-error').html('');
                $('.js-appointment-time').removeClass('border-danger').next('.js-error').html('');
            });


            //It will stop times being saved if fields are empty
            if(date == "" || time_id == ""){
                if(date == ""){
                    $('.js-appointment-date').addClass('border-danger').next('.js-error').html('Date needs to be selected');
                }else{
                    $('.js-appointment-date').removeClass('border-danger').next('.js-error').html('')
                }
                if(time_id == ""){
                    $('.js-appointment-time').addClass('border-danger').next('.js-error').html('Time needs to be selected');
                }else{
                    $('.js-appointment-time').removeClass('border-danger').next('.js-error').html('')
                }
            //Ends Validation

            }else{
                //  alert( book_id + " - " + date_id + " - " + time_id + " - " + preference + " - " + drink + " - "+  notes + " - "+  customer);

                fetch('/exec/appointments/store-appointment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        book_id: book_id,
                        exec_id: exec_id,
                        interest: interest,
                        vehicles: vehicles,
                        date: date,
                        event_id: event_id,
                        time_id: time_id,
                        preference: preference,
                        drink: drink,
                        notes: notes
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

    //Updates Appointment Function
    function update_appointment(){

        $('.js-update-appointment').click(function(){

            var vehicles        =   $('.js-select-vehicles img.active');
            var vehicles        =   $.map(vehicles, e => $(e).attr('data-vehicle'))
            var interest        =   $('#model_interest').val(); // Model Interest

            var id              =   $('#appointment_id').val(); //Appointment ID

            var customer        =   $('#book_id').attr('book-id'); //Customer/Book id
            var date            =   $('#event_date').val(); // Booking date
            var time            =   $('#event_time').val(); // Booking time

            //Values to save to the appointments table
            var event_id        =   $('#date').attr('event-id');
            var book_id         =   $('#book_id').attr('book-id');
            var date            =   $('#date').attr('date');
            var time_id         =   $('#time').attr('time-id');
            var preference      =   $('#preference').val();
            var drink           =   $('#drink').val();
            var notes           =   $('#notes').val();

            //This is to make sure any warnings disapear if any times are entered
            $('body').mousedown(function() {
                $('.js-appointment-customer').removeClass('border-danger').next('.js-error').html('');
                $('.js-appointment-date').removeClass('border-danger').next('.js-error').html('');
                $('.js-appointment-time').removeClass('border-danger').next('.js-error').html('');
            });

            //  alert( book_id + " - " + date_id + " - " + time_id + " - " + preference + " - " + drink + " - "+  notes + " - "+  customer);
                if(customer == "" || date == "" || time == ""){
                    if(customer == ""){
                        $('.js-appointment-customer').addClass('border-danger').next('.js-error').html('Customer needs to be selected');
                    }else{
                        $('.js-appointment-customer').removeClass('border-danger').next('.js-error').html('')
                    }
                    if(date == ""){
                        $('.js-appointment-date').addClass('border-danger').next('.js-error').html('Date needs to be selected');
                    }else{
                        $('.js-appointment-date').removeClass('border-danger').next('.js-error').html('')
                    }
                    if(time == ""){
                        $('.js-appointment-time').addClass('border-danger').next('.js-error').html('Time needs to be selected');
                    }else{
                        $('.js-appointment-time').removeClass('border-danger').next('.js-error').html('')
                    }
                //Ends Validation

                }else{
                    fetch('/exec/appointments/update-appointment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            id: id,
                            book_id: book_id,
                            interest: interest,
                            vehicles: vehicles,
                            date: date,
                            event_id: event_id,
                            time_id: time_id,
                            preference: preference,
                            drink: drink,
                            notes: notes
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


//#############################################
//ENDS Appointments
//#############################################

    //##############################################
    // Updates vehicles
    //##############################################

    //Saves customer model interest on Click
    function selectVehicle() {
        $('.js-select-vehicles').click( function(){
            $(this).children().toggleClass('active')
            //Fetchs all the execs that belongs to the selected dealership
        })
    }

    //END



});
