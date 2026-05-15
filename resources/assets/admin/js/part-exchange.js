    $('.v-reg input').focus(function(){
        $('.v-reg span').addClass('slide-up');
        $('.js-get-vehicle').removeClass('hide');
    });


    //It will return Customer vehicle details from DVLA
    $('.js-get-vehicle').click(function(){

        $('.js-part-exchange').removeClass('active'); //Removes Active class

        //Gets Registration number that was entered
        var reg_number = $('#reg_number').val();
        var reg_number = reg_number.replace(/ /g, '');

        if(reg_number === ""){

            let message = `<div class="text-center border-0 alert-danger px-2 py-1 mt-1 bold rounded text-danger">Please enter a valid registration!</div>`
            $('.js-get-vehicle').removeClass('disabled');
            $('.show-vehicle-details').removeClass('hide').html(message)

        }else{

            $.ajax({
                url: '/book/show-vehicle-details',
                method:'get',
                data: {
                    reg_number: reg_number,
                },
                    success:function(response){

                        console.log(response)

                        $('.js-get-vehicle').removeClass('disabled');
                        $('.show-vehicle-details').removeClass('hide').html(response)

                    }
            });

        }

    });


    function partExchange(){
        //Saves all vehicle details
        $('.js-part-exchange-details').click(function(){
            var registration_number     =   $('#registration').val();
            var make                    =   $('#make').val();
            var colour                  =   $('#colour').val();
            var fuel_type               =   $('#fuel_type').val();
            var appointment_id          =   $('#appointment_id').val();
            var mileage                 =   $('#mileage').val();

            var attr = $(this).attr('item');


            //If .js-part-exchange has .active class it will redirect to next page with no further action
            if($('.js-part-exchange').hasClass('active')){
                window.location.replace("/book/confirm-details");
            }else{
                fetch('/book/part-exchange-details',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        registration_number: registration_number,
                        make: make,
                        colour: colour,
                        fuel_type: fuel_type,
                        appointment_id: appointment_id,
                        mileage: mileage,
                    }),
                })
                .then((response) => response.json())
                .then((response) => {
                    console.log(response);
                    //window.location.replace("/book/part-exchange");

                    if(attr == "save"){
                        location.reload();
                    }else{
                        window.location.replace("/book/confirm-details");
                    }


                    //alert("Success");
                    //$('.show-vehicle-details').removeClass('hide').html(response)

                })
                    .catch(error => console.log('Error:' + error))
            }
        })

    }

    partExchange()
