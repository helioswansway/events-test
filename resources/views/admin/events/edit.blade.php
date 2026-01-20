@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-calendar-alt"></i> Edit Event
        <span class="h1-button" style="">
            <a href="{{route('event.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>


    <div class="row justify-content-center">
        <div class="col-lg-10">
            @include('admin.inc._messages')
            <div class="s-card shadow">
                <div class="s-card-header bg-brother border-0"> Event </div>

                <div class="s-card-body p-0 border-0">
                    <form action="{{route('event.update', [$event->id])}}"   enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        {{ method_field('POST') }}

                         <img src="{{asset('assets/images/public/general/')}}/{{$event->filename}}" alt="" class="block">


                         <div class="s-card-body px-3 py-0 border-0">
                            <div class="row  py-3 alert-light border-0">
                                <div class="col-lg-4">
                                    <label for="filename" class="font-weight-bold">Event Image: <small class="fs-80"> (Size 1800 X 422)</small> <span class="text-danger">*</span></label>
                                    <input type="file" name="filename" class="form-control form-control-lg mb-0 pb-0" id="filename">

                                </div>

                                <div class="col-lg-4">
                                    <label class="bold" for="name">Event Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ $event->name }}" autocomplete="off" class="form-control form-control-lg" required>
                                </div>

                                {{-- <div class="col-lg-4">
                                    <label class="bold" for="friendly_name">Event Friendly Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="friendly_name" id="friendly_name" value="{{ $event->friendly_name }}" autocomplete="off" class="form-control form-control-lg" required>
                                </div> --}}

                                <div class="my-2"></div>

                                <div class="col-lg-4 text-lg-center">
                                    <div class="form-check form-check-inline m-0">
                                        <span class="form-check-label bold pb-1 me-2">Active:</span>
                                        <label for="yes" class="form-check-label">
                                            Yes <input name="active" class="form-check-input ms-1" type="radio" value="1" id="yes"
                                            {{ $event->active == 1 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <label for="no" class="form-check-label">
                                            No <input name="active"  class="form-check-input ms-1" type="radio" value="0" id="no"
                                            {{ $event->active == 0 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <span class="badge-light text-dark badge-pill py-1 px-3  border border-white">
                                            <a href="javascript:void(0)">
                                                <i title="Sets Event to active." class="fas fa-eye text-danger"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <div class="my-2 d-lg-block d-xl-none"></div>

                                <div class="col-lg-4 text-lg-center">
                                    <div class="form-check form-check-inline m-0">
                                        <span class="form-check-label bold pb-1 me-2">Inc. execs:</span>
                                        <label for="inc_yes" class="form-check-label">
                                            Yes <input name="inc_exec" class="form-check-input ms-1" type="radio" value="1" id="inc_yes"
                                            {{ $event->inc_exec == 1 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <label for="inc_no" class="form-check-label">
                                            No <input name="inc_exec"  class="form-check-input ms-1" type="radio" value="0" id="inc_no"
                                            {{ $event->inc_exec == 0 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <span class="badge-light text-dark badge-pill py-1 px-3 border border-white">
                                            <a href="javascript:void(0)">
                                                <i title="Allows Prospects to Select Execs ." class="fas fa-eye text-danger"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <div class="my-2 d-lg-block d-xl-none"></div>

                                {{-- <div class="col-lg-4 text-lg-center">
                                    <div class="form-check form-check-inline m-0">
                                        <span class="form-check-label bold pb-1 me-2">Finished:</span>
                                        <label for="yes_finished" class="form-check-label  js-finished">
                                            Yes <input name="finished" class="form-check-input ms-1" type="radio" value="1" id="yes_finished"
                                            {{ $event->finished == 1 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <label for="no_finished" class="form-check-label  js-finished">
                                            No <input name="finished"  class="form-check-input ms-1" type="radio" value="0" id="no_finished"
                                            {{ $event->finished == 0 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <span class="badge-light text-dark badge-pill py-1 px-3 border border-white">
                                            <a href="javascript:void(0)">
                                                <i title="Sets Event has finished." class="fas fa-eye text-danger"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <div class="my-2"></div> --}}

                                <div class="col-lg-4 text-lg-center">
                                    <div class="form-check form-check-inline m-0">
                                        <span class="form-check-label bold pb-1 me-2">Show Vehicles:</span>
                                        <label for="inc_yes" class="form-check-label">
                                            Yes <input name="show_vehicles" class="form-check-input ms-1" type="radio" value="1" id="show_vehicles" checked="checked"
                                            {{ $event->show_vehicles == 1 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <label for="no_show_vehicles" class="form-check-label">
                                            No <input name="show_vehicles"  class="form-check-input ms-1" type="radio" value="0" id="no_show_vehicles"
                                            {{ $event->show_vehicles == 0 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <span class="badge-light text-dark badge-pill py-1 px-3 border border-white">
                                            <a href="javascript:void(0)">
                                                <i title="Shows Vehicles to Propects." class="fas fa-eye text-danger"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <div class="my-2"></div>

                                <div class="col-lg-4 text-lg-center">

                                    <div class="form-check form-check-inline m-0">
                                        <span class="form-check-label bold pb-1 me-2">Show Part Exchange:</span>
                                        <label for="show_part_exchange" class="form-check-label">
                                            Yes <input name="show_part_exchange" class="form-check-input ms-1" type="radio" value="1" id="show_part_exchange"
                                            {{ $event->show_part_exchange == 1 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <label for="no_show_part_exchange" class="form-check-label">
                                            No <input name="show_part_exchange"  class="form-check-input ms-1" type="radio" value="0" id="no_show_part_exchange"
                                            {{ $event->show_part_exchange == 0 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <span class="badge-light text-dark badge-pill py-1 px-3 border border-white">
                                            <a href="javascript:void(0)">
                                                <i title="Determines if part Exchange is available to prospects." class="fas fa-eye text-danger"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <div class="my-2 d-lg-block d-xl-none"></div>

                                <div class="col-lg-4 text-lg-center">

                                    <div class="form-check form-check-inline m-0">
                                        <span class="form-check-label bold pb-1 me-2">Send Confirmation Email:</span>
                                        <label for="send_confirmation_email" class="form-check-label">
                                            Yes <input name="send_confirmation_email" class="form-check-input ms-1" type="radio" value="1" id="send_confirmation_email" checked="checked"
                                            {{ $event->send_confirmation_email == 1 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <label for="no_send_confirmation_email" class="form-check-label">
                                            No <input name="send_confirmation_email"  class="form-check-input ms-1" type="radio" value="0" id="no_send_confirmation_email"
                                            {{ $event->send_confirmation_email == 0 ? 'checked="checked"' : " "}}
                                            >
                                        </label>
                                        <span class="badge-light text-dark badge-pill py-1 px-3 border border-white">
                                            <a href="javascript:void(0)">
                                                <i title="Sends an email confirmation to prospects when an appointment is made." class="fas fa-eye text-danger"></i>
                                            </a>
                                        </span>
                                    </div>

                                </div>


                            </div>
                         </div>

                        <div class="s-card-header bg-brother">Assign a Dealership: <span class="text-danger">*</span></div>
                        <div class="s-card-body px-3 py-0 border-0">
                            <div class="row">
                                @foreach($all_dealerships as $dealership)
                                    <div class="col-lg-4 pt-2 alert-light bold border border-white">
                                        <div class="form-check form-check-inline m-0">
                                            <input type="checkbox" id="dealership_{{$dealership->id}}" class="form-check-input js-select-dealership m-0" name="dealership_id[]" value="{{$dealership->id}}"
                                                @foreach($event->dealerships as $item)
                                                    {{ $item->id == $dealership->id ? 'checked="checked"' : " "}}
                                                @endforeach
                                            >
                                            <label for="dealership_{{$dealership->id}}" class="form-check-label bold">{{$dealership->name}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 py-3">
                            <button type="submit" class="btn btn-default sister js-edit-event"> <i class="fas fa-save mr-2"></i> Save Event </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $( function() {
            //$( "#date" ).datepicker({ dateFormat: 'dd/mm/yy' }).val();

            $(".js-select-dealership").click(function() {
                $(this).parent().toggleClass('bg-white border-white');
            });


            $(".js-finished input[type=radio]").change(function () {
                    var value = $(this).val();
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to update Event?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    return true;

                                }
                            });
                        },
                        cancel: function () {
                            location.reload();
                        }
                    }
                });
            });


        } );
    </script>


@endsection
