@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4"><i class="fas fa-user-plus"></i> Edit Sales Log

        <span class="h1-button" style="">
            <a href="{{route('admin.leaderboard.index')}}" class="btn btn-sm btn-default sister px-2 me-1"><i class="fas fa-angle-double-left"></i> Back</a>
        </span>

    </h1>


    @include('admin.inc._messages')
    <form action="{{route('admin.leaderboard.update.log', [$log->id])}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        {{ method_field('POST') }}
        <input type="hidden" name="competition_id" value="{{$competition_id}}">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="s-card shadow">
                    <div class="s-card-header bg-brother">
                        <div class="row">
                            <div class="col">Update Sales Log:</div>
                        </div>

                    </div>

                    <div class="s-card-body p-3">
                        <div class="row">
                            <div class="col-lg-4 mt-2">
                                <label  class="bold">Sale Type <span class="text-danger">*</span></label>
                                <select name="sale_types_id" id="sale_types_id" class="form-control form-control-lg js-sale-type">
                                    <option value="">--Select one--</option>
                                    @foreach($sales_type as $type)
                                        <option value="{{$type->id}}"
                                            @if($log->sale_types_id == $type->id) selected @endif
                                        >{{$type->name}}</option>
                                    @endforeach
                                </select>
                                <span class="js-error text-danger"></span>
                            </div>

                            <div class="col-lg-4 mt-2">
                                <label  class="bold">Customer Name <span class="text-danger">*</span></label>
                                <input id="customer" type="text" class="form-control form-control-lg" name="customer" value="{{$log->customer}}" required>
                            </div>

                            <div class="col-lg-4 mt-2">
                                <label for="order_number" class="bold">Vehicle Reg Number <span class="text-danger">*</span></label>
                                <input   id="order_number" type="text" class="form-control form-control-lg js-order-number" name="order_number" value="{{$log->order_number}}" required>
                            </div>

                        </div>

                        <div class="row my-3">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-action brand block  ">Save Log</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('scripts')



@endsection
