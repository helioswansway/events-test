<table>
    <thead>
        <tr>

            <th>Dealership</th>
            <th>Booked By</th>
            <th>Edited By</th>
            <th>Exec</th>
            <th>Cust Name</th>
            <th>Cust Number</th>
            <th>UTM URL</th>
            <th>Cust Mobile</th>
            <th>Cust Home Phone</th>
            <th>Cust Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Model Interest</th>
            <th>Part Exchange</th>
            <th>Mileage</th>
            <th>Registration</th>
            <th>Make</th>
            <th>Colour</th>
            <th>Fuel Type</th>
            <th>Friend Interest</th>
            <th>Friend Model Interest</th>
            <th>Friend Name</th>
            <th>Confirmed</th>
            <th>Arrived</th>
            <th>No Show</th>
            <th>In progress</th>
            <th>Cancelled</th>
            <th>Not Interested</th>
            <th>Completed/Sale</th>
            <th>Call Made</th>
            <th>Call Back</th>
            <th>Call Attempts</th>
            <th>Message Left</th>
            <th>Notes</th>
            <th>Preference</th>
            <th>Drink</th>

            <th>Created At</th>
        </tr>
    </thead>

    <thead>
        @foreach($appointments as $appointment)
            <tr>
                <th>{{dealershipByCode($appointment->dealership_code)->name}}</th>
                <th>{{bookedBy($appointment->booked_by)}}</th>
                <th>{{editedBy($appointment->edited_by)}}</th>
                <th>
                    @if($appointment->exec_id == NULL)
                    @else

                        @if(!empty($appointment->exec->name))
                            {{$appointment->exec->name}}
                        @else
                            {{$appointment->id}}
                        @endif

                    @endif
                </th>
                <th>{{$appointment->title}} {{$appointment->name}} {{$appointment->surname}}</th>
                <th>{{$appointment->customer_number}}</th>
                <th>{{$appointment->utm_url}}</th>
                <th>{{$appointment->mobile}}</th>
                <th>{{$appointment->home_phone}}</th>
                <th>{{$appointment->email}}</th>
                <th>{{$appointment->date}}</th>
                <th>
                    @if($appointment->event_time_id == NULL)
                    @else
                        {{$appointment->eventTime->time}}
                    @endif
                </th>
                <th>{{$appointment->model_interest}}</th>
                <th> @if($appointment->part_exchange == 1) Yes @else No @endif </th>
                <th>{{$appointment->mileage}}</th>
                <th>{{$appointment->registration}}</th>
                <th>{{$appointment->make}}</th>
                <th>{{$appointment->colour}}</th>
                <th>{{$appointment->fuel_type}}</th>
                <th>{{$appointment->friend_interest}}</th>
                <th>{{$appointment->friend_model_interest}}</th>
                <th>{{$appointment->friend_name}}</th>
                <th> @if($appointment->confirm == 1) Yes @else No  @endif </th>
                <th> @if($appointment->arrived == 1) Yes @else No @endif </th>
                <th> @if($appointment->no_show == 1) No Show @else --- @endif </th>

                <th> @if($appointment->in_progress == 1) In Progress @else --- @endif </th>

                <th> @if($appointment->cancelled == 1) Yes @elseif($appointment->cancelled == 2) Cancelled by reception @else No @endif </th>
                <th> @if($appointment->not_interested == 1) Yes @else No @endif </th>
                <th> @if($appointment->completed == 1) Yes @else No @endif </th>
                <th> @if($appointment->call_made == 1) Yes @else No @endif </th>
                <th> @if($appointment->call_back == 1) Yes @else No @endif </th>
                <th> @if($appointment->call_attempts == NULL) 0 @else {{$appointment->call_attempts}}  @endif </th>
                <th> @if($appointment->message_left == 1) Yes @else No @endif </th>
                <th> {{$appointment->notes}} </th>
                <th> {{$appointment->preference}} </th>
                <th> {{$appointment->drink}} </th>

                <th> {{$appointment->created_at}} </th>
            </tr>
        @endforeach
    </thead>

</table>
