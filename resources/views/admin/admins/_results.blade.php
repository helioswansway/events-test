<div class="s-card shadow">

    <div class="s-card-header bg-brother">
        <div class="px-2">
            <div class="row ">
                <div class="col-9">
                    {{ $admins->links() }}
                    <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                        Results: {{number_format($admins->count())}}
                    </span>
                </div>

                <div class="col-3 pr-3 text-end pt-1">
                    <span class="badge bg-brand text-white  fs-90 px-1">
                        <strong>Total:</strong> {{number_format($admins->total())}}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="s-card-header bg-brand ">
        <div class="row">
            <div class="col-2 border-right border-white">
                Name
            </div>
            <div class="col-3 border-right border-white  d-none d-sm-block">
                Email
            </div>

            <div class="col-3 border-right border-white ">
                Role
            </div>

            <div class="col-1 border-right border-white  text-center">
                Active
            </div>
            <div class="col-2 border-right border-white  text-center">
                last logged in
            </div>
            <div class="col">

            </div>
        </div>
    </div>

    <div class="s-card-body py-0">
        <div class="col-12">
            @if($admins->count() > 0)
                @foreach($admins as $admin)
                    @if($admin->role_name == "super")
                        <div class="row s-card-row py-2 line-height-24">
                            <div class="col-2 border-right">
                                {{$admin->name}}
                            </div>
                            <div class="col-3 border-right  d-none d-sm-block" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{$admin->email}}
                            </div>

                            <div class="col-3 border-right">

                            </div>
                            <div class="col-1 text-center border-right">
                                {!! $admin->active? "<i class='fas fa-thumbs-up text-success'></i>"  : "<i class='fas fa-thumbs-down text-danger'></i>" !!}
                            </div>

                            <div class="col-2  text-center border-right">
                                {{$admin->last_login_at}}
                            </div>

                        </div>

                    @else
                        <div class="row s-card-row line-height-34">
                            <div class="col-2 border-right">
                                {{$admin->name}}
                            </div>
                            <div class="col-3 border-right  d-none d-sm-block" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{$admin->email}}
                            </div>
                            <div class="col-3 border-right fs-100">
                                @foreach ($roles->getRoles($admin->id) as $role)
                                    <span class="badge  bg-sister px-1 text-white mr-1">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="col-1 text-center border-right">
                                {!! $admin->active? "<i class='fas fa-thumbs-up text-success'></i>"  : "<i class='fas fa-thumbs-down text-danger'></i>" !!}
                            </div>

                            <div class="col-2 text-center  border-right">
                                {{$admin->last_login_at}}
                            </div>

                            <span class="col text-end">
                                {{-- <a href="#" class="btn btn-sm btn-border px-1 warning js-resend-password" item-id="{{$admin->id}}" title="Resend new password to Admin"><i class="fa-solid fa-unlock-keyhole"></i></a> --}}

                                <a href="{{route('admin.edit',[$admin->id])}}" class="btn btn-sm btn-border p-1 info mx-1" title="Edit admin"><i class="far fa-edit"></i></a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-border px-1 danger js-delete" item-id="{{$admin->id}}"  title="Delete admin"><i class="fa fa-trash"></i></a>

                            </span>
                        </div>
                    @endif
                @endforeach

            @else
                <div class="pane-body py-3">
                    <div class="alert-warning p-3 text-dark bold">
                        {!!$message!!}
                    </div>
                </div>
            @endif
        </div>


    </div>

    <div class="col-12 border-0 py-2 ">
        <div class="col-12">
            <div class="row ">
                <div class="col-9">
                    {{ $admins->links() }}
                </div>

                <div class="col-3 pr-3 text-end pt-1">
                    <span class="badge bg-brand text-white  fs-90 px-1">
                        <strong>Total:</strong> {{number_format($admins->total())}}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>






