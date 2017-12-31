<div class="ui fixed teal inverted menu">

    <a class="item" href="{{ url('/home') }}">
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

            {{-- user information --}}
            <div class="ui inline dropdown item">
                <div class="text">
                    <img class="ui avatar image" src="http://fakeimg.pl/50/">
                    {{ Auth::user()->name }}
                </div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    {{-- logout button --}}
                    <div class="item">
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
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