@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4">
        <i class="fas fa-user-plus"></i> Add Exec
        <span class="h1-button" style="">
            <a href="{{route('exec.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>


    @include('admin.inc._messages')
    <form action="{{route('exec.store.exec')}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="s-card shadow">
                    <div class="s-card-header mb-0 bg-brother">
                        <div class="row">
                            <div class="col">Enter Exec Details:</div>
                        </div>

                    </div>
                    <div class="s-card-body border-top py-0 px-3">
                        <div class="row pt-3">
                            <div class="col-12 pt-0 relative bold">
                                <label for="dealership_code">Dealership: <span class="text-danger">*</span></label>
                                <select name="dealership_code" id="dealership_code" class=" form-control form-control-lg" required>
                                    <option value="">--Select a dealership--</option>
                                    @foreach($dealerships as $dealership)
                                        <option value="{{$dealership->code}}">{{$dealership->name}}</option>
                                    @endforeach
                                </select>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold">
                                <label for="name">Name: <span class="text-danger">*</span></label>

                                <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold">
                                <label for="email">Email: <span class="text-danger">*</span></label>

                                <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold">
                                <label for="specialised">Specialised:</label>

                                <input type="text" id="specialised" name="specialised" value="{{old('specialised')}}" class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold ">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description"rows="6" class="form-control form-control-lg">{{old('description')}}</textarea>
                            </div>
                        </div>

                        <div class="row py-3">
                            <div class="col-12 bold ">
                                <button type="submit" name="button" class="btn btn-action sister block"><i class="fas fa-save mr-2"></i> Save Exec </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('scripts')



@endsection
