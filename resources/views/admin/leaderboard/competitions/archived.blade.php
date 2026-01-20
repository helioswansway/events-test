@extends('_layouts._dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-archive"></i> Archived Competitions
                <span class="h1-button" style="">
                    @admin('super-admin')
                        <a href="{{route('admin.leaderboard.index')}}" class="btn btn-border sister"><i class="fas fa-chart-bar mr-2"></i> Leaderboard</a>
                    @endadmin
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="s-card shadow mb-5">
        <div class="s-card-header bg-brother">
            Archived Competitions
        </div>

        <div class="s-card-body js-active p-3">


                <div class="s-card-header bg-brand d-none d-lg-block d-xl-block">
                    <div class="row ">
                        <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            Competition
                        </div>

                        <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            Active
                        </div>
                        <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            Archived
                        </div>

                        <div class="col text-end" style="">

                        </div>
                    </div>
                </div>

                <div class="s-card-body py-0 px-3">
                    @if(count($competitions) > 0)
                        @foreach($competitions as $competition)
                            <div class="row s-card-row py-1 line-height-34">
                                <div class="col-lg-2  border-right bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Name: </span>
                                    {{$competition->name}}
                                </div>

                                <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    @if($competition->active == 1) <i class="fas fa-thumbs-up text-success"></i> @else <i class="fas fa-thumbs-down text-danger"></i> @endif
                                </div>

                                <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    @if($competition->archived == 1) <i class="fas fa-thumbs-up text-success"></i> @else <i class="fas fa-thumbs-down text-danger"></i> @endif

                                </div>

                                <div class="col text-end">
                                    <a href="{{route('admin.competition.edit.archived', $competition->id)}}" class="js-edit mr-1" item-id="{{$competition->id}}" title="Edit Competition"><i class="far fa-edit text-warning"></i></a>
                                    <a href="javascript:void(0)" class="js-delete" item-id="{{$competition->id}}" title="Delete Competition"><i class="fa fa-trash text-danger"></i></a>
                                </div>

                            </div>

                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-12 bold alert-warning text-dark border border-warning py-2">
                                <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                            </div>
                        </div>
                    @endif
                </div>
        </div>
    </div>



    <div class="py-5 my-3"></div>

@endsection


@section('scripts')


    <script>
        //Asks Admin to confirm deletion
        $('.js-delete').click(function(){
            var item_id     =   $(this).attr('item-id');
            var hide_row    =   $(this).closest('.s-card-row');

            $.confirm({
                title: 'Confirm!',
                content: '<div class="fs-90">Are you sure you want to delete Competition?</div> <div class="text-brother fs-90 my-2"><i class="fas fa-exclamation-triangle mr-1"></i> All <strong>Execs</strong>  and <strong>Sales League entries</strong> assigned to this competition will also be deleted! </div> <div class="fs-90"> Make sure you do a backup.</div>',
                buttons: {
                    //If confirmed proceeds to delete
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                // var url = '{{ route('admin.competition.delete', ":id") }}';
                                // url = url.replace(':id',item_id);
                                // window.location.href = url;

                                $.ajax({
                                    url: '/dashboard/competition/delete?id=' + item_id,
                                        // //url: '{{ route('admin.competition.update', ":id, :active, :end_date, :name") }}',

                                            success:function(data){

                                                console.log(data);
                                                hide_row.addClass('hide');
                                                $('.message').addClass('col-12 alert-success py-2 my-3').html('Competition was successfully deleted!')
                                                setTimeout(function(){
                                                    //$('.pop-up-wrapper').fadeOut('slow').html(data);
                                                    $('.message').removeClass('col-12 alert-success py-2 my-3').html('')

                                                }, 3000);
                                        }
                                    });

                            }
                        });
                    },

                    //If Cancelled does nothing
                    cancel: function () {
                        //location.reload();
                    }
                }
            });

        })


    </script>



@endsection
