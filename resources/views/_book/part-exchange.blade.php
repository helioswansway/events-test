@extends('_layouts._book-dashboard')

@section('content')

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-4 bold mb-0">Your part exchange details</h1>
            <h2 class="fs-120 bold alert-light py-2 px-3 rounded border-0 hide-mobile mb-0 text-center mt-3">If you don't have a part exchange, you can just skip to the next step</h2>

        </div>
    </div>
    <input type="hidden" name="appointment_id" id="appointment_id" value="{{$appointment->id}}">
    <div class="s-card px-3 mt-4">
       <div class="row justify-content-center">
            <div class="col-lg-8 shadow py-3">
                <h2 class="border-bottom mb-3 bold">Enter Vehicle Details</h2>
                <div class="v-reg mb-0 mt-2">
                    <span>Registration Number:</span>
                    <input type="text" id="reg_number" name="reg_number" autocomplete="off">
                </div>
                <a href="javascript:void(0)" class="btn btn-action brother block mt-2 js-get-vehicle @if($appointment->part_exchange == 1) hide @endif">Get Vehicle Details</a>
                <div class="show-vehicle-details hide"></div>

                @if($appointment->part_exchange == 1)
                    <div class="show-part-exchange-details mt-4">
                        <div class="fs-100 p-4 alert-light lighter text-dark " style="margin-top: -5px">
                            <div class="mb-1">
                                <span class="bold">Registration:</span> {{$appointment->registration}}
                                <input type="hidden" name="registration_number" id="registration" class="form-control" value="{{$appointment->registration}}">
                            </div>
                            <div class="mb-1">
                                <span class="bold">Make:</span> {{$appointment->make}}
                                <input type="hidden" name="make" id="make" class="form-control" value="{{$appointment->make}}" disabled>
                            </div>
                            <div class="mb-1">
                                <span class="bold">Colour:</span> ' {{$appointment->colour}}
                                <input type="hidden" name="colour" id="colour" class="form-control" value="{{$appointment->colour}}" disabled>
                            </div>
                            <div class="mb-1">
                                <span class="bold">Fuel Type:</span> {{$appointment->fuel_type}}
                                <input type="hidden" name="fuel_type" id="fuel_type" class="form-control" value="{{$appointment->fuel_type}}" disabled>
                            </div>
                        </div>

                        <div class="v-mileage mt-4">
                            <label class="bold">Mileage</label>
                            <input type="text" name="mileage" id="mileage" class="form-control" value="{{$appointment->mileage}}" placeholder="Enter your approximate Mileage">
                        </div>

                    </div>

                @endif

            </div>

            {{-- <div class="show-mobile" style="height: 40px"></div> --}}

            {{-- <div class="col-lg-6 no-part-exchange1 text-center d-flex justify-content-center align-items-center">
                <h2 class="fs-110 bold js-part-exchange @if($appointment->part_exchange == 1) js-no-part-exchange-details   @else active @endif">If you don't have a part exchange, you can just skip to the next step</h2>

            </div> --}}

       </div>
    </div>

    <div class="col-12 text-center mt-5">
        <h2 class="fs-120 bold alert-light py-2 px-3 rounded border-0 show-mobile mb-3">If you don't have a part exchange, you can just skip to the next step</h2>

        <a href="{{route('book.appointment')}}" class="btn btn-border warning btn-radius-md mr-5"><i class="fas fa-arrow-left mr-3"></i>  Back</a>

        <a href="javascript:void(0)" class="btn btn-border sister btn-radius-md ml-5 js-part-exchange-details">Next <i class="ml-3 fas fa-arrow-right"></i></a>
    </div>


@endsection

