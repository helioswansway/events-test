
@extends('_layouts._exec-dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>
    <h1 class="display-4">
        <i class="fas fa-chalkboard-teacher"></i> Prospects Overview <small class="ml-3 text-sister hide-mobile">{{$exec->name}} Prospects</small>
        <span class="h1-button" style="">
            <a href="{{route('exec.prospect.register', [$event_id, $dealership->id])}}" class="btn btn-border sister"><i class="fas fa-user-plus mr-2"></i> Register Prospect</a>
        </span>
    </h1>

    <input type="hidden" name="eventId" id="eventId" value="{{$event_id}}">
    <input type="hidden" name="dealership_code" id="dealership_code" value="{{$dealership->code}}">
    @include('admin.inc._messages')


    <div class="row py-3 border-0 border-bottom mb-1">
        <div class="col-lg-3">
            <input type="text" id="keyword" class="form-control form-control-lg shadow-sm py-3 fs-90" placeholder="Search Customers by (Registration, Customer Number, Name or Email)">
        </div>

        <div class="col-lg-9 text-end pt-2 mb-1 fs-90 pl-0">
            <a href="javascript:void(0)" class="float-start js-refresh btn btn-border brand text-center px-1 pb-0 pt-1" title="Refresh"><i class="fas fa-sync fs-150"></i></a>
            <span class="icon-list hide"> <span class="icon-name"> New Prospect</span> <span class="icon booked-circle bg-dark "></span> </span>
            <span class="icon-list"> <span class="icon-name"> Not Interested</span> <span class="icon booked-circle alert-info "></span> </span>

            <div class="mob-space"></div>
            <span class="icon-list"> <span class="icon-name"> Require Call Back</span> <span class="icon booked-circle bg-warning "></span> </span>
            <span class="icon-list"> <span class="icon-name"> Call Made</span> <span class="icon booked-circle alert-other "></span> </span>
            <span class="icon-list"> <span class="icon-name"> Cancelled</span> <span class="icon booked-circle bg-danger "></span> </span>

            <span class="icon-list"> <span class="icon-name"> Sale</span> <span class="icon booked-circle alert-success "></span> </span>

            <a href="javascript:void(0)" class="js-completed"><span class="icon-list"> <span class="icon-name"> Completed</span> <span class="icon booked-circle bg-sister "></span></span></a>
            <a href="javascript:void(0)" class="js-hot-prospect"><span class="icon-list"> <span class="icon-name"> Hot Prospect</span> <span class="icon booked-circle alert-danger"></span></span></a>
            <a href="javascript:void(0)" class="js-in-progress"><span class="icon-list"> <span class="icon-name"> In Progress</span> <span class="icon booked-circle border border-warning"></span> </span></a>
            <a href="javascript:void(0)" class="js-confirm"><span class="icon-list"> <span class="icon-name"> Confirmed</span> <span class="icon booked-circle bg-success "></span></span></a>

        </div>
    </div>

    <div class="s-card shadow">
        <div class="js-results">
            {{----}}@include('exec.prospects._results')
        </div>

    </div>

@endsection


@section('scripts')
    <script>
        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page                = $(this).attr('href').split('page=')[1];
            var search              = $('#keyword').val();
            var event_id            = $('#eventId').val();
            var dealership_code     = $('#dealership_code').val();

            fetch_data(page, search, event_id, dealership_code);

        });

        function fetch_data(page, search, event_id, dealership_code){

            $.ajax({
                url: '/exec/prospects/fetchData?page='+page + "&keyword=" + search+ "&event_id=" + event_id + "&dealership_code=" + dealership_code,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }

        $(document).on('keyup', '#keyword', function(){            //e.preventDefault();

            var search              = $('#keyword').val();
            var page                = $('#hidden_page').val();
            var event_id            = $('#eventId').val();
            var dealership_code     = $('#dealership_code').val();


            fetch_data(page, search, event_id, dealership_code);


        });





        $('.js-confirm').click(function(){
            $(this).addClass('bold rounded p-2 border')
            $('.js-hot-prospect, .js-completed, .js-in-progress').removeClass('bold rounded p-2 border')
            fetch_confirm_data();
        })

        function fetch_confirm_data(){

            $.ajax({
                url: '/exec/prospects/fetchConfirmedData',
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }

        $('.js-in-progress').click(function(){
            $(this).addClass('bold rounded p-2 border')
            $('.js-hot-prospect, .js-completed, .js-confirm').removeClass('bold rounded p-2 border')
            fetch_in_progress_data();
        })

        function fetch_in_progress_data(){
            var dealership_code     = $('#dealership_code').val();
            var event_id            = $('#event_id').val();
            $.ajax({
                url: '/exec/prospects/fetchInProgressData',
                    success:function(response){
                        console.log(response)
                        $('.js-results').delay(500).html(response);
                    }
                });
        }




        $('.js-completed').click(function(){
            $(this).addClass('bold rounded p-2 border')
            $('.js-hot-prospect, .js-confirm, .js-in-progress').removeClass('bold rounded p-2 border')
            fetch_completed_data();
        })

        function fetch_completed_data(){

            $.ajax({
                url: '/exec/prospects/fetchCompletedData',
                success:function(response){
                    $('.js-results').delay(500).html(response);
                }
            });
        }

        /**/

        $('.js-hot-prospect').click(function(){
            $(this).addClass('bold rounded p-2 border')
            $('.js-confirm, .js-completed').removeClass('bold rounded p-2 border')
            fetch_hot_prospect_data();
        })

        function fetch_hot_prospect_data(){
            $.ajax({
                url: '/exec/prospects/fetchHotProspectdData',
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                    }
                });
        }


        $('.js-refresh').click(function(){
            location.reload();
        })

    </script>
@endsection
