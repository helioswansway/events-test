@extends('_layouts._exec-dashboard')

@section('content')
    <h1 class="display-4 "><i class="fas fa-users"></i> Update Details</h1>

    <form action="{{route('exec.account.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
        @csrf
        @method('patch')
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @include('admin.inc._messages')
                <div class="s-card shadow">
                    <div class="s-card-header bg-brother">Current Details</div>

                    <div class="s-card-body p-3">
                        <div class="row d-flex align-items-center">
                            <label for="filename" class="bold px-3 pt-2">Your Avatar: </label>
                            <div class="col-lg-4  mb-3">
                                @if($exec->filename == "")
                                    <label for="filename">
                                        <img src="{{asset('assets/images/')}}/avatar.jpg" alt="" style="width:255px; height: auto;" class="img-fluid mr-3 border p-2" title="You Avatar">
                                    </label>
                                @else
                                    <img src="{{asset('assets/images/public/general/')}}/{{$exec->filename}}" alt="" style="width:255px; height: auto;" class="img-fluid mr-3 border p-2" title="{{$exec->name}}">
                                @endif
                            </div>
                            <div class="col-lg-8">
                                <input type="file" name="filename" id="filename" class="form-control form-control-lg">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name" class="bold pt-2">Dealership: </label>
                                <input type="text" value="{{ $exec->dealership($exec->dealership_code) }}" name="dealership_code" class="form-control form-control-lg" id="name" disabled>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="specialised" class="bold pt-2">Specialization:</label>
                                <input type="text" value="{{ $exec->specialised }}" name="specialised" class="form-control form-control-lg" id="specialised">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <label for="name" class="bold pt-2">Name: <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $exec->name }}" name="name" class="form-control form-control-lg" id="name" required>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="email" class="bold pt-2">Email: <span class="text-danger">*</span></label>
                                <input type="email" value="{{ $exec->email }}" name="email" class="form-control form-control-lg" id="email" required>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="mobile" class="bold pt-2">Mobile: <span class="text-danger">*</span></label>
                                <input type="mobile" value="{{ $exec->mobile }}" name="mobile" class="form-control form-control-lg" id="mobile" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="description" class="bold">Description:</label>
                                <textarea name="description" class="form-control form-control-lg" id="description" rows="8">{{ $exec->description }}</textarea>
                            </div>
                        </div>

                        <div class="mt-3 mb-2">
                            <button type="submit" name="button" class="btn btn-action brother block">Save <i class="fa fa-angle-double-right"></i></button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
