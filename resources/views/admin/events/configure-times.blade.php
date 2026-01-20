@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-cog"></i> Configure Event</h1>
    {{--It will display the execs assign to the dealership--}}
        <div class="pop-up-wrapper hide">
            <div class="row justify-content-center">
                <div id="js-execs" class="js-execs col-lg-4 p-0 relative" style="height: auto;">
                    <span class="pop-up-close" style="top:10px; right: 10px">X</span>
                    <div id="js-execs-inner" class="s-card-body border-0 p-0"></div>
                </div>
            </div>
        </div>
    {{--END--}}



    @csrf
    <div class="row justify-content-center">
        <div class="col-lg-11">

            @include('admin.events._event')

            {{--Configure Dates--}}
                <div class="s-card shadow my-5">
                    <div class="s-card-header bg-brand border-0">
                        <div class="row pt-1">
                            <div class="col">
                                <i class="fas fa-calendar-alt mr-1"></i> Event Dates for: {{$dealership->self(Request::segment(5))->name}}
                            </div>

                            @admin('super')
                                <div class="col text-end  text-end pe-0">
                                    @if(count($times) >=  0)
                                        <a href="javascript:void(0)" event-id="{{Request::segment(4)}}" dealership-id="{{Request::segment(5)}}" class="btn btn-sm btn-border brother js-split-customers mr-3 px-1 fs-80"><i class="fas fa-th mr-2"></i>
                                            Split Customers to Execs
                                            <span class="badge  alert-brother px-1 text-brand ml-1">Amount: {{prospectsAmount($dealership->self(Request::segment(5))->code, $event->id)}}</span>
                                            <span class="badge  alert-sister px-1 text-brand ml-1">K2K: {{prospectsRenewalAmount($dealership->self(Request::segment(5))->code, $event->id)}}</span>
                                        </a>
                                    @endif
                                </div>
                            @endadmin

                        </div>
                    </div>

                    <div class="s-card-body px-3 ">
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

                                <div class="col-lg-4   text-end">
                                    <label for="" class="block">&nbsp;</label>
                                    <div class="col">
                                        <a href="javascript:void(0)" class="btn btn-border sister px-2 mt-2 js-save-date"><i class="fas fa-save mr-2"></i> Save Dates </a>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="row ">
                                        <div class="col-8">
                                            <a href="javascript:void(0)" class="btn btn-date js-minus-date"  title="Add minus one day"><i class="far fa-calendar-minus"></i></a>
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

                                                    @if ($loop->first || $loop->last)
                                                        <a href="javascript:void(0)" data-id="{{$d->id}}" class="js-delete-date delete-date">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    @endif

                                                </div>
                                            @endforeach
                                            <a href="javascript:void(0)" class="btn btn-date js-plus-date" title="Add plus one day"><i class="far fa-calendar-plus"></i></a>
                                        </div>


                                    </div>
                                </div>

                            @endif

                        </div>
                    </div>

                </div>
            {{--END Dates--}}

            {{--Configure Times--}}

                @if(Request::segment(6) == 'dates')

                @else
                    <div class="s-card shadow my-5">
                        @if(count($times) <=  0)
                            <div class="s-card-header bg-light">
                                <i class="fas fa-clock mr-2"></i> Event Times:
                            </div>
                        @else

                            <div class="s-card-header bg-brother border-0 fs-90">
                                <div class="row">
                                    <div class="col-lg-1 bold border-end border-white">
                                        Slots:
                                    </div>
                                    <div class="col bold">
                                        Execs:
                                    </div>
                                    <div class="col text-end">
                                        <a href="javascript:void(0)" data-id="{{Request::segment(6)}}" class="btn btn-sm btn-border brand js-reset-times fs-90"><i class="fas fa-sync-alt"></i> Reset Time slots</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="s-card-body px-3 py-3 time">

                            @if(count($times) <=  0)
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="bold" for="open_time">Open Time <span class="text-danger">*</span></label>
                                        <div class="relative">
                                            <input type="text" value="" name="open_time" autocomplete="off"  class="js-open-time form-control form-control-lg">
                                            <div class="js-open-time-wrapper mb-3">
                                                <span value="8:30">8:30am</span>
                                                <span value="9:00">9:00am</span>
                                                <span value="9:30">9:30am</span>
                                                <span value="10:00">10:00am</span>
                                                <span value="10:30">10:30am</span>
                                                <span value="11:00">11:00am</span>
                                                <span value="11:30">11:30am</span>
                                                <span value="12:00">12:00pm</span>
                                                <span value="12:30">12:30pm</span>
                                                <span value="13:00">13:00pm</span>
                                                <span value="13:00">13:30pm</span>
                                                <span value="14:00">14:00pm</span>
                                                <span value="14:00">14:30pm</span>
                                                <span value="15:00">15:00pm</span>
                                                <span value="15:00">15:30pm</span>
                                                <span value="16:00">16:00pm</span>
                                                <span value="16:30">16:30pm</span>
                                                <span value="17:00">17:00pm</span>
                                                <span value="17:30">17:30pm</span>
                                                <span value="18:00">18:00pm</span>
                                                <span value="18:30">18:30pm</span>
                                                <span value="19:00">19:00pm</span>
                                                <span value="19:30">19:30pm</span>
                                            </div>
                                            <span class="js-error text-danger py-3"></span>

                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="interval" class="bold">Interval <span class="text-danger">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="interval" value="" name="interval" autocomplete="off" class="js-required js-interval form-control form-control-lg">
                                            <div class="js-interval-wrapper fs-90">
                                                <span value="30">30 minutes</span>
                                                <span value="60">60 minutes</span>
                                                <span value="90">90 minutes</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="bold" for="close_time">Last Appointment Slot <span class="text-danger">*</span></label>
                                        <div class="relative">
                                            <input type="text" value="" name="close_time" autocomplete="off"  class="js-close-time form-control form-control-lg">
                                            <div class="js-close-time-wrapper">
                                                <span value="12:00">12:00pm</span>
                                                <span value="12:30">12:30pm</span>
                                                <span value="13:00">13:00pm</span>
                                                <span value="13:00">13:30pm</span>
                                                <span value="14:00">14:00pm</span>
                                                <span value="14:00">14:30pm</span>
                                                <span value="15:00">15:00pm</span>
                                                <span value="15:00">15:30pm</span>
                                                <span value="16:00">16:00pm</span>
                                                <span value="16:30">16:30pm</span>
                                                <span value="17:00">17:00pm</span>
                                                <span value="17:30">17:30pm</span>
                                                <span value="18:00">18:00pm</span>
                                                <span value="18:30">18:30pm</span>
                                                <span value="19:00">19:00pm</span>
                                                <span value="19:30">19:30pm</span>
                                            </div>
                                        </div>


                                        <span class="js-error text-danger py-3"></span>
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="" class="block">&nbsp;</label>
                                        <a href="javascript:void(0)" date-item="{{$date}}" class="btn btn-default brother mt-1 js-save-time"><i class="fas fa-save mr-2"></i> Save Time Slot </a>
                                    </div>
                                </div>
                            @endif

                            @foreach($times as $t)
                                <div class="row s-card-row py-1 line-height-34 fs-90">
                                    <div class="col-lg-1 bold border-end">
                                        {{$t->time}}
                                    </div>
                                    <div class="col-10">
                                        @foreach($execs->exec($t->id) as $exec)
                                            <a href="javascript:void(0)" exec-id="{{$exec->id}}"  item-id="{{$exec->e_id}}" title="Delete Exec" class="btn btn-border brother px-2 py-0  mr-1 fs-80 js-delete-exec">
                                                <span class="badge alert-brother text-brand me-1">{{prospectsCount($exec->id)}}</span> {{$exec->name}}  <i class="fas fa-times ml-1"></i>
                                            </a>
                                        @endforeach
                                    </div>

                                    <div class="col text-end pt-2">
                                        @if($execs->checkExec($t->id, Request::segment(5)))
                                            <a href="javascript:void(0)" dealership-id="{{ Request::segment(5) }}"  time-slot="{{$t->id}}" class="btn btn-border sister float-end fs-80 js-add-exec py-0 px-1" title="Add Exec"><i class="fas fa-user-plus ml-1"></i></a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif
            {{--END Times--}}

        </div>
    </div>

