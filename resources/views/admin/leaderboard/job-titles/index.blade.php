<div class="container">
    <div class="row justify-content-center ">
        <div class="col-lg-10 bg-white flex-wrap shadow py-3 px-0">

             <a href="javascript:void(0)" class="js-close" title="Close"><i class="fas fa-times"></i> </a>
             <h3 class="fs-150 px-3">All Job Titles</h3>

             <div class="row px-3">
                 <span class="message"></span>
             </div>


             <div class="s-card ">
                <div class="s-card-header bg-brand border border-white">
                    <div class="row">
                        <div class="col-4 border-right"">Name</div>
                        <div class="col"></div>
                    </div>
                </div>

                 <ul class="s-card-body basic-ul px-3">

                     <span  id="saved"></span>
                     @foreach($job_titles as $job)
                         <li class="row s-card-row py-1">
                             <div class="col-4 bold border-right"> <span id="job_name">{{$job->name}}</span> </div>

                             <div class="col text-end">
                                 <a href="javascript:void(0)" class="js-edit mr-1" item-id="{{$job->id}}" title="Edit Job Title"><i class="far fa-edit text-warning  fs-130"></i></a>
                                 <a href="javascript:void(0)" class="js-delete" item-id="{{$job->id}}" title="Delete Job Title"><i class="fa fa-trash text-danger  fs-130"></i></a>
                             </div>

                             <div class="col-12 s-edit-row hide mt-2">
                                 <div class="row pt-1 bg-white border-top">
                                     <div class="col-4 bold pe-0">
                                         <input type="text" name="edit_name" id="edit_name_{{$job->id}}" class="form-control form-control-sm " value="{{$job->name}}" autocomplete="off" />

                                       </div>

                                     <div class="col text-start pl-1">
                                         <a href="javascript:void(0)" class="js-save fs-150" title="Save Job Title" item-id="{{$job->id}}"><i class="fas fa-save text-success"></i></a>
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
                        <label for="jobTitle" class="fs-100 bold ">Enter Job Title Name</label>
                        <input type="text" name="jobTitle" id="jobTitle" class="form-control form-control-lg " placeholder="Enter job title name" autocomplete="off" />
                        <div class="row error px-3">
                            <span></span>
                        </div>


                        <div class="mt-3 text-start">
                            <a href="javascript:void(0)"  class="btn btn-default sister js-create-job-title"><i class="fas fa-save"></i> Save Job Title</a>
                        </div>
                    </div>
                </div>
            </div>

         </div>
     </div>
 </div>

 <script>

         //Creates Sale Type
         $('.js-create-job-title').click(function(){

             var name        =   $('#jobTitle').val();

             if(name == ""){
                 $('#jobTitle').addClass('border border-danger').next('.error').children('span').addClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('Job Title needs to be entered!')
             }else{

                 $.ajax({
                     url: '/dashboard/job-title/store?name=' + name,
                         success:function(data){
                             console.log(data);

                             $('#jobTitle').val('');
                             $('#saved').append('<li class="row s-card-row py-1 alert-success border-0" style="margin-top:0px!important; border-bottom:1px solid #FFFFFF!important;"><div class="col-4 bold border-right">'
                                 +name+
                                 '</div></li>'
                                 );

                             // setTimeout(function(){
                             //     $('.pop-up-wrapper').fadeOut('slow').html(data);
                             // }, 400);
                     }
                 });
             }
         })

         //Job Title Name
         //Job Title Type name field as default
         $("#jobTitle").click(function(){
             $('#jobTitle').removeClass('border border-danger').next('.error').children('span').removeClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('')
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

             $(this).closest('.s-edit-row').addClass('hide')
             $('body').removeClass('overflow');

             //alert(name + " - " + active  + " - " + end_date + " - " + id)

             $.ajax({
                url: '/dashboard/job-title/update?id=' + id + '&name=' + name,


                     success:function(data){
                         console.log(data);
                         $('#job_name').addClass('text-success').html(name);
                         $('.message').addClass('col-12 alert-success py-2 my-3').html('Job Title [' +name+ '] was successfully save!')

                         setTimeout(function(){
                             $('.pop-up-wrapper').fadeOut('slow').html(data);
                         }, 3000);
                     }
             });

         })

         //Asks Admin to confirm deletion
         $('.js-delete').click(function(){
             var item_id     =   $(this).attr('item-id');
             var hide_row    =   $(this).closest('.s-card-row');

             $.confirm({
                 title: 'Confirm!',
                 content: 'Are you sure you want to delete Job Title?',
                 buttons: {
                     //If confirmed proceeds to delete
                     confirm: function (e) {
                         $.ajax({
                             success: function (response)
                             {

                                 $.ajax({
                                     url: '/dashboard/job-title/delete?id=' + item_id,

                                             success:function(data){

                                                 console.log(data);
                                                 hide_row.addClass('hide');
                                                 $('.message').addClass('col-12 alert-success py-2 my-3').html('Job Title was successfully deleted!')
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

