
@if(isset($data['errorCode']))
    <div class="px-2 py-2 mt-1 text-center bg-red-100 rounded bold text-danger">
        Registration <span class="fs-16 text-danger">"{{$registration}}"</span>  doesn't seem to exist. Please try again!
    </div>
@else
    <div class="px-3 rounded fs-100 alert-brother lighter text-dark pt-3">
        {{-- @foreach($data as $d)@endforeach --}}

        <div>
            <span class="bold">Registration:</span> {{$data['registration']}}
            <input type="hidden" name="registration" id="registration" class="form-control" value="{{$data['registration']}}">
        </div>
        <div class="">
            <span class="bold">Make:</span> {{$data['make']}}
            <input type="hidden" name="make" id="make" class="form-control" value="{{$data['make']}}" >
        </div>
        <div class="">
            <span class="bold">Colour:</span> {{$data['primaryColour']}}
            <input type="hidden" name="colour" id="colour" class="form-control" value="{{$data['primaryColour']}}" >
        </div>
        <div class="">
            <span class="bold">Fuel Type:</span> {{$data['fuelType']}}
            <input type="hidden" name="fuel_type" id="fuel_type" class="form-control" value="{{$data['fuelType']}}" >
        </div>

        <div class="space-20"></div>

        <div class="v-mileage">
            <input type="text" name="mileage" id="mileage" class="form-control" placeholder="Enter your approximate Mileage">
        </div>
    </div>

    <div class="space-30"></div>



@endif
