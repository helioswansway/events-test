
@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4">
        <i class="fas fa-calendar-alt"></i> Archived
        <span class="h1-button" style="">
            <a href="{{route('event.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>
    @include('admin.inc._messages')
    <div class="js-message alert-success py-2 px-3 hide"></div>

        {{csrf_field()}}
        <div class="row justify-content-center">
            <div class="col-lg-10">


                <div class="s-card shadow ">
                    <div class="s-card-header bg-brand border-bottom-0 pl-0">
                        <div class="col-12">
                            <div class="row">
                                <div class="col "> Events Archived </div>
                            </div>
                        </div>
                    </div>

                    <div class="s-card-header bg-brother border-bottom-0">
                        <div class="row ">
                            <div class="col-3 border-right pl-0 ">
                                Event Name
                            </div>

                            <div class="col-3 border-right">
                               Event Dates
                            </div>

                            <div class="col-2 border-right">
                               Archived Files
                             </div>

                            <div class="col-2">
                                N: Appointments
                            </div>
                        </div>
                    </div>

                    <div class="s-card-body px-0 py-0">
                        <div class="col-12">
                            @foreach($archives as $archive)
                                <div class="row s-card-row py-2">
                                    <div class="col-3  border-right bold">
                                        {{$archive->event_name}}
                                    </div>

                                    <div class="col-3 border-right">
                                        {{$archive->event_dates}}
                                    </div>
                                    <div class="col-2 border-right">
                                        <a href="/assets/archived/{{($archive->file_path)}}"><i class="fas fa-download"></i> Download csv file</a>
                                    </div>

                                    <div class="col-2 bold text-info">
                                        {{$archive->count}}
                                    </div>

                                    <div class="col text-end ">
                                        @admin('super,super-admin')
                                            <a href="javascript:void(0)" item-id="{{$archive->id}}" class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Archive"><i class="fa fa-trash"></i></a>
                                        @endadmin
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection


@section('scripts')
    <script>
        $(function(){


            $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Archive?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('archive.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '/dashboard/archive/events';
                        }
                    }
                });

        })


        });

    </script>
@endsection

