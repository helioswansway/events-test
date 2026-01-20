
<div class="col-lg-6 js-appointment p-0 ">
    <div class=" s-card-header alert-brand border-0 border-bottom px-3 py-3 relative"><i class="fas fa-chart-bar"></i>   {{$leaderboard->name}} - <span class="text-dark fs-90 normal">Total: {{count($logs)}}</span>
        <span class="pop-up-close">X</span>
    </div>
    <div class="s-card-body px-3 py-3">
        <div class="s-card-header  bg-dark text-white py-2 border-0">
            <div class="row normal">
                <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Sale Type
                </div>
                <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Order Number
                </div>

                <div class="col-3  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Customer
                </div>
                <div class="col-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Created At
                </div>
            </div>
        </div>
        <div class="s-card-body px-3">
            @foreach($logs as $log)
                <div class="row s-card-row py-1 fs-90">
                    <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->name}}
                    </div>

                    <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->order_number}}
                    </div>

                    <div class="col-3  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->customer}}
                    </div>
                    <div class="col-3 " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{$log->created_at}}
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</div>
