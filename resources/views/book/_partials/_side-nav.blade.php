<aside class="sideNav shadow" id="sideNav">


    <header class="bg-white text-dark pt-5" style="min-height: 300px;">

        <div style="margin-top: -40px; padding-right: 20px; text-align: right;" class="show-mobile"><a href="" class="btn btn-border brand btn-close fs-120 border px-2" style="border: 1px solid #5e5d5d !important; border-radius: 20px; display: inline-block; width:20px !important; line-height:26px; height: 26px" title="Close">X</a></div>

        <img src="{{asset('assets/images/public/general')}}/{{brandLogo()}}" alt="" width="150" class="img-fluid mt-2" title="{{$config->company_name}}">
        <h4 class="mb-5">{{ Auth::guard('book')->user()->name }} {{ Auth::guard('book')->user()->surname }}</h4>
    </header>

    @if($event->inc_exec == 0)
        <ul class="basic-ul">
            <li>
                <a href="{{route('book.dashboard')}}" class="{{ (request()->is('book')) ? 'active' : '' }}" title="Select Model">
                    <div class="numb">1</div> <span> Select Model <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            <li>
                <a href="{{route('book.appointment')}}" class="{{ (request()->is('book/appointment')) ? 'active' : '' }}" title="Book Your Appointment">
                    <div class="numb">2</div> <span> Book Your Appointment  <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            {{-- <li>
                <a href="{{route('book.confirm-details')}}" class="{{ (request()->is('book/confirm-details')) ? 'active' : '' }}" title="Confirm Your Details">
                    <div class="numb">3</div> <span> Confirm Your Details <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li> --}}

            <li>
                <a href="{{route('book.confirmation')}}" class="{{ (request()->is('book/booking-confirmation')) ? 'active' : '' }}" title="Booking Confirmation">
                    <div class="numb">4</div> <span> Booking Confirmation <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>
        </ul>

    @else
        <ul class="basic-ul">
            @if($event->show_vehicles == 1)
                <li>
                    <a href="{{route('book.dashboard')}}" class="{{ (request()->is('book')) ? 'active' : '' }}" title="Select Model">
                        <div class="numb">1</div> <span> Select Model <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{route('book.appointment')}}" class="{{ (request()->is('book/appointment')) ? 'active' : '' }}" title="Book Your Appointment">
                    <div class="numb">2</div> <span> Book Your Appointment  <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>

            @if($event->show_part_exchange == 1)
                <li>
                    <a href="{{route('book.part.exchange')}}"  name="partexchange_link" class="{{ (request()->is('book/part-exchange')) ? 'active' : '' }}" title="Your Part Exchange Details">
                        <div class="numb">3</div> <span> Your Part Exchange Details <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </li>
            @endif


            {{-- <li>
                <a href="{{route('book.confirm-details')}}" class="{{ (request()->is('book/confirm-details')) ? 'active' : '' }}" title="Confirm Your Details">
                    <div class="numb">4</div> <span> Confirm Your Details <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li> --}}


            <li>
                <a href="{{route('book.confirmation')}}" class="{{ (request()->is('book/booking-confirmation')) ? 'active' : '' }}" title="Booking Confirmation">
                    <div class="numb">5</div> <span> Booking Confirmation <i class='fas fa-angle-right fs-100'></i></span>
                </a>
            </li>
        </ul>
    @endif


    @if($appointment->confirm == 1)

        <form action="{{route('book.resend.email')}}" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
            <div class="col text-center py-4">

                <button type="submit"class="btn btn-border success btn-radius-md text-center ">
                    <i class="fa-solid fa-paper-plane me-2"></i> Resend appointment details
                </button>
            </div>
        </form>

    @endif

    <div class="col text-center @if($appointment->confirm == 0) py-4 @endif">
        <a href="{{ route('book.logout') }}" class="btn btn-border warning btn-radius-md text-center "
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fas fa-power-off"></i> Log Out
        </a>
        <form id="logout-form" action="{{ route('book.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>





</aside>
