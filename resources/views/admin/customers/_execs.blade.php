<label for="exec_id" class="bold">Exec @if($execs->count() > 0) <span class="text-danger">*</span> @endif</label>
<select name="exec_id" id="exec_id" class="form-control form-control-lg form-select alert-light lighter" @if($execs->count() > 0) required autofocus @endif>
    <option value="">--Select Exec--</option>
    @foreach($execs as $exec)
        <option value="{{$exec->id}}"
            @if(isset(customerExec($customer->id)->id) && customerExec($customer->id)->id == $exec->id) selected @endif
        >{{$exec->name}}</option>
    @endforeach
</select>
