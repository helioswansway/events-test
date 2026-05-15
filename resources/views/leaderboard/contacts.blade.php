@extends('_layouts._leaderboard-dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="content-wrapper">
        <h1 class="display-4"><i class="fas fa-at"></i> Help</h1>

        @include('admin.inc._messages')

        <div class="s-card shadow">
            <div class="s-card-header bg-brother">Contacts</div>
            <div class="s-card-body px-3 py-0">
                <div class="row s-card-row line-height-34">
                    <div class="col-2 bold border-right">All-in League:</div>
                    <div class="col"><a href="mailto:l.hodgkinson@swanswaygarages.com"> Leah Hodgkinson </a></div>
                </div>
                <div class="row s-card-row line-height-34">
                    <div class="col-2 bold border-right">Users Access:</div>
                    <div class="col"><a href="mailto:l.hodgkinson@swanswaygarages.com"> Leah Hodgkinson </a></div>
                </div>
                <div class="row s-card-row line-height-34">
                    <div class="col-2 bold border-right">Technical Issues:</div>
                    <div class="col"><a href="mailto:h.pinto@swanswaygarages.com"> Helio Pinto </a></div>
                </div>
            </div>
        </div>


        <div class="py-5 my-3"></div>
    </div>


@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>



    </script>



@endsection
