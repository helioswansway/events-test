@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-cog"></i> Configure Event</h1>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            @include('admin.inc._messages')
            {{--Configure Event--}}
            @include('admin.events._event')
            {{--END--}}
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
        } );
    </script>


@endsection
