@extends('_layouts._dashboard')

@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-user-tie"></i> Leaderboard Users for <span class="text-sister" style="text-decoration: underline;">{{$competition->name}}</span> competition
                <span class="h1-button" style="">
                    <a href="{{route('admin.leaderboard.index')}}" class="btn btn-sm  btn-default brother px-2 me-3"><i class="fas fa-chart-bar mr-2"></i> Leaderboard</a>
                    <a href="{{route('admin.leaderboard.create')}}" class="btn btn-sm  btn-default brand px-2 me-3"><i class="fas fa-user-plus me-1"></i> Create Single user</a>

                    @admin('super')
                        <a href="{{route('admin.leaderboard.upload')}}" class="btn btn-sm  btn-default sister px-2 me-3"> Upload Users <i class="ml-2 fas fa-upload ml-2"></i></a>
                    @endadmin

                    <a href="javascript:void(0)" class="btn btn-sm btn-default light px-2 js-job-title"><i class="fas fa-user-tie me-1"></i> Manage Job Titles</a>

                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="js-keyword text-end">
        <input type="text" id="keyword" class="form-control form-control-lg mb-1 py-3" placeholder="Search Execs by (Exec Dealership ID, Name, Email or Job Title)">
    </div>

    <div class="js-results">
        @include('admin.leaderboard._results')
    </div>

@endsection


@section('scripts')
    <script>

        //Closes Book Appointment Wrapper
        $('.js-refresh').click(function(){
            return location.reload();
        })

        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page    = $(this).attr('href').split('page=')[1];
            var search  = $('#keyword').val();

            fetch_data(page, search);

        });

        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();
            var search      = $('#keyword').val();
            var page        = $('#hidden_page').val();
            fetch_data(page, search);

        });

        function fetch_data(page, search){
            $.ajax({
                url: '/dashboard/leaderboard/fetchData?page='+page + "&keyword=" + search,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                        $('.js-delete').click(function(){
                                var item_id = $(this).attr('item-id');

                                $.confirm({
                                    title: 'Confirm!',
                                    content: 'Are you sure you want to delete Leaderboard/User?',
                                    buttons: {
                                        confirm: function (e) {
                                            $.ajax({
                                                success: function (response)
                                                {
                                                    var url = '{{ route('leaderboard.delete', ":id") }}';
                                                    url = url.replace(':id',item_id);
                                                    window.location.href = url;
                                                }
                                            });
                                        },
                                        cancel: function () {
                                            window.location.href = '{{ route('admin.leaderboard.get.execs') }}';
                                        }
                                    }
                                });
                        });
                    }
                });
        }


        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Exec?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('leaderboard.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;
                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '{{ route('admin.leaderboard.index') }}';
                        }
                    }
                });
        });


    </script>


@endsection
