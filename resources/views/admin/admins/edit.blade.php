@extends('_layouts._dashboard')

@section('content')
    <h1 class="display-4 "><i class="fas fa-users"></i> Edit Admin
        <span class="h1-button">
            <a href="{{ route('admin.index') }}" class="btn btn-border sister mr-2"> Back</a>
        </span>
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="s-card shadow-sm">
                <div class="s-card-header bg-brand d-flex justify-content-between"> <span> Edit details of {{$admin->name}}</span> <span class=" bold fs-80">Last logged in: <u class="ms-1">{{ $admin->last_login_at }}</u></span></div>

                <div class="s-card-body px-3 pt-1 pb-3">
                    @include('multiauth::message')

                        <form action="{{route('admin.update',[$admin->id])}}" method="post">
                            @csrf @method('patch')

                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label for="role" class=" bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $admin->name }}" name="name" class="form-control form-control-lg " id="role" required>
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <label for="role" class=" bold">Email <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $admin->email }}" name="email" class="form-control form-control-lg " id="role" required>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="s-card-header bg-brother">Assign Dealerships <span class="text-danger">*</span></div>
                                <div class="col-12">
                                    <div class="row ">
                                        @foreach($dealerships as $dealership)
                                            <div class="col-lg-6 pt-2 bold border border-white
                                                @if (in_array($dealership->id,$admin->dealerships->pluck('id')->toArray()))
                                                    bg-white border-white
                                                @else
                                                    alert-light border-white
                                                @endif
                                            ">
                                                <div class="form-check form-check-inline m-0">
                                                    <input type="checkbox" id="dealership_{{$dealership->id}}" class="form-check-input m-0" name="dealership_id[]" value="{{$dealership->id}}"
                                                        @if (in_array($dealership->id,$admin->dealerships->pluck('id')->toArray()))
                                                            checked
                                                        @endif
                                                    >
                                                    <label for="dealership_{{$dealership->id}}" class="form-check-label bold">{{$dealership->name}}</label>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                            </div>

                            <div class="mt-4">
                                <div class="s-card-header bg-brother">Assign Role<span class="text-danger">*</span></div>
                                <div class="col-12">
                                    <div class="row">
                                        @foreach($roles as $role)
                                            @if($role->name == 'super')

                                            @else
                                                <div class="col-lg-6 pt-2 bold border border-white
                                                            @if (in_array($role->id,$admin->roles->pluck('id')->toArray()))
                                                                bg-white
                                                            @else
                                                                alert-brand
                                                            @endif

                                                        ">
                                                    <div class="form-check form-check-inline m-0">
                                                        <input type="checkbox" id="role_{{$role->id}}" class="form-check-input m-0" name="role_id[]" value="{{$role->id}}"
                                                            @if (in_array($role->id,$admin->roles->pluck('id')->toArray()))
                                                                checked
                                                            @endif
                                                        >
                                                        <label for="role_{{$role->id}}" class="form-check-label bold">{{$role->name}}</label>
                                                    </div>
                                                </div>

                                            @endif

                                        @endforeach

                                        @if ($errors->has('role_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 mt-4">
                                <div class="row justify-content-between alert-success border-0 py-2">
                                    <div class="col-lg-6 text-center pt-2">
                                        <div class="form-check form-check-inline text-end">
                                            <label for="activation" class="form-check-label bold me-2">Active?</label>
                                            <input type="checkbox" id="activation" class="form-check-input" name="activation" value="1"
                                                {{ $admin->active ? 'checked':'' }}
                                            >
                                        </div>
                                    </div>

                                    <div class="col-lg-6 text-start pt-2">
                                        <div class="form-check form-check-inline text-end">
                                            <input type="radio" id="clone_to_exec" class="form-check-input js-clone-exec" name="clone_exec" value="1"
                                                @if(isset($exec->email) && strtolower($exec->email) == strtolower($admin->email))
                                                    checked
                                                @endif
                                            >
                                            <label for="clone_to_exec" class="form-check-label bold me-2">Clone Admin to EXEC?</label>

                                            <input type="radio" id="delete_exec" class="form-check-input js-delete-exec" name="clone_exec" value="0">
                                            <label for="delete_exec" class="form-check-label bold me-2">Delete Admin from EXEC?</label>
                                        </div>

                                        <div class="@if(isset($exec->email) && strtolower($exec->email) == strtolower($admin->email)) @else hide @endif js-clone-exec-container">
                                            <div class="col-12 mt-2 mb-3 px-0">
                                                <select name="cloned_dealership_code" id="" class="form-control form-control-lg form-select bold">
                                                    <option value="" >--Select Dealership--</option>
                                                    @foreach($dealerships as $dealership)
                                                        <option value="{{$dealership->code}}"
                                                            @if(isset($exec->email) && $exec->dealership_code == $dealership->code)
                                                                selected
                                                            @endif
                                                        >{{$dealership->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-action sister block">Save</button>

                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(function(){
            $(".js-clone-exec").click(function() {
                if($(this).is(":checked")) {
                    $(".js-clone-exec-container").removeClass('hide');
                    $("#cloned_dealership_code").attr("required", true);

                } else {
                    $(".js-clone-exec-container").addClass('hide');
                    $("#cloned_dealership_code").removeAttr('required');
                }
            });

            $(".js-delete-exec").click(function() {
                $(".js-clone-exec-container").addClass('hide');


                $.confirm({
                    title: 'Deletes Admin from Execs',
                    content: 'This will remove current Admin from the Execs table when saving the Admin. <br> <strong> Do you still want to processed?</strong>',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Okay',
                            btnClass: 'btn-light',
                            action: function(){
                            }
                        }
                    }
                });

            })
        })
    </script>

@endsection
