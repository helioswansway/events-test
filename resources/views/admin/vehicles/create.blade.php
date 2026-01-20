@extends('_layouts._dashboard')

@section('content')

    <h1 class="display-4">
        <i class="fas fa-calendar-alt"></i> Add Vehicles
        <span class="h1-button" style="">
            <a href="{{ route('vehicle.index') }}" class="btn btn-border sister"><i class="fas fa-arrow-left mr-2"></i> Back </a>
        </span>
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            @include('admin.inc._messages')
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">Add Vehicles</div>

                <div class="s-card-body px-3 py-0">
                    <form action="/dashboard/vehicles/store"  enctype="multipart/form-data" method="POST">
                            {{csrf_field()}}

                            <div class="row alert-light border-bottom py-2">

                                <div class="col-lg-6">
                                    <label for="brand_id" class="bold">Assign a Brands(s): <span class="text-danger">*</span></label>
                                    <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                        <select name="brand_id" id="brand_id" class="form-control form-control-lg" required>
                                            <option value="">--Select a Brand--</option>

                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach

                                        </select>
                                </div>

                                <div class="col-lg-6">
                                    <label class="bold" for="name">Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="off" class="rounded-0 form-control form-control-lg" required>
                                </div>

                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col">
                                            <input type="file" name="filename" class="form-control form-control-lg" id="filename">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group py-3">
                                <button type="submit" class="btn btn-action sister block"> <i class="fas fa-save mr-2"></i> Save Vehicle </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

    <script>
        $( function() {
            $( "#date" ).datepicker({ dateFormat: 'dd/mm/yy' }).val();

            $(".js-select-dealership").click(function() {
                $(this).parent().toggleClass('bg-light border-white');
            });
        });
    </script>


@endsection
