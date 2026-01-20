$('.v-reg input').focus(function(){
    $('.v-reg span').addClass('slide-up');
    $('.js-get-vehicle').removeClass('hide');
});

//Gets vehicle details if theres a part exchange
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


            })
                .catch(error => console.log('Error:' + error))
        }
    })

}

partExchange()
