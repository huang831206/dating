@extends('layouts.app') @section('style')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
<style media="screen">
    body {
        overflow-y: hidden;
    }

    .chat-message {
        /*overflow: auto;*/
    }

    .pusher {
        height: 100%;
        background: url('http://dating.my/images/ring-blur2.jpg') #103d50 !important;
        background-size: cover !important;
        background-position: center !important;
    }

    #app {
        margin-top: 47px !important;
    }

</style>
@endsection
@section('content')

<div id="scroll-content" class="ui container" style="height:79%; overflow-x: hidden; overflow-y: auto;">
    <div class="ui borderless segment" style="background:0;">
        <div class="ui middle aligned list chat-messages">


            @forelse ($data['messages'] as $message)
                <div class="item">
                    @if ($message->from_user_id == Auth::user()->id)
                        <div class="right floated content message ui large pink label my-message">
                            {{$message->message}}
                        </div>
                    @else
                        <div class="left floated content message ui large grey label other-message">
                            {{$message->message}}
                        </div>
                    @endif
                </div>
            @empty
                <div class="item">
                    <div class="ui compact message right floated content">
                        Start Your Chat. Be polite...
                    </div>
                </div>
            @endforelse
{{--
            <div class="item">
                <div class="right floated content message ui large olive my-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
                </div>
            </div>
            <div class="item">
                <div class="left floated content message ui large grey label other-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg

                </div>
            </div>
            <div class="item">
                <div class="right floated content message ui large pink label my-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
                </div>
            </div>
            <div class="item">
                <div class="left floated content message ui large grey label other-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg

                </div>
            </div>
            <div class="item">
                <div class="right floated content message ui large pink label my-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
                </div>
            </div>
            <div class="item">
                <div class="left floated content message ui large grey label other-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg

                </div>
            </div>
            <div class="item">
                <div class="right floated content message ui large pink label my-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
                </div>
            </div>
            <div class="item">
                <div class="right floated content message ui large pink label my-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
                </div>
            </div>
            <div class="item">
                <div class="left floated content message ui large grey label other-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg

                </div>
            </div>
            <div class="item">
                <div class="left floated content message ui large grey label other-message">
                    gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg

                </div>
            </div>
--}}
        </div>

    </div>

</div>
<div class="ui bottom attached centered grid chat-box" style=" margin-top: 0;">
    <div class="centered row teal inverted">
        <div class="middle aligned column">
            <button class="circular ui icon button">
            <i class="add square icon"></i>
            </button>
        </div>
        <div class="twelve wide column">
            <div class="ui fluid action input olive inverted segment">
                <input id="textBox" type="text" placeholder="Go...">
                <div class="ui button" id="sendMessage">Go</div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="ui bottom attached horizontal segments grid chat-box" style=" margin-bottom: 2em;">
    <div class="six wide column">
        <i class="add square icon"></i>gg
    </div>
    <div class="ten wide column">
        <div class="ui fluid action input olive inverted segment">

            <input id="textBox" type="text" placeholder="Go...">
            <div class="ui button" id="sendMessage">Go</div>
        </div>
    </div>
</div> --}}


@include('partials/_my-message')
@include('partials/_other-message')

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
<script src="{{asset('js/chat.js')}}"></script>

@endsection