@endsection


@section('scripts')
    <script>

        //Deletes date and every time slots and execs attached
        $('.js-delete-date').click(function(){
                var item_id = $(this).attr('data-id');

                var dealership_id   =  $('#dealership_id').val(); //Gets the dealership_id
                var event_id        = $('#event_id').val(); //Gets the event_id

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete this Date? <p class="text-danger bold mt-1"> ALL TIME SLOTS AND EXECS ATTACHED TO IT WILL BE DELETED</p>',
                    buttons: {
                        confirm: function (e) {

                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');

                            $.ajax({
                                url: '/dashboard/events/delete-date',
                                method:'get',
                                data: {
                                    date_id: item_id,
                                },
                                success: function (response)
                                {

                                    setTimeout(function(){
                                        location.href = '/dashboard/events/configure/'+event_id+'/'+dealership_id+'/dates';
                                    }, 800);

                                }
                            });
                        },
                        cancel: function () {
                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');
                            setTimeout(function(){
                                return location.reload();
                            }, 200);
                        }
                    }
                });

        })

        //Deletes time slots and execs attached
        $('.js-reset-times').click(function(){

                var item_id = $(this).attr('data-id');
                var dealership_id   =  $('#dealership_id').val(); //Gets the dealership_id
                var event_id        = $('#event_id').val(); //Gets the event_id
                $.confirm({
                    theme: 'bootstrap',
                    title: 'Confirm!',
                    content: 'Are you sure you want to proceed with this action? <p class="text-danger bold mt-1"> ALL TIME SLOTS AND EXECS ATTACHED TO THIS DEALERSHIP WILL BE DELETED</p>',
                    buttons: {
                        confirm: function (e) {

                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');

                            $.ajax({
                                url: '/dashboard/events/reset-time-slots',
                                method:'get',
                                data: {
                                    date_id: item_id,

                                },
                                success: function (response)
                                {

                                    setTimeout(function(){
                                        return location.reload();
                                    }, 800);
                                }
                            });
                        },
                        cancel: function () {
                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');
                            setTimeout(function(){
                                return location.reload();
                            }, 200);
                        }
                    }
                });

        })

        //Splits prospects through Execs
        $('.js-split-customers').click(function(){

            var event_id        =   $(this).attr('event-id');
            var dealership_id   =   $(this).attr('dealership-id');



            $.confirm({
                theme: 'bootstrap',
                title: 'Confirm!',
                content: 'Are you sure you want to proceed with this action? <em class="fs-90">This will delete any prospects assigned if any</em> . <p class="text-warning bold mt-2  fs-90" style="line-height: 18px;"> Please make sure that all Execs and Prospects are on the system before you proceed.</p>',
                buttons: {
                    confirm: function (e) {
                        $('.pop-up-wrapper-spin').removeClass('hide');
                        $('body').addClass('overflow');

                        $.ajax({
                            url: '/dashboard/events/split-customers-to-execs',
                            method:'get',
                            data: {
                                event_id: event_id,
                                dealership_id: dealership_id,
                            },
                            success: function (response)
                            {
                                //console.log(response)
                                //setTimeout(function(){ }, 800);
                                return location.reload();

                            }
                        });
                    },
                    cancel: function () {
                        $('.pop-up-wrapper-spin').removeClass('hide');
                        $('body').addClass('overflow');
                        setTimeout(function(){
                            return location.reload();
                        }, 200);
                    }
                }
            });

        })

        //Deletes time slots and execs attached
        $('.js-delete-exec').click(function(){
            var item_id = $(this).attr('item-id');
            var exec_id = $(this).attr('exec-id');

            $.confirm({
                theme: 'bootstrap',
                title: 'What do you want to do!',
                content: '<p class="fs-90 bold">Delete Exec from the <span class="text-brother">Event</span>  or from <span class="text-sister">Time Slot</span> ?</p>',
                buttons: {

                    deleteFromTimeSlot: {
                        text: 'Time Slot',
                        btnClass: 'bg-sister text-white float-start',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');

                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('event.delete.exec.from.time.slot', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

                                }
                            });

                        }
                    },

                    deleteFromEvent: {
                        text: 'From Event',
                        btnClass: 'bg-brother text-white float-start',
                        keys: ['enter', 'shift'],
                        action: function(){

                            $('.pop-up-wrapper-spin').removeClass('hide');
                            $('body').addClass('overflow');

                            $.ajax({
                                success: function (response)
                                {

                                    var url = '{{ route('event.delete.exec.from.event', ":id") }}';
                                    url = url.replace(':id',exec_id);
                                    window.location.href = url;

                                }
                            });

                        }
                    },
                    cancel: function () {
                        $('.pop-up-wrapper-spin').removeClass('hide');
                        $('body').addClass('overflow');
                        setTimeout(function(){
                            return location.reload();
                        }, 200);

                    },
                }
            });

        })


    </script>


@endsection
