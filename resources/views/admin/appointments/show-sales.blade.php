@extends('_layouts._dashboard')


@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-chalkboard-teacher"></i> Sales for <em>{{$dealership->name}}</em> <span class="text-sister fs-60 ms-1 border border-warning rounded-circle" style="padding:4px;">{{count($sales)}}</span>
                <span class="h1-button" style="">
                    <a href="{{url()->previous()}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-1"></i> Back </a>
                    <a href="{{route('admin.appointment.reception', [$dealership->id])}}" class="btn btn-border brother"><i class="fas fa-concierge-bell"></i> Reception </a>
                    <a href="{{route('admin.appointment.prospect', [$event_id, $dealership->id])}}" class="btn btn-border brother"><i class="fas fa-chalkboard-teacher mr-2"></i> Prospects</a>
                    <a href="{{route('admin.appointment.index')}}" class="btn btn-border brother"><i class="fas fa-calendar-check mr-2"></i> Appointments</a>
                </span>
            </h1>
        </div>
    </div>


    <input type="hidden" name="event_id" id="event_id" value="{{$event_id}}">
    <input type="hidden" name="dealership_code" id="dealership_code" value="{{$dealership->code}}">

    @include('admin.inc._messages')

    <div class="s-card border-0">
        <div class="js-results">
            @include('admin.appointments._results-show-sales')
        </div>

    </div>

@endsection


@section('scripts')
    <script>
        $('.js-refresh').click(function(){
            location.reload();
        })

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