@section('scripts')

    <script>

        //It will return Customer vehicle details from DVLA
        $('.js-get-vehicle').click(function(){

            $(this).addClass('disabled'); //Disables button
            $('.js-part-exchange').removeClass('active'); //Removes Active class
            $('.show-part-exchange-details').addClass('hide');

            //Gets Registration number that was entered
            var reg_number = $('#reg_number').val();
            var reg_number = reg_number.replace(/ /g, '');


            if(reg_number === ""){
                var message = `<div class="col-12 alert-danger lighter py-1 mt-1 bold rounded text-danger">Please enter a valid registration!</div>`
                $('.js-get-vehicle').removeClass('disabled');
                $('.show-vehicle-details').removeClass('hide').html(message)
            }else{
                //Fetchs all the execs that belongs to the selected dealership
                fetch('/book/show-vehicle-details',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        reg_number: reg_number,
                    }),
                })
                .then((response) =>{
                    if(!response.ok){
                        throw Error("There's an Error")
                    }
                    return response.json()
                })
                .then((response) => {
                    console.log(response);

                    if(response == '404'){
                        var message = `<div class="col-12 alert-danger lighter py-1 mt-1 bold rounded">Vehicle <span class="normal fs-120 text-danger">"${reg_number}"</span>  doesn't seem to exist.<br> Please try again!</div>`
                        $('.js-get-vehicle').removeClass('disabled');
                        $('.show-vehicle-details').removeClass('hide').html(message)

                    }else{

                        const html = response.map(item => {
                                    return `
                                            <div class="fs-100 p-2 rounded alert-brother lighter text-dark mt-1">
                                                <div class="line-height-20">
                                                    <span class="bold">Registration:</span> ${item.registration}
                                                    <input type="hidden" name="registration_number" id="registration" class="form-control" value="${item.registration}">
                                                </div>
                                                <div class="">
                                                    <span class="bold">Make:</span> ${item.make}
                                                    <input type="hidden" name="make" id="make" class="form-control" value="${item.make}" disabled>
                                                </div>
                                                <div class="">
                                                    <span class="bold">Colour:</span> ${item.primaryColour}
                                                    <input type="hidden" name="colour" id="colour" class="form-control" value="${item.primaryColour}" disabled>
                                                </div>
                                                <div class="">
                                                    <span class="bold">Fuel Type:</span> ${item.fuelType}
                                                    <input type="hidden" name="fuel_type" id="fuel_type" class="form-control" value="${item.fuelType}" disabled>
                                                </div>
                                            </div>

                                        <div class="v-mileage mt-3">
                                            <input type="text" name="mileage" id="mileage" class="form-control" placeholder="Enter your approximate Mileage">
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-border success py-1 js-part-exchange-details" item="save">Save </a>

                                    `
                            })

                            $('.js-get-vehicle').removeClass('disabled');
                            $('.show-vehicle-details').removeClass('hide').html(response)
                            document.querySelector('.show-vehicle-details').insertAdjacentHTML("afterbegin", html)
                            partExchange()

                    }





                })
                .catch(error => console.log('Error:' + error))
            }


        })


        function partExchange(){
            //Saves all vehicle details
            $('.js-part-exchange-details').click(function(){
                var registration_number = $('#registration').val();
                var make = $('#make').val();
                var colour = $('#colour').val();
                var fuel_type = $('#fuel_type').val();
                var appointment_id = $('#appointment_id').val();
                var mileage = $('#mileage').val();

                var attr = $(this).attr('item');


                //If .js-part-exchange has .active class it will redirect to next page with no further action
                if($('.js-part-exchange').hasClass('active')){
                    window.location.replace("/book/booking-confirmation");
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
                            window.location.replace("/book/booking-confirmation");
                        }


                        //alert("Success");
                        //$('.show-vehicle-details').removeClass('hide').html(response)

                    })
                    .catch(error => console.log('Error:' + error))
                }
            })

        }

        partExchange()


        //Saves if no part exchange details
        $('.js-no-part-exchange-details').click(function(){
            var appointment_id          =   $('#appointment_id').val();

            fetch('/book/no-part-exchange-details',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    appointment_id: appointment_id,
                }),
            })
            .then((response) => response.json())
            .then((response) => {
                //console.log(response);
                window.location.replace("/book/part-exchange");
            })
            .catch(error => console.log('Error:' + error))

        })

    </script>



@endsection
