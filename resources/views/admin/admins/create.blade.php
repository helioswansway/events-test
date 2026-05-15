@extends('_layouts._dashboard')

@section('content')

    <h1 class="display-4 "><i class="fas fa-users"></i> Create Admin
        <span class="h1-button">
            <a href="{{ route('admin.show') }}" class="btn btn-border sister mr-2"> Back</a>
        </span>
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="s-card shadow-sm ">
                <div class="s-card-header bg-brand">Create New Admin</div>
                <div class="s-card-body px-3 pt-1">
                    {{-- @include('multiauth::message') --}}
                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="name" class=" bold">Name: <span class="text-danger">*</span> </label>
                                <input id="name" type="text" class="form-control form-control-lg @if ($errors->has('name')) border-danger @endif" name="name" value="{{ old('name') }}" >
                                @if ($errors->has('name'))
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6 mt-2 ">
                                <label for="email" class="bold">E-Mail Address: <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control form-control-lg @if ($errors->has('email')) border-danger @endif" name="email" value="{{ old('email') }}" >
                                @if ($errors->has('email'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                            </div>
                        </div>

                        <div class="py-2"></div>

                        <div class="row g-3">
                            <div class="col-lg-6 bold">
                                <label for="phone">Phone</label>
                                <input type="number" name="phone" value="{{ old('phone') }}" class="form-control form-control-lg">
                                @if ($errors->has('phone'))
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6 bold">
                                <label for="mobile">Mobile </label>
                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form-control-lg">
                            </div>
                        </div>


                        <div class="mt-3">
                            <div class="s-card-header bg-brother">Assign Dealerships
                                @if ($errors->has('dealership_id'))
                                    <span class="text-danger ms-1" role="alert">
                                        <strong>{{ $errors->first('dealership_id') }}</strong>
                                    </span>
                                @else
                                    <span class="text-danger">*</span>
                                @endif

                            </div>

                            <div class="col-12">
                                <div class="row">
                                    @foreach($dealerships as $dealership)
                                        <div class="col-lg-6 pt-2 alert-light bold border border-white">
                                            <div class="form-check form-check-inline m-0">
                                                <input type="checkbox" id="dealership_{{$dealership->id}}" class="form-check-input m-0" name="dealership_id[]" value="{{$dealership->id}}" @if(is_array(old('dealership_id')) && in_array($dealership->id, old('dealership_id')))) checked @endif> <label for="dealership_{{$dealership->id}}">{{$dealership->name}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>


                        <div class="mt-4">
                            <div class="s-card-header bg-brother">
                                Assign Role
                                @if ($errors->has('role_id'))
                                    <span class="text-danger ms-1" role="alert">
                                        <strong>{{ $errors->first('role_id') }}</strong>
                                    </span>

                                @else
                                    <span class="text-danger">*</span>
                                @endif
                            </div>

                            <div class="col-12">
                                <div class="row ">
                                    @foreach($roles as $role)
                                        @if($role->name == 'super' || $role->name == 'developer')

                                        @else
                                            <div class="col-lg-6 pt-2 alert-brand bold border border-white">
                                                <div class="form-check form-check-inline m-0">
                                                    <input type="checkbox" name="role_id[]" class="form-check-input m-0" @if(is_array(old('role_id')) && in_array($role->id, old('role_id')))) checked @endif value="{{$role->id}}"> {{$role->name}}
                                                </div>
                                            </div>
                                        @endif

                                    @endforeach
                                </div>
                            </div>
                        </div>



                        <div class="col-12 mt-4">
                            <div class="row justify-content-between alert-success border-0 py-2">
                                <div class="col-lg-6 text-center pt-2">
                                    <div class="form-check form-check-inline text-end">
                                        <label for="activation" class="form-check-label bold me-2">Active?</label>
                                        <input type="checkbox" id="activation" class="form-check-input" name="activation" value="1" >
                                    </div>
                                </div>

                                <div class="col-lg-6 text-start pt-2">
                                    <div class="form-check form-check-inline text-end">
                                        <input type="checkbox" id="clone_to_exec" class="form-check-input js-clone-exec" name="clone_exec" value="1">
                                        <label for="clone_to_exec" class="form-check-label bold me-2">Clone Admin to EXEC?</label>
                                    </div>

                                    <div class=" hide js-clone-exec-container">
                                        <div class="col-12 mt-2 mb-3 px-0">
                                            <select name="cloned_dealership_code" id="cloned_dealership_code" class="form-control form-control-lg form-select bold">
                                                <option value="" >--Select Dealership--</option>
                                                @foreach($dealerships as $dealership)
                                                    <option value="{{$dealership->code}}">{{$dealership->name}}</option>
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
