@extends('_layouts._dashboard')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fa-solid fa-bullhorn side-nav-icon"></i> Create Campaign
                <span class="h1-button" style="">
                    <a href="{{route('admin.pot-campaign.index')}}" class="btn btn-border sister"><i class="fas fa-arrow-left mr-3"></i> Back </a>
                </span>
            </h1>
        </div>
    </div>


    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">
                    Pot Campaign Name
                </div>

                <div class="s-card-body px-3">
                    <form action="{{route('admin.pot-campaign.update', $campaign->id)}}" enctype="multipart/form-data" method="POST" autocomplete="off">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="bold">Name:  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $campaign->name }}" name="name" class="form-control form-control-lg" id="name" required>
                        </div>

                        <div class="form-group mt-3 mb-4">
                            <div class="row">
                                <div class="col pt-2">
                                    <label class="bold block "> Is Active?</label>
                                    <div class="bold ">
                                        <label for="active_yes">
                                            <input type="radio" id="active_yes" name="active" value="1"
                                            @if($campaign->active == 1) checked @endif
                                            > Yes
                                        </label>

                                        <label for="active_no" class="ml-2">
                                            <input type="radio" id="active_no" name="active" value="0"
                                            @if($campaign->active == 0) checked @endif
                                            > No
                                        </label>
                                    </div>
                                </div>

                                <div class="col pt-2">
                                    <label for="end_date" class="fs-100 bold ">End Date</label>
                                    <input type="text" name="end_date" id="end_date" value="{{$campaign->end_date}}" class="form-control form-control-lg " placeholder="Enter End date" autocomplete="off" />
                                    <div class="row error px-3">
                                        <span></span>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="form-group mt-3 mb-0 ">
                            <button type="submit" class="btn btn-action sister block"> <i class="fas fa-save mr-2"></i> Save </button>
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
            $( "#end_date, .js-edit-end-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

    </script>


@endsection
