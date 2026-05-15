@extends('_layouts._dashboard')

@section('content')
    <div class="row pop-up-wrapper"></div>

    <h1 class="display-4"><i class="fas fa-user-plus"></i> Add Exec
        <span class="h1-button" style="">
            <a href="{{route('admin.leaderboard.get.execs')}}" class="btn btn-border sister "><i class="fas fa-angle-double-left"></i> Back</a>
        </span>
    </h1>


    @include('admin.inc._messages')
    <form action="{{route('admin.leaderboard.store.exec')}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}


        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="s-card shadow">
                    <div class="s-card-header bg-brother">
                        <div class="row">
                            <div class="col">Enter Exec Details:</div>
                        </div>
                    </div>

                    <div class="s-card-body px-3 py-3">
                        <div class="row">
                            <div class="col-12 bold ">
                                <label for="dealership_code">Dealership: <span class="text-danger">*</span></label>
                                    <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                    <select name="dealership_code" id="dealership_code" class=" form-control form-control-lg" required>
                                        <option value="">--Select a dealership--</option>
                                        @foreach($dealerships as $dealership)
                                            <option value="{{$dealership->code}}">{{$dealership->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="s-card rounded p-3 border alert-brother mt-3">

                                <div class="s-card-header rounded bg-brand pt-2 pb-0 mb-1">
                                    <div class="row">
                                        <div class="col pt-1">Assign Competitions to Execs</div>
                                        <div class="col text-end">
                                            <label class="border rounded px-2 py-1 fs-90 alert-light ml-3">
                                                <input type="checkbox" id="selectAll" value="10" class="js-select-competition mr-2">
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <label class="mb-0 bold" for="dealership_code">Competitions: <span class="text-danger">*</span></label>
                                <div class="s-card-body border-0">
                                    <div class="row ">
                                        @foreach($competitions as $competition)
                                            <label class="col-lg-6 border bg-white p-2 m-0  fs-90"
                                            >
                                                <input type="checkbox" name="competition_id[]" class="js-select-competition" value="{{$competition->id}}">
                                                {{$competition->name}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row  pt-3 pb-2">
                                <div class="col-12 ">
                                    <div class="row">
                                        <div class="col bold"><label for="job_title_id">Job Title: <span class="text-danger">*</span></label></div>
                                        <div class="col text-end pb-1">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default light px-2 py-0 me-1 js-job-title"><i class="fas fa-user-tie me-1"></i> Add Job Title</a>
                                        </div>
                                    </div>
                                    <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                    <select name="job_title_id" id="job_title_id" class=" form-control form-control-lg" required>
                                        <option value="">--Select a Job--</option>
                                        @foreach($job_titles as $job)
                                            <option value="{{$job->id}}">{{$job->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 bold pb-2">
                                    <label for="name">User/Exec Name: <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control form-control-lg" required>
                                </div>

                                <div class="col-lg-6 bold pb-2">
                                    <label for="email">Email: <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control form-control-lg" required>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" name="button" class="btn btn-action sister block"><i class="fas fa-save mr-2"></i> Save Exec </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection


@section('scripts')


<script>
        $( function() {

            //Shows pop up to create, edit and delete Job Title information
            $('.js-job-title').click(function(){
                //Removes overflow class from body tag if exists one
                $('body').addClass('overflow');

                // Adds .fade-in class
                // Removes .fade-out class if exists

                $.ajax({
                    url: '/dashboard/job-title/create',
                        success:function(data){
                            console.log(data);
                            setTimeout(function(){
                                $('.pop-up-wrapper').fadeIn('slow').html(data);
                            }, 400);
                    }
                });

            })

            $(".js-select-competition").click(function() {
                $(this).parent().toggleClass('alert-sister border-white');
            });

            $("#selectAll").click(function() {
                $('.js-select-competition').parent().toggleClass('alert-sister border-white');
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
