@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4">
        <i class="fas fa-address-card"></i> Exec Details
        <span class="h1-button" style="">
            <a href="{{route('exec.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>


    <form action="{{route('exec.update', [$exec->id])}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="col-12 px-0 pb-3">
                    @include('admin.inc._messages')
                </div>
                <div class="s-card shadow">
                    <div class="s-card-header mb-0 bg-brother">
                        Edit Exec Details:
                    </div>
                    <div class="s-card-body py-0 px-3">
                        <div class="row border-0 alert-brand py-3">
                            <div class="col-12 text-brand bold fs-120">
                                Dealership:
                                <select name="dealership_code" id="dealership_code" class="form-control form-control-lg form-select" required>
                                    <option value="">--Select Dealership--</option>
                                    @foreach($dealerships as $dealership)
                                        <option value="{{$dealership->code}}"
                                            @if($exec->dealership_code == $dealership->code) selected @endif
                                            >{{$dealership->name}}</option>
                                    @endforeach

                                </select>
                                {{-- <input type="hidden" name="dealership_code" value="{{$exec->dealership_code}}" class="col-lg-6 form-control form-control-lg">
                                {{$exec->dealership($exec->dealership_code)}} --}}
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold">
                                Name:
                                <input type="text" name="name" value="{{$exec->name}}" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold">
                                Email:
                                <input type="email" name="email" value="{{$exec->email}}" class="form-control form-control-lg" required>
                            </div>
                        </div>


                        <div class="col-12 my-4">
                            <div class="row py-3 alert-brother lighter rounded shadow-sm border-0 border-white">
                                <div class="col-lg-6 bold">
                                    Password:
                                    <input type="password" name="password" value="" class="form-control form-control-lg">
                                </div>

                                <div class="col-lg-6 bold">
                                    Confirm Password:
                                    <input type="repassword" name="repassword" value="" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>


                        <div class="row ">
                            <div class="col-12 bold">
                                Specialised:
                                <input type="text" name="specialised" value="{{$exec->specialised}}" class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 bold">
                                Description:
                                <textarea name="description" id=""rows="6" class="form-control form-control-lg">{{$exec->description}}</textarea>
                            </div>
                        </div>

                        <div class="row py-3">
                            <div class="col-12 ">
                                <button type="submit" name="button" class="btn btn-action sister block"><i class="fas fa-save mr-2"></i> Save Exec Details </button>
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
