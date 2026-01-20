@include('admin.inc._messages')
{{--Configure Event--}}

    <div class="fixed-icons text-center shadow-sm">
        <i class="fab fa-houzz" title="Event: {{$event->name}}"></i>
        @foreach($event->dealerships as $dealership)
            <a href="javascript:void(0)" item="{{$dealership->id}}" class="<?php if(Request::segment(5) == $dealership->id){ echo 'active ';}else{ echo '';} ?> border-white js-add-date fs-90">
                <img src="{{asset('assets/images/public/general/')}}/{{$dealership->brand->filename}}" class="fluid-img"  style="height:20px" title="{{$dealership->brand->filename}} Logo">
                <span> {{ $dealership->name}}</span>
            </a>
        @endforeach
        <a href="{{route('event.edit', $event->id)}}" class="edit"><i class="far fa-edit"></i> <span>Edit Event</span> </a>
    </div>

    <div class="s-card shadow py-0">
        <div class="s-card-header bg-brother border-0">
            <div class="row">
                <div class="col">
                    <i class="fas fa-calendar-alt mr-1"></i>  Event Name: <a href="{{route('event.index')}}" class="btn btn-border sister normal fs-80 ms-3 py-1">{{$event->name}}</a>
                </div>
            </div>
        </div>
        <input type="hidden" id="event_id" name="event_id" value="{{$event->id}}">
        <input type="hidden" id="date_id" name="date_id" value="{{ Request::segment(6) }}">
        <input type="hidden" name="dealership_id" id="dealership_id" value="{{ Request::segment(5) }}">
        <img src="{{asset('assets/images/public/general/')}}/{{$event->filename}}" alt="" class="block">

    </div>
{{--END--}}
