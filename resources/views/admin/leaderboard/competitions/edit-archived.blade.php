@extends('_layouts._dashboard')

@section('content')
    <div class="row pop-up-wrapper"></div>

    <h1 class="display-4">
        <i class="fas fa-archive "></i> Edit Archived
        <span class="h1-button" style="">
            @admin('super-admin')
                <a href="{{route('admin.competition.archived')}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-2"></i> Back</a>
            @endadmin
        </span>
    </h1>


    @include('admin.inc._messages')
    <form action="{{route('admin.competition.update.archived', [$competition->id])}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="s-card shadow">
                    <div class="s-card-header  bg-brother">
                        Competition Details
                    </div>
                    <div class="s-card-body px-3 py-3 ">

                        <label for="competition" class="fs-100 bold ">Competition Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg " value="{{$competition->name}}" autocomplete="off" />

                        <div class="row ">
                            <div class="col-3 py-3">
                                <label class="bold block"> Is Active? </label>
                                <div class="bold ">
                                    <label for="active_yes">
                                        <input type="radio" id="active_yes" name="active" value="1"
                                            @if($competition->active == 1) checked @endif
                                        > Yes
                                    </label>

                                    <label for="active_no" class="ml-2">
                                        <input type="radio" id="active_no" name="active" value="0"
                                            @if($competition->active == 0) checked @endif
                                        > No
                                    </label>
                                </div>
                            </div>

                            <div class="col-3 py-3">
                                <label class="bold block"> Is Archived?</label>
                                <div class="bold ">
                                    <label for="archived_yes">
                                        <input type="radio" id="archived_yes" name="archived" value="1"
                                            @if($competition->archived == 1) checked @endif
                                        > Yes
                                    </label>

                                    <label for="archived_no" class="ml-2">
                                        <input type="radio" id="archived_no" name="archived" value="0"
                                            @if($competition->archived == 0) checked @endif
                                        > No
                                    </label>
                                </div>
                            </div>

                            <div class="col py-3">
                                <label for="end_date" class="fs-100 bold ">End Date</label>
                                <input type="text" name="end_date" id="end_date" class="form-control form-control-lg " value="{{$competition->end_date}}" autocomplete="off" />
                                <div class="row error px-3">
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-12">
                                <button type="submit" name="button" class="btn btn-action sister block"><i class="fas fa-save mr-2"></i> Update Competition </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="s-card shadow my-5">
        <div class="s-card-header bg-brother">
            Archived Competition
        </div>

        <div class="s-card-body js-active p-3">
            @if($competitions->count() > 0)
                @if($competitions->count() == 1)
                    @foreach($competitions as $competition)
                        <a  href="javascript:void(0)" class="
                        btn btn-action brand mr-3 rounded-0 ">{{ucwords($competition->name)}} </a>
                    @endforeach

                    {{competition_single_sale_leagues($competition->id)}}
                    {{-- @include('admin.leaderboard._show-competition-league') --}}

                @else
                    @foreach($competitions as $competition)
                        <a href="javascript:void(0)" class="
                                                        btn btn-action  mr-3 rounded-0 js-show-league
                                                        @if ($loop->first) js-first  @endif

                                                        @if(\Carbon\Carbon::now()->startOfDay()->gte($competition->end_date))
                                                            @if ($loop->first) brand @else  sister @endif
                                                        @else brother @endif

                                                        "
                                                        item-id="{{$competition->id}}">
                            <i class="fas fa-trophy mr-2"></i> {{ucwords($competition->name)}}

                            @if(\Carbon\Carbon::now()->startOfDay()->gte($competition->end_date))
                                <span class="fs-80 ml-2">(Ended)</span>
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

<script>

    $( function() {
        $( "#end_date, .js-edit-end-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );


    $( function() {


        $("#active_yes").click(function() {
            $("#archived_no").prop("checked", $(this).prop("checked"));
        });

        $("#active_no").click(function() {
            $("#archived_yes").prop("checked", $(this).prop("checked"));
        });

        $("#archived_yes").click(function() {
            $("#active_no").prop("checked", $(this).prop("checked"));
        });

    } );


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
