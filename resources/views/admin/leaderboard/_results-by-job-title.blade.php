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
    <div class="s-card-header bg-brother  pb-0">
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
            <div class="col text-start">
                <div class="row">
                    <div class="col-6">
                        Job Title
                    </div>

                   <div class="col-6 text-end">
                        {{-- <label class="text-center border rounded bold px-3 py-1 fs-100 bg-white text-dark block cursor">
                            <input type="checkbox" id="selectAll" class="select-job-title me-2">
                            Select All
                        </label> --}}
                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="s-card-body px-3 py-0">

        @if($execs->count() > 0)
            <form action="{{route('admin.add.users.to.competition')}}" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="job_title_id" value="{{$job_title_id}}">
                {{csrf_field()}}
                {{ method_field('POST') }}
                @foreach($execs as $exec)
                    <div class="row s-card-row pt-1 pb-0">
                        <div class="col-2 border-right">
                            {{$exec->exec_name}}
                        </div>
                        <div class="col-2 border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ dealershipByCode($exec->dealership_code)->name}}
                        </div>
                        <div class="col-3 border-right">
                            {{$exec->email}}
                        </div>

                        <div class="col border-right">
                            <div class="row">
                                <div class="col" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <label for="select-job-title_{{$exec->id}}">
                                        @if($exec->job_title_id != 0)
                                            <span>{{$exec->job_title->name}}</span>

                                        @endif
                                    </label>
                                </div>

                                {{-- <div class="col">
                                    <input type="checkbox" name="exec_id[]" style="margin-top: 6px;" class="select-job-title ml-1 float-end" value="{{$exec->id}}"
                                    @if(competitionLeaderboard($competition_id, $exec->id)) checked @endif
                                    >
                                </div> --}}
                            </div>
                        </div>

                        <div class="col-1 text-end">
                            <a href="{{route('admin.leaderboard.edit',['id' => $exec->id])}}" class="btn btn-sm btn-border  p-1 info " title="Edit Exec"><i class="far fa-edit"></i></a>
                            <a href="javascript:void(0)" item-id="{{$exec->id}}"  class="btn btn-sm btn-border p-1 danger js-delete" title="Delete Exec"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach

                <div class="row border-top">
                    <div class="col-7"></div>

                    <div class="col">
                        <div class="row">
                            {{-- @if(competitionLeaderboard($competition_id, $exec->id))
                                <div class="col">
                                    <button type="submit" name="btn_update" class=" btn btn-sm btn-default brother fs-80 block my-2" value="Update"><i class="far fa-trash-alt mr-2"></i>Update</button>
                                </div>
                            @endif --}}

                            {{-- <div class="col">
                                <button type="submit" name="btn_save" class=" btn btn-default sister block my-2" value="Save"><i class="fas fa-save mr-2"></i>Save</button>
                            </div> --}}
                        </div>
                    </div>

                </div>
            </form>
        @else

            <div class="row">
                <div class="alert-warning text-dark border border-warning px-3 py-2">
                    <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                </div>
            </div>
        @endif
    </div>


    <div class="row py-2">
        <div class="col-9">

            <span class="float-start badge bg-brand text-white px-1 fs-90 ml-3 mt-1">
                Results: {{number_format($execs->count())}}
            </span>
        </div>


    </div>

</div>

<script>

$(document).ready(function() {


    $('.js-refresh').click(function(){
        location.reload();
    })

    $(".select-job-title").click(function() {
        $(this).parent().toggleClass('alert-sister border-white');
    });

    $("#selectAll").click(function() {
        $('.select-job-title').parent().toggleClass('alert-sister border-white');
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));

       // $('.btn-save-job-title').toggleClass('hide')
    });

    $("input[type=checkbox]").click(function() {

        if (!$(this).prop("checked")) {

            $("#selectAll").prop("checked", false);
        }

    });



})

</script>

