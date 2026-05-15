@extends('_layouts._dashboard')

@section('content')

    <h1 class="display-4">
        <i class="fab fa-houzz"></i> Create Dealership
        <span class="h1-button" style="">
            <a href="{{ route('dealership.index') }}" class="btn btn-border sister"><i class="fas fa-arrow-left mr-2"></i> Back </a>
        </span>
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-6 py-3">
            @include('admin.inc._messages')
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow ">
                <div class="s-card-header bg-brother">
                    Dealership
                </div>

                <div class="s-card-body p-0">
                    <form action="{{route('dealership.store')}}" method="POST">
                        {{csrf_field()}}

                        <div class="col-12 bold border-bottom border-0 my-3">
                            <label for="brand_id">Brand: <span class="text-danger">*</span></label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="brand_id" id="brand_id" class="form-control form-control-lg" required>
                                <option value="">Select Dealership</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="col-12 bold alert-brother pb-3">
                                <div class="row">
                                    <div class="col-lg-6 mt-2 bold">
                                        <label for="brand_manager">Brand Manager Name: <span class="text-danger">*</span></label>
                                        <input type="text" name="brand_manager" id="brand_manager" value="{{ old('brand_manager') }}" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-lg-6 mt-2 bold">
                                        <label for="brand_manager_email">Brand Manager Email: <span class="text-danger">*</span></label>
                                        <input type="email" name="brand_manager_email" id="brand_manager_email" value="{{ old('brand_manager_email') }}" class="form-control form-control-lg" required>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="row pb-3-4">
                                <div class="col-lg-6 mt-2 bold">
                                    <label for="name">Dealership Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control form-control-lg" required>
                                </div>

                                <div class="col-lg-6 mt-2 bold">
                                    <label for="code">Dealership Code: <span class="text-danger">*</span></label>
                                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control form-control-lg" required>
                                </div>

                                <div class="col-lg-6 mt-2 bold">
                                    <label for="email">Email: <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-lg" required>
                                </div>

                                <div class="col-lg-6 mt-2 bold">
                                    <label for="website">Website: <span class="text-danger">*</span></label>
                                    <input type="text" name="website" id="website" value="{{ old('website') }}" class="form-control form-control-lg" required>
                                </div>


                                <div class="col-lg-6 mt-2 bold">
                                    <label for="slug">Slug: <span class="text-danger">*</span>  <small>(For text message purpose)</small> </label>
                                    <input maxlength="11" type="text" name="slug" id="name" value="{{ old('slug') }}" class="form-control form-control-lg" required>
                                </div>

                                <div class="col-lg-6 mt-2 bold">
                                    <label for="phone">Phone: <span class="text-danger">*</span> <small>(Main Dealership Phone)</small> </label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control form-control-lg" required>
                                </div>

                                <div class="col-lg-6 mt-2 bold">
                                    <label for="cc_phone">CC Phone:  <small>(Different number for use if required, i.e. tracking purposes)</small></label>
                                    <input type="text" name="cc_phone" id="cc_phone" value="{{ old('cc_phone') }}" class="form-control form-control-lg">
                                </div>
                            </div>


                        </div>

                            <div class="col py-3">
                                <button type="submit" class="btn btn-action sister block"> <i class="fas fa-save mr-2"></i> Save Dealership </button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
<script>
    var maxLength = 11;
    $('#slug').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#count').text(textlen);
    });

    $( function() {
        $(".js-select-dealership").click(function() {
            $(this).parent().toggleClass('bg-secondary text-white');
        });

        $("#selectAll").click(function() {
            $('.js-select-dealership').parent().toggleClass('bg-secondary text-white');
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });

        $("input[type=checkbox]").click(function() {
            if (!$(this).prop("checked")) {
                $("#selectAll").prop("checked", false);
            }
        });
    } );


</script>


@endsection
