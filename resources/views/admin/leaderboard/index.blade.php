@extends('_layouts._dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-chart-bar"></i> Leaderboard
                <span class="h1-button" style="">
                    @admin('super-admin')
                        <a href="javascript:void(0)" class="btn btn-sm btn-default light js-competition"><i class="fas fa-trophy"></i> Competitions</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default light js-sale-type"><i class="fas fa-tag"></i> Sale Type</a>
                        <a href="{{route('admin.competition.archived')}}" class="btn btn-sm btn-default sister px-2 me-1"><i class="fas fa-archive "></i> Archived</a>
                    @endadmin

                    @admin('super,super-admin')
                        <a href="javascript:void(0)" class="btn btn-sm btn-border brother px-2 js-reset-leaderboard hide"><i class="fas fa-trash me-1"></i> Reset</a>
                    @endadmin
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="s-card shadow mb-5">
        <div class="s-card-header bg-brother">
            Current Competitions
        </div>

        <div class="s-card-body js-active p-3">
            @if($competitions->count() > 0)
                @if($competitions->count() == 1)
                    @foreach($competitions as $competition)
                        <a  href="javascript:void(0)" class="
                        btn btn-action @if(isNow() > isPast($competition->end_date) ) bg-brother @else  bg-brand @endif mr-3 rounded-0 ">{{ucwords($competition->name)}}  </a>
                    @endforeach

                    {{competition_single_sale_leagues($competition->id)}}
                    {{-- @include('admin.leaderboard._show-competition-league') --}}

                @else
                    @foreach($competitions as $competition)
                        <a href="javascript:void(0)" class="
                                                        btn btn-action  mr-3 rounded-0 js-show-league
                                                        @if ($loop->first) js-first  @endif

                                                        @if(isNow() < isPast($competition->end_date))
                                                            @if ($loop->first) brand  @else sister  @endif
                                                        @else sister @endif
                                                        "
                                                        item-id="{{$competition->id}}">
                            <i class="fas fa-trophy mr-2"></i> {{ucwords($competition->name)}}
                            @if(isNow() > isPast($competition->end_date) )
                                <span class="fs-80 ml-2 alert-danger text-danger rounded px-1 line-height-20">(Ended)</span>
                            @endif
                        </a>
                    @endforeach
                    <div class="js-display-league"></div>
                @endif
            @else

                <div class="alert-warning border border-warning px-3 py-2">
                    <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                </div>

            @endif

        </div>
    </div>

    <div class="py-5 my-3"></div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>

        //Loads competition based on the the first tab
        $(window).on('load', function(){
            //Grabs first tab id
            var id = $('.js-first').attr('item-id');

            $.ajax({
                url: '/dashboard/competition/show-competition-league?id='+id,
                    success:function(data){
                        console.log(data);

                        $('.js-display-league').fadeIn('slow').html(data);
                }
            });
        })

        //It will leaderboard sales League based on the competition that's selected
        $('.js-show-league').click(function(){
            var id = $(this).attr('item-id')
            //$('.js-display-league').html(id)
            $.ajax({
                url: '/dashboard/competition/show-competition-league?id='+id,
                    success:function(data){
                        console.log(data);
                        $('.js-display-league').fadeIn('slow').html(data);
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

        //Shows pop up to create, edit and delete competition information
        $('.js-competition').click(function(){
            //Removes overflow class from body tag if exists one
            $('body').addClass('overflow');
            // Adds .fade-in class
            // Removes .fade-out class if exists

            $.ajax({
                url: '/dashboard/competition/create',
                    success:function(data){
                        console.log(data);
                        setTimeout(function(){
                            $('.pop-up-wrapper').fadeIn('slow').html(data);
                        }, 400);
                }
            });

        })

        //Shows pop up to create, edit and delete Sale Type information
        $('.js-sale-type').click(function(){
            //Removes overflow class from body tag if exists one
            $('body').addClass('overflow');

            // Adds .fade-in class
            // Removes .fade-out class if exists

            $.ajax({
                url: '/dashboard/sale-type/create',
                    success:function(data){
                        console.log(data);
                        setTimeout(function(){
                            $('.pop-up-wrapper').fadeIn('slow').html(data);
                        }, 400);
                }
            });

        })


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
                    url: '/dashboard/leaderboard/sale-logs?leaderboard_id=' + leaderboard_id + '&competition_id=' + competition_id,
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
        })


    </script>



@endsection
