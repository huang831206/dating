<div class="ui fixed inverted menu">

    <a class="item" href="{{ url('/') }}">
        {{-- <img src="http://fakeimg.pl/100/"> --}}
        {{ config('app.name', 'Laravel') }}
    </a>

    <a class="item">
        <div class="ui icon input">
            <input type="text" placeholder="Search...">
            <i class="search link icon"></i>
      </div>
    </a>

    <div class="right menu">

        @guest
            <a class="item" href="{{ route('register') }}"><div class="ui primary button">Sign up</div></a>
            <a class="item" href="{{ route('login') }}"><div class="ui button">Log-in</div></a>
        @else

            @if (Auth::user()->current_match)
            <a class="item" href="{{ route('chat', ['match' => Auth::user()->current_match]) }}">
                <i class="circular red inverted talk icon"></i>
            </a>
            @else
            <a class="item" href="{{ route('pair') }}"><div class="ui green button">開始配對</div></a>
            @endif

            {{-- user information --}}
            <div class="ui inline dropdown item">
                <div class="text">
                    {{-- <img class="ui avatar image" src="http://fakeimg.pl/50/"> --}}
                    <i class="user icon"></i>
                    {{ Auth::user()->name }}
                </div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" href="{{ route('home') }}" style="color: #000000;">Dashboard</a>
                    {{-- logout button --}}
                    <div class="item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <a href="{{ route('logout') }}"
                        {{-- onclick="event.preventDefault(); document.getElementById('logout-form').submit();" --}}
                        style="color: #000000;">
                            Logout
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>

        @endguest
    </div>
</div>
