<div class="s-card shadow">

    <div class="col-12 alert-light border-0 py-2 ">
        <div class="row ">
            <div class="col-9">
                {{ $customers->links() }}
                <span class="float-start badge bg-brand text-white px-1 fs-90" style="margin-top: 5px;">
                    Results: {{number_format($customers->count())}}
                </span>
            </div>

            <div class="col-3 text-end ">
                <span class="badge bg-brand text-white  fs-90 px-1"  style="margin-top: 5px;">
                    <strong>Total:</strong> {{number_format($customers->total())}}
                </span>
            </div>
        </div>
    </div>


    <div class="s-card-header bg-brother fs-90 px-3">
        <div class="row">
            <div class="col-2 border-right">
                Name
            </div>
            <div class="col-2 border-right">
                Phone
            </div>
            <div class="col-2  border-right">
                Email
            </div>
            <div class="col-2  border-right">
                Exec Assigned too
            </div>

            <div class="col-2  text-center  border-right">
                Appointment Info
            </div>

        </div>
    </div>


    <div class="s-card-body px-3 py-0  fs-90"">

            @if($customers->count() > 0)

                @foreach($customers as $customer)
                    <div class="row s-card-row py-1">

                        <div class="col-2 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{$customer->title}} {{$customer->name}} {{$customer->surname}}
                        </div>

                        <div class="col-2 border-right">
                            @if(empty($customer->mobile))
                                {{$customer->home_phone}}
                            @else
                                {{$customer->mobile}}
                            @endif
                        </div>

                        <div class="col-2 border-right">
                            {{$customer->email}} {{$customer->id}}
                        </div>

                        <div class="col-2 border-right">
                            @if(!empty(prospectExec($customer->id)))
                                {{prospectExec($customer->id)->name}} - <strong>{{prospectExec($customer->id)->dealership_name}}</strong>
                            @endif
                        </div>

                        <div class="col-2 text-center border-right">
                            @if(!empty(prospectAppointmentStatus($customer->id)))

                                @if(prospectAppointmentStatus($customer->id)->confirm == 1)
                                    <span class="icon-list"> <span class="icon-name"> Confirmed</span> <span class="icon booked-circle border border-secondary"></span> </span>
                                @endif

                                @if(prospectAppointmentStatus($customer->id)->in_progress == 1)
                                    <span class="icon-list"> <span class="icon-name"> In Progress</span> <span class="icon booked-circle border border-warning"></span> </span>
                                @endif

                                @if(prospectAppointmentStatus($customer->id)->not_interested == 1)
                                    <span class="icon-list"> <span class="icon-name"> Not Interested</span> <span class="icon booked-circle border border-info"></span> </span>
                                @endif

                                @if(prospectAppointmentStatus($customer->id)->cancelled == 1)
                                    Cancelled
                                @endif

                                @if(prospectAppointmentStatus($customer->id)->confirm == 0 && prospectAppointmentStatus($customer->id)->booked_by == NULL && prospectAppointmentStatus($customer->id)->edited_by == NULL)
                                    <span class="icon-list"> <span class="icon-name"> Hot Leads</span> <span class="icon booked-circle border border-danger"></span> </span>
                                @endif

                            @endif
                        </div>


                    </div>
                @endforeach

            @else

            <div class="row">
                <div class="alert-warning text-dark border border-warning px-2 py-2">
                    <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                </div>
            </div>

            @endif

    </div>

    <div class="col-12 border-0 py-2 ">
        <div class="row ">
            <div class="col-9">
                {{ $customers->links() }}
            </div>

            <div class="col-3 text-end pt-1">
                <span class="badge bg-brand text-white  fs-90 px-1">
                    <strong>Total:</strong> {{number_format($customers->total())}}
                </span>
            </div>
        </div>
    </div>

</div>
