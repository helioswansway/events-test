<table>
    <thead>
        <tr>
            <th>Dealership</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Handled by</th>
            <th>Booking Status</th>
            <th>Call Status</th>
            <th>Call Attempts</th>
            <th>Left Message</th>
            <th>Notes</th>
        </tr>
    </thead>

    <thead>
        @foreach($pot_lists as $list)
            <tr>
                <th>{{$list->dealership->name}}</th>
                <th>{{$list->title}} {{$list->first_name}} {{$list->last_name}}</th>
                <th>{{$list->email}}</th>
                <th>{{$list->phone}}</th>
                <th>
                    @if(isset($list->admin->name))
                        {{$list->admin->name}}
                    @else
                        N/A
                    @endif
                </th>
                <th>{{$list->booking_status}}</th>
                <th>{{$list->call_status}}</th>
                <th>{{$list->call_attempts}}</th>
                <th>{{$list->message_left}}</th>
                <th>{{$list->notes}}</th>
            </tr>
        @endforeach
    </thead>
</table>
