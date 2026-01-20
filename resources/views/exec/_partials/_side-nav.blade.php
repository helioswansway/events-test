<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" id="nav">
    <div class="offcanvas-header py-2 ">
        <a href="/exec" class="logo">
            <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" width="130" class="img-fluid" title="{{$config->company_name}}">
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body bg-brand">
        <ul class="basic-ul">
            <li class="header"> <span> Menu </span> </li>

            <li>
                <a href="{{route('exec.dashboard')}}" class="{{ (request()->is('exec/dashboard')) ? 'active' : '' }}" title="Dashboard">
                    <i class="fas fa-tachometer-alt"></i> <span> Dashboard <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li>
                <a href="{{route('exec.appointment.index')}}" class="{{ (request()->is('exec/appointments*')) ? 'active' : '' }}" title="Appointments">
                    <i class="fas fa-calendar-alt"></i> <span> Appointments <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            {{-- <li>
                <a href="{{route('exec.prospect.index')}}" class="{{ (request()->is('exec/prospects*')) ? 'active' : '' }}" title="Prospects">
                    <i class="fas fa-users"></i> <span> Prospects<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li> --}}

            <li>
                <a href="{{route('exec.sale.index')}}" class="{{ (request()->is('exec/sales*')) ? 'active' : '' }}" title="Sales">
                    <i class="fas fa-tags"></i> <span> Sales<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li>
                <a href="{{route('exec.reception.log')}}" class="{{ (request()->is('exec/reception-log*')) ? 'active' : '' }}" title="Prospects">
                    <i class="fas fa-concierge-bell"></i> <span> Reception Log<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li><div class="my-3"><hr></div></li>


            <li>
                <a href="{{route('exec.contacts')}}" class="{{ (request()->is('exec/admin-contacts')) ? 'active' : '' }}" title="Prospects">
                    <i class="fas fa-users-cog"></i> <span> Admin Contacts<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

        </ul>

    </div>

</div>

<a href="/exec" class="js-logo">
    <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" width="130" class="img-fluid" title="{{$config->company_name}}">
</a>

<!-- Button to open the offcanvas sidebar -->
<button class="js-btn-nav" type="button" data-bs-toggle="offcanvas" data-bs-target="#nav">
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
</button>

{{--
    <aside class="sideNav" id="sideNav">

        <header>
            <a href="/exec" class="logo" >
                <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" class="img-fluid" title="{{$config->company_name}}">
            </a>
            <span class="js-close">X</span>
            <span class="js-appointment-event"></span>
        </header>

        <ul class="basic-ul">
            <li class="header pl-3"> <span> Menu </span> </li>
            <li>
                <a href="{{route('exec.dashboard')}}" class="{{ (request()->is('exec/dashboard')) ? 'active' : '' }}" title="Dashboard">
                    <i class="fas fa-tachometer-alt"></i> <span> Dashboard <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>
            <li class="hr-1 m-0"><hr class="m-0"></li>
            <li>
                <a href="{{route('exec.appointment.index')}}" class="{{ (request()->is('exec/appointments*')) ? 'active' : '' }}" title="Appointments">
                    <i class="fas fa-calendar-alt"></i> <span> Appointments <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li>
                <a href="{{route('exec.prospect.index')}}" class="{{ (request()->is('exec/prospects*')) ? 'active' : '' }}" title="Prospects">
                    <i class="fas fa-users"></i> <span> Prospects<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li>
                <a href="{{route('exec.sale.index')}}" class="{{ (request()->is('exec/sales*')) ? 'active' : '' }}" title="Sales">
                    <i class="fas fa-tags"></i> <span> Sales<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li>
                <a href="{{route('exec.reception.log')}}" class="{{ (request()->is('exec/reception-log*')) ? 'active' : '' }}" title="Prospects">
                    <i class="fas fa-concierge-bell"></i> <span> Reception Log<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>


            <li class="hr-1 my-3"><hr class="m-0"></li>

            <li>
                <a href="{{route('exec.contacts')}}" class="{{ (request()->is('exec/admin-contacts')) ? 'active' : '' }}" title="Prospects">
                    <i class="fas fa-users-cog"></i> <span> Admin Contacts<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

        </ul>

    </aside>
--}}
