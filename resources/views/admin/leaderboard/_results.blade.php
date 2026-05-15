<div class="s-card-header border-0">
    <div class="row">
        <div class="col-7 border-right border-white">
            <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                Results: {{number_format($execs->count())}}
            </span>
        </div>
    </div>
</div>

<div class="s-card shadow">
    <div class="s-card-header bg-brother">
        <div class="row">
            <div class="col-2 border-right">
                Name
            </div>
            <div class="col-2 border-right">
                Dealership
            </div>
            <div class="col-3 border-right">
                Email
            </div>
            <div class="col ">
                <div class="row">
                    <div class="col">Job Title</div>
                </div>
            </div>
        </div>
    </div>

    <div class="s-card-body px-3 py-0">

        @if($execs->count() > 0)
            @foreach($execs as $leaderboard)
                <div class="row s-card-row py-1">
                    <div class="col-lg-2  border-right bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Exec: </span>
                        {{$leaderboard->exec_name}}
                    </div>

                    <div class="col-lg-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                        @if(dealership($leaderboard->id))
                            {{dealership($leaderboard->id)->name}}
                        @endif
                    </div>

                    <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Email: </span>
                        {{$leaderboard->email}}
                    </div>

                    <div class="col  border-right">
                        @if($leaderboard->job_title_id != 0)
                            {{$leaderboard->job_title->name}}
                        @endif
                    </div>

                    <div class="col-1 text-end">
                        <a href="{{route('admin.leaderboard.edit',['id' => $leaderboard->id])}}" class="btn btn-sm btn-border  p-1 info " title="Edit Exec"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" item-id="{{$leaderboard->id}}"  class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Exec"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            @endforeach
        @else

            <div class="row">
                <div class="alert-warning text-dark border border-warning px-3 py-2">
                    <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                </div>
            </div>
        @endif

    </div>

</div>

<script>


</script>

