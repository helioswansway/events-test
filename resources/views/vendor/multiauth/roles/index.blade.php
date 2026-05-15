@extends('_layouts._dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 "><i class="fas fa-chalkboard-teacher"></i> Roles
                @permitTo('CreateRole')
                    <span class="h1-button" style="">
                        <a href="{{route('admin.role.create')}}" class="btn btn-sm btn-default sister px-3">New Role <i class="fas fa-plus"></i></a>
                    </span>
                @endpermitTo
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="s-card shadow">
        <div class="s-card-header bg-brother mt-3">
            <div class="row ">
                <div class="col-sm-3 col border-right">
                    Name
                </div>
                <div class="col-3 border-right">
                    Admins N:
                </div>

                <div class="col-4 border-right d-none d-sm-block">
                    Permissions N:
                </div>
                <div class="col"></div>


            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            @foreach ($roles as $role)
                <div class="row s-card-row line-height-36">
                    <div class="col-sm-3 col  border-right">
                        {{ $role->name }}
                    </div>
                    <div class="col-3 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="badge bg-brand badge-pill">{{ $role->admins->count() }} {{ucfirst(config('multiauth.prefix')) }}</span>
                    </div>

                    <div class="col-4 border-right d-none d-sm-block">
                        <span class="badge bg-success badge-pill">{{ $role->permissions->count() }} Permissions</span>
                    </div>

                    <div class="col text-end">
                        @permitTo('UpdateRole')
                            <a href="{{ route('admin.role.edit',$role->id) }}" class="btn btn-sm btn-border p-1 info mr-1"><i class="far fa-edit"></i></a>
                        @endpermitTo

                        @permitTo('DeleteRole,UpdateRole')
                            <a href="javascript:void(0)" class="btn btn-sm btn-border px-1 danger js-delete" item-id="{{$role->id}}"><i class="fa fa-trash"></i></a>
                        @endpermitTo
                    </div>

                </div>
            @endforeach
        </div>

    </div>

@endsection


@section('scripts')

    <script>

        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Role?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('admin.role.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;
                                }
                            });
                        },
                        cancel: function () {
                           window.location.href = '/admin/roles';
                        }
                    }
                });

        });

    </script>
@endsection
