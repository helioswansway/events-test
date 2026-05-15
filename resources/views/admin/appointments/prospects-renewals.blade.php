@extends('_layouts._dashboard')


@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-chalkboard-teacher"></i> Renewals Prospects Overview for <em>{{$dealership->name}}</em>
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.prospect', [$event_id, $dealership->id])}}" class="btn btn-border brother"><i class="fas fa-chalkboard-teacher mr-2"></i> Prospects</a>
                </span>
            </h1>
        </div>
    </div>


    <input type="hidden" name="event_id" id="event_id" value="{{$event_id}}">
    <input type="hidden" name="dealership_code" id="dealership_code" value="{{$dealership->code}}">

    @include('admin.inc._messages')

    <div class="s-card border-0">
        <div class="s-card-header border-0 px-0">
            <div class="row pt-3 border-0 border-bottom mb-1">
                <div class="col-lg-3">
                    <input type="text" id="keyword" class="form-control form-control-lg shadow-sm py-3" placeholder="Search Customers by (Customer Number, Name or Email)">
                </div>

                <div class="col-lg-9 text-end pt-2 mb-1 fs-80 pl-0 bold">

                    <a href="javascript:void(0)" class="float-start js-refresh btn btn-border brand text-center px-1 py-0" title="Refresh"><i class="fas fa-sync fs-120"></i></a>

                    <span class="icon-list hide"> <span class="icon-name"> New Prospect</span> <span class="icon booked-circle bg-dark "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Not Interested</span> <span class="icon booked-circle alert-info "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Cancelled</span> <span class="icon booked-circle bg-danger "></span> </span>

                    <div class="mob-space"></div>
                    <span class="icon-list"> <span class="icon-name"> Require Call Back</span> <span class="icon booked-circle bg-warning "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Call Made</span> <span class="icon booked-circle alert-other "></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Sale</span> <span class="icon booked-circle alert-success "></span> </span>
                    <a href="javascript:void(0)" class="js-completed"><span class="icon-list"> <span class="icon-name"> Completed</span> <span class="icon booked-circle bg-sister "></span></span></a>
                    <a href="javascript:void(0)" class="js-hot-prospect"><span class="icon-list"> <span class="icon-name"> Hot Prospect</span> <span class="icon booked-circle alert-danger"></span></span></a>
                    <a href="javascript:void(0)" class="js-in-progress"><span class="icon-list"> <span class="icon-name"> In Progress</span> <span class="icon booked-circle border border-warning"></span> </span></a>
                    <a href="javascript:void(0)" class="js-confirm"><span class="icon-list"> <span class="icon-name"> Confirmed</span> <span class="icon booked-circle bg-success "></span></span></a>

                </div>

            </div>
        </div>

        <div class="js-results">
            @include('admin.appointments._results-renewals')
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
                url: '/dashboard/prospects/fetchRenewalsData?page='+page + "&keyword=" + search+ "&event_id=" + event_id + "&dealership_code=" + dealership_code,
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

        $('.js-refresh').click(function(){
            location.reload();
        })

        $('.js-in-progress').click(function(){
            $(this).addClass('bold rounded p-2 border')
            $('.js-hot-prospect, .js-completed,.js-confirm').removeClass('bold rounded p-2 border')
            fetch_in_progress_data();
        })

        function fetch_in_progress_data(){
            var dealership_code     = $('#dealership_code').val();
            var event_id            = $('#event_id').val();
            $.ajax({
                url: '/dashboard/prospects/fetchInProgressData?dealership_code=' + dealership_code+ "&event_id=" + event_id ,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }


        $('.js-confirm').click(function(){
            $(this).addClass('bold rounded p-2 border')
            $('.js-hot-prospect, .js-completed').removeClass('bold rounded p-2 border')
            fetch_confirm_data();
        })

        function fetch_confirm_data(){
            var dealership_code     = $('#dealership_code').val();
            var event_id            = $('#event_id').val();
            $.ajax({
                url: '/dashboard/prospects/fetchConfirmedData?dealership_code=' + dealership_code+ "&event_id=" + event_id ,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }


        $('.js-hot-prospect').click(function(){
            $(this).addClass('bold rounded  p-2 border');
            $('.js-confirm, .js-completed').removeClass('bold rounded p-2 border')
            fetch_hot_prospect_data();
        })


        function fetch_hot_prospect_data(){
            var dealership_code     = $('#dealership_code').val();
            var event_id            = $('#event_id').val();
            $.ajax({
                url: '/dashboard/prospects/fetchHotProspectData?dealership_code=' + dealership_code+ "&event_id=" + event_id ,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }

        $('.js-completed').click(function(){
            $(this).addClass('bold rounded  p-2 border');
            $('.js-confirm, .js-hot-prospect').removeClass('bold rounded p-2 border')
            fetch_completed_data();
        })

        function fetch_completed_data(){
            var dealership_code     = $('#dealership_code').val();
            var event_id            = $('#event_id').val();

            $.ajax({
                url: '/dashboard/prospects/fetchCompletedData?dealership_code=' + dealership_code+ "&event_id=" + event_id ,
                success:function(response){
                    $('.js-results').delay(500).html(response);

                }
            });
        }

    </script>
@endsection
