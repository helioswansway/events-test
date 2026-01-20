@extends('_layouts._dashboard')

@section('content')


    <h1 class="display-4">
        <i class="fas fa-upload"></i> Upload Exec Data
        <span class="h1-button" style="">
            <a href="{{route('exec.index')}}" class="btn btn-border sister py-0"><i class="fas fa-caret-left"></i> Back </a>
        </span>
    </h1>


    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="col-12 s-card-header bg-brother">
                    <div class="row">
                        <div class="col">
                            Upload Exec Data
                        </div>
                    </div>
                </div>

                <div class="s-card-body px-3 py-3">
                    <form action="{{route('exec.store')}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}

                        <div class="col-12 px-5 py-2 alert-brand">
                            <p class="fs-120 bold">There's currently <span class="bold fs-150 mx-1"> {{number_format($exec_count)}}</span> Execs in the system.</p>
                            Use this area to ulpoad new or update existing execs. They will be available when creating the event.
                        </div>

                        <div class="row pt-3 ">
                            <div class="col-lg-8">
                                <input type="file" name="filename" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" name="button" class="btn  btn-default py-1 sister block "><i class="fas fa-save mr-2"></i> Upload CSV File </button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ URL::to('/') }}/assets/vendor/tinymce/tinymce.min.js"></script>
    <script>
        $(function(){
            $( ".js-datePicker" ).datepicker();
        });

    </script>



    <script>

        tinymce.init({
            selector: 'textarea#message',
            menubar:false,
            height: 300,
            toolbar: 'componentName componentDate componentTechnician componentDealership',
            setup: function (editor) {

                /* Helper functions */
                var toDateHtml = function (date) {
                return '<time datetime="' + date.toString() + '">' + date.toDateString() + '</time>';
                };
                var toGmtHtml = function (date) {
                return '<time datetime="' + date.toString() + '">' + date.toGMTString() + '</time>';
                };
                var toIsoHtml = function (date) {
                return '<time datetime="' + date.toString() + '">' + date.toISOString() + '</time>';
                };

                /* INSERTS THE COMPONENT NAME */
                editor.ui.registry.addButton('componentName', {
                text: 'Customer Name',
                tooltip: 'Inserts Component name on cursor location!',
                onAction: function (_) {
                    editor.insertContent("<span v-model='componentName' style='color:#00718f; font-weight: bold;'> [Sender Name] </span>");
                }
                });

                /* INSERTS THE COMPONENT DATE */
                editor.ui.registry.addButton('componentDate', {
                text: 'Component Date',
                tooltip: 'Inserts Component Date on cursor location!',
                    onAction: function (_) {
                        editor.insertContent("<span v-model='componentDate' style='color:#426b1a; font-weight: bold;'> [Date] </span>");
                    }
                });

                /* INSERTS THE COMPONENT TECHNICIAN'S NAME */
                editor.ui.registry.addButton('componentTechnician', {
                    text: 'Technician Name',
                    tooltip: 'Inserts Component to replace with the Technician Name!',
                    onAction: function (_) {
                        editor.insertContent("<span v-model='technicianName' style='color:#ca1111; font-weight: bold;'> [Technician Name] </span>");
                    }
                });

                /* INSERTS THE COMPONENT TECHNICIAN'S NAME */
                editor.ui.registry.addButton('componentDealership', {
                text: 'Dealership',
                tooltip: 'It will display the Dealership name!',
                    onAction: function (_) {
                        editor.insertContent("<span v-model='dealershipName' style='color:#fba400; font-weight: bold;'> [Dealership Name] </span>");
                    }
                });


                /* Toggle button that inserts the date, but becomes inactive when the cursor is in a "time" element */
                /* so you can't insert a "time" element inside another one. Also gives visual feedback. */
                editor.ui.registry.addToggleButton('toggleDateButton', {
                icon: 'insert-time',
                tooltip: 'Insert Current Date',
                onAction: function (_) {
                    editor.insertContent(toDateHtml(new Date()));
                },
                onSetup: function (buttonApi) {
                    var editorEventCallback = function (eventApi) {
                    buttonApi.setActive(eventApi.element.nodeName.toLowerCase() === 'time');
                    };
                    editor.on('NodeChange', editorEventCallback);
                    return function (buttonApi) {
                    editor.off('NodeChange', editorEventCallback);
                    }
                }
                });

            }
        });

    </script>


@endsection
