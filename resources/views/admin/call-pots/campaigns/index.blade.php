@extends('_layouts._dashboard')


@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fa-solid fa-bullhorn side-nav-icon"></i> Manage Campaigns
                <span class="h1-button" style="">
                    <a href="{{route('admin.pot-list.index')}}" class="btn btn-border brand me-2 px-2"><i class="fas fa-angle-double-left me-1"></i> Pot List </a>

                    <a href="{{route('admin.pot-campaign.create')}}" class="btn btn-border sister">Create Campaing <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>


    @include('admin.inc._messages')

    <div class="s-card shadow">
        <div class="s-card-header bg-brother">
            <div class="row">
                <div class="col-3 border-right">
                    Campaign Name
                </div>
                <div class="col-1 text-center border-right">
                    Active
                </div>
                <div class="col-2 text-center border-right">
                    Created At
                </div>
                <div class="col-2 text-center">
                    End date
                </div>
                <div class="col ">

                </div>
            </div>

        </div>

        <div class="s-card-body px-3 py-0">

            @if(count($campaigns) > 0)

                <div class="js-sortable">
                    @foreach($campaigns as $campaign)
                        <div class="row s-card-row py-2" id="{{$campaign->id}}" data-index="{{$campaign->id}}" data-position="{{$campaign->position_order}}">

                            <div class="col-3 border-right bold">
                                <i class="fa-solid fa-up-down-left-right me-1"></i>    {{$campaign->name}}
                            </div>
                            <div class="col-1 border-right bold text-center">
                                {!! $campaign->active == 1 ? '<i class="fas fa-thumbs-up text-success"></i>' : ' <i class="fas fa-thumbs-down text-danger"></i>' !!}
                            </div>
                            <div class="col-2 border-right bold text-center">
                                {{$campaign->created_at}}
                            </div>
                            <div class="col-2 border-right bold text-center">
                                {{$campaign->end_date}}
                            </div>
                            <div class="col text-end">
                                <a href="{{route('admin.pot-campaign.edit', ['id' => $campaign->id])}}" class="btn btn-sm btn-border  p-1 info " title="Edit Pot Campaign"><i class="far fa-edit"></i></a>

                                <a href="javascript:void(0)" item-id="{{$campaign->id}}" class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Pot Campaign"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else

                <div class="row">
                    <div class="col-12 alert-warning lighter text-dark border border-warning py-2 bold fs-110">
                        <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif



        </div>

    </div>


@endsection


@section('scripts')
    <script>

        $( function() {

            $(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })

            // $(".js-sortable-cancel").sortable({
            //     items: ".cancel"
            // });

            $( ".js-sortable" ).sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('position-updated');
                        }
                    })

                    savePositions();
                },

            });



            function savePositions() {
                    var positions = [];
                    $('.position-updated').each(function () {
                        positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                        $(this).removeClass('updated');
                    });

                    $.ajax({
                        url:'/dashboard/pot-campaign/itemPosition',
                        method:'POST',
                        dataType: 'text',
                        data: {
                            update:1,
                            positions:positions
                        },success:function(response){
                            console.log(response);
                        }
                    });

            }

        } );

        //Asks Admin to confirm deletion
        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Campaign?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('admin.pot-campaign.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;
                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '{{ route('admin.pot-campaign.index') }}';
                        }
                    }
                });

        })

    </script>


@endsection
