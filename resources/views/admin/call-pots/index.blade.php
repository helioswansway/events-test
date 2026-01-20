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
            <div class="s-card mb-5">
                <div class="display-3 text-center fs-300 my-3" style="border: none !important">
                    Current Campaigns
                </div>

                <div class="s-card-body js-active border-0">
                    @if($campaigns->count() > 0)
                        <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                            @foreach($campaigns as $campaign)
                                <a href="{{route('admin.pot-list.show', $campaign->id)}}" style="border-radius: 20px;"
                                                                class="shadow d-flex align-items-center align-self-stretch btn btn-action info  mr-3"
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

            <div class="py-5 my-3"></div>
        </div>
    </div>
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
