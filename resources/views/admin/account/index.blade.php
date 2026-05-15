@extends('_layouts._dashboard')

@section('content')
    <h1 class="display-4 "><i class="fas fa-users"></i> Update Details</h1>
    @include('admin.inc._messages')

    <div class="row justify-content-center">

        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">Current Details</div>

                <div class="s-card-body p-3">
                    <form action="{{route('admin.update-account',[$admin->id])}}" method="post">
                        @csrf @method('patch')

                        <div class="mb-3">
                            <label for="name" class="bold">Name</label>
                            <input type="text" value=" {{auth('admin')->user()->name}} " name="name" class="form-control form-control-lg" id="name">
                        </div>

                        <div class="row g-3">

                            <div class="col-lg-6">
                                <label for="job_title" class="bold">Job Title: <span class="text-danger">*</span></label>
                                <input id="job_title" type="text" class="form-control form-control-lg" name="job_title" value="{{auth('admin')->user()->job_title}}" required/>
                                @if ($errors->has('job_title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('job_title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-6 bold">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg" value="{{auth('admin')->user()->email}}">
                                @if ($errors->has('email'))
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="py-2"></div>

                        <div class="row g-3">
                            <div class="col-lg-6 bold">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" value="{{auth('admin')->user()->phone}}" class="form-control form-control-lg">
                                @if ($errors->has('phone'))
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6 bold">
                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                <input type="number" name="mobile" value="{{auth('admin')->user()->mobile}}" class="form-control form-control-lg">
                                @if ($errors->has('mobile'))
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="mt-3">
                            <button type="submit" class="btn btn-action block sister"> <i class="fas fa-save"></i> Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
