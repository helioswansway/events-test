@extends('_layouts._dashboard')

@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-user-tie"></i> Leaderboard Users
                <span class="h1-button" style="">
                    <a href="{{route('admin.leaderboard.index')}}" class="btn btn-sm  btn-default brother px-2 me-3"><i class="fas fa-chart-bar mr-2"></i> Leaderboard</a>
                    <a href="{{route('admin.leaderboard.create')}}" class="btn btn-sm  btn-default brand px-2 me-3"><i class="fas fa-user-plus me-1"></i> Create Single user</a>

                    @admin('super')
                        <a href="{{route('admin.leaderboard.upload')}}" class="btn btn-sm  btn-default sister px-2 me-3"> Upload Users <i class="ml-2 fas fa-upload ml-2"></i></a>
                    @endadmin
                    <a href="javascript:void(0)" class="btn btn-sm btn-default light px-2 js-job-title"><i class="fas fa-user-tie me-1"></i> Manage Job Titles</a>

                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <div class="js-keyword text-end">
        <input type="text" id="keyword" class="form-control form-control-lg mb-4 py-3" placeholder="Search Execs by (Exec Dealership ID, Name or Email)">
    </div>

    <div class="col">
        <div class="row justify-content-center my-3 py-3 shadow-sm">
            <div class="row">
                <div class="col-12">
                    <div class="mb-2 bold text-info border-bottom">
                       Follow the Steps to Search Execs by Job Title in Bulk!
                    </div>

                </div>
                <div class="col-3 relative">
                    <label for="brand_id"  class="bold">By Brands <span class="text-danger">*</span></label>
                    <select name="brand_id" id="brand_id" class="form-control form-control-lg js-select-brand">
                        <option value="">-- Select Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}" >{{$brand->name}} </option>
                        @endforeach
                        <option value="all">All</option>
                    </select>
                    <span class="arrow-down" style="position: absolute;"><i class="fas fa-caret-down"></i></span>
                </div>

                <div class="col-3 js-show-job-title hide">
                    <label for="job_title_id"  class="bold">Job Titles <span class="text-danger">*</span></label>
                    <select name="job_title_id" id="job_title_id" class="form-control form-control-lg js-select-job-title">
                        <option value="">-- Select Job Title --</option>
                        @foreach($job_titles as $job)
                            <option value="{{$job->id}}" >{{$job->name}} </option>
                        @endforeach
                        <option value="all">All</option>
                    </select>
                    <span class="arrow-down" style="position: absolute;"><i class="fas fa-caret-down"></i></span>
                </div>

                <div class="col-3 js-show-competions hide">
                    <label for="job_title_id"  class="bold">Competitions <span class="text-danger">*</span></label>
                    <select name="competition_id" id="competition_id" class="form-control form-control-lg js-select-competition">
                        <option value="">-- Select a Competition --</option>
                        @foreach($competitions as $competition)
                            <option value="{{$competition->id}}" >{{$competition->name}} </option>
                        @endforeach
                    </select>
                    <span class="arrow-down" style="position: absolute;"><i class="fas fa-caret-down"></i></span>
                </div>

                <div class="col text-end pt-3">
                    <a href="javascript:void(0)" class="btn btn-border brand js-refresh" title="Refresh Searching"><i class="fas fa-sync-alt"></i></a>
                </div>


            </div>
        </div>
    </div>

    <div class="js-results">
        @include('admin.leaderboard._results')
    </div>

@endsection


