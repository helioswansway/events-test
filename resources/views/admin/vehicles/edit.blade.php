@extends('_layouts._dashboard')


@section('content')



    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-car"></i>
                Edit Model Vehicles
                <span class="h1-button" style="">
                    <a href="{{ route('vehicle.index') }}" class="btn btn-border sister me-2"><i class="fas fa-arrow-left mr-2"></i> Back </a>
                    <a href="/dashboard/vehicles/create" class="btn btn-default sister ">Add Vehicles <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-lg-8">
            @include('admin.inc._messages')
            <div class="s-card shadow">
                <div class="s-card-header bg-brother"> {{$brand->name}} Models </div>

                <div class="s-card-body ">
                    <div class="px-3">
                       <div class="row js-sortable mb-1">
                            @foreach ($vehicles as $vehicle)
                                <div class="drag-item ui-state-default col-lg-2 text-end" style="padding: 10px !important; border: none !important;" id="{{$vehicle->id}}" data-index="{{$vehicle->id}}" data-position="{{$vehicle->position_order}}">
                                    <a href="{{route('vehicle.edit', ['id' => $vehicle->id])}}" title="Edit Vehicle" class="btn btn-sm btn-border  p-1 info "><i class="far fa-edit text-info"></i></a>
                                    <a href="javascript:void(0)" item-id="{{$vehicle->id}}" title="Delete Vehicle" class="btn btn-sm btn-border  p-1 danger js-delete"><i class="fa fa-trash"></i></a>
                                    <img src="{{asset('assets/images/public/general/')}}/{{$vehicle->filename}}" alt="" class="border block rounded">
                                    <div class="text-center fs-80 bold border-bottom">
                                        {{$vehicle->name}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $( function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $( ".js-sortable" ).sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('position-updated');
                        }
                    });
                    savePositions();
                }
            });

            function savePositions() {
                    var positions = [];
                    $('.position-updated').each(function () {
                        positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                        $(this).removeClass('updated');
                    });

                    $.ajax({
                        url:'/dashboard/vehiclePosition',
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
                content: 'Are you sure you want to delete Vehicle?',
                buttons: {
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {


                                var url = '{{ route('vehicle.delete', ":id") }}';
                                url = url.replace(':id',item_id);
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


    </script>


@endsection
