@extends('_layouts._dashboard')


@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-chalkboard-teacher"></i> Prospects Overview for <em>{{$dealership->name}}</em>
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.prospect', [$event_id, $dealership->id])}}" class="btn btn-border brand"><i class="fas fa-chalkboard-teacher mr-2"></i> Prospects</a>

                    <a href="{{route('admin.appointment.index')}}" class="btn btn-border brother"><i class="fas fa-calendar-check mr-2"></i> Appointments</a>
                </span>
            </h1>
        </div>
    </div>

    <input type="hidden" name="event_id" id="event_id" value="{{$event_id}}">
    <input type="hidden" name="dealership_code" id="dealership_code" value="{{$dealership->code}}">

    @include('admin.inc._messages')

    <div class="s-card border-0">
        <div class="col-12">
            <div class="row  border-0 border-bottom mb-1">
                <div class="col-lg-12 text-end pt-2 mb-1 fs-90">
                    <span class="icon-list hide"> <span class="icon-name"> New Prospect</span> <span class="icon booked-circle bg-dark "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Confirmed</span> <span class="icon booked-circle bg-success "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Not Interested</span> <span class="icon booked-circle alert-info "></span> </span>

                    <div class="mob-space"></div>
                    <span class="icon-list"> <span class="icon-name"> Require Call Back</span> <span class="icon booked-circle bg-warning "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Call Made</span> <span class="icon booked-circle alert-other "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Hot Prospect</span> <span class="icon booked-circle alert-danger "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Cancelled</span> <span class="icon booked-circle bg-danger "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Sale</span> <span class="icon booked-circle alert-success "></span> </span>
                </div>
            </div>
        </div>

        <div class="js-results">
            @include('admin.appointments._results-registered')
        </div>

    </div>

@endsection


@section('scripts')
    <script>
        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page        = $(this).attr('href').split('page=')[1];
            var search      = $('#keyword').val();
            var event_id    = $('#event_id').val();
            var dealership_code        = $('#dealership_code').val();

            fetch_data(page, search, event_id, dealership_code);



        });

        function fetch_data(page, search, event_id, dealership_code){
            $.ajax({
                url: '/dashboard/prospects/fetchData?page='+page + "&keyword=" + search+ "&event_id=" + event_id + "&dealership_code=" + dealership_code,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }

        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();

            var search      = $('#keyword').val();
            var page = $('#hidden_page').val();
            var event_id  = $('#event_id').val();
            var dealership_code  = $('#dealership_code').val();
            fetch_data(page, search, event_id, dealership_code);

        });


    </script>
@endsection