@section('scripts')
    <script>

        //Closes Book Appointment Wrapper
        $('.js-refresh').click(function(){
            return location.reload();
        })

        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page    = $(this).attr('href').split('page=')[1];
            var search  = $('#keyword').val();

            fetch_data(page, search);

        });

        $(document).on('keyup', '#keyword', function(){
            //e.preventDefault();
            var search      = $('#keyword').val();
            var page        = $('#hidden_page').val();
            fetch_data(page, search);

        });

        function fetch_data(page, search){
            $.ajax({
                url: '/dashboard/leaderboard/fetchData?page='+page + "&keyword=" + search,
                    success:function(response){
                        $('.js-results').delay(500).html(response);

                        $('.js-delete').click(function(){
                                var item_id = $(this).attr('item-id');

                                $.confirm({
                                    title: 'Confirm!',
                                    content: 'Are you sure you want to delete Leaderboard/User?',
                                    buttons: {
                                        confirm: function (e) {
                                            $.ajax({
                                                success: function (response)
                                                {
                                                    var url = '{{ route('leaderboard.delete', ":id") }}';
                                                    url = url.replace(':id',item_id);
                                                    window.location.href = url;
                                                }
                                            });
                                        },
                                        cancel: function () {
                                            window.location.href = '{{ route('admin.leaderboard.get.execs') }}';
                                        }
                                    }
                                });
                        });
                    }
                });
        }

        //Shows pop up to create, edit and delete Job Title information
        $('.js-job-title').click(function(){

            //Removes overflow class from body tag if exists one
            $('body').addClass('overflow');

            // Adds .fade-in class
            // Removes .fade-out class if exists

            $.ajax({
                url: '/dashboard/job-title/create',
                    success:function(data){
                        console.log(data);
                        setTimeout(function(){
                            $('.pop-up-wrapper').fadeIn('slow').html(data);
                        }, 400);
                }
            });

        })

        $('.js-select-brand').change(function(){
            var id = $(this).val();

            $('.js-select-competition').val("")
            $('.js-select-job-title').val("")

            if(id == ""){
                $('.js-show-job-title').addClass('hide')
                $('.js-show-competitions').addClass('hide')
            }else{
                $('.js-show-job-title').removeClass('hide')
                $('.js-show-competitions').removeClass('hide')
            }

            $.ajax({
                url: '/dashboard/leaderboard/fetchExecsByBrand?brand_id='+id,
                success:function(response){
                    $('.js-results').delay(500).html(response);

                    $('.js-delete').click(function(){
                            var item_id = $(this).attr('item-id');
                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to delete User?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                var url = '{{ route('leaderboard.delete', ":id") }}';
                                                url = url.replace(':id',item_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        window.location.href = '{{ route('admin.leaderboard.index') }}';
                                    }
                                }
                            });
                    });
                }
            });
        })


        $('.js-select-job-title').change(function(){
            var brand_id    =   $('.js-select-brand').val();
            var job_title_id = $(this).val();

            $('.js-select-competition').val("")

            if(job_title_id == ""){
                $('.js-show-competions').addClass('hide')
            }else{
                $('.js-show-competions').removeClass('hide')
            }

            $('.js-results').html("");

            // $('.js-results .s-card-body').delay(500).html('<div class="text-center p-3 pt-5"><div class="pt-5 pb-4  inline"><i class="fas fa-spinner fa-spin fs-200 text-info" style="opacity: 0.5;"></i><p class="bold mt-3 text-brother text-center">Please select a Competition...</p></div></div>');
            // $('.js-results .s-card span').delay(500).html("");
            // $('.js-results .alert-sister').addClass('hide');

            $.ajax({
                url: '/dashboard/leaderboard/fetchExecsByJobTitle?brand_id='+brand_id +'&job_title_id='+job_title_id,
                success:function(response){

                    $('.js-results').delay(500).html(response);

                    $('.js-delete').click(function(){
                            var item_id = $(this).attr('item-id');
                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to delete User?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                var url = '{{ route('leaderboard.delete', ":id") }}';
                                                url = url.replace(':id',item_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        window.location.href = '{{ route('admin.leaderboard.index') }}';
                                    }
                                }
                            });
                    });
                }
            });

        })

        $('.js-select-competition').change(function(){

            var brand_id    = $('.js-select-brand').val()
            var job_title_id    = $('.js-select-job-title').val()
            var competition_id = $(this).val();



            $.ajax({
                url: '/dashboard/leaderboard/fetchExecsByCompetition?competition_id='+competition_id +'&job_title_id='+job_title_id+'&brand_id='+brand_id,
                success:function(response){
                    $('.js-results').delay(500).html(response);

                    $('.js-delete').click(function(){
                            var item_id = $(this).attr('item-id');

                            $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure you want to delete User?',
                                buttons: {
                                    confirm: function (e) {
                                        $.ajax({
                                            success: function (response)
                                            {
                                                var url = '{{ route('leaderboard.delete', ":id") }}';
                                                url = url.replace(':id',item_id);
                                                window.location.href = url;
                                            }
                                        });
                                    },
                                    cancel: function () {
                                        window.location.href = '{{ route('admin.leaderboard.index') }}';
                                    }
                                }
                            });
                    });
                }
            });

            //$('.js-keyword').html('<a href="javascript:void(0)" class="btn btn-border sister js-refresh" title="Refresh Searching"><i class="fas fa-sync-alt"></i></a>')

        })


        $('.js-delete').click(function(){
                var item_id = $(this).attr('item-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Exec?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('leaderboard.delete', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;
                                }
                            });
                        },
                        cancel: function () {
                            window.location.href = '{{ route('admin.leaderboard.index') }}';
                        }
                    }
                });
        });


    </script>


@endsection
