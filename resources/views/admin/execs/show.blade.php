@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4"><i class="fas fa-comment"></i> Customer Details</h1>
    <hr class="mb-5">

    @include('admin.inc._messages')
    <form action="{{route('customer.update', [$customer->customer_number])}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}
        <div class="col-12">

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold py-2 fs-110">
                    Customer Unique Number
                </div>
                <div class="col py-2 border-top border-bottom">
                    {{$customer->customer_number}}
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold py-2 fs-110">
                    Dealership/Code
                </div>
                <div class="col py-2 border-bottom">
                    <input type="hidden" name="dealership_code" value="{{$customer->dealership_code}}" class="col-lg-6 form-control form-control-lg">
                    {{$customer->dealership_code}}
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Title
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="title" value="{{$customer->title}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Name
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="name" value="{{$customer->name}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3 fs-110">
                    Surname
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="surname" value="{{$customer->surname}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Address 1
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="address_1" value="{{$customer->address_1}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Address 2
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="address_2" value="{{$customer->address_2}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold pt-3 fs-110">
                    Address 3
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="address_3" value="{{$customer->address_3}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Address 4
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="address_4" value="{{$customer->address_4}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Address 5
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="address_5" value="{{$customer->address_5}}" class="col-lg-6 form-control form-control-lg" >
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Post Code
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="post_code" value="{{$customer->post_code}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Home Phone
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="home_phone" value="{{$customer->home_phone}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Mobile
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="mobile" value="{{$customer->mobile}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Email
                </div>
                <div class="col py-1 border-bottom">
                    <input type="email" name="email" value="{{$customer->email}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Vehicle Registration
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="vehicle_reg" value="{{$customer->vehicle_reg}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>

            <div class="row border-bottom border-white">
                <div class="col-lg-3 bg-light bold  pt-3  fs-110">
                    Vehicle Description
                </div>
                <div class="col py-1 border-bottom">
                    <input type="text" name="vehicle_description" value="{{$customer->vehicle_description}}" class="col-lg-6 form-control form-control-lg">
                </div>
            </div>



        </div>

        <div class="js-btn-holder">
            <button type="submit" name="button" class="btn btn-primary"><i class="fas fa-save"></i> Save Customer Details </button>
        </div>
    </form>
@endsection


@section('scripts')



@endsection
