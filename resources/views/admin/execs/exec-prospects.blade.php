@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-address-card"></i> (<strong>{{$exec->name}}</strong>) Prospects List
                <span class="h1-button" style="">
                    <a href="{{route('exec.index')}}" class="btn btn-border sister mr-2"><i class="fa-solid fa-caret-left mr-1"></i> Execs</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="text" id="keyword" class="form-control form-control-lg shadow-sm mb-4 py-3" placeholder="Search Prospects by (Customer Number, Name or Email)">

    <div class="js-results" exec-id="{{$exec->id}}">
        @include('admin.execs._prospects-results')
    </div>


@endsection


@section('scripts')
    <script>

        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page    = $(this).attr('href').split('page=')[1];
            var search  = $('#keyword').val();
            var exec_id  = $('.js-results').attr('exec-id');

            fetch_data(exec_id, page, search);

        });

        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();
            var search = $('#keyword').val();
            var page = $('#hidden_page').val();
            var exec_id  = $('.js-results').attr('exec-id');

            fetch_data(exec_id, page, search);

        });

        function fetch_data(exec_id, page, search){
            $.ajax({
                url: '/dashboard/execs/fetchProspectsData?page='+page + "&keyword=" + search+ "&exec_id=" + exec_id,
                    success:function(response){
                        $('.js-results').delay(500).html(response);
                    }
                });
        }


    </script>


@endsection
