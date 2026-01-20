@extends('_layouts._dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fab fa-black-tie"></i> Edit Brand
                <span class="h1-button" style="">
                    <a href="{{route('brand.index')}}" class="btn btn-border sister"><i class="fas fa-arrow-left mr-3"></i> Back </a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">Brand</div>
                <div class="s-card-body px-3">
                    <form action="{{route('brand.update', [$brand->id])}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        {{ method_field('POST') }}

                        <div class="form-group">
                            <label for="name" class=" bold">Name</label>
                            <input type="text" value="{{ $brand->name }}" name="name" class="form-control form-control-lg" id="name" required>

                        </div>

                        <div class="form-group mt-3">
                            <img src="{{asset('assets/images/public/general/')}}/{{$brand->filename}}" class="fluid-img img-thumbnail mr-1" class="border" style="height:40px" title="{{$brand->name}} Logo">
                            <label for="filename" class="bold">Brand Logo: <span class="text-danger">*</span></label>
                            <input type="file" name="filename" class="form-control form-control-lg mt-2" id="filename">
                        </div>

                        <div class="form-group pt-2 pb-1">
                            <button type="submit" class="btn btn-action sister block"> <i class="fas fa-save mr-2"></i> Save Brand  </button>
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
