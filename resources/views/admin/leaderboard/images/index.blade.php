@extends('_layouts._dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-image"></i> Create Leaderboard Image</h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="s-card shadow">
                <div class="s-card-header">
                    <div class="row pt-2">
                        <div class="col">
                            Upload Image
                        </div>
                    </div>
                </div>

                <div class="s-card-body py-3">
                    <div class="col-12">
                        <form action="{{route('admin.competition.store.image')}}" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="competition_id" value="{{$competition}}">
                            {{csrf_field()}}

                            <div class="form-group row mt-3 mb-4">
                                <div class="col-lg-3 bold">
                                    <label for="filename" class="font-weight-bold">Brand: <span class="text-danger">*</span></label>
                                </div>

                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <select name="brand_id" id="" class="form-control form-control-lg" required>
                                                <option value="">--Select a Brand--</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-lg-3 bold">
                                    <label for="filename" class="font-weight-bold">Competition Banner: <span class="text-danger">*</span></label>
                                </div>

                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="file" name="filename" class="form-control form-control-lg" id="filename" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <div class="col offset-lg-3">
                                    <button type="submit" class="btn btn-sm  btn-default sister"> <i class="fas fa-save mr-2"></i> Save Image  </button>

                                    <a href="{{route('admin.leaderboard.index')}}" class="btn btn-sm  btn-default brother float-end"><i class="fas fa-chart-bar mr-2"></i> Leaderboard</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>



    <div class="py-5 my-3"></div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>


    </script>



@endsection
