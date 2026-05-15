@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-address-card"></i> Customers
                <span class="h1-button" style="">
                    <a href="{{route('customer.register')}}" class="btn btn-border sister mr-2"><i class="fas fa-address-card mr-1"></i> Register Customer</a>
                    <a href="/dashboard/customers/create" class="btn btn-border brother">Upload Customers Data <i class="ml-2 fas fa-upload"></i></a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="text" id="keyword" class="form-control form-control-lg mb-4 py-3" placeholder="Search Customers by (Customer Number, Name or Email)">

    <div class="js-results">
        {{----}}@include('admin.customers._results')
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



        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();
            var search      = $('#keyword').val();
            var page = $('#hidden_page').val();
            fetch_data(page, search);

        });

        function fetch_data(page, search){
            $.ajax({
                url: '/dashboard/customers/fetchData?page='+page + "&keyword=" + search,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                        //Asks Admin to confirm deletion
                        $('.js-delete').click(function(){
                                var item_id = $(this).attr('item-id');

                                $.confirm({
                                    title: 'Confirm!',
                                    content: 'Are you sure you want to delete Customer?',
                                    buttons: {
                                        confirm: function (e) {
                                            $.ajax({
                                                success: function (response)
                                                {
                                                    var url = '{{ route('customer.delete', ":id") }}';
                                                    url = url.replace(':id',item_id);
                                                    window.location.href = url;

                                                }
                                            });
                                        },
                                        cancel: function () {
                                            window.location.href = '{{ route('customer.index') }}';
                                        }
                                    }
                                });

                        });


                    }
                });
        }

        //Asks Admin to confirm deletion
        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Customer?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('customer.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '{{ route('customer.index') }}';
                        }
                    }
                });

        })



    </script>


@endsection
