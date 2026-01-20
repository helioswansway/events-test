<div class="offcanvas offcanvas-start" id="nav">
    <div class="offcanvas-header py-2 ">
        <a href="/leaderboard" class="logo">
            <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" width="130" class="img-fluid" title="{{$config->company_name}}">
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <aside class="offcanvas-body bg-brand">
        <ul class="basic-ul">
            <li class="header"> <span> Menu </span> </li>
            <li>
                <a href="{{route('leaderboard.dashboard')}}" class="{{ (request()->is('leaderboard')) ? 'active' : '' }}" title="Home">
                    <i class="fas fa-home"></i> <span> Home <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li class="hide">
                <a href="{{route('leaderboard.sale.league.index')}}" class="{{ (request()->is('leaderboard/sales-league*')) ? 'active' : '' }}" title="Leaderboard">
                    <i class="fas fa-chart-bar"></i> <span> Leaderboard<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li class="hr-1 m-0 hide"><hr class="my-2"></li>

            <li>
                <a href="{{route('leaderboard.contacts')}}" class="{{ (request()->is('leaderboard/admin-contacts')) ? 'active' : '' }}" title="Ask for help">
                    <i class="fas fa-at"></i> <span>Ask for help<i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>
        </ul>

        <div class="col-12 text-center">
            <div class="hr-line my-4"></div>

            <h2 class="col-12" style="font-size:300%">Hi!</h2>
            <h2 class="fs-150 mb-5">
                <span> {{ auth('leaderboard')->user()->name }}</span>
            </h2>

            <a class="text-brother" href="/leaderboard/logout" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off fs-200 mr-1"></i>  {{ __('Logout') }}
            </a>


            <form id="logout-form" action="{{ route('leaderboard.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>


        </div>

    </aside>
</div>


<a href="/leaderboard" class="js-logo">
    <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="" width="130" class="img-fluid" title="{{$config->company_name}}">
</a>

<!-- Button to open the offcanvas sidebar -->
<button class="js-btn-nav" type="button" data-bs-toggle="offcanvas" data-bs-target="#nav">
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
    <span class="line"></span>
</button>
