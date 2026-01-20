<table>
    <thead>
        <tr>
            <th>Unique Number</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Exec Assigned to</th>
            <th>Dealership</th>
            <th>Appointment Status</th>
        </tr>
    </thead>

    <thead>
        @foreach($prospects as $prospect)
            <tr>
                <th>{{$prospect->customer_number}}</th>
                <th>{{$prospect->title}} {{$prospect->name}} {{$prospect->surname}}</th>
                <th>{{$prospect->mobile}}</th>
                <th>{{$prospect->email}}</th>
                <th>{{$exec->name}}</th>
                <th>{{prospectExec($prospect->id)->dealership_name}}</th>
                <th>
                    @if(!empty(prospectAppointmentStatus($prospect->id)))

                        @if(prospectAppointmentStatus($prospect->id)->confirm == 1)
                            Confirmed
                        @endif

                        @if(prospectAppointmentStatus($prospect->id)->in_progress == 1)
                            In Progress
                        @endif

                        @if(prospectAppointmentStatus($prospect->id)->not_interested == 1)
                            Not Interested
                        @endif

                        @if(prospectAppointmentStatus($prospect->id)->cancelled == 1)
                            Cancelled
                        @endif

                        @if(prospectAppointmentStatus($prospect->id)->confirm == 0 && prospectAppointmentStatus($prospect->id)->booked_by == NULL && prospectAppointmentStatus($prospect->id)->edited_by == NULL)
                            Hot Leads
                        @endif

                    @endif

                </th>
            </tr>
        @endforeach
    </thead>

</table>
