<div class="s-card shadow">

    <div class="col-12 alert-light border-0 py-2 ">
        <div class="row">
            <div class="col-9">
                {{ $execs->links() }}
                <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                    Results: {{number_format($execs->count())}}
                </span>
            </div>

            <div class="col-3 text-end pt-1 pr-4">
                <span class="badge bg-brand text-white fs-90 px-1">
                    <strong>Total:</strong> {{number_format($execs->total())}}
                </span>
            </div>
        </div>
    </div>

    <div class="s-card-header bg-brother fs-90">
        <div class="row">
            <div class="col-2 border-right">
                Name
            </div>
            <div class="col-3 border-right">
                Dealership
            </div>

            <div class="col-2">
                Email
            </div>

        </div>
    </div>


    <div class="s-card-body px-3 py-0">
        @if($execs->count() > 0)
            @foreach($execs as $exec)
                <div class="row s-card-row pt-1 fs-90">
                    <div class="col-2 border-right">
                        {{$exec->exec_name}}
                    </div>
                    <div class="col-3 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        @if(dealershipByCode($exec->dealership_code))
                            {{ dealershipByCode($exec->dealership_code)->name}}
                        @endif
                    </div>

                    <div class="col-2 border-right">
                        {{$exec->email}}
                    </div>

                    <div class="col text-end">

                        @admin('super-admin')

                            @if(prospectsExecCount($exec->id) > 0)
                                <a href="javascript:void(0)" exec-id="{{$exec->id}}" class="btn btn-sm btn-border px-1 light me-1 js-remove-prospects" title="Removes Prospects From Exec"><i class="fa-solid fa-user-xmark"></i></a>
                            @endif

                        @endadmin

                        @admin('brand-manager,super-admin')

                            @if(prospectsExecCount($exec->id) > 0)
                                <a href="{{route('exec.prospect.export',[ $exec->id])}}" class="btn btn-sm btn-border px-1 sister me-1 " title="Export Exec Prospects"><i class="fa-solid fa-file-excel fs-100"></i></a>
                            @endif

                        @endadmin

                            <a href="{{route('exec.all.prospects',[ $exec->id])}}" class="btn btn-sm btn-border p-1 brand me-1 " title="All Exec Prospects" style="width:60px;">
                                <i class="fas fa-address-card"></i> <span class="ms-1 badge bg-brother text-brand">{{prospectsExecCount($exec->id)}}</span>
                            </a>
                            <a href="{{route('exec.all.appointments',[ $exec->id])}}" class="btn btn-sm btn-border  p-1 success me-1 " title="All Exec Appointments"><i class="fas fa-calendar-check"></i></a>

                        @admin('super-admin')
                            <a href="{{route('exec.edit',['id' => $exec->id])}}" class="btn btn-sm btn-border  p-1 info " title="Edit Exec"><i class="far fa-edit"></i></a>
                            <a href="javascript:void(0)" item-id="{{$exec->id}}"  class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Exec"><i class="fa fa-trash"></i></a>
                        @endadmin

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


    <div class="col-12 border-0 py-2 ">

            <div class="row ">
                <div class="col-9">
                    {{ $execs->links() }}
                    <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                        Results: {{number_format($execs->count())}}
                    </span>
                </div>

                <div class="col-3 pr-3 text-end pt-1">
                    <span class="badge bg-brand text-white  fs-90 px-1">
                        <strong>Total:</strong> {{number_format($execs->total())}}
                    </span>
                </div>
            </div>

    </div>
</div>
