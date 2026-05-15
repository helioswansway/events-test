@extends('_layouts._book-dashboard')

@section('content')

    @include('admin.inc._messages')

    @if($event->inc_exec == 1)
        <div class="row justify-content-center">
            <h1 class="display-4 bold mb-0">Select Your Model of Interest</h1>
            <div class="col-12 text-center py-4 js-car-interest">
                <a href="javascript:void(0)" class="btn mob-full-with @if($appointment->model_interest == 'new') active @endif" car-iterest="new">NEW</a>
                <a href="javascript:void(0)" class="btn mob-full-with  @if($appointment->model_interest == 'used') active @endif" car-iterest="used">USED</a>
                <a href="javascript:void(0)" class="btn mob-full-with @if(!$appointment->model_interest || $appointment->model_interest == 'either') active @endif" car-iterest="either">EITHER</a>
            </div>
        </div>
    @endif

    <div class="s-card px-3 mb-5 mt-4">
        <div class="row">
            <div class="col">


            </div>
        </div>

       <div class="row text-center js-models">
            <input type="hidden" id="dealershipId"  value="{{$dealership->id}}">
            <input type="hidden" id="eventId"  value="{{$event->id}}">

            @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                <div class="col-lg-2 mb-4">
                    <a href="javascript:void(0)"  class="mb-2 bg-white js-select-vehicles">
                        <img class="border block

                            @if(isset($appointment->vehicles))
                                @php $obj = json_decode($appointment->vehicles, true); @endphp
                                @foreach($obj as $key => $value)
                                    @if($value == $vehicle->id) active @endif
                                @endforeach
                            @endif

                        " data-vehicle="{{$vehicle->id}}"  src="{{asset('assets/images/public/general')}}/{{$vehicle->filename}}" alt="">
                    </a>
                    <div class="py-1 bold border-bottom">{{$vehicle->name}}</div>
                </div>
            @endforeach
       </div>
    </div>

    <div class="col-12 text-center">
        <a href="{{route('book.appointment')}}" class="btn btn-border sister btn-radius-md js-book-appointment">Book Your Appointment <i class="ml-3 fas fa-arrow-right"></i></a>
    </div>

@endsection

@section('scripts')


    <script>


    </script>



@endsection
