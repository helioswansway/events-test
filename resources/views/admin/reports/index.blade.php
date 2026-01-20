
@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4">
        <i class="fas fa-chart-pie"></i> Reports
        <span class="h1-button" style="">
            <a href="{{route('admin.appointment.index')}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-2"></i> Back</a>
        </span>

    </h1>
    @include('admin.inc._messages')
    <div class="js-message alert-success p-3 hide"></div>
    <div class="s-card border-0">
        {{csrf_field()}}
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="s-card shadow ">
                    <div class="s-card-header bg-brother">
                        <i class="fas fa-file-csv fs-120 mr-1"></i> Export
                     </div>

                    <div class="s-card-body border-0 px-5">
                        <div class="row">
                            <div class="col-lg-3 border">
                                <div class="landing-icons py-5">
                                    <a href="{{route('admin.appointment.export.all', [$event->id])}}"  class="text-sister">
                                            <i class="fas fa-calendar-check fs-300 block bold mb-3"></i> <span class="btn btn-border sister"> Appointments <i class="fas fa-angle-right fs-110 mt-1 ml-3"></i></span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 border border border-left-0">
                                <div class="landing-icons py-5">
                                    <a href="{{route('admin.sale.export.all', [$event->id])}}" class="text-sister">
                                        <i class="fas fa-tags fs-300 block bold mb-3"></i> <span class="btn btn-border sister">Sales <i class="fas fa-angle-right fs-110 mt-1 ml-3"></i></span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 border border border-left-0">
                                <div class="landing-icons py-5">
                                    <div><i class="fas fa-user-tie fs-300 block bold mb-3"></i> </div>

                                    <a href="{{route('admin.prospects.export.all', [$event->id])}}" class="text-sister">
                                        <span class="btn btn-border sister">All Prospects <i class="fas fa-angle-right fs-110 mt-1 ml-3"></i></span>
                                    </a>

                                    <a href="{{route('admin.prospects.export.appointments', [$event->id])}}" class="text-sister">
                                        <span class="btn btn-border brother">With Appointments <i class="fas fa-angle-right fs-110 mt-1 ml-3"></i></span>
                                    </a>
                                </div>

                            </div>

                            <div class="col-lg-3 border border border-left-0">
                                <div class="landing-icons py-5">
                                    <a href="{{route('admin.conversions.export.all', [$event->id])}}" class="text-sister">
                                        <i class="fas fa-exchange-alt fs-300 block bold mb-3"></i> <span class="btn btn-border sister">Conversions <i class="fas fa-angle-right fs-110 mt-1 ml-3"></i></span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection


@section('scripts')
    <script>
        $(function(){

        });

    </script>
@endsection
