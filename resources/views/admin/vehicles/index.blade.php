@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-car"></i>
                Vehicles
                <span class="h1-button" style="">
                    <a href="/dashboard/vehicles/create" class="btn btn-default sister">Add Vehicles <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>
    <h1 class="display-4"></h1>

    @include('admin.inc._messages')

    <div class="s-card shadow">
        <div class="s-card-header bg-brother">Brands</div>

        <div class="s-card-body px-3 py-0">
            @if(count($vehicles) > 0)

                @foreach($vehicles as $vehicle)
                    <div class="row s-card-row py-1">
                        <div class="col-3 border-right bold">
                            <img src="{{asset('assets/images/public/general/')}}/{{$vehicle->brand->filename}}" alt="" class="fluid-img img-thumbnail " style="width:30px;" >
                            {{$vehicle->brand->name}}

                        </div>

                        <div class="col text-end ">
                            <a href="{{route('vehicle.edit.by.brand', ['id' => $vehicle->brand->id])}}" class="btn btn-sm btn-border  p-1 info" title="Edit Vehicles"><i class="far fa-edit"></i></a>
                        </div>
                    </div>
                @endforeach

            @else

                <div class="row">
                    <div class="col-12 alert-warning text-dark border border-warning py-3">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                </div>

            @endif
        </div>



    </div>


@endsection


@section('scripts')
    <script>


    </script>


@endsection
