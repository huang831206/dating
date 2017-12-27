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
        <h2 class="ui teal header">
          <div class="content">
              Register
          </div>
        </h2>

        <form class="ui big form{{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="ui stacked segment">
                <div class="required field{{ $errors->has('name') ? ' error' : '' }}">
                    <label for="name" class="">Name</label>
                    <input id="name" type="text" class="" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="required field{{ $errors->has('email') ? ' error' : '' }}">
                    <label for="email" class="">Email</label>
                    <input id="email" type="email" class="" name="email" placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <div class="required field{{ $errors->has('password') ? ' error' : '' }}">
                    <label for="name" class="">Password</label>
                    <input id="password" type="password" class="" name="password" placeholder="Password (min length : 6)" required>
                </div>

                <div class="required field">
                    <label for="password-confirm" class="">Password Confirm</label>
                    <input id="password-confirm" type="password" class="" name="password_confirmation" placeholder="Type Your Password Again" required>
                </div>


                <button type="submit" class="ui fluid large blue submit button">Register</button>
            </div>
            <div class="ui error message">
                <ul class="list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </form>

    </div>
</div>

@endsection
