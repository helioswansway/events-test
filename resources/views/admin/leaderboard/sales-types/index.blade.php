<div class="container">
   <div class="row justify-content-center ">
    <div class="col-lg-10 bg-white flex-wrap shadow py-3 px-0">

        <a href="javascript:void(0)" class="js-close" title="Close"><i class="fas fa-times"></i> </a>
        <h3 class="fs-150 px-3">All Sale Types</h3>

        <div class="col-12">
            <div class="row px-3">
                <span class="message"></span>
            </div>
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
                @foreach($sale_types as $type)
                    <li class="row s-card-row py-1">
                        <div class="col-4 bold border-right"> <span id="type_name">{{$type->name}}</span> </div>

                        <div class="col text-end">
                            <a href="javascript:void(0)" class="js-edit mr-1" item-id="{{$type->id}}" title="Edit Sale Type"><i class="far fa-edit text-warning fs-130"></i></a>
                            <a href="javascript:void(0)" class="js-delete" item-id="{{$type->id}}" title="Delete Sale Type"><i class="fa fa-trash text-danger fs-130"></i></a>
                        </div>

                        <div class="col-12 s-edit-row hide ">
                            <div class="row pt-1 alert-brother border-0 border-top">
                                <div class="col-4 bold pe-0">
                                    <input type="text" name="edit_name" id="edit_name_{{$type->id}}" class="form-control form-control-sm " value="{{$type->name}}" autocomplete="off" />
                                </div>

                                <div class="col text-start pl-1">
                                    <a href="javascript:void(0)" class="js-save fs-150" title="Save Sale Type" item-id="{{$type->id}}"><i class="fas fa-save text-success"></i></a>
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
                    <label for="saleType" class="fs-100 bold ">Enter Sale Type Name</label>
                    <input type="text" name="saleType" id="saleType" class="form-control form-control-lg " placeholder="Enter sale type name" autocomplete="off" />
                    <div class="row error px-3">
                        <span></span>
                    </div>

                    <div class="mt-3 text-start">
                        <a href="javascript:void(0)"  class="btn btn-default sister js-create-sale-type"><i class="fas fa-save"></i> Save Sale Type</a>
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

        //Creates Sale Type
        $('.js-create-sale-type').click(function(){

            var name        =   $('#saleType').val();

            if(name == ""){
                $('#saleType').addClass('border border-danger').next('.error').children('span').addClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('Sale Type name needs to be entered!')
            }else{

                $.ajax({
                    url: '/dashboard/sale-type/store?name=' + name,
                        success:function(data){
                            console.log(data);

                            $('#saleType').val('');
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

        //Sale Type Name
        //Sets Sale Type name field as default
        $("#saleType").click(function(){
            $('#saleType').removeClass('border border-danger').next('.error').children('span').removeClass('col-12 rounded mt-1 text-left alert-danger block py-1').html('')
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
               url: '/dashboard/sale-type/update?id=' + id + '&name=' + name,


                    success:function(data){
                        console.log(data);
                        $('#type_name').addClass('text-success').html(name);
                        $('.message').addClass('col-12 alert-success py-2 my-3').html('Sale Type [' +name+ '] was successfully save!')

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
            alert(item_id)
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete Sale Type?',
                buttons: {
                    //If confirmed proceeds to delete
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {

                                $.ajax({
                                    url: '/dashboard/sale-type/delete?id=' + item_id,

                                            success:function(data){

                                                console.log(data);
                                                hide_row.addClass('hide');
                                                $('.message').addClass('col-12 alert-success py-2 my-3').html('Sale Type was successfully deleted!')
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

