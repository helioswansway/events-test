@extends('_layouts._dashboard')


@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fab fa-black-tie"></i> Manage Brands
                <span class="h1-button" style="">
                    <a href="{{route('brand.create')}}" class="btn btn-border sister">Add a Brand <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>


    @include('admin.inc._messages')

    <div class="s-card shadow">
        <div class="s-card-header bg-brother"> Brand Name </div>

        <div class="s-card-body px-3 py-0">

            @if(count($brands) > 0)
                @foreach($brands as $brand)
                    <div class="row s-card-row py-1">
                        <div class="col-1 border-right d-none d-sm-block">
                            <img src="{{asset('assets/images/public/general/')}}/{{$brand->filename}}" class="fluid-img img-thumbnail " class="border" style="height:24px" title="{{$brand->name}} Logo">
                        </div>
                        <div class="col-8 col-sm-4 border-right bold">
                            {{$brand->name}}
                        </div>
                        <div class="col text-end">
                            <a href="{{route('brand.edit', ['id' => $brand->id])}}" class="btn btn-sm btn-border  p-1 info " title="Edit Brand"><i class="far fa-edit"></i></a>

                            <a href="javascript:void(0)" item-id="{{$brand->id}}" class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Brand"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            @else

                <div class="row">
                    <div class="col-12 alert-warning text-dark border border-warning py-1">
                        <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif



        </div>

    </div>


@endsection


@section('scripts')
    <script>

        //Asks Admin to confirm deletion
        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Brand?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('brand.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;
                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '{{ route('brand.index') }}';
                        }
                    }
                });

        })

    </script>


@endsection
