<div class="col-lg-4 js-appointment p-0">

    <div class=" s-card-header alert-brand border-0 border-bottom px-3"><i class="fas fa-tag"></i>  Sales Types
        <span class="pop-up-close">X</span>
    </div>

    <div class=" s-card-header bg-brand border-0 border-bottom px-3">
        <div class="row">
            <div class="col-4 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Name
            </div>
            <div class="col text-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Created at
            </div>
        </div>
    </div>

    <div class="s-card-body px-3 py-0">
        @foreach($sales_type as $type)
            <div class="row s-card-row line-height-34">
                <div class="col-4 border-right bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{$type->name}}
                </div>
                <div class="col  text-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ \Carbon\Carbon::parse($type->created_at)->format('d-M-Y h:m:s')}}
                </div>
            </div>
        @endforeach
    </div>
</div>
