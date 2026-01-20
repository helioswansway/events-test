<table>
    <thead>
        <tr>
            <th>Sales Exec</th>
            <th>Dealership</th>
            <th>Sale Type</th>
            <th>Order Number</th>
            <th>Customer</th>
            <th>Created At</th>
        </tr>
    </thead>

    <thead>
        @foreach($sales as $sale)
            <tr>
                <th>{{$sale->leaderboard->name}}</th>
                <th>{{dealership($sale->leaderboard_id)->name}}</th>
                <th>{{sale_type($sale->sale_types_id)->name}}</th>
                <th>{{$sale->order_number}}</th>
                <th>{{$sale->customer}}</th>
                <th>{{$sale->created_at}}</th>
            </tr>
        @endforeach
    </thead>
</table>
