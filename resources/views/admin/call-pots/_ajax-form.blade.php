<form action="{{ route('admin.pot-list.update', $list->id) }}" method="post">
    {{csrf_field()}}
    {{ method_field("POST") }}

    <div class="col-lg-12 bg-white s-card-body">
        <label for="call_attempts" class="bold mb-0">Call Attempts</label>
        <select name="call_attempts" id="call_attempts" class="form-control form-control-lg form-select" required>
            <option value="">--Please Select--</option>
            <option value="1st Call" @if($list->call_attempts == '1st Call') selected @endif>1st Call</option>
            <option value="2nd Call" @if($list->call_attempts == '2nd Call') selected @endif>2nd Call</option>
            <option value="3rd Call" @if($list->call_attempts == '3rd Call') selected @endif>3rd Call</option>
            <option value="4th Call" @if($list->call_attempts == '4th Call') selected @endif>4th Call</option>
        </select>

        <div class="row gx-5  my-3">
            <div class="col-lg-4 bold  border-end pb-1 pt-2">
                <div class="form-check form-check-inline">
                    <label for="call_made" class="form-check-label" title="Call Made">Call Made</label>
                    <input type="radio" id="call" class="form-check-input" name="call_status" value="call_made"
                        @if($list->call_status == 'call_made') checked @endif
                    >
                </div>
                <span class="js-error p-2 text-danger text-center"></span>
            </div>

            <div class="col-lg-4 bold  border-end pb-1 pt-2">
                <div class="form-check form-check-inline">
                    <label for="call_back" class="form-check-label" title="Call back required">Call Back Required</label>
                    <input type="radio" id="call" class="form-check-input" name="call_status" value="request_call_back"
                        @if($list->call_status == 'request_call_back') checked @endif
                    >
                </div>
            </div>

            <div class="col-lg-4 bold  pb-1 pt-2">
                <div class="form-check form-check-inline">
                    <label for="message_left" class="form-check-label" title="Message left">Message Left</label>
                    <input type="checkbox" id="message_left" class="form-check-input js-call-message" name="message_left" value="0"
                        @if($list->message_left == '0') checked @endif
                    >
                </div>
            </div>

        </div>

        <div class="row gx-5 mb-3 px-3">
            <div class="col-lg-12 alert-light lighter rounded text-center bold py-3">
                <div class="form-check form-check-inline">
                    <label for="" class="form-check-label" title="Call Made">Booked</label>
                    <input type="radio" id="call" class="form-check-input" name="booking_status" value="booked"
                        @if($list->booking_status == 'booked') checked @endif
                    >
                </div>

                <div class="form-check form-check-inline">
                    <label for=" " class="form-check-label" title="Call back required">Not Interested</label>
                    <input type="radio"  class="form-check-input" name="booking_status" value="not_interested"
                        @if($list->booking_status == 'not_interested') checked @endif
                    >
                </div>

                <div class="form-check form-check-inline">
                    <label for=" " class="form-check-label" title="Call back required">In Progress</label>
                    <input type="radio"  class="form-check-input" name="booking_status" value="in_progress"
                        @if($list->booking_status == 'in_progress') checked @endif
                    >
                </div>
            </div>

        </div>

        <div class="row gx-5 border-bottom">
            <div class="col-12 bold">
                <label for="notes" class="mb-0">Notes</label>
                <textarea name="notes" id="notes" rows="4" class="form-control form-control-lg">{{$list->notes}}</textarea>
                <div class="js-error p-2 text-danger text-center bold"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-action info block mt-3">Submit</button>
    </div>
</form>
