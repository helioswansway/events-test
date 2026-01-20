$(function(){
    //Saves customer model interest on Click
    $('.js-car-interest').click(function(){

        var interest        =  $('.js-car-interest .active').attr('car-iterest');
        var vehicles        =  $('.js-select-vehicles img.active');
        var dealership_id   =  $('#dealershipId').val();
        var event_id        =  $('#eventId').val();

        var vehicles = $.map(vehicles, e => $(e).attr('data-vehicle'))

        //Fetchs all the execs that belongs to the selected dealership

        fetch('/book/appointment/save-model',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                interest: interest,
                vehicles: vehicles,
                dealership_id: dealership_id,
                event_id: event_id
            }),
        })
        .then((response) => response.json())
        .then((response) => {

                //console.log(response);
                window.location.href = '/book';


        })
        .catch(error => console.log('Error:' + error))

    })

    //Saves Vehicles that customer selects (It's saved in json format)
    $('.js-select-vehicles').click(function(){

        var interest        =  $('.js-car-interest .active').attr('car-iterest');
        var vehicles        =  $('.js-select-vehicles img.active');
        var dealership_id   =  $('#dealershipId').val();
        var event_id        =  $('#eventId').val();

        var vehicles = $.map(vehicles, e => $(e).attr('data-vehicle'))

        //Fetchs all the execs that belongs to the selected dealership

        fetch('/book/appointment/save-model',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                interest: interest,
                vehicles: vehicles,
                dealership_id: dealership_id,
                event_id: event_id
            }),
        })
        .then((response) => response.json())
        .then((response) => {

                //console.log(response);
                window.location.href = '/book';


        })
        .catch(error => console.log('Error:' + error))

    })

    $('.js-update-time').click(function(){
        var time_id =  $(this).attr('item');
        var appointment_id =  $(this).attr('appointment-id');
        var exec_id =  $('#exec_id').val();

        //alert(time_id + " - "+ appointment_id);

        //Fetchs all the execs that belongs to the selected dealership
        /**/
        fetch('/book/update-time',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                time_id: time_id,
                appointment_id: appointment_id,
                exec_id: exec_id
            }),
        })
        .then((response) => response.json())
        .then((response) => {
           // console.log(response);
            location.reload();
        })
        .catch(error => console.log('Error:' + error))

    })


});
