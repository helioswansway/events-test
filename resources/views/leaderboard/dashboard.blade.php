@extends('_layouts._leaderboard-dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="js-display-banner">
        @if(isset($image->filename))
            {{competition_image($exec->id, $image->filename)}}
        @endif
    </div>

    <div class="content-wrapper">


        @include('admin.inc._messages')
        {{-- <h1 class="display-4"><i class="fas fa-tachometer-alt"></i> Dashboard</h1> --}}

        <div class="s-card mb-5">
            <div class="s-card-header col-12 bg-brother text-white mb-3">
                Current Competitions
            </div>

            <div class="s-card-body shadow border-0 js-active px-0 pt-0">

                @if(count($competitions) > 1)
                    @foreach($competitions as $competition)
                        <a href="javascript:void(0)"
                            class="btn btn-action  mr-3 rounded-0 js-show-league
                                @if ($loop->first) js-first  @endif

                                @if(isNow() < isPast($competition->end_date))
                                    @if ($loop->first) brand  @else sister  @endif
                                @else sister @endif
                            "
                            exec-id="{{$exec->id}}" dealership-id="{{$dealership->id}}" competition-id="{{$competition->id}}"><i class="fas fa-trophy mr-2"></i>
                            {{ucwords($competition->name)}}
                            @if(isNow() > isPast($competition->end_date))
                                <span class="fs-80 ml-2 alert-danger text-danger rounded px-1 line-height-20">(Ended)</span>
                            @endif

                        </a>
                    @endforeach
                @else


                    <div class="s-card-header px-3 bg-brand text-light border-0">
                        <div class="row">
                            <div class="col-6"> {{ucwords($competition->name)}} </div>
                            <div class="col-6 text-end ">
                                @if(isNow() > isPast($competition->end_date))
                                    <span class="fs-80 mr-3 alert-danger text-danger py-1 px-2 rounded">
                                        Competition ended at: <span class="ml-1"> {{ formatDate(isPast($competition->end_date)) }}</span>
                                    </span>
                                @else
                                    <span class="fs-80 mr-3 bg-white text-brand px-2 py-1 rounded">
                                        Competition ends at: <span class="ml-1"> {{ formatDate(isPast($competition->end_date))}}</span>
                                    </span>
                                @endif

                                @if(isNow() <= isPast($competition->end_date))
                                    <a href="javascript:void(0)" class="btn  btn-border sister normal mr-3 js-create-sale-league" exec-id="{{$exec->id}}" dealership-id="{{$dealership->id}}" competition-id="{{$competition->id}}" ><i class="fas fa-chart-bar mr-1"></i> Log Sale</a>
                                @endif
                                Total: <span class="js-sum"></span>
                            </div>
                        </div>
                    </div>

                    <div class="s-card-header px-3 alert-secondary border-0 border-bottom text-dark d-none d-lg-block d-xl-block">
                        <div class="row ">
                            <div class="col-2 border-end border-white" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Team Member
                            </div>
                            <div class="col-2 border-end border-white" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Dealership
                            </div>
                            <div class="col-2 border-end border-white text-left" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Sales Type
                            </div>
                            <div class="col text-end">
                                Sales
                            </div>
                        </div>
                    </div>

                    <div class="s-card-body px-3 pt-0">
                        @if(count($sales) > 0)
                            @foreach($sales as $sale)
                                <div class="row s-card-row line-height-34">

                                    <div class="col-lg-2 bold  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Exec: </span>
                                         @if($sale->leaderboard->id == $exec->id) <span class="bg-brother text-brand px-2 rounded">{{$sale->leaderboard->name}}  <small class="bold">(you)</small></span> @else {{$sale->leaderboard->name}} @endif
                                    </div>

                                    <div class="col-lg-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                                        {{dealership($sale->leaderboard->id)->name}}
                                    </div>

                                    <div class="col-lg-2  border-right text-left" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Sales Type: </span>
                                        <span> <span class="badge bg-info"><i class="fas fa-tag"></i> </span> <a href="javascript:void(0)" item-id="{{$sale->leaderboard_id}}" competition-id="{{$competition->id}}" class="ml-1 js-view-sale-types link">View all</a> </span>

                                    </div>

                                    <div class="col  text-end">
                                        <span class="badge bg-brother js-total">{{competitionSalesCount($competition->id, $sale->leaderboard->id)}} </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-12 alert-warning text-dark border border-warning p-3 bold">
                                    <i class="fas fa-frown text-warning fs-170 mr-2"></i>
                                    No entries as yet!
                                </div>
                            </div>
                        @endif
                    </div>





                @endif
                <div class="js-display-league">{{competition_sale_leagues()}}</div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })

        function getTotal(){
            var total = 0;
            $('.js-total').each(function(){
                total += parseFloat(this.innerHTML)
            });
            $('.js-sum').text(total);
        }

        getTotal();

        //It will leaderboard sales League based on the competition that's selected
        $('.js-show-league').click(function(){
            var competition_id = $(this).attr('competition-id')
            var exec_id = $(this).attr('exec-id')
            var dealership_id = $(this).attr('dealership-id')


            // $(this).parent().addClass('active');
            // $(this).addClass('brother');

            //$('.js-display-league').html(id)
            $.ajax({
                url: '/leaderboard/competition/show-competition-league?competition_id='+competition_id
                                                                        + '&dealership_id='+dealership_id
                                                                        + '&exec_id='+exec_id,
                success:function(response){
                    console.log(response);
                    $('.js-display-league').fadeIn('slow').html(response);
                }
            });

            $.ajax({
                url: '/leaderboard/competition/show-competition-filename?competition_id='+competition_id
                                                                                    + '&exec_id='+exec_id,
                    success:function(response){
                        console.log(response);

                        $('.js-display-banner').html(response);
                }
            });


        })


        $('.js-active a').on('click', function() {
            var buttonActive = $(this).hasClass('brand');
            // Remove the brother class from all elements.
            $('.js-active a').removeClass('brand').addClass('sister');
            // Add brother state if this clicked button doesn't have.
            if (!buttonActive) {
                $(this).removeClass('sister').addClass('brand');
            }
        });


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

                        $('.pop-up-wrapper').fadeIn(100).html(response);

                        //Closes Book Appointment Wrapper
                        $('.pop-up-close').click(function(){
                            $('.pop-up-wrapper').fadeOut(500);
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
                var dealership_id = $('.js-dealership-id').attr('dealership-id');
                var exec_id = $('.js-exec-id').attr('exec-id');
                var order_number = $('#order_number').val();
                var sale_types_id = $('#sale_types_id').val();
                var customer = $('#customer').val();

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

                    $.ajax({
                            url: '/leaderboard/store',
                            method: "post",
                            data:{
                                dealership_id: dealership_id,
                                competition_id: competition_id,
                                customer: customer,
                                exec_id: exec_id,
                                order_number: order_number,
                                sale_types_id: sale_types_id
                            },
                            success:function(response){
                                console.log(response)

                                $('.pop-up-wrapper').fadeOut(1500);
                                $('.js-message').fadeIn(1500);

                                /**/
                                setTimeout(function(){
                                    return location.reload();
                                }, 1000);


                            }
                        });


                }


            });

        }
        //END

    </script>

@endsection
