
<div class="s-card shadow">

    <div class="s-card-header border-0">
        <div class="row ">
            <div class="col-9">
                {{ $prospects->links() }}
                <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                    Results: {{number_format($prospects->count())}}
                </span>
            </div>

            <div class="col-3 pr-3 text-end pt-1">
                <span class="badge bg-brand text-white  fs-90 px-1">
                    <strong>Total:</strong> {{number_format($prospects->total())}}
                </span>
            </div>
        </div>
    </div>


    <div class="s-card-header bg-brother hide-mobile fs-90">
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
                            <a href="{{route('admin.edit.appointment', [$prospect->event_id, $dealership->id, $prospect->id])}}" class="float-end btn btn-border brother text-center px-1 py-0 mt-1 js-admin-book" title="Edit {{$prospect->title}} {{$prospect->name}} {{$prospect->surname}} Appointment">
                                <i class="far fa-edit fs-110"></i>
                            </a>
                        @else
                            <a href="{{route('admin.create.appointment', [$prospect->event_id, $dealership->id, $prospect->id])}}" class="float-end btn btn-border sister text-center px-1 py-0 mt-1 js-admin-book" title="Book {{$prospect->title}} {{$prospect->name}} {{$prospect->surname}}">
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
                        @if(empty($prospect->appointment->id))
                        ----
                        @endif

                        @if(isset($prospect->appointment->id))
                            {{--callBack($prospect->id) callMade($prospect->id)--}}
                            @if($prospect->appointment->call_back == 1)
                                <span class="booked-circle bg-warning" title="Require Call Back"></span>
                            @endif

                            @if($prospect->appointment->call_made == 1)
                                <span class="booked-circle alert-other"  title="Call Made"></span>
                            @endif
                        @endif

                    </div>
                    {{--END call Status--}}

                    {{-- Booking Status--}}
                        <div class="col-4 col-lg-2 text-center border-right">
                            @if(isset($prospect->appointment->id))
                                @if($prospect->appointment->completed == 1)
                                    <span class="booked-circle bg-sister" title="completed"></span>
                                @endif

                                @if($prospect->appointment->in_progress == 1)
                                    <span class="booked-circle border border-warning" title="In Progress"></span>
                                @endif

                                @if($prospect->appointment->confirm == 1)
                                    <span class="booked-circle bg-success" title="Appointment Confirmed"></span>
                                @endif

                                @if($prospect->appointment->cancelled == 1)
                                    <span class="booked-circle bg-danger" title="Appointment Cancelled"></span>
                                @endif

                                @if($prospect->appointment->confirm == 0 &&  $prospect->appointment->cancelled == 0  &&  $prospect->appointment->not_interested == 0 &&  $prospect->appointment->in_progress == 0 &&  $prospect->appointment->completed == 0)
                                    <span class="booked-circle alert-danger" title="Hot Prospect"></span>
                                @endif

                                @if($prospect->appointment->not_interested == 1)
                                    <span class="icon booked-circle alert-info " title="Prospect not interested"></span>
                                @endif

                            @else
                                ----
                            @endif

                        </div>
                    {{--END Booking Status--}}

                    {{--Sale column--}}
                        <div class="col-4 col-lg-1 text-center ">

                            {{-- @if(isset($prospect->appointment->not_interested) && $prospect->appointment->not_interested == 1)
                                ---
                            @else
                                @if(isset($prospect->appointment->id))
                                    @if(isset($prospect->sale->id))
                                        <span  title="Sale Confirmed" class="booked-circle alert-success "></span>
                                    @endif
                                @endif
                            @endif --}}

                            @if(isset($prospect->appointment->confirm) && $prospect->appointment->confirm == 0 || isset($prospect->appointment->completed) && $prospect->appointment->completed == 0)
                                - -
                            @endif

                            @if(isset($prospect->appointment->confirm) && $prospect->appointment->confirm == 1)
                                <a href="{{route('admin.sale.create', $prospect->appointment->id)}}" title="Add a Sale"><i class="fas fa-tags fs-120"></i></a>
                            @endif

                            @if(isset($prospect->appointment->completed) && $prospect->appointment->completed == 1)
                                <span class="icon booked-circle alert-success "></span>
                                <a href="{{route('admin.sale.edit', $prospect->sale->id)}}" title="Edit Sale"><i class="fas fa-tags fs-120 text-warning"></i></a>
                            @endif

                            {{-- @if(prospectIsBooked($prospect->appointment->book_id))
                                @if(hasSale($prospect->appointment->book_id))
                                    <span class="icon booked-circle alert-success "></span>
                                    <a href="{{route('admin.sale.edit', $prospect->sale->id)}}" title="Edit Sale"><i class="fas fa-tags fs-120 text-warning"></i></a>

                                @else
                                    <a href="{{route('admin.sale.create', $prospect->id)}}" title="Add a Sale"><i class="fas fa-tags fs-120"></i></a>
                                @endif
                            @else
                                ---
                            @endif --}}
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
