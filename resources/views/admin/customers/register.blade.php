@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4">
        <i class="fas fa-address-card"></i> Register Customer
        <span class="h1-button" style="">
            <a href="{{route('customer.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>


    @include('admin.inc._messages')
    <form action="{{route('customer.register.customer')}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="s-card shadow">
                    <div class="s-card-header bg-brother"">
                        <div class="row">
                            <div class="col">Enter Customer Details:</div>
                        </div>
                    </div>
                    <div class="s-card-body px-3 py-0">
                        <div class="row s-card-row py-2">
                            <div class="col-lg-6 bold ">
                                <label for="dealership_code">Dealership: <span class="text-danger">*</span></label>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="dealership_code" id="dealership_code" class=" form-control form-control-lg" required>
                                    <option value="">--Select a dealership--</option>
                                    @foreach($dealerships as $dealership)
                                        <option value="{{$dealership->code}}">{{$dealership->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 bold ">
                                <label for="event_id">Event: <span class="text-danger">*</span></label>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="event_id" id="event_id" class=" form-control form-control-lg" required></select>
                            </div>
                        </div>

                        <div class="row s-card-row py-2">
                            <div class="col-lg-4 bold pb-2 ">
                                <label for="title">Title: <span class="text-danger">*</span></label>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="title" id="title" class=" form-control form-control-lg" required>
                                    <option value="">--Select one--</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                </select>
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="name">Name: <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="surname">Surname: <span class="text-danger">*</span></label>
                                <input type="text" id="surname" name="surname" value="{{old('surname')}}" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="row s-card-row py-2">
                            <div class="col-lg-4 bold pb-2">
                                <label for="email">Email: <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="home_phone">Home Phone: </label>
                                <input type="text" id="home_phone" name="home_phone" value="{{old('home_phone')}}" class="form-control form-control-lg">
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="mobile">Mobile: </label>
                                <input type="text" id="mobile" name="mobile" value="{{old('mobile')}}" class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="row s-card-row py-2">
                            <div class="col-lg-4 bold pb-2">
                                <label for="address_1">Address: <span class="text-danger">*</span></label>
                                <input type="text" id="address_1" name="address_1" value="{{old('address_1')}}" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="address_2">Address 2: </label>
                                <input type="text" id="address_2" name="address_2" value="{{old('address_2')}}" class="form-control form-control-lg">
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="address_3">Address 3: </label>
                                <input type="text" id="address_3" name="address_3" value="{{old('address_3')}}" class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="row s-card-row py-2">
                            <div class="col-lg-4 bold pb-2">
                                <label for="address_4">Address 4: </label>
                                <input type="text" id="address_4" name="address_4" value="{{old('address_4')}}" class="form-control form-control-lg">
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="address_5">Address 5: </label>
                                <input type="text" id="address_5" name="address_5" value="{{old('address_5')}}" class="form-control form-control-lg">
                            </div>

                            <div class="col-lg-4 bold pb-2">
                                <label for="post_code">Post Code: <span class="text-danger">*</span></label>
                                <input type="text" id="post_code" name="post_code" value="{{old('post_code')}}" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="row s-card-row border-bottom py-2">
                            <div class="col ">
                                <button type="submit" name="button" class="btn btn-action sister block"><i class="fas fa-save mr-2"></i> Register Customer </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('scripts')

    <script>
        $(function(){
           $('#dealership_code').change(function(){
              var dealership_code = $(this).val();

                if(dealership_code != ""){
                    $.ajax({
                            url: '/dashboard/customers/fetchEvents?dealership_code='    + dealership_code,
                            success:function(response){
                                //console.log(response)
                                $('#event_id').html(response);
                            }
                    });

              }else{
                $('#event_id').html(' ');
              }

           })

        });

    </script>



@endsection
