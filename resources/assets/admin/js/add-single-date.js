$(function(){

    $('.pop-up-wrapper').hide(); //Hides pop-up-wrapper

    //Removes .hide class after 0.2s
    setTimeout(function(){
        $('.pop-up-wrapper').removeClass('hide');
    }, 200);


    //On click it will pop up a window with execs
    $('.js-add-single-date').click(function(){

        var dealership_id   =  $(this).attr('dealership-id'); //Grabs the dealership id

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


        //Saves Single date

        $('.js-save-single-date').click(function(){
            var single_date   =  $('#single_date').val(); //Grabs the dealership id
            alert(single_date +" "+ dealership_id);
        })

        //Fetchs all the execs that belongs to the selected dealership
        /** */
        fetch('/dashboard/events/add-single-date',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                single_date: single_date,
                dealership_id: dealership_id,
            }),
        })
        .then((response) => response.json())
        .then((response) => {
            // response = JSON.stringify(response);

            let output = '<h2 class="border-bottom mb-3">Execs</h2>'

            response.forEach(function(exec){
                output += `<div class="bold text-dark py-1 border-bottom"><label><input type="checkbox" name="exec[]" value="${exec.id}" class="js-exec-value mr-1"> ${exec.name} (${exec.id})</label></div>`;
            });

            let button = '<button class="my-3 btn btn-border warning js-submit-exec">Add Exec</button>';

            document.getElementById('js-execs-inner').innerHTML = output + button;

            //Submit Excec to time slot
            $('.js-submit-exec').click(function(){
                //var exec = document.getElementsByClassName("js-exec-value").checked = $(".js-exec-value").val();
                //Create an Array.

                var response = new Array();
                $("input[name='exec[]']:checked").each(function(i) {
                    response.push($(this).val());
                });

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
                    },
                    body: JSON.stringify({
                        execs: response,
                        time_slot: time_slot,
                        dealership_id: dealership_id,
                    }),
                }).then((response) => response.json())
                .then((response) => {
                    $('.pop-up-wrapper').removeAttr('style').removeClass('fade-in').addClass('fade-out');
                    setTimeout(function(){
                        return location.reload();
                    }, 300);

                    //return console.log(response)
                })


            })

        })
        .catch(error => console.log('Error:' + error))



    });




});
