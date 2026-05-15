@extends('_layouts._dashboard')

@section('content')
    <h1 class="display-4"><i class="fas fa-cogs"></i> Site Configuration</h1>

    @include('admin.inc._messages')


    <form action="/dashboard/site-configuration/{{$config->id}}" enctype="multipart/form-data" method="POST">

        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">


        <div class="s-card shadow">
            <div class="s-card-header bg-brother">Edit Site Configuration</div>
            <div class="s-card-body px-3 pb-5">
                <div class="s-card">
                    <div class="s-card-header  alert-light">Address Details</div>
                    <div class="s-card-body ">
                        <div class="row">
                            <div class="col-lg-12 mb-3 bold">
                                <label for="company_name">Company Name: <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" id="company_name" value="{{$config->company_name}}" required="required" class="form-control form-control-lg">
                            </div>
                            <div class="col-lg-6 bold">
                                <label for="filename">Company Logo: </label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="filename" class="col alert-brand">
                                            <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" title="Company Logo" class="img-fluid py-2">
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="file" id="filename" name="filename" class="form-control form-control-lg">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 bold">
                                <label for="filename">Company Logo (Contrast):</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="filename" class="col bg-brand mt-0">
                                            <img src="{{asset('assets/images/public/general/')}}/{{$config->filename_contrast}}" alt="" title="Company Logo" class="img-fluid py-2">
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="file" id="filename_contrast" name="filename_contrast" class="form-control form-control-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6 bold mb-2">
                        <label for="phone">Phone: <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{$config->phone}}" class="form-control form-control-lg" required>
                    </div>


                    <div class="col-lg-6 bold mb-2">
                        <label for="email">Email: <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{$config->email}}" id="email" class="form-control form-control-lg" required>
                    </div>

                    <div class="col-lg-6 bold mb-2">
                        <label for="address">Address: <span class="text-danger">*</span></label>
                        <input type="text" name="address" id="address" value="{{$config->address}}" class="form-control form-control-lg" required>
                    </div>



                    <div class="col-lg-6 bold mb-2">
                        <label for="address_1">Address 1:</label>
                        <input type="text" name="address_1" id="address_1" value="{{$config->address_1}}" class="form-control form-control-lg">
                    </div>

                    <div class="col-lg-6 bold mb-2">
                        <label for="town">Town: <span class="text-danger">*</span></label>
                        <input type="text" name="town" id="town" value="{{$config->town}}" class="form-control form-control-lg" required>
                    </div>

                    <div class="col-lg-6 bold mb-2">
                        <label for="county">County: <span class="text-danger">*</span></label>
                        <input type="text" name="county" id="county" value="{{$config->county}}" class="form-control form-control-lg" required>
                    </div>


                    <div class="col-lg-6 bold mb-2">
                        <label for="post_code">Post Code: <span class="text-danger">*</span></label>
                        <input type="text" name="post_code" id="post_code" value="{{$config->post_code}}" class="form-control form-control-lg" required>
                    </div>
                </div>

                <div class="form-group row mb-0 mt-2">
                    <div class="col">
                        <button type="submit" name="button" class="btn btn-default sister"><i class="fas fa-save mr-2"></i> Save Site Configuration </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection




@section('scripts')

<script>
        $( function() {
          $( "#tabs" ).tabs();
        } );
</script>

@endsection
