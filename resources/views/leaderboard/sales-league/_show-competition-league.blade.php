<div class="s-card ">
    <div class="s-card-header col-12 bg-brand text-light border-0">
        <div class="row  py-1">
            <div class="col-8 fs-80 normal">
                @if(isNow() > isPast($competition->end_date))
                    <span class="alert-danger text-danger px-2 py-1  rounded">
                        Competition ended at: <span class="ml-1"> {{ formatDate(isPast($competition->end_date)) }}</span>
                    </span>
                @else
                    <span class="fs-100 mr-3 bg-white text-brand px-2  py-1 rounded">
                        Competition ends at: <span class="ml-1"> {{ formatDate(isPast($competition->end_date)) }}</span>
                    </span>
                @endif
            </div>
            <div class="col text-end">
                @if(isNow() < isPast($competition->end_date))
                    <a href="javascript:void(0)" class="btn py-0 px-2 btn-default brother normal mr-3 js-create-sale-league" exec-id="{{$exec->id}}" dealership-id="{{$dealership->id}}" competition-id="{{$competition->id}}" ><i class="fas fa-chart-bar mr-1"></i> Log Sale</a>
                @endif
                Total: <span class="js-sum"></span>
            </div>
        </div>
    </div>

    <div class="s-card-header px-0 alert-brand text-dark border-0 border-bottom d-none d-lg-block d-xl-block">
        <div class="col-12">
            <div class="row ">
                <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Team Member
                </div>
                <div class="col-3  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Dealership
                </div>
            </div>
        </div>

    </div>

    <div class="s-card-body py-0">
        <div class="col-12">
            @if(count($sales) > 0)
                @foreach($sales as $sale)


                    <div class="row s-card-row py-1 line-height-22">
                        <div class="col-lg-2  border-right bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Exec: </span>
                            {{$sale->leaderboard->name}} @if($sale->leaderboard->id == $exec->id) <small class="text-brother bold">(you)</small> @endif
                        </div>

                        <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                            {{dealership($sale->leaderboard->id)->name}}
                        </div>

                        <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Sales: </span>
                            <span class="badge bg-info js-total"> {{competitionSalesCount($competition->id, $sale->leaderboard->id)}}  </span>
                            <a href="javascript:void(0)" leaderboard-id="{{$sale->leaderboard->id}}" competition-id="{{$competition->id}}" class="ml-3 fs-80 btn px-1 py-0 btn-border brand js-view-sales">Sales Log <i class="fas fa-eye"></i></a>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="row">
                    <div class="col-12 alert-warning text-dark border border-warning p-3">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<script>

    $(function(){

        function getTotal(){
            var total = 0;
            $('.js-total').each(function(){
                total += parseFloat(this.innerHTML)
            });
            $('.js-sum').text(total);
        }

        getTotal();

        $('.js-view-sales').click(function(){
            var leaderboard_id = $(this).attr('leaderboard-id');
            var competition_id = $(this).attr('competition-id');


            $('body').addClass('overflow');

            $.ajax({
                url: '/leaderboard/sale-logs?leaderboard_id=' + leaderboard_id + '&competition_id=' + competition_id,
                    success:function(response){
                        console.log(response)
                        $('.pop-up-wrapper').fadeIn(800).html(response);
                        //Closes Book Appointment Wrapper
                        $('.pop-up-close').click(function(){
                            $('.pop-up-wrapper').fadeOut(1000);
                            $('.pop-up-wrapper').html("");
                            $('body').removeClass('overflow');
                        });


                        //Asks Admin to confirm deletion
                        $('.js-delete').click(function(){
                            var item_id = $(this).attr('item-id');

                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to delete Sale Log?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                //var url = route('leaderboard.delete.log', ":id");
                                                var url = '/dashboard/leaderboard/delete-log/' + item_id;
                                                //url = url.replace(':id',item_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        location.reload();
                                    }
                                }
                            });

                        })

                    }
            });

        })


    //Confirm Appointment
        $('.js-create-sale-league').click(function(){

            var exec_id             =   $(this).attr('exec-id');
            var dealership_id       =   $(this).attr('dealership-id');
            var competition_id      =   $(this).attr('competition-id');



            $.ajax({
                url: '/leaderboard/log-sale?exec_id='   + exec_id
                                +'&dealership_id='   + dealership_id
                                +'&competition_id='   + competition_id,

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


                        store_sale(competition_id);

                    }
            });

        });
    //END


    //Stores an Appointment Function
        function store_sale(competition_id){

            $('.js-submit-log').click(function(){

                //Values to save to the appointments table
                var dealership_id       =   $('.js-dealership-id').attr('dealership-id');
                var exec_id             =   $('.js-exec-id').attr('exec-id');
                var order_number        =   $('#order_number').val();
                var sale_types_id       =   $('#sale_types_id').val();
                var customer            =   $('#customer').val();

                //This is to make sure any warnings disapear if any times are entered
                $('body').mousedown(function() {
                    $('.js-order-number').removeClass('border-danger').next('.js-error').html('');
                    $('.js-customer').removeClass('border-danger').next('.js-error').html('');
                    $('.js-sale-type').removeClass('border-danger').next('.js-error').html('');
                    $('.js-submit-log').removeClass('disabled');
                });


                //It will stop times being saved if fields are empty
                if(order_number == "" || customer == ""){
                    $('.js-submit-log').addClass('disabled');

                    if(order_number == ""){
                        $('.js-order-number').addClass('border-danger').next('.js-error').html('Please enter an Order or Reg Number');

                    }else{
                        $('.js-order-number').removeClass('border-danger').next('.js-error').html('')
                    }

                    if(customer == ""){
                        $('.js-customer').addClass('border-danger').next('.js-error').html('Please enter a Customer name or Order');
                    }else{
                        $('.js-customer').removeClass('border-danger').next('.js-error').html('')
                    }

                    if(sale_types_id == ""){
                        $('.js-sale-type').addClass('border-danger').next('.js-error').html('Please enter a Sale Type');
                    }else{
                        $('.js-sale-type').removeClass('border-danger').next('.js-error').html('')
                    }

                //Ends Validation

                }else{



                    fetch('/leaderboard/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            dealership_id: dealership_id,
                            competition_id: competition_id,
                            customer: customer,
                            exec_id: exec_id,
                            order_number: order_number,
                            sale_types_id: sale_types_id

                        }),
                    })
                    .then((response) => response.json())
                    .then((response) => {

                            console.log(response);
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


    })

</script>
