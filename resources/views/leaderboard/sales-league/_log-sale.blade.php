<div class="col-lg-6 js-appointment p-0">

    <div class=" s-card-header alert-brand border-0 border-bottom px-3 relative"><i class="fas fa-chart-bar"></i>   Create Sale
        <span class="pop-up-close">X</span>
    </div>
    <div class="s-card-body px-3 ">
        <div class="row">
            <div class="col-lg-6 mt-2">
                <label  class="bold">Dealership</label>
                <input type="text" class="form-control form-control-lg js-dealership-id" dealership-id="{{$dealership->id}}"  value="{{$dealership->name}}" disabled>
            </div>

            <div class="col-lg-6 mt-2">
                <label class="bold">Sales Exec</label>
                <input   type="text" class="form-control form-control-lg js-exec-id" exec-id="{{$exec->id}}"  value="{{$exec->name}}" disabled>
            </div>

            <div class="col-lg-4 mt-2">
                <label  class="bold">Sale Type <span class="text-danger">*</span></label>
                <select name="sale_types_id" id="sale_types_id" class="form-control form-control-lg js-sale-type">
                    <option value="">--Select one--</option>
                    @foreach($sales_type as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <span class="js-error text-danger"></span>
            </div>

            <div class="col-lg-4 mt-2">
                <label  class="bold">Customer Name <span class="text-danger">*</span></label>
                <input id="customer" type="text" class="form-control form-control-lg js-customer" name="customer"   value="">
                <span class="js-error text-danger"></span>
            </div>

            <div class="col-lg-4 mt-2">
                <label for="order_number" class="bold">Vehicle Reg Number <span class="text-danger">*</span></label>
                <input   id="order_number" type="text" class="form-control form-control-lg js-order-number" name="order_number"  value="" >
                <span class="js-error text-danger "></span>
            </div>

        </div>

        <div class="row my-3">
            <div class="col-lg-12">
                <a href="javascript:void(0)"class="btn btn-action sister block js-submit-log">Submit Log</a>
            </div>
        </div>

    </div>
</div>
