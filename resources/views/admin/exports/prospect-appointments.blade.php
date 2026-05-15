<table>
    <thead>
        <tr>
            <th>Event</th>
            <th>Customer Number</th>
            <th>Dealership</th>
            <th>Title</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Home Phone</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address 1</th>
            <th>Address 2</th>
            <th>Address 3</th>
            <th>Address 4</th>
            <th>Address 5</th>
            <th>Post Code</th>
            <th>Vehicle Registration</th>
            <th>Vehicle Description</th>
            <th>Confirmed</th>
            <th>In Progress</th>
            <th>Cancelled</th>
            <th>Not Interested</th>
            <th>Created At</th>
        </tr>
    </thead>

    <thead>
        @foreach($prospects as $prospect)
            <tr>
                <th>{{$prospect->event_name}}</th>
                <th>{{$prospect->customer_number}}</th>
                <th>{{$prospect->dealership_name}}</th>
                <th>{{$prospect->title}}</th>
                <th>{{$prospect->name}}</th>
                <th>{{$prospect->surname}}</th>
                <th>{{$prospect->home_phone}}</th>
                <th>{{$prospect->mobile}}</th>
                <th>{{$prospect->email}}</th>
                <th>{{$prospect->address_1}}</th>
                <th>{{$prospect->address_2}}</th>
                <th>{{$prospect->address_3}}</th>
                <th>{{$prospect->address_4}}</th>
                <th>{{$prospect->address_5}}</th>
                <th>{{$prospect->post_code}}</th>
                <th>{{$prospect->vehicle_reg}}</th>
                <th>{{$prospect->vehicle_description}}</th>

                <th>

                    @if($prospect->confirm == 1)
                        Yes
                    @else
                        No
                    @endif

                </th>

                <th>

                    @if($prospect->in_progress == 1)
                        Yes
                    @else
                        No
                    @endif

                </th>

                <th>

                    @if($prospect->cancelled == 1)
                        Yes
                    @else
                        No
                    @endif

                </th>

                <th>

                    @if($prospect->not_interested == 1)
                        Yes
                    @else
                        No
                    @endif

                </th>

                <th>{{$prospect->created_at}}</th>
            </tr>
        @endforeach
    </thead>

</table>
