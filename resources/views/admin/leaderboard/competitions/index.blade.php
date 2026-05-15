<div class="container">
   <div class="row justify-content-center ">
        <div class="col-lg-10 bg-white flex-wrap shadow py-3 px-0">

            <a href="javascript:void(0)" class="js-close" title="Close"><i class="fas fa-times"></i> </a>
            <h3 class="fs-150 px-3">All Competitions</h3>

            <div class="row px-3">
                <span class="message"></span>
            </div>


            <div class="s-card">
                <div class="s-card-header border border-white bg-brand">
                    <div class="row">
                        <div class="col-4 border-right"">Name</div>
                        <div class="col-1 text-center border-right">Active</div>
                        <div class="col-3 text-center border-right">End Date</div>
                        <div class="col-2 text-center border-right">N: Execs</div>
                        <div class="col"></div>
                    </div>
                </div>

                 <ul class="s-card-body border basic-ul px-3">
                    <span  id="saved"></span>
                    @foreach($competitions as $competition)
                        <li class="row s-card-row py-1">
                            <div class="col-4 bold border-right">
                                <div class="row">
                                    <div class="col">{{$competition->name}} </div>
                                    <div class="col text-end">
                                        <a href="{{route('admin.competition.create.image', $competition->id)}}" title="Manage Leaderboard Image"
                                            class="btn btn-border py-0 px-1 ml-2 fs-80 @if(isset(competitionImage($competition->id)->id) == $competition->id) success @else sister @endif">
                                            <i class="fas fa-image"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1 text-center border-right">
                                @if($competition->active == 1) <i class="fas fa-thumbs-up text-success"></i> @else <i class="fas fa-thumbs-down text-danger"></i> @endif
                            </div>
                            <div class="col-3 text-center border-right">
                                {{formatDate($competition->end_date)}}
                                @if(isNow() > isPast($competition->end_date))
                                    <span class="fs-80 ml-2 alert-danger text-danger rounded px-1 line-height-20">(Ended)</span>
                                @endif
                            </div>
                            <div class="col-2 text-center border-right">
                                 <span class="badge bg-brand">{{--{{competitionLeaderboardCount($competition->id)}} --}} {{count($competition->leaderboards)}}</span>
                                <a href="{{route('admin.leaderboard.get.execs.by.competition', [$competition->id])}}" title="Manage Execs" class="btn btn-border sister py-0 px-1 ml-2 fs-80">
                                    <i class="fas fa-user-tie"></i>
                                </a>
                            </div>
                            <div class="col text-end">
                                <a href="javascript:void(0)" class="js-edit fs-130" item-id="{{$competition->id}}" title="Edit Competition"><i class="far fa-edit text-warning"></i></a>
                                <a href="javascript:void(0)" class="js-archive fs-130 mx-1" item-id="{{$competition->id}}" title="Archive Competition"><i class="fas fa-archive text-info"></i></a>
                                <a href="javascript:void(0)" class="js-delete fs-130" item-id="{{$competition->id}}" title="Delete Competition"><i class="fa fa-trash text-danger"></i></a>
                            </div>


                            <div class="col-12 s-edit-row hide pb-0">
                                <div class="row py-1 alert-brother pt-1 border-top">
                                    <div class="col-3 bold border-right">
                                        <input type="text" name="edit_name" id="edit_name_{{$competition->id}}" class="form-control form-control-sm " value="{{$competition->name}}" autocomplete="off" />
                                    </div>
                                    <div class="col-2 text-center border-right pt-1">
                                        <div class="js-active-ckeckboxes">
                                            <label >
                                                <input type="radio" name="active_{{$competition->id}}" value="1"
                                                    @if($competition->active == 1) checked @endif
                                                > Yes
                                            </label>

                                            <label class="ml-2">
                                                <input type="radio" name="active_{{$competition->id}}" value="0"
                                                @if($competition->active == 0) checked @endif
                                                > No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 border-right">
                                        <input type="text" name="edit_end_date" id="edit_end_date_{{$competition->id}}" class="form-control form-control-sm js-edit-end-date" value="{{$competition->end_date}}" autocomplete="off" />
                                    </div>
                                    <div class="col text-end">
                                        <a href="javascript:void(0)" class="js-save fs-120" title="Save Competition" item-id="{{$competition->id}}"><i class="fas fa-save text-success"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="p-5">
                <div class="card shadow-sm">
                    <div class="s-card-body p-3">
                        <label for="competition" class="fs-100 bold ">Enter Competition Name</label>
                        <input type="text" name="competition" id="competition" class="form-control form-control-lg " placeholder="Enter competition name" autocomplete="off" />

                        <div class="row error px-3">
                            <span></span>
                        </div>

                        <div class="row ">
                            <div class="col py-2">
                                <label class="bold block "> Is Active?</label>
                                <div class="bold ">
                                    <label for="active_yes">
                                        <input type="radio" id="active_yes" name="active" value="1"> Yes
                                    </label>

                                    <label for="active_no" class="ml-2">
                                        <input type="radio" id="active_no" name="active" value="0" checked=""> No
                                    </label>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-12 js-friend  hide  mt-3 text-start">
                                        <div class="border-top mb-3"></div>
                                        <label for="friend_name" class="bold">Friend Name  </label>
                                        <input placeholder="Enter your friends name" id="friend_name" type="text" class=" form-control form-control-lg" name="friend_name" value="" autocomplete="off">
                                        <div class="js-error p-2 text-danger text-center bold"></div>
                                        <label for="model_interest" class="bold">Friend Model Interest</label>
                                        <input placeholder="Friend Model Interest" id="friend_model_interest" type="text" class="mt-3 form-control form-control-lg " name="friend_model_interest" value="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col pt-2">
                                <label for="end_date" class="fs-100 bold ">End Date</label>
                                <input type="text" name="end_date" id="end_date" class="form-control form-control-lg " placeholder="Enter End date" autocomplete="off" />
                                <div class="row error px-3">
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 mt-3 border-top text-start">
                            <a href="javascript:void(0)"  class="btn btn-default sister js-create-competition"><i class="fas fa-save"></i> Save Competition</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
        $( function() {
            $( "#end_date, .js-edit-end-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

        //Creates Competition
        $('.js-create-competition').click(function(){
            var name        =   $('#competition').val();
            var end_date    =   $('#end_date').val();
            var active      =   $('input[name="active"]:checked').val();

            if(active == 1) {
                var thumb = '<i class="fas fa-thumbs-up text-success"></i>';
            }else{
                var thumb = '<i class="fas fa-thumbs-down text-danger"></i>';

            }


            if(name == ""){
                $('#competition').addClass('border border-danger').next('.error').children('span').addClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('Competition name needs to be entered!')
            }else if (end_date == ""){
                $('#end_date').addClass('border border-danger').next('.error').children('span').addClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('End Date needs to be entered!')
            }else{

                $.ajax({
                    url: '/dashboard/competition/store?name=' + name + '&active=' + active + '&end_date=' + end_date,
                        success:function(data){
                            console.log(data);
                            // setTimeout(function(){
                            //     $('.pop-up-wrapper').fadeOut('slow').html(data);
                            // }, 400);

                            var image_url = '{{ route("admin.competition.create.image", ":data") }}';
                                image_url = image_url.replace(':data', data);


                             $('#competition').val('');
                             $('#end_date').val('');


                            $('#saved').append('<li class="row s-card-row py-1 alert-success border-0" style="margin-top:0px!important; border-bottom:1px solid #FFFFFF!important;">'+
                                                    '<div class="col-3 bold border-right">'+
                                                        '<div class="row">'+
                                                            '<div class="col">'+name+'</div>'+
                                                            '<div class="col text-end">'+
                                                                '<a href="'+image_url+'" title="Manage Leaderboard Image"'+
                                                                    'class="btn btn-border py-0 px-1 ml-2 fs-80 sister "> <i class="fas fa-image"></i>'+
                                                                '</a>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="col-2 text-center border-right">' + thumb + '</div>'+
                                                    '<div class="col-3 text-center border-right">'+end_date+'</div>'+
                                                    '<div class="col-2 text-center border-right"><span class="badge bg-brand">0</span> <a href=\'{{route("admin.leaderboard.get.execs")}}\' title="Manage Execs" class="btn btn-border sister py-0 px-1 ml-2 fs-80"><i class="fas fa-user-tie"></i></a> </div>'+
                                                    '<div class="col text-end"></div>'+

                                                '</li>'

                            );

                    }
                });
            }
        })

        //Competition Name
        //Clearls End Date field
        $("#end_date").click(function(){
            $('#end_date').removeClass('border border-danger').next('.error').children('span').removeClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('')
        });

        //Clearls Competition name field
        $("#competition").click(function(){
            $('#competition').removeClass('border border-danger').next('.error').children('span').removeClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('')
        });

        //Refreshes the page
        $('.js-close').click(function(){
            location.reload();
        });

        //$('.s-edit-row').hide();
        //Refreshes the page
        $('.js-edit').click(function(){
              $(this).closest('.s-card').addClass('active-card');

              var $target = $(this).closest('.s-card-row')
                            .addClass('active')
                            .children(".s-edit-row")
                            .toggleClass('hide');

            $(".s-edit-row").not($target).addClass('hide');

           // $(this).closest(".s-edit-row").eq(0).removeClass('hide');
        });

        //Saves
        $('.js-save').click(function(){
            var id = $(this).attr('item-id')
            var name        =   $('#edit_name_'+id).val();
            var active      =   $('input[name="active_'+id+'"]:checked').val();
            var end_date    =   $('#edit_end_date_'+id).val();

            $(this).closest('.s-edit-row').addClass('hide')
            $('body').removeClass('overflow');

            //alert(name + " - " + active  + " - " + end_date + " - " + id)

            $.ajax({
               url: '/dashboard/competition/update?id=' + id + '&active=' + active + '&end_date=' + end_date + '&name=' + name,
                // //url: '{{ route('admin.competition.update', ":id, :active, :end_date, :name") }}',

                    success:function(data){
                        console.log(data);
                        $('.message').addClass('col-12 alert-success py-2 my-3').html('Competition [' +name+ '] was successfully save! You will see the Changes when pop up is closed.')


                        // setTimeout(function(){
                        //     $('.pop-up-wrapper').fadeOut('slow').html(data);
                        // }, 3000);
                }
            });

        })

        //Archives Competition
        $('.js-archive').click(function(){

            var item_id     =   $(this).attr('item-id');
            var hide_row    =   $(this).closest('.s-card-row');

            $.confirm({
                title: 'Confirm!',
                content: '<div class="fs-90">Are you sure you want to Archive this Competition?</div> ',
                buttons: {
                    //If confirmed proceeds to delete
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                // var url = '{{ route('admin.competition.delete', ":id") }}';
                                // url = url.replace(':id',item_id);
                                // window.location.href = url;

                                $.ajax({
                                    url: '/dashboard/competition/archive?id=' + item_id,
                                        // //url: '{{ route('admin.competition.update', ":id, :active, :end_date, :name") }}',

                                            success:function(data){

                                                console.log(data);
                                                hide_row.addClass('hide');
                                                $('.message').addClass('col-12 alert-success py-2 my-3').html('Competition was successfully archived!')
                                                setTimeout(function(){
                                                    //$('.pop-up-wrapper').fadeOut('slow').html(data);
                                                    $('.message').removeClass('col-12 alert-success py-2 my-3').html('')

                                                }, 3000);
                                        }
                                    });

                            }
                        });
                    },

                    //If Cancelled does nothing
                    cancel: function () {
                        //location.reload();
                    }
                }
            });

        })

        //Asks Admin to confirm deletion
        $('.js-delete').click(function(){
            var item_id     =   $(this).attr('item-id');
            var hide_row    =   $(this).closest('.s-card-row');

            $.confirm({
                title: 'Confirm!',
                content: '<div class="fs-90">Are you sure you want to delete Competition?</div> <div class="text-brother fs-90 my-2"><i class="fas fa-exclamation-triangle mr-1"></i> All <strong>Execs</strong>  and <strong>Sales League entries</strong> assigned to this competition will also be deleted! </div> <div class="fs-90"> Make sure you do a backup.</div>',
                buttons: {
                    //If confirmed proceeds to delete
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {
                                // var url = '{{ route('admin.competition.delete', ":id") }}';
                                // url = url.replace(':id',item_id);
                                // window.location.href = url;

                                $.ajax({
                                    url: '/dashboard/competition/delete?id=' + item_id,
                                        // //url: '{{ route('admin.competition.update', ":id, :active, :end_date, :name") }}',

                                            success:function(data){

                                                console.log(data);
                                                hide_row.addClass('hide');
                                                $('.message').addClass('col-12 alert-success py-2 my-3').html('Competition was successfully deleted!')
                                                setTimeout(function(){
                                                    //$('.pop-up-wrapper').fadeOut('slow').html(data);
                                                    $('.message').removeClass('col-12 alert-success py-2 my-3').html('')

                                                }, 3000);
                                        }
                                    });

                            }
                        });
                    },

                    //If Cancelled does nothing
                    cancel: function () {
                        //location.reload();
                    }
                }
            });

        })



</script>

