

@if($customers->count() > 0)
    @foreach($customers as $customer)
    @if(customerAppointment($customer->id, $event_id))
        <div
            cust-id="{{$customer->id}}"
            vehicle-reg="{{$customer->vehicle_reg}}"
            post-code="{{$customer->post_code}}"
            home-phone="{{$customer->home_phone}}"
            mobile="{{$customer->mobile}}"
            email="{{$customer->email}}"
            name="{{$customer->name}}"
            class="js-customer-appointment text-success"
            >
            <i class="fas fa-check"></i>    {{$customer->name}} {{$customer->surname}} <span class="text-danger fs-90 float-end"style="display:inline;"> Booked</span>
        </div>
    @else
        <span
            cust-id="{{$customer->id}}"
            vehicle-reg="{{$customer->vehicle_reg}}"
            post-code="{{$customer->post_code}}"
            home-phone="{{$customer->home_phone}}"
            mobile="{{$customer->mobile}}"
            email="{{$customer->email}}"
            name="{{$customer->name}}"
            class="js-customer-appointment"
            >
                {{$customer->name}}  {{$customer->surname}}
        </span>
    @endif


    @endforeach

@endif

