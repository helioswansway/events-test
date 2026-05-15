
<div class="s-card shadow">

    <div class="s-card-header">
        <div class="row ">
            <div class="col-12 pr-3 text-end pt-1">
                <span class="badge bg-brand text-white  fs-90 px-1">
                    <strong>Total:</strong> {{number_format(count($prospects))}}
                </span>
            </div>
        </div>
    </div>


    <div class="s-card-header  bg-brother hide-mobile fs-90">
        <div class="row">
            <div class="col-2 border-right">Name</div>
            <div class="col-2 border-right text-center">H. Phone</div>
            <div class="col-2 border-right text-center">M. Phone</div>
            <div class="col-2 border-right text-center">Registration</div>
            <div class="col-1 border-right text-center px-0">Calls Status</div>
            <div class="col-2 border-right text-center">Booking Status</div>
            <div class="col-1 text-center">Sale</div>
        </div>
    </div>


    <div class="s-card-body px-3 py-0">
        @if($prospects->count() > 0)

            @foreach($prospects as $prospect)
                <div class="row s-card-row line-height-30">
                    {{--Prospect Name--}}
                    <div class="col-4 col-lg-2 border-right border-light text-start text-lg-start pe-1">
                        {{$prospect->title}} {{$prospect->name}} {{$prospect->surname}}
                        @if(prospectIsBooked($prospect->id))
                            <a href="{{route('admin.edit.appointment', [$prospect->event_id, $dealership->id, $prospect->id])}}" class="mt-1 float-end btn btn-border brother text-center px-1 py-0 js-admin-book" title="Edit {{$prospect->title}} {{$prospect->name}} {{$prospect->surname}} Appointment">
                                <i class="far fa-edit fs-110"></i>
                            </a>
                        @else
                            <a href="{{route('admin.create.appointment', [$prospect->event_id, $dealership->id, $prospect->id])}}" class="mt-1 float-end btn btn-border sister text-center px-1 py-0 js-admin-book" title="Book {{$prospect->title}} {{$prospect->name}} {{$prospect->surname}}">
                                <i class="fas fa-book-reader fs-110"></i>
                            </a>
                        @endif
                    </div>
                    {{--END Prospect Name--}}

                    {{--Prospect Home Phone--}}
                    <div class="col-4 col-lg-2 text-center border-right hide-mobile">
                        {{$prospect->home_phone}}
                    </div>
                    {{--END Prospect Home Phone--}}

                    {{--Prospect Mobile Number--}}
                    <div class="col-4 col-lg-2 border-right text-center text-lg-start">
                        {{$prospect->mobile}}
                    </div>
                    {{--END Prospect Mobile Number--}}

                    {{--Prospect Vehicle Registration--}}
                    <div class="col-4 col-lg-2 border-right text-center text-lg-start">
                        {{$prospect->vehicle_reg}}
                    </div>
                    {{--END Prospect Vehicle Registration--}}

                    <div class="mob-space py-1 border-bottom"></div>

                    {{--CALL Status Column--}}
                    <div class="col-4 col-lg-1 text-center border-right">

                            {{--callBack($prospect->id) callMade($prospect->id)--}}
                            @if(callBack($prospect->id))
                                <span class="booked-circle bg-warning" title="Require Call Back"></span>
                            @endif

                            @if(callMade($prospect->id))
                                <span class="booked-circle alert-other"  title="Call Made"></span>
                            @endif



                    </div>
                    {{--END call Status--}}

                    {{-- Booking Status--}}
                    <div class="col-4 col-lg-2 text-center border-right">
                        <span class="booked-circle alert-danger" title="Hot prospect"></span>
                    </div>
                    {{--END Booking Status--}}

                    {{--Sale column--}}
                    <div class="col-4 col-lg-1 text-center border-right">
                        @if(isset($prospect->appointment->id))
                            @if(isset($prospect->sale->id))
                                <span  title="Sale Confirmed" class="booked-circle alert-success "></span>
                            @else
                                ----
                            @endif
                        @else
                                ----
                        @endif
                    </div>
                    {{--END Sale column--}}

                </div>
            @endforeach
        @else
            <div class="row">
                <div class="col alert-warning text-dark border border-warning py-1">
                    <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                </div>
            </div>
        @endif
    </div>

    <div class="col-12 border-0 py-2 ">
        <div class="row ">
            <div class="col-12 text-end pt-1">
                <span class="badge bg-brand text-white  fs-90 px-1">
                    <strong>Total:</strong> {{number_format(count($prospects))}}
                </span>
            </div>
        </div>
    </div>

</div>
