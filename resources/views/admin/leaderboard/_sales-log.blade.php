
<div class="col-lg-6 js-appointment p-0 ">
    <div class="row">
    <div class=" s-card-header alert-brand border-0 border-bottom py-2 relative"><i class="fas fa-chart-bar"></i>   {{$leaderboard->name}} - <span class="text-dark fs-90 normal">Total: {{count($logs)}}</span>
        <span class="pop-up-close">X</span>
    </div>
    <div class="s-card-body py-3">
        <div class="s-card-header  bg-dark text-white py-2 border-0">
            <div class="row normal">
                <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Sale Type
                </div>

                <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Order Number
                </div>

                <div class="col-2  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Customer
                </div>
                <div class="col-3  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Created At
                </div>
            </div>
        </div>
        <div class="s-card-body py-0 px-3">
            @foreach($logs as $log)
                <div class="row s-card-row fs-90" style="padding-top:6px; padding-bottom:6px;">
                    <div class="col-2 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->name}}
                    </div>

                    <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->order_number}}
                    </div>

                    <div class="col-2  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->customer}}
                    </div>
                    <div class="col-3  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->created_at}}
                    </div>
                    <div class="col text-end p-0" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <a href="{{route('leaderboard.edit.log', [$log->id, $competition_id])}}" class="btn btn-sm btn-border px-1 py-0 info js-edit" title="Edit sale"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" item-id="{{$log->id}}" class="btn btn-sm btn-border px-1 py-0 warning js-delete" title="Delete sale"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
    </div>

