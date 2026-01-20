@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-chart-bar"></i> Pot Lists
                <span class="h1-button" style="">
                    @admin('super')
                        <a href="{{route('admin.pot-list.upload')}}" class="btn btn-sm btn-default success px-2 me-1"><i class="fas fa-upload me-1"></i> Upload CSV File</a>
                    @endadmin

                    @admin('super-admin')
                        <a href="{{route('admin.pot-campaign.index')}}" class="btn btn-sm btn-default info px-2 me-1"><i class="fa-solid fa-bullhorn me-1"></i> Campaigns</a>
                    @endadmin
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="s-card">
                <div class="display-3 text-center fs-300 my-3" style="border: none !important">
                    Current Campaigns
                </div>

                <div class="s-card-body js-active border-0">
                    @if($campaigns->count() > 0)
                        <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                            @foreach($campaigns as $campaign)
                                <a href="{{route('admin.pot-list.show', $campaign->id)}}" style="border-radius: 20px;"
                                                            class="shadow d-flex align-items-center align-self-stretch btn btn-action  mr-3
                                                                    @if($campaign->id == Request::segment(4)) success @else info @endif
                                                                "
                                                                item-id="{{$campaign->id}}">
                                    <div class="row">
                                        <div class="text-center pb-2">
                                            <img src="{{asset('assets/images/public/general/')}}/{{brandCampaignLogo($campaign->id)}}" class=""   style="width:50px" title="">
                                        </div>
                                        <div>{{ucwords($campaign->name)}}</div>
                                    </div>

                                    @if(isNow() > isPast($campaign->end_date) )
                                        <span class="fs-80 ml-2 alert-danger text-danger rounded px-1 line-height-20">(Ended)</span>
                                    @endif
                                </a>
                            @endforeach


                        </div>
                    @else

                        <div class="alert-warning border border-warning px-3 py-2">
                            <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                        </div>

                    @endif

                </div>
            </div>
        </div>



        @admin('super-admin,admin')
            @if($campaigns->count() > 0)
                <input type="hidden" name="campaign_id" class="js-campaign-id" value="{{ \Request::segment(4) }}">
                <div class="col-lg-10">
                    <div class="row justify-content-center my-2">
                        <div class="col-lg-4 text-center">
                            <label id="dealership" for="dealership_id" class="bold fs-120">Select Dealership</label>
                            <select id="dealership_id" class="fs-120 shadow form-control form-select mb-3 js-pot-list-dealerships @if(\Request::segment(5)) alert-success lighter @endif" style="line-height: 40px; height: auto;">
                                <option value="">--Select a Dealership--</option>
                                @foreach($dealerships as $dealership)
                                    <option value="{{$dealership->id}}"
                                        @if(\Request::segment(5) == $dealership->id) selected @endif
                                        >{{$dealership->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        @endadmin

        @if(isset($booked))
            @include('admin.call-pots._pot-list-booked')
        @elseif(isset($in_progress))
            @include('admin.call-pots._pot-list-in-progress')
        @elseif(isset($not_interested))
            @include('admin.call-pots._pot-list-not-interested')
        @else
            @include('admin.call-pots._pot-list')
        @endif

    </div>
@endsection


@section('scripts')

    <script>


        $('.js-pot-list-dealerships').change(function(){
            var campaign_id = $('.js-campaign-id').val();
            var dealership_id = $(this).val();

             var url = '/dashboard/pot-list/by-dealership/' + campaign_id + '/' + dealership_id +"#dealership"
            if(dealership_id){

              window.location.href = url;
            }

        })

        //It will leaderboard sales League based on the competition that's selected
        $('.js-show-list').click(function(){
            var id = $(this).attr('item-id')

            //$('.js-display-league').html(id)
            $.ajax({
                url: '/dashboard/pot-list/show-campaign-list?id='+id,
                    success:function(data){
                        //console.log(data);
                        $('.js-display-league').fadeIn('slow').html(data);

                        registerAction()
                }
            });
        })


        $('.js-get-form').on('click', function() {
            var buttonActive = $(this).hasClass('brand');
            // Remove the brother class from all elements.
            $('.js-active').removeClass('brand').addClass('sister');
            // Add brother state if this clicked button doesn't have.
            if (!buttonActive) {
                $(this).removeClass('sister').addClass('brand');
            }
        });


        $('.js-get-form').click(function(){
            var item_id = $(this).attr('item-id')

            var url = '{{ route('admin.pot-list.form', ":id") }}';
            url = url.replace(':id',item_id);

            $.confirm({
                columnClass: 'col-lg-8 ',
                closeIcon: true,
                closeIconClass: 'fa fa-close',
                title: 'Lock your action',
                content: 'url:'+url,

                buttons: false,

            });

        });

        //Asks Admin to confirm deletion
        $('.js-reset').click(function(){
            var item_id = $(this).attr('item-id');

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to Reset this Pot List?',
                buttons: {
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                var url = '{{ route('admin.pot-list.reset', ":id") }}';
                                url = url.replace(':id',item_id);
                                window.location.href = url;
                            }
                        });
                    },
                    cancel: function () {
                        location.reload();;
                    }
                }
            });

        })


    </script>

@endsection
