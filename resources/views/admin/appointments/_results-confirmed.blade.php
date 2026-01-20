
<div class="s-card shadow">

    <div class="s-card-header border-0 ps-0">
        <div class="row ">
            <div class="col-9">
                {{ $prospects->links() }}
                <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                    Results: {{number_format($prospects->count())}}
                </span>
            </div>

            <div class="col-3 text-end pr-3  pt-1">
                <span class="badge bg-brand text-white  fs-90 px-1">
                    <strong>Total:</strong> {{number_format($prospects->total())}}
                </span>
            </div>
        </div>
    </div>


    <div class="s-card-header bg-brand  hide-mobile fs-90">
        <div class="row">
            <div class="col-2 border-right">Name</div>
            <div class="col-2 border-right text-center">H. Phone</div>
            <div class="col-2 border-right text-center">M. Phone</div>
            <div class="col-2 border-right text-center">Registration</div>
            <div class="col-1 border-right text-center">Calls Status</div>
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

                    <a href="{{route('admin.edit.appointment', [$prospect->event_id, $dealership->id, $prospect->id])}}" class="mt-1 float-end btn btn-border brother text-center px-1 py-0 js-admin-book" title="Edit {{$prospect->title}} {{$prospect->name}} {{$prospect->surname}} Appointment">
                        <i class="far fa-edit fs-110"></i>
                    </a>

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

                        @if($prospect->call_back == 1 || $prospect->call_made == 1)
                            {{--callBack($prospect->id) callMade($prospect->id)--}}
                            @if($prospect->call_back == 1)
                                <span class="booked-circle bg-warning" title="Require Call Back"></span>
                            @endif

                            @if($prospect->call_made == 1)
                                <span class="booked-circle alert-other"  title="Call Made"></span>
                            @endif

                        @else

                            ----

                        @endif


                </div>
                {{--END call Status--}}

                {{-- Booking Status--}}
                <div class="col-4 col-lg-2 text-center border-right">
                    <span class="booked-circle bg-success" title="Appointment Confirmed"></span>
                </div>
                {{--END Booking Status--}}

                {{--Sale column --}}
                    <div class="col-4 col-lg-1 text-center border-right">
                        @if($event->inc_exec == 1)
                            @if(prospectIsBooked($prospect->id))
                                @if(hasSale($prospect->id))
                                    <span class="icon booked-circle alert-success "></span>
                                @else
                                <a href="{{route('admin.sale.create', $prospect->id)}}" title="Create Sale"><i class="fas fa-tags"></i></a>
                                @endif
                            @else
                                ---
                            @endif
                        @else
                            ---
                        @endif
                    </div>
                {{--END Sale column--}}

            </div>
        @endforeach
        @else
        <div class="row">
            <div class="alert-warning text-dark border border-warning p-3">
                <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
            </div>
        </div>

        @endif

    </div>

    <div class="col-12 border-0 py-2 ">
        <div class="px-2">
            <div class="row ">
                <div class="col-9">
                    {{ $prospects->links() }}
                </div>

                <div class="col-3 pr-3 text-end pt-1">
                    <span class="badge bg-brand text-white  fs-90 px-1">
                        <strong>Total:</strong> {{number_format($prospects->total())}}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
