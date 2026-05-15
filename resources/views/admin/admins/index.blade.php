@extends('_layouts._dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 "><i class="fas fa-users"></i> Admins

                <span class="h1-button" style="">
                    <a href="{{route('admin.create')}}" class="btn btn-sm btn-default sister px-3">New Admin <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="text" id="keyword" class="form-control form-control-lg py-3 mb-4" placeholder="Search Admins by (Name, Email or Role)">


    <div class="js-results">
       @include('admin.admins._results')
    </div>

@endsection


@section('scripts')

    <script>


        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var search  = $('#keyword').val();

            fetch_data(page, search);

        });

        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();
            var search = $('#keyword').val();
            var page = $('#hidden_page').val();
            fetch_data(page, search);

        });

        function fetch_data(page, search){
            $.ajax({
                url: '/dashboard/admins/fetchData?page='+page + "&keyword=" + search,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                        $('.js-delete').click(function(){
                            var item_id = $(this).attr('item-id');

                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to delete page?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                var url = '{{ route('admin.delete', ":id") }}';
                                                url = url.replace(':id',item_id);
                                                window.location.href = url;

                                            }
                                        });
                                    },
                                    cancel: function () {
                                        window.location.href = '/dashboard/admins';
                                    }
                                }
                            });

                        })

                    }

                });
        }

        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Admin?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('admin.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '/dashboard/admins';
                        }
                    }
                });

        });

    </script>
@endsection

