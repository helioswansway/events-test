@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4">
        <i class="fas fa-upload"></i> Upload Customer Data
        <span class="h1-button" style="">
            <a href="{{route('customer.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>


    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="s-card shadow">
                <div class="col-12 s-card-header bg-brother">
                    <div class="row">
                        <div class="col">
                            Upload Customer Data
                        </div>
                    </div>
                </div>

                <div class="s-card-body p-3">

                    <form action="{{route('customer.store')}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}

                        <div class="col-12  p-3 alert-sister">
                            <p class="fs-120 bold">There's currently <span class="bold fs-150"> {{number_format($cust_count)}}</span> customers in the system.</p>
                            Use this area to ulpoad new Prospect or update existing ones. They are to be used in the booking Events.
                            <p class="bold mb-0 mt-3">Required Rows</p>
                            <span class="text-danger fs-90">Customer Number, Title, Surname and Email</span> <br>
                            Prospect will be attached to Dealership and Event based on your selection below.

                        </div>

                        <div class="row  my-3">
                            <div class="col-12">
                                <label for="event_id" class="bold">Select an Event <span class="text-danger">*</span></label>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="event_id" id="event_id" class="form-control form-control-lg js-select-event" required>
                                    <option value="">--Select an Event--</option>

                                    @foreach($events as $event)
                                        <option value="{{$event->id}}">{{$event->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row  my-3 js-dealership hide">
                            <div class="col-12">
                                <label for="dealership_code" class="bold">Select Dealership <span class="text-danger">*</span></label>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="dealership_code" id="dealership_code" class="form-control form-control-lg js-select-dealership" required>

                                </select>
                            </div>
                        </div>

                        <div class="row js-upload-file hide">
                            <div class="col-12"> <label for="filename" class="bold">Upload a File <span class="text-danger">*</span></label> </div>

                            <div class="col-lg-8">
                                <input type="file" name="filename" id="filename" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" name="button" class="btn btn-default sister py-1 block "><i class="fas fa-save mr-2"></i> Upload CSV File </button>
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
        $(function(){
            //$('.js-dealership').hide();
            //$('.js-upload-file').hide();


           $('.js-select-event').change(function(){
               var event_id = $(this).val();


               if(event_id != ""){
                    $('.js-dealership').removeClass('hide')

                    $.ajax({
                        url: '/dashboard/customers/get-dealerships?event_id='+event_id,
                            success:function(response){
                                console.log(response);
                                $('.js-select-dealership').html(response);


                                $('.js-select-dealership').change(function(){
                                    var dealership_id = $(this).val();
                                    if(dealership_id != ""){
                                        $('.js-upload-file').removeClass('hide')
                                    }else{
                                        $('.js-upload-file').addClass('hide')
                                    }
                                })
                            }
                    });


               }else{
                    $('.js-dealership').addClass('hide')
                    $('.js-upload-file').addClass('hide')

               }

           })

        });

    </script>



@endsection
