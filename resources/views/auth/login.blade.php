@extends('layouts.app')

@section('style')
    <style type="text/css">
        body > .grid {
            height: 100%;
        }

        .column {
            max-width: 450px;
        }
    </style>
@endsection

@section('content')

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
          <div class="content">
            {{-- Log-in to your account --}}
          </div>
        </h2>

        <form class="ui large form{{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="ui stacked segment">
                <div class="field{{ $errors->has('email') ? ' error' : '' }}">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input id="email" type="email" class="" name="email" placeholder="E-mail address" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="field{{ $errors->has('password') ? ' error' : '' }}">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input id="password" type="password" class="" name="password" placeholder="Password" value="{{ old('password') }}" required>
                    </div>
                </div>
                <button type="submit" class="ui fluid large teal submit button">Login</button>
            </div>

            <div class="ui error message">
                <ul class="list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </form>

        <div class="ui message">
            New to us? <a href="{{ route('register') }}">Sign Up</a>
        </div>


        <div class="ui message">
            <a class="" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </div>

    </div>
</div>



@endsection
