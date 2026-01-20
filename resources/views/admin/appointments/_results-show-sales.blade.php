
<div class="s-card shadow">

    <div class="s-card-header bg-brother hide-mobile fs-90">
        <div class="row">
            <div class="col-2 border-right">Exec Name</div>
            <div class="col-2 border-right">Prospect Name</div>
            <div class="col-1 border-right text-center">Order Number</div>
            <div class="col-1 border-right text-center">Sale Type</div>
            <div class="col-5 border-right text-center px-0">Add-ons</div>
            <div class="col-1 text-center">
                <a href="{{route('admin.sale.export.all', [Request::segment(5)])}}" class="text-sister" title="Export all Sales">
                    <i class="fas fa-file-csv fs-200 bold "></i>
                </a>
            </div>
        </div>
    </div>


    <div class="s-card-body px-3 pt-0 pb-0">
        @if($sales->count() > 0)

        @foreach($sales as $sale)
            <div class="row s-card-row line-height-30">
                {{--Exec Name--}}
                <div class="col-4 col-lg-2 border-right border-light text-start text-lg-start">
                    {{$sale->exec->name}}
                </div>
                {{--END Exec Name--}}

                {{--Prospect Name--}}
                <div class="col-4 col-lg-2 border-right border-light text-start text-lg-start">
                    {{$sale->book->title}} {{$sale->book->name}} {{$sale->book->surname}}
                </div>
                {{--END Prospect Name--}}

                {{--Order Number--}}
                <div class="col-4 col-lg-1 text-center border-right hide-mobile">
                    {{$sale->order_number}}
                </div>
                {{--END Order Number--}}

                {{--Sale Type--}}
                <div class="col-4 col-lg-1 border-right text-center text-lg-start">
                    {{$sale->sale_type}}
                </div>
                {{--END Sale Type--}}

                {{--Finance--}}
                <div class="col-4 col-lg-5 border-right fs-80 bold text-center text-lg-start">
                    @if($sale->finance == 1) <span class="me-1 alert-brand px-1 rounded py-0">Finance</span> @endif
                    @if($sale->sold_vehicle == 1) <span class="me-1 alert-brand px-1 rounded py-0">Vehicle Sold</span> @endif
                    @if($sale->paint_protection == 1) <span class="me-1 alert-brand px-1 rounded py-0">Paint Protection</span> @endif
                    @if($sale->warranty == 1) <span class="me-1 alert-brand px-1 rounded py-0">Warranty</span> @endif
                    @if($sale->gap == 1) <span class="me-1 alert-brand px-1 rounded py-0">Gap</span> @endif
                    @if($sale->smart == 1) <span class="me-1 alert-brand px-1 rounded py-0">Smart</span> @endif
                    @if($sale->alloy == 1) <span class="me-1 alert-brand px-1 rounded py-0">Alloy</span> @endif
                    @if($sale->tyre == 1) <span class="me-1 alert-brand px-1 rounded py-0">Tyre</span> @endif
                </div>
                {{--END Finance--}}

                <div class="mob-space py-1 border-bottom"></div>

                {{--Exec--}}
                <div class="col-4 col-lg-1 text-center border-right">
                    <a href="{{route('admin.sale.edit', $sale->id)}}" title="Edit Sale"><i class="fas fa-tags"></i></a>
                </div>
                {{--END Exec--}}

                {{--Sale column --}}
                    <div class="col-4 col-lg-1 text-center ">
                        {{-- @if($event->inc_exec == 1)
                            @if(prospectIsBooked($prospect->id))
                                @if(hasSale($prospect->id))
                                    <span class="icon booked-circle alert-success "></span>
                                @else
                                <a href="{{route('admin.sale.create', $prospect->id)}}" title="Create Sale"><i class="fas fa-tags"></i></a>
                                @endif
                            @else
                                ---
                            @endif
                        @else
                            ---
                        @endif --}}
                    </div>
                {{--END Sale column--}}

            </div>
        @endforeach
        @else
            <div class="row">
                <div class="alert-warning text-dark border border-warning p-3">
                    <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                </div>
            </div>

        @endif
    </div>
</div>
