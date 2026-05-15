<div class="col-lg-12 alert-brand p-3">
    <div class="col-12 bg-white p-3">
        <div class="px-3">
            <div class="row align-items-center">
                <div class="col-lg">
                   {{ $pot_lists->links() }}
                </div>
                <div class="col">
                    <div class="search-box">
                        <div class="search-icon"><i class="fa fa-search search-icon"></i></div>
                        <form action="{{route('admin.searchable.pot.list')}}" method="GET" class="search-form">
                            <input type="text" placeholder="Search by description, model or reg..." id="search" name="term" autocomplete="off">
                            <input type="hidden" id="campaign_id" name="campaign_id" value="{{$camp->id}}">
                            {{-- <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}"> --}}
                        </form>
                        <svg class="search-border" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" viewBox="0 0 671 111" style="enable-background:new 0 0 671 111;"
                            xml:space="preserve">
                            <path class="border" d="M335.5,108.5h-280c-29.3,0-53-23.7-53-53v0c0-29.3,23.7-53,53-53h280"/>
                            <path class="border" d="M335.5,108.5h280c29.3,0,53-23.7,53-53v0c0-29.3-23.7-53-53-53h-280"/>
                        </svg>
                        <div class="go-icon"><i class="fa fa-arrow-right arrow-right"></i></div>
                    </div>
                </div>
                <div class="col text-end">
                    <div class="row">

                        <div class="col-lg-6 px-1">
                            <div class="px-3 py-2 alert-brother lighter py-1 rounded-lg">
                                <div class="row" style="margin:0 -15px !important">

                                    <div class="col-12 text-start bold fs-110" style="padding:0 0.5rem !important"> Sale Date </div>
                                    <div class="col-lg-6 text-center" style="padding:0 0.5rem !important">
                                        <input type="text" id="sale_date_first" placeholder="From..." class="form-control" value="{{ app('request')->input('first_sale_date') }}">
                                    </div>
                                    <div class="col-lg-6 text-center" style="padding:0 0.5rem !important">
                                        <input type="text" id="sale_date_last" placeholder="To..." class="form-control" value="{{ app('request')->input('last_sale_date') }}">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 px-1">
                            <div class="px-3 py-2 alert-sister lighter py-1 rounded-lg">
                                <div class="row" style="margin:0 -15px !important">
                                    <div class="col-12 text-start bold fs-110" style="padding:0 0.5rem !important"> Last Work Date </div>
                                    <div class="col-lg-6 text-center" style="padding:0 0.5rem !important">
                                        <input type="text" id="last_work_date_start" placeholder="From..." class="form-control" value="{{ app('request')->input('start_date') }}">
                                    </div>
                                    <div class="col-lg-6 text-center" style="padding:0 0.5rem !important">
                                        <input type="text" id="last_work_date_end" placeholder="To..." class="form-control" value="{{ app('request')->input('end_date') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="s-card ">
        <div class="s-card-header col-12 border bg-brother">
            <div class="row">
                <div class="col pt-1">
                    @if(isNow() > isPast($camp->end_date))
                        <span class="fs-80 mr-3 alert-danger text-danger py-1 px-2 rounded">
                            Campaign ended at: <span class="ml-1"> {{ formatDate(isPast($camp->end_date))}}</span>
                        </span>
                    @else
                        <span class="fs-80 mr-2 bg-white text-brand px-2 py-1 rounded">
                            Campaign ends at: <span class="ml-1"> {{ formatDate(isPast($camp->end_date))}}</span>
                        </span>

                        <span class="badge bg-brand text-white px-2 py-1 fs-90" style="">
                            Results: {{number_format($pot_lists->total())}}
                        </span>

                    @endif
                </div>
                <div class="col text-end pt-1">
                    @admin('super-admin,admin')
                        <a href="{{route('admin.pot-list.booked', $camp->id)}}" class="btn btn-border btn-sm fs-90 success normal">Booked</a>
                        <a href="{{route('admin.pot-list.inProgress', $camp->id)}}" class="btn btn-border btn-sm fs-90 warning mx-1 normal">In Progress</a>
                        <a href="{{route('admin.pot-list.notInterest', $camp->id)}}" class="btn btn-border btn-sm fs-90 danger me-2 normal">Not Interested</a>

                        @if(count($pot_lists) > 0)
                            <a href="{{route('admin.pot-list.export', $camp->id)}}" class="btn btn-sm btn-default sister px-2 mr-3"> Export League <i class="fas fa-file-download ml-2"></i></a>
                        @endif
                    @endadmin
                    Total: {{count($pot_lists) }}
                </div>
            </div>
        </div>

        <div class="s-card-header text-dark d-none d-lg-block d-xl-block">
            <div class="row ">
                <div class="col-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                   Name
                </div>

                <div class="col-1 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Dealership
                 </div>

                 <div class="col-1 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Registration
                 </div>

                <div class="col-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Phone
                </div>

                <div class="col-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Customer Type
                </div>

                <div class="col-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Model
                </div>

                <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Description
                </div>

                <div class="col-1 text-center border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Booking Status
                </div>

                <div class="col-1 text-center border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Call Status
                </div>

                <div class="col-1 text-center border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Call Attempts
                </div>
            </div>
        </div>

        <div class="s-card-body px-3 py-0">

            @if(isNow() > isPast($camp->end_date))
                <div class="row">
                    <div class="col-12 alert-success lighter text-dark bold py-2 fs-120">
                        <i class="fas fa-exclamation-triangle text-dark fs-150 mr-1"></i> Sorry! Campaing have ended.
                    </div>
                </div>
            @else
                @if(count($pot_lists) > 0)
                    @foreach($pot_lists->where('pot_campaign_id', $camp->id) as $list)
                        @if($list->booking_status == 'not_interested' || $list->booking_status == 'booked')

                        @else

                            <div class="row px-1 s-card-row py-1 line-height-34">
                                <div class="col-lg-1  border-right bold" title="{{$list->title}} {{$list->first_name}} {{$list->last_name}}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Name: </span>
                                    {{$list->title}}    {{$list->first_name}} {{$list->last_name}}
                                </div>
                                <div class="col-lg-1  border-right bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                                    <span style="cursor:help;" title="{{$list->dealership->name}}">{{$list->dealership->name}}</span>

                                </div>

                                <div class="col-lg-1  border-right bold">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Registration: </span>
                                    {{$list->registration}}
                                </div>

                                <div class="col-lg-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Phone: </span>
                                    0{{$list->phone}}
                                </div>

                                <div class="col-lg-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Customer Type: </span>
                                    {{$list->customer_type}}
                                </div>

                                <div class="col-lg-1  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Model: </span>
                                    {{$list->model}}
                                </div>

                                <div class="col-lg-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Model: </span>
                                    {{$list->description}}
                                </div>

                                <div class="
                                        col-lg-1 text-center border-right bold fs-90
                                        @if($list->booking_status == 'in_progress') text-warning @endif
                                        @if($list->booking_status == 'booked') text-success @endif
                                        @if($list->booking_status == 'not_interested') text-danger @endif
                                        "
                                        style="">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Booking Status: </span>

                                    @if($list->booking_status == 'in_progress') <i class="fa-solid fa-triangle-exclamation me-1 fs-100"></i>  @endif
                                    @if($list->booking_status == 'booked') <i class="fa-solid fa-check me-1 fs-100"></i> @endif
                                    @if($list->booking_status == 'not_interested') <i class="fa-solid fa-xmark me-1 fs-100"></i> @endif
                                    {{str_replace('_', ' ', ucwords($list->booking_status))}}
                                    </span>

                                </div>

                                <div class="col-lg-1 text-center border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Call Status: </span>
                                    {{str_replace('_', ' ', ucwords($list->call_status))}}
                                </div>

                                <div class="col-lg-1 text-center border-right" style="">
                                    <span class="d-xl-none d-lg-none bold text-brand mr-2"> Call Attempts: </span>
                                    {{$list->call_attempts}}
                                </div>
                                <div class="col text-end pe-1" style="">

                                    @if($list->locked == 1 && $list->admin_id == auth('admin')->user()->id)
                                        @admin('super-admin')
                                            <a href="javascript:void(0)" item-id="{{$list->id}}" class="btn btn-sm btn-border p-1 warning js-reset" title="Reset List"><i class="fa-solid fa-arrows-rotate"></i></a>
                                        @endadmin
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default success js-get-form px-1" title="This Pot List Belongs to you" item-id="{{$list->id}}"><i class="fa-solid fa-check-to-slot"></i></a>

                                    @elseif($list->locked == 0)
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default info js-get-form" title="Register Action" item-id="{{$list->id}}"><i class="fa-solid fa-keyboard"></i></a>
                                    @else
                                        @admin('super-admin')
                                            <a href="javascript:void(0)" item-id="{{$list->id}}" class="btn btn-sm btn-border p-1 warning js-reset" title="Reset List"><i class="fa-solid fa-arrows-rotate"></i></a>
                                        @endadmin
                                        <span class="bg-danger rounded" style="padding: 3px 7px 4px 7px" title="Pot List is locked"><i class="fa-solid fa-lock fs-90"></i></span>
                                    @endif
                                </div>
                            </div>
                        @endif

                    @endforeach

                @else
                    <div class="row">
                        <div class="col-12 alert-warning text-dark border border-warning bold py-2">
                            <i class="fas fa-exclamation-triangle text-warning fs-170 mr-1"></i> There's no record sets in the database!
                        </div>
                    </div>
                @endif

            @endif

        </div>

    </div>
</div>


