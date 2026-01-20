@extends('_layouts._book-dashboard')

@section('content')

    @include('admin.inc._messages')

    @if($event->show_vehicles == 1)
        @if($event->inc_exec == 1)
            <div class="row justify-content-center">
                <h1 class="display-4 bold mb-0">Select Your Model of Interest</h1>
                <div class="col-12 text-center py-4 js-car-interest">
                    <a href="javascript:void(0)" class="btn mob-full-with @if($appointment->model_interest == 'new') active @endif" car-iterest="new">NEW</a>
                    <a href="javascript:void(0)" class="btn mob-full-with  @if($appointment->model_interest == 'used') active @endif" car-iterest="used">USED</a>
                    <a href="javascript:void(0)" class="btn mob-full-with @if(!$appointment->model_interest || $appointment->model_interest == 'either') active @endif" car-iterest="either">EITHER</a>

                    <a href="{{route('book.appointment')}}" name="select_model_skip" class="btn btn-default brand mob-full-with " style="width: auto; padding: 0.1rem 1rem; line-height: 24px !important; border-radius: 20px!important" >Skip <i class="ml-1 fas fa-arrow-right"></i></a>

                </div>
            </div>
        @endif

        <div class="s-card px-3 mt-4">
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

    @endif

    <div class="col-12 text-center mt-5">
        <a href="{{route('book.appointment')}}" name="book_your_appointment" id="book_your_appointment" class="btn btn-border sister btn-radius-md js-book-appointment">Book Your Appointment <i class="ml-3 fas fa-arrow-right"></i></a>
    </div>

@endsection

@section('scripts')


    <script>


    </script>



@endsection
