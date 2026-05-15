<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" id="nav">
    <div class="offcanvas-header py-2 ">
        <a href="/dashboard" class="logo">
            <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" width="130" class="img-fluid" title="{{$config->company_name}}">
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body bg-brand">
        <ul class="basic-ul">
            <li class="header"> <span> Menu </span> </li>
            <li>
                <a href="{{route('admin')}}" class="{{ (request()->is('dashboard')) ? 'active' : '' }}" title="Dashboard">
                    <i class="fas fa-tachometer-alt"></i> <span> Dashboard <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            @admin('super-admin')
                <li class="header pl-3"> <span> Events </span></li>

                <li>
                    <a href="{{route('event.index')}}" class="{{ (request()->is('dashboard/events*')) ? 'active' : '' }}" title="Events">
                        <i class="fas fa-calendar-alt"></i>    <span> Events <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super-admin,brand-manager')
                <li>
                    <a href="{{route('customer.index')}}" class="{{ (request()->is('dashboard/customers*')) ? 'active' : '' }}" title="Customers">
                        <i class="fas fa-address-card"></i>    <span> Prospects <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super-admin,brand-manager')
                <li>
                    <a href="{{route('exec.index')}}" class="{{ (request()->is('dashboard/execs*')) ? 'active' : '' }}" title="Execs">
                        <i class="fas fa-user-tie"></i>    <span> Execs <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super-admin,appointments')
                <li>
                    <a href="{{route('admin.appointment.index')}}" class="{{ (request()->is('dashboard/appointments*')) ? 'active' : '' }}" title="Appointments">
                        <i class="fas fa-calendar-check"></i>   <span> Appointments <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin


            @admin('super-admin,leaderboard')
                <li class="header"> <span> Competitions </span></li>
                <li>
                    <a href="{{route('admin.leaderboard.index')}}" class="{{ (request()->is('dashboard/leaderboard')) ? 'active' : '' }}" title="Execs">
                        <i class="fas fa-chart-bar"></i>    <span>Leaderboard <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.leaderboard.get.execs')}}" class="
                                                                                {{ (request()->is('dashboard/leaderboard/get-execs')) ? 'active' : '' }}
                                                                                {{ (request()->is('dashboard/leaderboard/create')) ? 'active' : '' }}
                                                                                {{ (request()->is('dashboard/leaderboard/edit*')) ? 'active' : '' }}
                                                                            " title="Execs">
                        <i class="fas fa-user-tie"></i>    <span>Users <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super')
                <li>
                    <a href="{{route('admin.leaderboard.upload')}}" class="{{ (request()->is('dashboard/leaderboard/upload')) ? 'active' : '' }}" >
                        <i class="fas fa-solid fa-chart-line"></i>   <span>User Leaderboard <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super')
                <li>
                    <a href="{{route('admin.leaderboard.upload')}}" class="{{ (request()->is('dashboard/leaderboard/upload')) ? 'active' : '' }}" >
                        <i class="fas fa-upload"></i>    <span>Upload Users <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super-admin,pot-list')
                <li class="header"> <span> Call Pots </span></li>
            @endadmin

            @admin('super-admin')
                <li>
                    <a href="{{route('admin.pot-campaign.index')}}" class="{{ (request()->is('dashboard/pot-campaign*')) ? 'active' : '' }}" title="Pot Campaign">
                        <i class="fa-solid fa-bullhorn side-nav-icon"></i>    <span>Campaings <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super-admin,pot-list')
                <li>
                    <a href="{{route('admin.pot-list.index')}}" class="{{ (request()->is('dashboard/pot-lists')) ? 'active' : '' }}" title="Pot Lists">
                        <i class="fa-solid fa-list side-nav-icon"></i>    <span>Pots List <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super')
                <li>
                    <a href="{{route('admin.pot-list.upload')}}" class="{{ (request()->is('dashboard/pot-lists/upload')) ? 'active' : '' }}" title="Upload Pot Lists">
                        <i class="fas fa-upload"></i>    <span>Upload CSV File <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super-admin')
                <li class="header"> <span> Manage </span></li>
                <li>
                    <a href="{{route('admin.wallpaper.index')}}" class="{{ (request()->is('dashboard/wallpapers*')) ? 'active' : '' }}" title="Brands">
                        <i class="far fa-image"></i> <span>Login Wallpapers <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('brand.index')}}" class="{{ (request()->is('dashboard/brands*')) ? 'active' : '' }}" title="Brands">
                        <i class="fab fa-black-tie"></i> <span>Brands <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>

                <li>
                    <a href="{{route('dealership.index')}}" class="{{ (request()->is('dashboard/dealerships*')) ? 'active' : '' }}">
                        <i class="fab fa-houzz"></i> <span>Dealerships <i class='fas fa-angle-right  fs-100'></i></span>
                    </a>
                </li>

                <li>
                    <a href="{{route('vehicle.index')}}" class="{{ (request()->is('dashboard/vehicles*')) ? 'active' : '' }}" title="Customers">
                        <i class="fas fa-car"></i>    <span> Vehicles <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>

                <li>
                    <a href="/dashboard/site-configuration" title="Site Configuration" class="{{ (request()->is('dashboard/site-configuration*')) ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i> <span>Site Configuration <i class='fas fa-angle-right  fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super')
                <li>
                    <a href="" class="" title="Brands">
                        <i class="fas fa-envelope-open-text"></i> <span>Email Templates <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

            @admin('super')
                <li><a href="{{route('dashboard.migrate')}}"><i class="fa-solid fa-server fs-150 me-1 w-30 text-center"></i> Migrate</a></li>
                <li><a href="{{route('dashboard.queue.work')}}"><i class="fa-solid fa-server fs-150 me-1 w-30 text-center"></i> Queue Work</a></li>

                <li><a href="{{route('dashboard.db-dump')}}"><i class="fa-solid fa-database fs-150 me-1 w-30 text-center"></i> Database Backup</a></li>
                <li><a href="{{route('dashboard.files-dump')}}"><i class="fa-solid fa-folder-tree fs-150 me-1 w-30 text-center"></i> Files Backup</a></li>
                <li><a href="{{route('dashboard.backup-all')}}"><i class="fa-solid fa-server fs-150 me-1 w-30 text-center"></i> Files & DB Backup</a></li>
            @endadmin

            @admin('super')
                <li class="header"> <span> Logs </span> </li>
                <li>
                    <a href="/dashboard/logs" class="{{ (request()->is('dashboard/logs*')) ? 'active' : '' }}" title="View Logs">
                        <i class="fa fa-fw fa-book"></i> <span>Logs Viewer <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endadmin

        </ul>

    </div>

</div>

<a href="/dashboard" class="js-logo">
    <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" width="130" class="img-fluid" title="{{$config->company_name}}">
</a>

<!-- Button to open the offcanvas sidebar -->
<button class="js-btn-nav" type="button" data-bs-toggle="offcanvas" data-bs-target="#nav">
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
</button>

