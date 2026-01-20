<table>
    <thead>
        <tr>

            <th>Dealership</th>
            <th>Prospects Invited</th>
            <th>Appointments</th>
            <th>%</th>
            <th>Sales</th>

        </tr>
    </thead>

    <thead>
        @foreach($appointments as $appointment)
            @php
                $prospects_count = prospectsArchivedCount($appointment->dealership->code, $appointment->event_id);
                $appointments_count = appointmentsConfirmedArchivedCount($appointment->dealership->code, $appointment->event_id);
            @endphp
            <tr>
                <th>{{$appointment->dealership->name}}</th>
                <th>{{$prospects_count}}</th>
                <th>{{$appointments_count}}</th>
                <th>
                    {{number_format(($appointments_count / $prospects_count) * 100, 2)}}%
                </th>
                <th>
                    @if(salesArchivedCount($appointment->dealership->code, $appointment->event_id) > 0)
                       {{ salesArchivedCount($appointment->dealership->code, $appointment->event_id)}}
                    @else
                        0
                    @endif
                </th>
            </tr>
        @endforeach
    </thead>

</table>
