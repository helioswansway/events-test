@extends('_layouts._dashboard')

@section('content')

    <h1 class="display-4">
        <i class="fab fa-houzz"></i> Edit Dealership
        <span class="h1-button" style="">
            <a href="{{ route('dealership.index') }}" class="btn btn-border sister"><i class="fas fa-arrow-left mr-2"></i> Back </a>
        </span>
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-6 ">
            @include('admin.inc._messages')
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow ">
                <div class="s-card-header bg-brother">
                    Dealership
                </div>

                <div class="s-card-body px-3 py-0">
                    <form action="{{route('dealership.update', [$dealership->id])}}" method="POST">

                        {{ method_field('POST') }}
                        {{csrf_field()}}

                        <div class="col-12 px-0 bold pb-3 mt-3">
                            <label for="brand_id">Brand: <span class="text-danger">*</span></label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="brand_id" id="brand_id" class="form-control form-control-lg">
                                <option value="">Select Dealership</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}"
                                    @if($brand->id == $dealership->brand_id)
                                        selected
                                    @endif
                                    >{{$brand->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('brand_id'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('brand_id') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-12 bold alert-brother pb-2 ">
                            <div class="row">
                                <div class="col-lg-6 mt-2 bold">
                                    <label for="brand_manager">Brand Manager Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="brand_manager" id="brand_manager" value="{{ $dealership->brand_manager }}" class="form-control form-control-lg" required>
                                </div>
                                <div class="col-lg-6 mt-2 bold">
                                    <label for="brand_manager_email">Brand Manager Email: <span class="text-danger">*</span></label>
                                    <input type="email" name="brand_manager_email" id="brand_manager_email" value="{{ $dealership->brand_manager_email }}" class="form-control form-control-lg" required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 mt-2 bold">
                                <label for="name">Dealership Name: <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ $dealership->name }}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-6 mt-2 bold">
                                <label for="code">Dealership Code: <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" value="{{ $dealership->code }}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-6 mt-2 bold">
                                <label for="email">Email: <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" value="{{ $dealership->email }}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-6 mt-2 bold">
                                <label for="website">Website: <span class="text-danger">*</span></label>
                                <input type="text" name="website" id="website" value="{{ $dealership->website }}" class="form-control form-control-lg" required>
                            </div>


                            <div class="col-lg-6 mt-2 bold">
                                <label for="slug">Slug: <span class="text-danger">*</span>  <small>(For text message purpose)</small> </label>
                                <input maxlength="11" type="text" name="slug" id="name" value="{{ $dealership->slug }}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-6 mt-2 bold">
                                <label for="phone">Phone: <span class="text-danger">*</span> <small>(Main Dealership Phone)</small> </label>
                                <input type="text" name="phone" id="phone" value="{{ $dealership->phone }}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-6 mt-2 bold">
                                <label for="cc_phone">CC Phone:  <small>(Different number for use if required, i.e. tracking purposes)</small></label>
                                <input type="text" name="cc_phone" id="cc_phone" value="{{ $dealership->cc_phone }}" class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="form-group row py-4">
                            <div class="col">
                                <button type="submit" class="btn btn-action sister block"> <i class="fas fa-save mr-2"></i> Save Dealership </button>
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


</script>


@endsection
