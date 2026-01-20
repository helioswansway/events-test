@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="far fa-image"></i>  Create Wallpaper
                <span class="h1-button" style="">
                    <a href="{{route('admin.wallpaper.index')}}" class="btn btn-border sister"><i class="fas fa-arrow-left mr-2"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">Wallpaper</div>

                <div class="s-card-body px-0 py-3">
                    <div class="col-12">
                        <form action="{{route('admin.wallpaper.store')}}" enctype="multipart/form-data" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="name" class="bold">Name:  <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('name') }}" name="name" class="form-control form-control-lg" id="name" required>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="path" class="bold">Path:  <span class="text-danger">*</span> {{url('/')}}/{{ old('path') }}</label>
                                        <input type="text" value="{{ old('path') }}" name="path" class="form-control form-control-lg" id="path" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col mb-2">
                                        <label for="description" class="bold">Description:  <span class="text-danger">*</span></label>
                                        <textarea type="text" rows="4" name="description" class="form-control form-control-lg" id="description" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  mt-3">
                                <label for="filename" class="font-weight-bold">Wallpaper: <span class="text-danger">*</span></label>
                                <input type="file" name="filename" class="form-control form-control-lg" id="filename">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="width" class="bold">Width:  <span class="text-danger">*</span></label>
                                        <select name="width" id="width" class="form-control form-control-lg" required>
                                            <option value="">--Select Width Size--</option>
                                            <option value="1920">1920 - (Full screen - registration form)</option>
                                            <option value="1200">1200 - (Half screen - login)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="height" class="bold">Height:  <span class="text-danger">*</span></label>
                                        <select name="height" id="height" class="form-control form-control-lg" required>
                                            <option value="">--Select Height Size--</option>
                                            <option value="1080">1080 - (Full screen - registration form)</option>
                                            <option value="1000">1000 - (Half screen - login)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group pt-3">
                                <button type="submit" class="btn btn-action block sister"> <i class="fas fa-save mr-2"></i> Save Wallpaper  </button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>


    </script>


@endsection
