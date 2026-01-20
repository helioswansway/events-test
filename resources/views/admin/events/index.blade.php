@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-calendar-alt"></i>
                Events
                <span class="h1-button" style="">
                    <a href="{{route('archive.index')}}" class="btn btn-sm btn-default brother px-2 me-1"><i class="fas fa-archive "></i> Archived</a>
                    <a href="/dashboard/events/create" class="btn btn-sm btn-default sister px-3">Create Event <i class="fas fa-plus"></i></a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="s-card shadow">
        <div class="s-card-header bg-brother px-3">
            <div class="row">
                <div class="col-6 border-end">
                    Assign Dates/Time Slots & Execs
                </div>

                <div class="col-1 border-end text-center">
                    Send Email
                </div>

                <div class="col-1 border-end text-center">
                    Show vehicles
                </div>

                <div class="col-1 border-end text-center">
                    Part Exchange
                </div>

                <div class="col-1 border-end text-center">
                    Inc Execs
                </div>

                <div class="col-1 border-end text-center">
                    Active
                </div>
            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            @if(count($events) > 0)

                @foreach($events as $event)
                        <div class="row s-card-row align-items-center py-2 line-height-34 ">
                            <div class="col-6 border-end bold ">
                                <i class="fas fa-calendar-alt"></i> {{$event->name}} <span class="ms-2 normal fs-90 text-brand"><u> From:</u> <span class="text-brand me-2"> {{eventFirstDate($event->id)}}</span> <u class="text-brand">To:</u> <span class="text-brand">{{eventLastDate($event->id)}}</span></span><br>
                                @foreach($event->dealerships as $dealership)
                                    <a href="{{route('event.index')}}/configure/{{$event->id}}/{{$dealership->id}}/dates" class="btn btn-border brand px-1 mr-1 fs-80" style="text-decoration: none;" title="Manage {{$dealership->name}} Dealership"><i class="fas fa-cog"></i> {{$dealership->name}} </a>
                                @endforeach
                            </div>

                            <div class="col-1 border-end bold  text-center">
                                {!! $event->send_confirmation_email == 1 ? '<i class="fas fa-thumbs-up text-success"></i>' : ' <i class="fas fa-thumbs-down text-danger"></i>' !!}
                            </div>

                            <div class="col-1 border-end bold  text-center">
                                {!! $event->show_vehicles == 1 ? '<i class="fas fa-thumbs-up text-success"></i>' : ' <i class="fas fa-thumbs-down text-danger"></i>' !!}
                            </div>

                            <div class="col-1 border-end bold  text-center">
                                {!! $event->show_part_exchange == 1 ? '<i class="fas fa-thumbs-up text-success"></i>' : ' <i class="fas fa-thumbs-down text-danger"></i>' !!}
                            </div>

                            <div class="col-1 border-end bold  text-center">
                                {!! $event->inc_exec == 1 ? '<i class="fas fa-thumbs-up text-success"></i>' : ' <i class="fas fa-thumbs-down text-danger"></i>' !!}
                            </div>

                            <div class="col-1 border-end bold  text-center">
                                {!! $event->active == 1 ? '<i class="fas fa-thumbs-up text-success"></i>' : ' <i class="fas fa-thumbs-down text-danger"></i>' !!}
                            </div>

                            <div class="col pl-0 text-end align-middle ">
                                <a href="{{route('event.edit', ['id' => $event->id])}}" class="btn btn-sm btn-border info" title="Edit Event"><i class="far fa-edit"></i></a>
                                <a href="javascript:void(0)" item-id="{{$event->id}}" class="btn btn-sm btn-border danger js-delete" title="Delete Event"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach

                @else

                <div class="row">
                    <div class="col-12 alert-warning text-dark border border-warning py-2 bold">
                        <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                    </div>
                </div>



            @endif

        </div>

        <div class="row">
            {{$events->render()}}
        </div>

    </div>

@endsection


@section('scripts')
    <script>
        $('.js-delete').click(function(){
            var item_id = $(this).attr('item-id');

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete Event?<div class="alert-brother border-0 lighter px-2 py-1 mt-1 bold text-info">All Appointments will be Archived</div>',
                buttons: {
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                var url = '{{ route('event.delete', ":id") }}';
                                url = url.replace(':id',item_id);
                                window.location.href = url;
                            }
                        });
                    },
                    cancel: function () {
                        window.location.href = '{{ route('event.index') }}';
                    }
                }
            });
        })

    </script>


@endsection
