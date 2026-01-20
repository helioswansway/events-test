@if(session('success'))
    <div class="alert alert-success js-display-message rounded-0">
        <i class='far fa-laugh'></i> {{session('success')}}
        <div class="js-close">X</div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning text-danger bold js-display-message rounded-0">
        <i class='far fa-frown-open'></i> {{session('warning')}}
        <div class="js-close">X</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger js-display-message rounded-0">
        <i class='fas fa-times'></i> {{session('error')}}
        <div class="js-close">X</div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger bold">
        <ul class="basic-ul">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


