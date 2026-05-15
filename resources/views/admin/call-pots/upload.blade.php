@extends('_layouts._dashboard')

@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-upload"></i> Upload Pot List
                <span class="h1-button" style="">
                    @admin('super-admin')
                        <a href="{{route('admin.pot-campaign.index')}}" class="btn btn-sm btn-default info px-2 me-1"><i class="fa-solid fa-bullhorn me-1"></i> Campaigns</a>
                    @endadmin

                    <a href="{{url()->previous()}}" class="btn btn-border sister "><i class="fas fa-angle-double-left"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="s-card shadow">
                <div class="s-card-header bg-brother">
                    Upload Pot List:
                </div>

                <div class="s-card-body px-4">

                    <form action="{{route('admin.pot-list.store')}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        <div class="row pb-3 js-leaderboard">
                            <div class="col-12">
                                <div class="row pb-4 ">
                                    <div class="col-12 bold ">
                                        <label for="campaign_id">Select Campaign: <span class="text-danger">*</span></label>
                                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                        <select name="campaign_id" id="campaign_id" class=" form-control form-control-lg" required>
                                            <option value="">--Select one--</option>
                                            @foreach($campaigns as $campaign)
                                                <option value="{{$campaign->id}}">{{$campaign->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row pb-4 ">
                                    <div class="col-12 bold ">
                                        <label for="dealership_id">Select Dealership: <span class="text-danger">*</span></label>
                                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                        <select name="dealership_id" id="dealership_id" class=" form-control form-control-lg" required>
                                            <option value="">--Select one--</option>
                                            @foreach($dealerships as $dealership)
                                                <option value="{{$dealership->id}}">{{$dealership->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 pb-4">
                                <input type="file" name="filename" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="button" class="btn btn-action sister block "><i class="fas fa-save mr-2"></i> Upload CSV File </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')


@endsection
