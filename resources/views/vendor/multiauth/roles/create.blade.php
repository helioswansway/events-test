@extends('_layouts._dashboard')
@section('content')
    <h1 class="display-4 "><i class="fas fa-chalkboard-teacher"></i> Create Role
        <span class="h1-button">
            <a href="{{ route('admin.roles') }}" class="btn btn-border sister mr-2"> Back</a>
        </span>
    </h1>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow ">
                <div class="s-card-header bg-brand">Add New Role</div>

                <div class="s-card-body px-3 py-0">
                    @include('multiauth::message')
                    <form action="{{ route('admin.role.store') }}" method="post">
                        @csrf
                        <div class="my-3">
                            <label for="role" class="bold line-height-30">Role Name:</label>
                            <input type="text" placeholder="Enter role name" name="name" class="form-control form-control-lg" id="role" required>
                        </div>


                        <label for="role" class="block s-card-header bg-brother">Assign Permissions:</label>
                        <div class="s-card-body py-0">
                            @foreach($permissions as $key => $value)
                                <label for="role" class="alert-light border-0 col-12 bold py-2">{{$key}}</label>
                                <div class="form-check py-2 mb-2">
                                    @foreach($value as $permission)
                                        <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                                        <input type="checkbox" name="permissions[]" class="form-check-input" value="{{$permission->id}}" id="{{$permission->id}}">
                                    @endforeach
                                </div>
                            @endforeach
                        </div>


                        <div class="row">
                            <div class="col my-3">
                                <button type="submit" class="btn btn-action block sister float-start">Save</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
