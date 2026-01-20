@extends('_layouts._exec-dashboard')


@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-tags fs-110"></i> Edit Sale
                <span class="h1-button" style="">
                    <a href="{{route('exec.sale.index')}}" class="btn btn-border sister "><i class="fas fa-angle-double-left"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 js-appointment p-0">
            @include('admin.inc._messages')

            <div class="s-card shadow">
                <div class=" s-card-header bg-brand border-0"> Edit Sale </div>
                <div class="s-card-body px-3 pb-3">


                    <form action="{{route('exec.sale.update', [$sale->id] )}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        {{ method_field('POST') }}

                        <div class="row">
                            <div class="col-lg-4 ">
                                <label  class="bold">Dealership</label>
                                <input type="text" class="form-control form-control-lg"  value="{{$sale->dealership->name}}" disabled>
                            </div>

                            <div class="col-lg-4">
                                <label class="bold">Sales Exec</label>
                                <input type="text" class="form-control form-control-lg" value="{{$sale->exec->name}}" disabled>
                            </div>

                            <div class="col-lg-4">
                                <label class="bold">Customer Name</label>
                                <input type="text" class="form-control form-control-lg"  value="{{$sale->book->title}} {{$sale->book->name}} {{$sale->book->surname}}" disabled>
                            </div>

                            <div class="col-lg-4 mt-3">
                                <label for="order_number" class="bold">Order Number</label> <span class="text-danger">*</span>
                                <input id="order_number" type="text" class="form-control form-control-lg" name="order_number"  value="{{$sale->order_number}}" required>
                            </div>

                            <div class="col-lg-4 mt-3">
                                <label for="from_appointment" class="bold">From Appointment</label> <span class="text-danger">*</span>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="from_appointment" class="form-control form-control-lg js-from-appointment" id="from_appointment" required>
                                    <option value="">--Please select--</option>
                                    <option value="from_appointment" @if($sale->from_appointment == 'from_appointment') selected @endif> From Appointment</option>
                                    <option value="walk_in" @if($sale->walk_in == 'walk_in') selected @endif> Walk In </option>
                                </select>
                                <span class="js-error text-danger "></span>
                            </div>

                            <div class="col-lg-4 mt-3">
                                <label for="sale_type" class="bold">Sale Type</label>  <span class="text-danger">*</span>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="sale_type" id="sale_type" class="form-control form-control-lg" required>
                                    <option value="">--Please select--</option>
                                    <option value="new" @if($sale->sale_type == 'new') selected @endif>New</option>
                                    <option value="used" @if($sale->sale_type == 'used') selected @endif> Used </option>
                                </select>
                                <span class="js-error text-danger "></span>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-12 bold mt-4">
                                Sold add-on products:
                            </div>

                            <div class="col-lg-4 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="sold_vehicle" id="sold_vehicle"  value="1" @if($sale->sold_vehicle == '1') checked @endif>
                                    <label class="form-check-label" for="sold_vehicle">Sold a vehicle</label>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="finance" id="finance" value="1" @if($sale->finance == '1') checked @endif>
                                    <label class="form-check-label" for="finance">Finance</label>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="paint_protection" id="paint_protection" value="1" @if($sale->paint_protection == '1') checked @endif>
                                    <label class="form-check-label" for="paint_protection">Paint Protection</label>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="smart" id="smart" value="1" @if($sale->smart == '1') checked @endif>
                                    <label class="form-check-label" for="smart">Smart</label>
                                </div>
                            </div>

                            <div class="col-lg-4  mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="gap" id="gap" value="1" @if($sale->gap == '1') checked @endif>
                                    <label class="form-check-label" for="gap">GAP</label>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="warranty" id="warranty" value="1" @if($sale->warranty == '1') checked @endif>
                                    <label class="form-check-label" for="warranty">Warranty</label>
                                </div>
                            </div>

                            <div class="col-lg-4  mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="alloy" id="alloy" value="1" @if($sale->alloy == '1') checked @endif>
                                    <label class="form-check-label" for="alloy">Alloy</label>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="tyre" id="tyre" value="1" @if($sale->tyre == '1') checked @endif>
                                    <label class="form-check-label" for="tyre">Tyre</label>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 mt-3 mb-4">
                            <div class="row alert-brand py-3">
                                <div class="col-12 bold mb-1">
                                    Part Exchange: <span class="text-danger">*</span>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="part_exchange_yes" class="form-check-input js-part-exchange-yes ms-0" name="part_exchange" value="1"
                                            @if($sale->part_exchange == '1') checked @endif
                                        >
                                        <label for="part_exchange_yes" class="form-check-label">Yes</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input js-part-exchange-no" type="radio" name="part_exchange" id="part_exchange_no" value="0"
                                            @if($sale->part_exchange == '0') checked @endif
                                        >
                                        <label class="form-check-label" for="part_exchange_no">No</label>

                                    </div>
                                </div>

                                <div class="row">
                                    <span class="js-exchange-error col-12 text-danger"></span>
                                </div>

                                <span class="col-12 js-span hide">
                                    <div class="row">
                                        <div class="col-12 bold mt-2">
                                            Enter Registration: <span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-4 mt-1">
                                            <input type="text" class="form-control form-control-lg js-registration" name="registration"  value="{{old('registration')}}" >
                                            <span class="js-error text-danger "></span>
                                        </div>
                                    </div>
                                </span>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit"  class="btn btn-action sister block ">Submit Sale</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection


@section('scripts')
    <script>
        $(function(){
            $('.js-part-exchange-yes').click(function(){
                $('.js-span').removeClass('hide');
                $('.js-submit').removeAttr("disabled");
                $('.js-registration').attr("required", 'required');
            })

            $('.js-part-exchange-no').click(function(){
                $('.js-span').addClass('hide');
                $('.js-submit').removeAttr("disabled");
                $('.js-registration').removeAttr("required", 'required');
            })


        })

    </script>
@endsection
