@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-tags"></i>
        Sales for {{$dealership->name}}
        <span class="h1-button" style="">
            <a href="{{route('admin.appointment.prospect',[$event_id, $dealership->id])}}" class="btn btn-sm btn-default brother px-3 py-1 "><i class="fas fa-angle-double-left mr-2"></i> Back</a>
        </span>
    </h1>

    @include('admin.inc._messages')


    <div class="col-12">
        <div class="row">
            <div class="s-card-header  alert-light">
                <div class="row">
                    <div class="col">Sales Log</div>
                    <div class="col text-end">Total: {{count($sales)}}</div>
                </div>
            </div>

            <div class="s-card-header bg-brand border-0 border-bottom hide-mobile">
                <div class="row">
                    <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Exec
                    </div>

                    <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Dealership
                    </div>

                    <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Customer
                    </div>
                    <div class="col-1 border-end text-center">Sale Type</div>

                    <div class="col-4 text-center border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Add-ons
                    </div>
                </div>
            </div>

            <div class="s-card-body p-0">
                @if(count($sales) > 0)
                    @foreach($sales as $sale)

                            <div class="col-12">
                                <div class="row s-card-row py-1 line-height-34">
                                    <div class="col-lg-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Exec: </span>
                                        {{$sale->exec->name}}
                                    </div>

                                    <div class="col-lg-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                                        {{$sale->dealership->name}}
                                    </div>

                                    <div class="col-lg-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Customer: </span>
                                        {{$sale->book->title}} {{$sale->book->name}} {{$sale->book->surname}}
                                    </div>

                                    <div class="col-lg-1  border-end text-lg-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Sale Type: </span>
                                        @if($sale->sale_type) {{$sale->sale_type}} @else -- @endif
                                    </div>

                                    <div class="col-lg-4  border-end text-lg-center">
                                        @if($sale->finance == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Finance</span> @endif
                                        @if($sale->sold_vehicle == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Vehicle Sold</span> @endif
                                        @if($sale->paint_protection == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Paint Protection</span> @endif
                                        @if($sale->warranty == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Warranty</span> @endif
                                        @if($sale->gap == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Gap</span> @endif
                                        @if($sale->smart == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Smart</span> @endif
                                        @if($sale->alloy == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Alloy</span> @endif
                                        @if($sale->tyre == 1) <span class="me-1 alert-success px-1 rounded py-0 fs-90">Tyre</span> @endif
                                    </div>

                                    <div class="col text-center">

                                        <a href="{{route('admin.sale.edit', $sale->id)}}" class="btn btn-border brother text-center px-1 py-0" title="View/Edit Sale Log Details">
                                            <i class="far fa-edit fs-110"></i>
                                        </a>

                                        <a href="javascript:void(0)" class="d-none d-lg-block d-xl-block js-view-sale hide" sale-id="{{$sale->id}}" ><i title="View Sale Log Details" class="fas fa-search"></i></a>
                                        <a href="" class="d-xl-none d-lg-none  btn btn-border sister block js-view-sale hide" sale-id="{{$sale->id}}">View Log</a>
                                    </div>
                                </div>
                            </div>
                    @endforeach

                @else
                    <div class="alert-warning text-dark border border-warning p-3">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                @endif

            </div>
        </div>


    </div>


    <div class="py-3 col-12"></div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>



    </script>



@endsection
