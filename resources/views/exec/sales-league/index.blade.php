@extends('_layouts._exec-dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>
    <h1 class="display-4 pb-4">
        <i class="fas fa-chart-bar"></i> Sales League       <span class="float-right" style="position: relative; top:-20px;"> <img src="{{asset('assets/images/public/general/')}}/{{$brand->filename}}" alt="" style="width: 70px">  <span class="fs-150 ml-2 bold" style="position: relative; top:5px;">{{$brand->name}}</span></span>
    </h1>

    @include('admin.inc._messages')

    <div class="s-card shadow ">
        <div class="s-card-header col-12 bg-other text-white">
            <div class="row">
                <div class="col">Sales Log </div>
                <div class="col text-end"><a href="javascript:void(0)" class="btn py-0 px-2 btn-default sister normal mr-3 js-create-sale-league" exec-id="{{$exec->id}}" dealership-id="{{$dealership->id}}" >Log Sale <i class="fas fa-plus"></i></a> Total: {{count($total_sales)}}</div>
            </div>
        </div>

        <div class="s-card-header alert-sister border-0 border-bottom text-brand d-none d-lg-block d-xl-block">
            <div class="row ">
                <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Sales Exec
                </div>

                <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Dealership
                </div>

                <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Sales
                </div>

                <div class="col text-end">
                    Total Sales
                </div>

            </div>
        </div>

        <div class="s-card-body py-0">
            @if(count($sales) > 0)
                @foreach($sales as $sale)
                    <div class="row s-card-row py-1 line-height-34">

                        <div class="col-lg-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Exec: </span>
                            {{$sale->exec->name}}
                        </div>

                        <div class="col-lg-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                            {{dealership($sale->exec->id)->name}}
                        </div>

                        <div class="col-lg-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <span class="d-xl-none d-lg-none bold text-brand mr-2"> Sales: </span>
                            {{$sale->total}}
                        </div>

                        <div class="col  text-end">
                            {{$sale->total}}
                        </div>
                    </div>

                @endforeach


                <div class="row">
                    <div class="col bg-white border-top  py-3">
                        {{ $sales->links() }}
                    </div>
                </div>



            @else
                <div class="row">
                    <div class="col-12 alert-warning text-dark border border-warning p-3">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="py-5 my-3"></div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>



    </script>



@endsection
