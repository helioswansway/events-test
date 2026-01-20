@extends('_layouts._dashboard')

@section('styles')

    <style>
        ::-webkit-scrollbar-track
                    {
                        background: #ffffff;
                        border-left: none;
                        margin: 2px;
                    }
    </style>

@endsection

@section('content')

    <div class="offcanvas offcanvas-end border-0 shadow" style="background: #ffffff !important; width:450px;  height: 95% padding: 0; margin:0" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasWithBackdropLabel">
        <div class="offcanvas-header bg-brand text-white">
            <h5 id="offcanvasRightLabel">Edit Exec</h5>
            <button type="button" class="btn btn-sm btn-border brother fs-90 px-2" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="offcanvas-body" style="height: 93%; background: #ffffff !important;">

            <form action="{{route('customer.exec.update', [$customer->id])}}" enctype="multipart/form-data" method="POST" style="">
                {{csrf_field()}}
                {{ method_field('POST') }}

                <div class="col-12 mt-2">
                    <label for="dealership_id" class="bold">Dealership <span class="text-danger">*</span></label>
                    <select name="dealership_id" id="dealership_id" customer-id="{{$customer->id}}" class="form-control form-control-lg form-select js-select-dealership" required autofocus>
                        <option value="">--Select Dealership--</option>
                        @foreach($dealerships as $dealership)
                            <option value="{{$dealership->id}}" @if($dealership->code == $customer->dealership_code) selected @endif>{{$dealership->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mt-3 js-display-execs">
                    <label for="exec_id" class="bold">Exec @if($execs->count() > 0) <span class="text-danger">*</span> @endif</label>
                    <select name="exec_id" id="exec_id" class="form-control form-control-lg form-select" @if($execs->count() > 0) required autofocus @endif>
                            <option value="">--Select Exec--</option>
                            @foreach($execs as $exec)
                                <option value="{{$exec->id}}"
                                    @if(isset(customerExec($customer->id)->id) && customerExec($customer->id)->id == $exec->id) selected @endif
                                >{{$exec->name}}</option>
                            @endforeach
                    </select>
                </div>


                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-default sister"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
                </div>

            </form>

        </div>
    </div>

    <h1 class="display-4"><i class="fas fa-address-card"></i> Customer Details</h1>


    @include('admin.inc._messages')
    <form action="{{route('customer.update', [$customer->id])}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="s-card shadow">
                    <div class="s-card-header bg-brother">
                        Edit Customer Details:
                    </div>
                    <div class="s-card-body border-0 p-0">
                        <div class="col-12">
                            <div class="row border-bottom  py-2">
                                <div class="col-lg-4 bold border-right">
                                    Customer Unique Number:
                                </div>
                                <div class="col text-brand bold fs-120">
                                    {{$customer->customer_number}}
                                </div>
                            </div>

                            <div class="row alert-brother border-0 py-2">
                                <div class="col-lg-4 border-right bold">
                                    Dealership/Code:
                                </div>
                                <div class="col ">
                                    <div class="row">

                                        <div class="col-10">
                                            <input type="hidden" name="dealership_code" value="{{$customer->dealership_code}}" class=" form-control form-control-lg js-dealership-code">
                                            {{dealershipByCode($customer->dealership_code)->name }} / {{$customer->dealership_code}}
                                        </div>

                                        @admin('super-admin')
                                            <div class="col pl-0 text-end">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-border info fs-90" customer-id="{{$customer->id}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasWithBackdrop" title="Edit Dealership"><i class="far fa-edit px-1"></i></a>
                                            </div>
                                        @endadmin

                                    </div>
                                </div>

                            </div>

                            <div class="row alert-brother border-top border-left-0 border-right-0 border-bottom-0 py-2">
                                <div class="col-lg-4 border-right bold">
                                    Exec Assigned too:
                                </div>

                                <div class="col ">
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="hidden" name="dealership_code" value="{{$customer->dealership_code}}" class=" form-control form-control-lg js-dealership-code">
                                            @if(isset(customerExec($customer->id)->id))
                                                {{customerExec($customer->id)->name }}
                                            @else
                                                N/A
                                            @endif
                                        </div>

                                        @admin('super-admin,brand-manager')
                                            <div class="col pl-0 text-end">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-border info fs-90" customer-id="{{$customer->id}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasWithBackdrop" title="Edit/Assign Exec"><i class="far fa-edit px-1"></i></a>
                                            </div>
                                        @endadmin

                                    </div>
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Title:
                                </div>
                                <div class="col ">
                                    <input type="text" name="title" value="{{$customer->title}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Name:
                                </div>
                                <div class="col ">
                                    <input type="text" name="name" value="{{$customer->name}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Surname:
                                </div>
                                <div class="col ">
                                    <input type="text" name="surname" value="{{$customer->surname}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Address 1:
                                </div>
                                <div class="col ">
                                    <input type="text" name="address_1" value="{{$customer->address_1}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Address 2:
                                </div>
                                <div class="col ">
                                    <input type="text" name="address_2" value="{{$customer->address_2}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Address 3:
                                </div>
                                <div class="col ">
                                    <input type="text" name="address_3" value="{{$customer->address_3}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Address 4:
                                </div>
                                <div class="col ">
                                    <input type="text" name="address_4" value="{{$customer->address_4}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Address 5:
                                </div>
                                <div class="col ">
                                    <input type="text" name="address_5" value="{{$customer->address_5}}" class="form-control form-control-lg" >
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Post Code:
                                </div>
                                <div class="col ">
                                    <input type="text" name="post_code" value="{{$customer->post_code}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Home Phone:
                                </div>
                                <div class="col ">
                                    <input type="text" name="home_phone" value="{{$customer->home_phone}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Mobile:
                                </div>
                                <div class="col ">
                                    <input type="text" name="mobile" value="{{$customer->mobile}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Email:
                                </div>
                                <div class="col ">
                                    <input type="email" name="email" value="{{$customer->email}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Vehicle Registration:
                                </div>
                                <div class="col ">
                                    <input type="text" name="vehicle_reg" value="{{$customer->vehicle_reg}}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="row border-top py-1">
                                <div class="col-lg-4 border-right bold pt-1">
                                    Vehicle Description:
                                </div>
                                <div class="col ">
                                    <input type="text" name="vehicle_description" value="{{$customer->vehicle_description}}" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="js-btn-holder">
            <a href="{{route('customer.index')}}" class="btn btn-border sister me-2 "><i class="fas fa-caret-left"></i> Back </a>
            <button type="submit" name="button" class="btn btn-border brother"><i class="fas fa-save mr-2"></i> Save Customer Details </button>
        </div>
    </form>
@endsection


@section('scripts')
    <script>
        $(function(){


            $(document).on('change', '.js-select-dealership', function(){
                var dealership_id = $(this).val();
                var customer_id = $(this).attr('customer-id');

                $('.js-display-execs').fadeOut();

                $.ajax({
                    url: '/dashboard/customers/get-execs',
                    method:'get',
                    data: {
                        dealership_id: dealership_id,
                        customer_id: customer_id,
                    },
                    }).done(function(response) {

                        console.log(response.html)

                    }).always(function(response) {

                        console.log(response.html)
                        $('.js-display-execs').fadeIn('slow');
                        $('.js-display-execs').html(response.html)

                    });


            })

        })

    </script>



@endsection
