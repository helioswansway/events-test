@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fab fa-houzz"></i>
                Manage Dealerships
                <span class="h1-button" style="">
                    <a href="{{route('dealership.create')}}" class="btn btn-sm btn-default sister px-3">Add a Dealership <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>



    @include('admin.inc._messages')

    <div class="s-card shadow">
        <div class="s-card-header bg-brother">
            <div class="row">
                <div class="col-3 col-sm-1  border-right">
                    Brand
                </div>

                <div class="col-6 col-sm-2 border-right">
                    Dealership
                </div>

                <div class="col border-right text-center">
                    code
                </div>

                <div class="col border-right d-none d-sm-block">
                    Email
                </div>
                <div class="col border-right d-none d-sm-block">
                    Phone
                </div>

                <div class="col">

                </div>

            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            @if(count($dealerships) > 0)
                @foreach($dealerships as $dealership)
                    <div class="row s-card-row line-height-36">
                        <div class="col-3 col-sm-1  border-right">
                            <img src="{{asset('assets/images/public/general/')}}/{{$dealership->brand->filename}}" class="fluid-img img-thumbnail"   style="height:30px" title="{{$dealership->brand->filename}} Logo">
                        </div>
                        <div class="col-6 col-sm-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{$dealership->name}}
                        </div>

                        <div class="col border-right d-none d-sm-block text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{$dealership->code}}
                        </div>

                        <div class="col border-right d-none d-sm-block" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{$dealership->email}}
                        </div>

                        <div class="col border-right d-none d-sm-block">
                            {{$dealership->phone}}
                        </div>

                        <div class="col text-end">
                            <a href="{{route('dealership.edit', ['id' => $dealership->id])}}" class="btn btn-sm btn-border  p-1 info" title="Edit Dealership"><i class="far fa-edit"></i></a>
                            <a href="javascript:void(0)" item-id="{{$dealership->id}}" class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Dealership"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            @else

                <div class="row">
                    <div class="alert-warning text-dark border border-warning py-2 px-3">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif
        </div>

    </div>


@endsection


@section('scripts')
    <script>
        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Dealership?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('dealership.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '/dashboard/dealerships';
                        }
                    }
                });

        })

    </script>


@endsection
