@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-user-tie"></i> Exec Appointments
                <span class="h1-button" style="">
                    <a href="{{route('exec.index')}}" class="btn btn-border sister mr-2"><i class="fas fa-angle-double-left mr-2"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="text" id="keyword" class="form-control form-control-lg shadow-sm mb-4 py-3" placeholder="Search Execs by (Exec Dealership ID, Name or Email)">

    <div class="s-card shadow">

        <div class="col-12 alert-light border-0 py-2 ">
            <div class="row">
                <div class="col-9">
                    <span class="float-start badge bg-brand text-white px-1 fs-90 me-2 mt-1">
                        Results: {{number_format($appointments->count())}}
                    </span>
                    for <strong>{{$exec->name}}</strong> from <strong>{{dealershipByCode($exec->dealership_code)->name}}</strong>

                </div>
            </div>
        </div>



        <div class="s-card-header bg-brother fs-90">
            <div class="row">
                <div class="col-2 border-right">
                    Customer Name
                </div>

                <div class="col-2 border-right">
                    Customer Email
                </div>

                <div class="col-1 border-right text-center">
                    Date
                </div>
                <div class="col-1  border-right text-center">
                    Time
                </div>


            </div>
        </div>


        <div class="s-card-body px-3 py-0">
            @if($appointments->count() > 0)
                @foreach($appointments as $appointment)
                    <div class="row s-card-row pt-1 fs-90">

                        <div class="col-2 border-right">
                            {{$appointment->title}} {{$appointment->name}} {{$appointment->surname}}
                        </div>

                        <div class="col-2 border-right">
                            {{$appointment->email}}
                        </div>

                        <div class="col-1 border-right text-center">
                            @if($appointment->date)
                                {{$appointment->date}}
                            @else
                                <strong>Null</strong>
                            @endif

                        </div>

                        <div class="col-1 border-right text-center">
                            @if(isset(eventTime($appointment->event_time_id)->time))
                                {{eventTime($appointment->event_time_id)->time}}
                            @else
                                <strong>Null</strong>
                            @endif
                        </div>

                        <div class="col text-end">
                            <a href="javascript:void(0)" item-id="{{$appointment->id}}"  class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Appointment"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            @else

                <div class="row">
                    <div class="alert-warning text-dark border border-warning px-2 py-2">
                        <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                    </div>
                </div>
            @endif
        </div>

    </div>


@endsection


@section('scripts')
    <script>



        $('.js-delete').click(function(){
            var item_id = $(this).attr('item-id');

            alert(item_id)

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete Appointment?',
                buttons: {
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                var url = '{{ route('admin.delete.appointment', ":id") }}';
                                url = url.replace(':id',item_id);
                                window.location.href = url;
                            }
                        });
                    },
                    cancel: function () {
                        location.reload();
                    }
                }
            });
        });



    </script>


@endsection
