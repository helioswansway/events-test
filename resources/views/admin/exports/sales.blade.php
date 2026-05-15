<table>
    <thead>
        <tr>
            <th>Dealership</th>
            <th>Prospect Number</th>
            <th>Exec</th>
            <th>Order Number</th>
            <th>From Appointment</th>
            <th>Sale Type</th>
            <th>Sold a Vehicle</th>
            <th>Finance</th>
            <th>Paint Protection</th>
            <th>Warranty</th>
            <th>GAP</th>
            <th>Smart</th>
            <th>Alloy</th>
            <th>Tyre</th>
            <th>Part Exchange</th>
            <th>Registration</th>

            <th>Created At</th>

        </tr>
    </thead>

    <thead>
        @foreach($sales as $sale)
            <tr>
                <th> {{$sale->dealership->name}}</th>
                <th> {{$sale->customer_number}} </th>
                <th> {{$sale->exec->name}} </th>
                <th> {{$sale->order_number}}</th>
                <th> {{$sale->from_appointment}}</th>
                <th> {{$sale->sale_type}}</th>
                <th> @if($sale->sold_vehicle == 1) Yes @else No @endif </th>
                <th> @if($sale->finance == 1) Yes @else No @endif  </th>
                <th> @if($sale->paint_protection == 1) Yes @else No @endif</th>
                <th> @if($sale->warranty == 1) Yes @else No @endif </th>
                <th> @if($sale->gap == 1) Yes @else No @endif </th>
                <th> @if($sale->smart == 1) Yes @else No @endif </th>
                <th> @if($sale->alloy == 1) Yes @else No @endif </th>
                <th> @if($sale->tyre == 1) Yes @else No @endif </th>
                <th> @if($sale->part_exchange == 1) Yes @else No @endif </th>
                <th> @if($sale->part_exchange == 1) {{$sale->registration}} @else N/A @endif </th>
                <th> {{$sale->created_at}} </th>
            </tr>
        @endforeach
    </thead>
</table>
