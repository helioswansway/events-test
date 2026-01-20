@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-user-tie"></i> Execs

                @admin('super-admin')
                    <span class="h1-button" style="">
                       {{--
                        <a href="{{route('exec.export')}}" class="btn btn-border sister mr-2"><i class="fa-solid fa-download"></i> Export all Execs</a>
                        <a href="{{route('exec.create')}}" class="btn btn-border sister mr-2"><i class="fas fa-user-plus"></i> Create Exec</a>
                        <a href="/dashboard/execs/upload" class="btn btn-border brother">Upload Execs Data <i class="ml-2 fas fa-upload"></i></a>
                         --}}
                    </span>
                @endadmin

            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="text" id="keyword" class="form-control form-control-lg shadow-sm mb-4 py-3" placeholder="Search Execs by (Exec Dealership ID, Name or Email)">

    <div class="js-results">
        {{----}}@include('admin.execs._results')
    </div>

@endsection


@section('scripts')
    <script>

        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page    = $(this).attr('href').split('page=')[1];
            var search  = $('#keyword').val();

            fetch_data(page, search);

        });


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
                                var url = '{{ route('exec.delete', ":id") }}';
                                url = url.replace(':id',item_id);
                                window.location.href = url;
                            }
                        });
                    },
                    cancel: function () {
                        window.location.href = '{{ route('exec.index') }}';
                    }
                }
            });
        });

        $('.js-remove-prospects').click(function(){
            var exec_id = $(this).attr('exec-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to detach Prospects from Exec?',
                buttons: {
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                var url = '{{ route('exec.prospect.remove', ":id") }}';
                                url = url.replace(':id',exec_id);
                                window.location.href = url;
                            }
                        });
                    },
                    cancel: function () {
                        window.location.href = '{{ route('exec.index') }}';
                    }
                }
            });
        });

        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();
            var search      = $('#keyword').val();
            var page        = $('#hidden_page').val();
            fetch_data(page, search);

        });

        function fetch_data(page, search){
            $.ajax({
                url: '/dashboard/execs/fetchData?page='+page + "&keyword=" + search,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

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
                                                var url = '{{ route('exec.delete', ":id") }}';
                                                url = url.replace(':id',item_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        window.location.href = '{{ route('exec.index') }}';
                                    }
                                }
                            });
                        });


                        //Removes Prospects from Execs
                        $('.js-remove-prospects').click(function(){
                            var exec_id = $(this).attr('exec-id');
                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to detach Prospects from Exec?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                var url = '{{ route('exec.prospect.remove', ":id") }}';
                                                url = url.replace(':id',exec_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        window.location.href = '{{ route('exec.index') }}';
                                    }
                                }
                            });
                        });


                    }
                });
        }

    </script>


@endsection
