
@if(Request::is('dashboard/*') || Request::is('admin/*' ) )
<nav class="mb-4">
    <ul class="breadcrumb pt-2 pb-1 rounded-0">
        <li class="breadcrumb-item">
            <a href="/dashboard"><i class='fas fa-home'></i> Dashboard</a>
        </li>
        {{--
        @foreach($segments = request()->segments() as $index => $segment)
            @if(is_numeric($segment))

            @else
                @if($segment == 'dashboard' || $segment == 'admin')

                @else
                    <li class="breadcrumb-item">
                        @if($segment == last($segments))

                        @else

                            <a href="{{ url(implode(array_slice($segments, 0, $index + 1), '/'))}}">
                                <i class='fas fa-angle-double-left'></i>
                            </a>
                        @endif
                    </li>
                @endif
            @endif

        @endforeach
        --}}

    </ul>
</nav>
@else

@endif
