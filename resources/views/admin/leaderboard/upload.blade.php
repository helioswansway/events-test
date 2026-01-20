@extends('_layouts._dashboard')

@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-upload"></i> Upload Account Users
                <span class="h1-button" style="">
                    <a href="{{url()->previous()}}" class="btn btn-border sister "><i class="fas fa-angle-double-left"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">
                    Upload users:
                </div>

                <div class="s-card-body p-3">

                    <form action="{{route('admin.leaderboard.store')}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}

                        <div class="col-12 px-5 py-3 alert-brother">
                            <p class="fs-120 bold">There's currently <span class="text-info bold fs-150"> {{number_format(count($users))}}</span> Execs in the system.</p>

                            Use this area to ulpoad new users. They will be able to reset a password with the email used in the file.
                        </div>

                        <a href="" class="btn btn-action brand block js-upload mt-3">I want to upload new users</a>

                        <div class="row pb-3 js-leaderboard">
                            <div class="col-12">
                                <div class="row py-3 ">
                                    <div class="col-12 bold ">
                                        <label for="dealership_code">Select Competition: <span class="text-danger">*</span></label>
                                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                        <select name="competition_id" id="competition_id" class=" form-control form-control-lg" required>
                                            <option value="">--Select one--</option>
                                            @foreach($competitions as $competition)
                                                <option value="{{$competition->id}}">{{$competition->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-8">
                                <input type="file" name="filename" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" name="button" class="btn py-1 btn-default sister block "><i class="fas fa-save mr-2"></i> Upload CSV File </button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ URL::to('/') }}/assets/vendor/tinymce/tinymce.min.js"></script>

    @if(count($users) > 0)
        <script>
            $(function(){
                $('.js-leaderboard').addClass('hide');

                $('.js-upload').click(function(e){
                    e.preventDefault()
                    $.confirm({
                    title: 'Confirm!',
                    content: 'Uploading new users will delete all the current ones, are you sure you want to proceed?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    $('.js-leaderboard').toggleClass('hide');
                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '/dashboard/leaderboard/upload';
                        }
                    }
                });


                })

            });

        </script>

    @else

    @endif





@endsection
