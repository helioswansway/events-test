@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-cog"></i> Configure Event</h1>
    <div class="pop-up-wrapper hide">
        <div class="row justify-content-center">
            <div id="js-execs" class="js-execs col-lg-6">
                <span class="pop-up-close">X</span>
                <div id="js-execs-inner" class="p-3"></div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            @include('admin.inc._messages')
            {{--Configure Event--}}
            @include('admin.events._event')
            {{--END--}}

            {{--Configure Dates--}}
                <div class="s-card shadow my-5">
                    <div class="s-card-header bg-brand">
                        <div class="row">
                            <div class="col">
                                <i class="fas fa-calendar-alt mr-1"></i> Event Dates: <span class="ms-2">( {{$dealership->self(Request::segment(5))->name}} )</span>
                            </div>
                        </div>
                    </div>

                    <div class="s-card-body px-3 py-2 date">
                        <div class="row">
                            @if(count($dates) <=  0)
                                <div class="col-lg-4">
                                    <label class="bold" for="from"><i class="far fa-calendar-check"></i> From <span class="text-danger">*</span></label>
                                    <input type="text" id="from" name="from" value="{{old('from')}}" autocomplete="off" class="js-required js-from-date form-control form-control-lg">
                                    <span class="js-error text-danger py-3"></span>
                                </div>

                                <div class="col-lg-4">
                                    <label class="bold" for="to"><i class="far fa-calendar-check"></i> To <span class="text-danger">*</span></label>
                                    <input type="text" id="to" name="to" value="{{old('to')}}" autocomplete="off" class="js-required js-to-date form-control form-control-lg">
                                    <span class="js-error text-danger py-3"></span>
                                </div>

                                <div class="col-lg-4  text-end">
                                    <label for="" class="block">&nbsp;</label>
                                    <div class="col">
                                        <a href="javascript:void(0)" class="btn btn-border sister px-2 mt-2 js-save-date"><i class="fas fa-save mr-2"></i> Save Dates </a>
                                    </div>
                                </div>
                            @else

                                <div class="row">
                                    <div class="col-12">
                                        <a href="javascript:void(0)" class="btn btn-date js-minus-date"  title="Add minus one day"><i class="far fa-calendar-plus"></i></a>
                                        @foreach($dates as $d)
                                            <div class="fs-80 date-container <?php if(Request::segment(6) == $d->id){ echo ' active ';}else{ echo ' ';} ?> ">
                                                <a href="{{route('event.configure.times', [$event->id,  Request::segment(5), $d->id])}}" title="Add/View Time Slots" class="view-date  <?php if(Request::segment(6) == $d->id){ echo ' disabled ';}else{ echo ' sister ';} ?>  p-1 mt-1"><i class="fas fa-eye"></i></a>

                                                @if($execs->dateExec($d->id, Request::segment(5)))
                                                    <span class="view-exec btn mt-1 no-cursor">
                                                        <i class="fas fa-user-tie text-warning fs-80"></i>
                                                    </span>
                                                @endif

                                                <span class="display-date">
                                                    {{ \Carbon\Carbon::parse($d->date)->format('d/m/Y') }}
                                                </span>

                                                {{-- @if ($loop->first || $loop->last)@endif --}}
                                                <a href="javascript:void(0)" data-id="{{$d->id}}" class="js-delete-date delete-date">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                            </div>
                                        @endforeach

                                        <a href="javascript:void(0)" class="btn btn-date js-plus-date" title="Add plus one day"><i class="far fa-calendar-plus"></i></a>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{--END Dates--}}

        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $( function() {
            var event_id = $('#event_id').val();

            $(".js-select-dealership").click(function() {
                $(this).parent().toggleClass('bg-light border-white');
            });

            setTimeout(function(){
                $('html,body').animate({
                    scrollTop: $(".date").offset().top},
                2000);
            }, 100);


            //Deletes date
            $('.js-delete-date').click(function(){
                var date_id = $(this).attr('data-id');
                var dealership_id = $('#dealership_id').val(); //Gets the dealership_id
                var event_id = $('#event_id').val(); //Gets the event_id

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete this Date? ALL TIME SLOTS AND EXECS ATTACHED TO IT WILL BE DELETED',
                    buttons: {
                        confirm: function (e) {
                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');

                            $.ajax({
                                url: '/dashboard/events/delete-date',
                                method:'get',
                                data: {
                                    date_id: date_id,

                                },
                                success: function (response)
                                {

                                    setTimeout(function(){
                                        return location.reload();
                                    }, 1000);

                                }
                            });
                        },
                        cancel: function () {
                            return location.reload();
                        }
                    }
                });

            })

        } );
    </script>


@endsection
