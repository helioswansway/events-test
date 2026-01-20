@extends('_layouts._dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

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

    <div class="s-card mb-5">
        <div class="s-card-header bg-brother">
            Current Competitions
        </div>

        <div class="s-card-body js-active ">
            @if($campaigns->count() > 0)
                @if($campaigns->count() == 1)
                    @foreach($campaigns as $campaign)
                        <a  href="javascript:void(0)" style="border-radius: 20px; height: 100px; " class="btn btn-action @if(isNow() > isPast($campaign->end_date) ) bg-brother @else  bg-brand @endif mr-3 rounded-0 ">{{ucwords($campaign->name)}}  </a>
                    @endforeach

                    {{campaign_list($campaign->id)}}

                @else
                    <div style="
                    display: flex;
                    align-items: center!important;  height: 100px;">


                        @foreach($campaigns as $campaign)
                            <a href="javascript:void(0)" style="border-radius: 20px;"
                                                            class="
                                                                btn btn-action  mr-3 js-show-list
                                                                @if ($loop->first) js-first  @endif

                                                            @if(isNow() < isPast($campaign->end_date))
                                                                @if ($loop->first) brand  @else sister  @endif
                                                            @else sister @endif
                                                            "
                                                            item-id="{{$campaign->id}}">
                                <i class="fas fa-trophy mr-2"></i> {{ucwords($campaign->name)}}
                                @if(isNow() > isPast($campaign->end_date) )
                                    <span class="fs-80 ml-2 alert-danger text-danger rounded px-1 line-height-20">(Ended)</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
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

        //Loads competition based on the the first tab
        $(window).on('load', function(){
            //Grabs first tab id
            var id = $('.js-first').attr('item-id');
            $.ajax({
                url: '/dashboard/pot-list/show-campaign-list?id='+id,
                    success:function(data){
                        console.log(data);

                        $('.js-display-league').fadeIn('slow').html(data);
                        registerAction()


                }
            });
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

        $('.js-active a').on('click', function() {
            var buttonActive = $(this).hasClass('brand');
            // Remove the brother class from all elements.
            $('.js-active a').removeClass('brand').addClass('sister');
            // Add brother state if this clicked button doesn't have.
            if (!buttonActive) {
                $(this).removeClass('sister').addClass('brand');
            }
        });

        function registerAction(){

            $('.js-action').click(function(){
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

                // $('.js-call-made').click(function(){
                //     $(this).val(1)
                //     $('.js-call-back').val(0)
                //     if($('.js-call-back').prop('checked')){
                //         $('.js-call-back').prop('checked', function(_, checked) {
                //             $(this).val(0)
                //             return !checked;
                //         });
                //     }else{

                //     }
                // });

                // //toggles between call back required and call made (unchecks call_made)
                // $('.js-call-back').click(function(){
                //     $(this).val(1)
                //     $('.js-call-made').val(0)
                //     if($('.js-call-made').prop('checked')){
                //         $('.js-call-made').prop('checked', function(_, checked) {
                //             $(this).val(0)

                //             return !checked;

                //         });
                //     }else{

                //     }
                // });
            })
        }

    </script>

@endsection
