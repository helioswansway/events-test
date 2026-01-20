<table>
    <thead>
        <tr>
            <th>Dealership</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>

    <thead>
        @foreach($execs as $exec)
            <tr>
                <th>{{$dealership->name}}</th>
                <th>{{$exec->name}}</th>
                <th>{{$exec->email}}</th>
            </tr>
        @endforeach
    </thead>

</table>
