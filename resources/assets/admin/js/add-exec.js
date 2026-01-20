$(function(){
    //On click it will pop up a window with execs
    $('.js-add-exec').click(function(){
        var time_slot       =  $(this).attr('time-slot'); //Grabs the time slot id
        var dealership_id   =  $(this).attr('dealership-id'); //Grabs the dealership id

        //alert(0);
        //Removes overflow class from body tag if exists one
        $('body').addClass('overflow');

        // Adds .fade-in class
        // Removes .fade-out class if exists
        $('.pop-up-wrapper').addClass('fade-in').removeClass('fade-out');

        //On Click adds .fade-out class removes .fade-in class after 0.8s if exists (This is so animation can take place)
        $('.pop-up-close').click(function(){
            $('.pop-up-wrapper').addClass('fade-out');
            setTimeout(function(){
                $('body').removeClass('overflow');
                $('.pop-up-wrapper').removeClass('fade-in');
            }, 800);
        })

        //Fetchs all the execs that belongs to the selected dealership
        fetch('/dashboard/events/fetch-exec',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                time_slot: time_slot,
                dealership_id: dealership_id,
            }),
        })
        .then((response) => response.json())
        .then((response) => {
            // response = JSON.stringify(response);

            let output = '<h2 class="s-card-header bg-brother mb-0">Execs</h2>'

            response.forEach(function(exec){
                output += `<div class="bold s-card-row text-dark line-height-30 pb-0 px-2"><label><input type="checkbox" name="exec[]" value="${exec.id}" class="js-exec-value mr-1"> ${exec.name} </label></div>`;
            });

            let button = '<button class="mt-3 btn btn-action sister js-submit-exec normal block">Add Exec</button>';

            document.getElementById('js-execs-inner').innerHTML = output + button;

            //Submit Excec to time slot
            $('.js-submit-exec').click(function(){
                //var exec = document.getElementsByClassName("js-exec-value").checked = $(".js-exec-value").val();
                //Create an Array.

                $('.pop-up-wrapper-spin').removeClass('hide');
                $('body').addClass('overflow');

                var response = new Array();
                $("input[name='exec[]']:checked").each(function(i) {
                    response.push($(this).val());
                });
                //alert(response + " " + time_slot + " " + dealership_id)
                //Display the selected CheckBox values.
                if (response.length > 0) {
                    //alert("Selected Execs: " + response.join(","));
                }else{
                    alert("No Execs were selected");
                }

                //Saves the execs selected
                fetch('/dashboard/events/add-exec-to-time-slot',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                        'X-Requested-With': 'XMLHttpRequest',
                        "Access-Control-Allow-Origin" : "*",
                        "Access-Control-Allow-Credentials" : true
                    },
                    body: JSON.stringify({
                        execs: response,
                        time_slot: time_slot,
                        dealership_id: dealership_id
                    }),
                })
                .then((response) => {

                    $('.pop-up-wrapper').removeAttr('style').removeClass('fade-in').addClass('fade-out')
                    setTimeout(function(){
                       return location.reload()
                    }, 300);

                })


            })

        })
        .catch(error => console.log('Error:' + error))

    });




});
