@extends('_layouts._exec-dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-tags"></i> Sales
        <span class="h1-button" style="">
            <a href="{{route('exec.appointment.index')}}" class="btn btn-border sister "><i class="fas fa-calendar-alt"></i> Appointments</a>
        </span>
    </h1>

    @include('admin.inc._messages')

    <div class="s-card-header bg-white">
        <div class="row">
            <div class="col">Sales Log</div>
            <div class="col text-end">Total: {{count($sales)}}</div>
        </div>
    </div>

    <div class="s-card shadow">
        <div class="s-card-header bg-brand border-0 hide-mobile">
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

                <div class="col-1  border-end text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Sale Type
                </div>

                <div class="col-1  border-end text-center">
                    Gap
                </div>

                <div class="col-1  border-end text-center">
                    Finance
                </div>

                <div class="col-1  border-end text-center">
                    Paint
                </div>

                <div class="col-1  border-end text-center">
                    Smart
                </div>

            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            @if(count($sales) > 0)
                @foreach($sales as $sale)
                    <div class="row s-card-row line-height-40">
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

                        <div class="col-lg-1  border-end text-lg-center">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Gap: </span>
                            @if($sale->gap == 1) <span title="Gap Sold" class="booked-circle bg-success"></span> @else -- @endif
                        </div>

                        <div class="col-lg-1  border-end text-lg-center">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Finance: </span>
                            @if($sale->finance == 1) <span title="Finance Sold" class="booked-circle bg-success"></span> @else -- @endif
                        </div>

                        <div class="col-lg-1  border-end text-lg-center">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Paint: </span>
                            @if($sale->paint_protection == 1) <span title="Paint protection Sold" class="booked-circle bg-success"></span> @else -- @endif
                        </div>

                        <div class="col-lg-1  border-end text-lg-center">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Smart: </span>
                            @if($sale->smart == 1) <span title="Smart Sold" class="booked-circle bg-success"></span> @else -- @endif
                        </div>

                        <div class="col text-center">
                            <a href="{{route('exec.sale.edit', $sale->id)}}" class="btn btn-border brother text-center px-1 py-0" title="View/Edit Sale Log Details">
                                <i class="far fa-edit fs-110"></i>
                            </a>

                            <a href="javascript:void(0)" class="d-none d-lg-block d-xl-block js-view-sale hide" sale-id="{{$sale->id}}" ><i title="View Sale Log Details" class="fas fa-search"></i></a>
                            <a href="" class="d-xl-none d-lg-none  btn btn-border sister block js-view-sale hide" sale-id="{{$sale->id}}">View Log</a>
                        </div>
                    </div>
                @endforeach

            @else
                <div class="row">
                    <div class="alert-warning text-dark border border-warning px-3 py-2">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="py-3 col-12"></div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>



    </script>



@endsection
