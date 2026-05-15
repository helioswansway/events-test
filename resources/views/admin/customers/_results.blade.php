
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


    <div class="s-card-header bg-brother fs-90 px-2">
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
            <div class="col ">
                Exec Assigned too
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
                            {{$customer->email}}
                        </div>

                        <div class="col-4 border-right">
                            @if(!empty(prospectExec($customer->id)))
                                {{prospectExec($customer->id)->name}} - <strong>{{prospectExec($customer->id)->dealership_name}}</strong>
                            @endif
                        </div>

                        <div class="col text-end">
                            <a href="{{route('customer.edit',['id' => $customer->id])}}" class="btn btn-sm btn-border  p-1 info " title="Edit Customer"><i class="far fa-edit"></i></a>

                            @admin('super-admin')
                                <a href="javascript:void(0)" item-id="{{$customer->id}}"  class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Customer"><i class="fa fa-trash"></i></a>
                            @endadmin

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
