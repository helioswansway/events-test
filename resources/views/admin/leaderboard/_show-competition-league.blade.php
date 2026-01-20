<div class="s-card ">
    <div class="s-card-header col-12 border bg-brand ">
        <div class="row">
            <div class="col pt-1">
                @if(isNow() > isPast($competition->end_date))
                    <span class="fs-80 mr-3 alert-danger text-danger py-1 px-2 rounded">
                        Competition ended at : <span class="ml-1"> {{ formatDate(isPast($competition->end_date)) }}</span>
                    </span>
                @else
                    <span class="fs-80 mr-3 bg-white text-brand px-2 py-1 rounded">
                        Competition ends at: <span class="ml-1"> {{ formatDate(isPast($competition->end_date)) }}</span>
                    </span>
                @endif
            </div>
            <div class="col text-end pt-1">
                @if(count($sales) > 0)
                    <a href="{{route('admin.leaderboard.export.total')}}" class="btn btn-border sister  hide"> Export Totals League <i class="fas fa-file-download ml-2"></i></a>
                    <a href="{{route('admin.leaderboard.export', $competition->id)}}" class="btn btn-border sister px-2 mr-3"> Export League <i class="fas fa-file-download ml-2"></i></a>
                @endif
                Total: <span class="js-sum"></span>
            </div>
        </div>
    </div>

    <div class="s-card-header alert-dark text-dark d-none d-lg-block d-xl-block">
        <div class="row ">
            <div class="col-2  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Sales Exec
            </div>

            <div class="col-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Dealership
            </div>

            <div class="col-3  border-right " style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Sales
            </div>
        </div>
    </div>

    <div class="s-card-body px-0 py-0">
        @foreach($competition->leaderboards as $leaderboard)
            <div class="col-12">
                <div class="row s-card-row py-1">
                    <div class="col-lg-2  border-right bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Exec: </span>
                         {{$leaderboard->name}}
                    </div>

                    <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Dealership: </span>
                        {{dealership($leaderboard->id)->name}}
                    </div>

                    <div class="col-lg-3  border-right" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span class="d-xl-none d-lg-none bold text-brand mr-2"> Sales: </span>
                        <span class="badge bg-info js-total"> {{competitionSalesCount($competition->id, $leaderboard->id)}} </span>

                        @admin('super-admin')
                            <a href="javascript:void(0)" leaderboard-id="{{$leaderboard->id}}" competition-id="{{$competition->id}}" class="ml-3 fs-80 btn px-1 py-0 btn-border brand js-view-sales">Sales Log <i class="fas fa-eye"></i></a>
                        @endadmin
                    </div>

                    <div class="col text-end" style="">
                        <a href="{{route('admin.leaderboard.export.brand', [$competition->id, brand($leaderboard->id)->id])}}" class="btn btn-sm btn-border info px-2 mr-3"> Export by Brand <i class="fas fa-file-download ml-2"></i></a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>

<script>

    $(function(){

        function getTotal(){
            var total = 0;
            $('.js-total').each(function(){
                total += parseFloat(this.innerHTML)
            });
            $('.js-sum').text(total);
        }

        getTotal();

        $('.js-view-sales').click(function(){
            var leaderboard_id = $(this).attr('leaderboard-id');
            var competition_id = $(this).attr('competition-id');

            $('body').addClass('overflow');

            $.ajax({
                url: '/dashboard/leaderboard/sale-logs?leaderboard_id=' + leaderboard_id + '&competition_id=' + competition_id,
                    success:function(response){
                        console.log(response)
                        $('.pop-up-wrapper').fadeIn(800).html(response);
                        //Closes Book Appointment Wrapper
                        $('.pop-up-close').click(function(){
                            $('.pop-up-wrapper').fadeOut(1000);
                            $('.pop-up-wrapper').html("");
                            $('body').removeClass('overflow');
                        });


                        //Asks Admin to confirm deletion
                        $('.js-delete').click(function(){
                            var item_id = $(this).attr('item-id');

                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to delete Sale Log?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                //var url = route('leaderboard.delete.log', ":id");
                                                var url = '/dashboard/leaderboard/delete-log/' + item_id;
                                                //url = url.replace(':id',item_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        location.reload();
                                    }
                                }
                            });

                        })

                    }
            });

        })
    })

</script>
