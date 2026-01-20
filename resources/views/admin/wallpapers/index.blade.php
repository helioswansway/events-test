@extends('_layouts._dashboard')


@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="far fa-image"></i> Manage Wallpapers

                @admin('super')
                    <span class="h1-button" style="">
                        <a href="{{route('admin.wallpaper.create')}}" class="btn btn-border sister">Add a Wallpaper <i class="fas fa-plus"></i></a>
                    </span>
                @endadmin
            </h1>
        </div>
    </div>


    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">
                    Upload Admin wallpaper:
                </div>

                <div class="s-card-header bg-brand">
                    <div class="row pt-2">
                        <div class="col-3 border-right "></div>
                        <div class="col-7">
                            Wallpaper Name  <em> <small class="text-warning"> (PS: Open links in a Incognito browser)</small></em>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>

                <div class="s-card-body px-3 py-0">
                    @if(count($wallpapers) > 0)
                        <div class="js-sortable mb-1">
                            @foreach($wallpapers as $wallpaper)
                                <div class="drag-item ui-state-default row align-items-center s-card-row" style="line-height: 20px;" id="{{$wallpaper->id}}" data-index="{{$wallpaper->id}}" data-position="{{$wallpaper->position_order}}">
                                    <div class="col-3 border-right text-center">
                                        <img src="{{asset('assets/images/public/general/')}}/{{$wallpaper->filename}}" class="fluid-img img-thumbnail my-1" class="border" style="height:60px" title="{{$wallpaper->name}} Logo">
                                        <br>
                                        <small>Size: {{$wallpaper->width}}px X {{$wallpaper->height}}px</small>
                                    </div>
                                    <div class="col-7 border-right py-2">


                                        <strong>Path Name:</strong> {{$wallpaper->name}}
                                        <div class="mt-1">
                                            <strong>URL:</strong> <em><a href="{{url('/')}}/{{$wallpaper->path}}" target="_blank">{{url('/')}}/{{$wallpaper->path}}</a> </em>
                                        </div>

                                        <div class="mt-1">
                                            <strong>Description:</strong><br> {{$wallpaper->description}}
                                        </div>

                                    </div>
                                    <div class="col text-end">
                                        <a href="{{route('admin.wallpaper.edit', ['id' => $wallpaper->id])}}" class="btn btn-sm btn-border  p-1 info me-1" title="Edit Brand"><i class="far fa-edit"></i></a>

                                        <a href="javascript:void(0)" item-id="{{$wallpaper->id}}" class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Brand"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert-warning text-dark border border-warning p-3">
                            <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>

        $( function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $( ".js-sortable" ).sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('position-updated');
                        }
                    });
                    savePositions();
                }
            });

            function savePositions() {
                    var positions = [];
                    $('.position-updated').each(function () {
                        positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                        $(this).removeClass('updated');
                    });

                    $.ajax({
                        url:'/dashboard/wallpaperPosition',
                        method:'POST',
                        dataType: 'text',
                        data: {
                            update:1,
                            positions:positions
                        },success:function(response){

                                console.log(response);
                            }
                    });

            }


        } );

        //Asks Admin to confirm deletion
        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Brand?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('wallpaper.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '{{ route('admin.wallpaper.index') }}';
                        }
                    }
                });

        })

    </script>


@endsection
