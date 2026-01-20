<table>
    <thead>
        <tr>

            <th>Exec Name</th>
            <th>Dealership</th>
            <th>Code</th>
            <th>Email</th>

        </tr>
    </thead>

    <thead>
        @foreach($execs as $exec)
            <tr>
                <th>{{$exec->name}}</th>

                @if(dealershipByCode($exec->dealership_code))
                    <th>
                        {{dealershipByCode($exec->dealership_code)->name}}
                    </th>
                    <th>{{$exec->dealership_code}}</th>

                @else
                    <th>DEALERSHIP CODE NOT VALID ({{$exec->dealership_code}})</th>
                    <th> </th>

                @endif


                <th>{{$exec->email}}</th>
            </tr>
        @endforeach
    </thead>

</table>
