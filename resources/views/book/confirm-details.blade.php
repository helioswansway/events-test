@extends('_layouts._book-dashboard')

@section('content')

    @include('admin.inc._messages')

    <div class="row justify-content-center">
        <h1 class="display-4 bold mb-0">Please confirm or amend your details.</h1>
        <div class="saved hide"></div>
    </div>

    <div class="s-card px-3 mb-5 mt-5">
       <div class="row justify-content-center">
            <div class="col-lg-12 shadow p-5">
                <div class="row">
                    <div class="col-lg-6 js-edit-personal-details">
                        <h2 class="border-bottom mb-4 pb-3">
                            Personal Details
                            <a href="javascript:void(0)" class="btn btn-default sister js-save-personal-details float-end py-1 hide"><i class="fas fa-save mr-2"></i> Save</a>
                            <a href="javascript:void(0)" class="btn btn-default light js-personal-details float-end py-1"><i class="fas fa-user-edit mr-2"></i> Edit</a>
                        </h2>
                        <input type="hidden" id="id" name="id" value="{{$customer->id}}">


                        <div class="block mb-3">
                            <span class="bold">Name:</span>
                            <input type="text" id="name" name="name" class="form-control form-control-lg"  value="{{$customer->name}}">
                        </div>

                        <div class="block mb-3">
                            <span class="bold">Surname:</span>
                            <input type="text" id="surname" name="surname" class="form-control form-control-lg" value="{{$customer->surname}}">
                        </div>
                        <div class="block mb-3">
                            <span class="bold">Email:</span>
                            <input type="text" id="email" name="email" class="form-control form-control-lg" value="{{$customer->email}}">
                        </div>
                        <div class="block mb-3">
                            <span class="bold">Home Phone:</span>
                            <input type="text" id="home_phone" name="home_phone" class="form-control form-control-lg" value="{{$customer->home_phone}}">
                        </div>

                        <div class="block mb-3">
                            <span class="bold">Mobile:</span>
                            <input type="text" id="mobile" name="mobile" class="form-control form-control-lg" value="{{$customer->mobile}}">
                        </div>
                    </div>

                    <div class="col-lg-6 js-edit-address-details">
                        <h2 class="border-bottom mb-4 pb-3">
                            Address Details
                            <a href="javascript:void(0)" class="btn btn-default sister js-save-address-details float-end py-1 hide"><i class="fas fa-save mr-2"></i> Save</a>
                            <a href="javascript:void(0)" class="btn btn-default light js-address-details float-end py-1"><i class="fas fa-user-edit mr-2"></i> Edit</a>
                        </h2>
                        <div class="block mb-3">
                            <span class="bold">Address:</span>
                            <input type="text" id="address_1" name="address_1" class="form-control form-control-lg" value="{{$customer->address_1}}">
                        </div>

                        <div class="block mb-3">
                            <span class="bold">Address 2:</span>
                            <input type="text" id="address_2" name="address_2" class="form-control form-control-lg" value="{{$customer->address_2}}">
                        </div>
                        <div class="block mb-3">
                            <span class="bold">Town:</span>
                            <input type="text" id="address_3" name="address_3" class="form-control form-control-lg" value="{{$customer->address_3}}">
                        </div>

                        <div class="block mb-3">
                            <span class="bold">Count:</span>
                            <input type="text" id="address_4" name="address_4" class="form-control form-control-lg" value="{{$customer->address_4}}">
                        </div>

                        <div class="block mb-3">
                            <span class="bold">Address 5:</span>
                            <input type="text" id="address_5" name="address_5" class="form-control form-control-lg" value="{{$customer->address_5}}">
                        </div>

                        <div class="block mb-3">
                            <span class="bold">Post Code:</span>
                            <input type="text" id="post_code" name="post_code" class="form-control form-control-lg" value="{{$customer->post_code}}">
                        </div>
                    </div>
                </div>

            </div>

       </div>
    </div>

    <div class="col-12 text-center pt-3">
        <a href="{{route('book.part.exchange')}}" class="btn btn-border warning btn-radius-md mr-5"><i class="fas fa-arrow-left mr-3"></i>  Back</a>

        <a href="{{route('book.confirmation')}}" class="btn btn-border sister btn-radius-md ml-5">Next <i class="ml-3 fas fa-arrow-right"></i></a>
    </div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>


    <script>

        $('.js-edit-personal-details input, .js-edit-address-details input').attr('disabled', 'disabled');


        $('.js-personal-details').click(function(){
            $('.js-edit-personal-details input').addClass('border border-dark').removeAttr('disabled', 'disabled');
            $(this).addClass('hide');
            $('.js-save-personal-details').removeClass('hide');
            $('.saved').addClass('hide')

        });

        $('.js-save-personal-details').click(function(){
            var name            = $('#name').val();
            var surname         = $('#surname').val();
            var email           = $('#email').val();
            var home_phone      = $('#home_phone').val();
            var mobile          = $('#mobile').val();
            var id              = $('#id').val();

            //Fetchs all the execs that belongs to the selected dealership
            fetch('/book/save-personal-details',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    id: id,
                    name: name,
                    surname: surname,
                    email: email,
                    home_phone: home_phone,
                    mobile: mobile
                }),
            })
            .then((response) => response.json())
            .then((response) => {
                console.log(response);
                $('.js-save-personal-details').addClass('hide');
                $('.js-personal-details').removeClass('hide');
                $('.js-edit-personal-details input').removeClass('border border-dark').attr('disabled', 'disabled');
                $('.saved').removeClass('hide').html(response)

                setTimeout(function() {
                    location.reload();
                }, 2000);

            })
            .catch(error => console.log('Error:' + error))

        });

        $('.js-address-details').click(function(){
            $('.js-edit-address-details input').addClass('border border-dark').removeAttr('disabled', 'disabled');
            $(this).addClass('hide');
            $('.js-save-address-details').removeClass('hide');
            $('.saved').addClass('hide')
        });

        $('.js-save-address-details').click(function(){
            var address_1       = $('#address_1').val();
            var address_2       = $('#address_2').val();
            var address_3       = $('#address_3').val();
            var address_4       = $('#address_4').val();
            var address_5       = $('#address_5').val();
            var post_code       = $('#post_code').val();
            var id              = $('#id').val();


            //Fetchs all the execs that belongs to the selected dealership
            fetch('/book/save-address-details',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                'X-Requested-With': 'XMLHttpRequest',
            },
                body: JSON.stringify({
                    id: id,
                    address_1: address_1,
                    address_2: address_2,
                    address_3: address_3,
                    address_4: address_4,
                    address_5: address_5,
                    post_code: post_code
                }),
            })
            .then((response) => response.json())
            .then((response) => {
                console.log(response);
                $('.js-save-address-details').addClass('hide');
                $('.js-address-details').removeClass('hide');
                $('.js-edit-address-details input').removeClass('border border-dark').attr('disabled', 'disabled');
                $('.saved').removeClass('hide').html(response)

                setTimeout(function() {
                    location.reload();
                }, 2000);

            })
            .catch(error => console.log('Error:' + error))
        });

    </script>



@endsection
