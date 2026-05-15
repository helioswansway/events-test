<div class="col-lg-6 js-appointment p-0">

    <div class=" s-card-header alert-brand border-0 border-bottom px-3 py-3"><i class="fas fa-chart-bar"></i>   Create Sale
        <span class="pop-up-close">X</span>
    </div>
    <div class="s-card-body">
        <div class="row">
            <div class="col-lg-6 mt-3">
                <label  class="bold">Dealership</label>
                <input type="text" class="form-control form-control-lg js-dealership-id" dealership-id="{{$dealership->id}}"  value="{{$dealership->name}}" disabled>
            </div>

            <div class="col-lg-6 mt-3">
                <label class="bold">Sales Exec</label>
                <input   type="text" class="form-control form-control-lg js-exec-id" exec-id="{{$exec->id}}"  value="{{$exec->name}}" disabled>
            </div>

            <div class="col-lg-6 mt-3">
                <label  class="bold">Customer Name/Order</label>
                <input id="customer" type="text" class="form-control form-control-lg js-customer" name="customer"   value="">
                <span class="js-error text-danger"></span>
            </div>

            <div class="col-lg-6 mt-3">
                <label for="order_number" class="bold">Order/Reg Number</label>
                <input   id="order_number" type="text" class="form-control form-control-lg js-order-number" name="order_number"  value="" >
                <span class="js-error text-danger "></span>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <a href="javascript:void(0)"class="btn btn-action sister block js-submit-sale">Submit Sale</a>
            </div>
        </div>

    </div>
</div>
