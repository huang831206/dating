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
        background: url("{{asset('images/ring-blur2.jpg')}}") #103d50 !important;
        background-size: cover !important;
        background-position: center !important;
    }

    #app {
        margin-top: 47px !important;
    }

    #invitation-date .ui.loader:before{
        border-color: #adacac7a;
    }

    #invitation-date .ui.loader:after{
        border-color: #4a4747 transparent transparent;
    }

</style>
@endsection

@section('sidebar')
    <div class="ui top sidebar segment">
        <div class="ui center aligned page grid">
            <div class="one column row">
                <div class="sixteen wide column">
                    <h2 class="ui header">關於對方</h2>
                </div>
            </div>
            <div class="five column divided row">
                <div class="column">
                    性別<br>
                    <img  class="ui wireframe image" src="{{asset('images/'. $data['other_profile']->gender .'.png')}}">
                    {{$data['other_profile']->gender}}
                </div>
                <div class="column">
                    來自於<br><br><br>
                    {{$data['other_profile']->city}}
                </div>
                <div class="column">
                    研究領域<br><br><br>
                    {{$data['other_profile']->area}}
                </div>
                <div class="column">
                    興趣<br><br><br>
                    {{$data['other_profile']->hobby}}
                </div>
                <div class="column">
                    自我介紹<br><br><br>
                    {{$data['other_profile']->introduction}}
                </div>
            </div>
        </div>
    </div>

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
            {{-- <div class="item">
                <div class="content message ui large olive" style="max-width:100%">
                    請確認是否參加2018/1/3 18:00，在 台灣桃園市中壢區環西路二段正老林羊肉爐 的聚會？
                    你們的推薦論文為：
                    <ul>
                        <li>一個具有聲音支援的情感導向式資訊視覺化系統</li>
                        <li>應用於程式行為分析之彈性資訊流追蹤技術</li>
                        <li>探討腦波資訊回饋對民眾求籤態度的影響</li>
                    </ul>
                    <div class="actions" style="margin-top:1em">
                        <div class="ui negative button">No</div>
                        <div class="ui positive right labeled icon button approve-invitation-btn" data-id=30>
                            Yes
                            <i class="checkmark icon"></i>
                        </div>
                    </div>
                </div>

            </div> --}}
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
    <div class="centered row inverted" style="background-color:#a4b8d078">
        <div class="middle aligned column">
            <button class="circular ui icon green inverted button" id="info-profile" data-tooltip="對方資料">
                <i class="info large icon"></i>
            </button>
        </div>
        <div class="middle aligned column">
            <button class="circular ui icon red inverted button" id="end-btn" data-tooltip="結束對話">
                <i class="remove large icon"></i>
            </button>
        </div>
        <div class="middle aligned column" >
            <button class="circular ui icon button" id="new-invitation-btn" data-tooltip="發送邀請">
                <i class="calendar large icon"></i>
            </button>
        </div>
        <div class="twelve wide column">
            <div class="ui fluid action input inverted segment" style="background-color:#deb94f;">
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
@include('partials/_invitation-modal')
@include('partials/_invitation-message')

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUj6U1I3CrgjudAY3-i6E9C0TH0aIOEdg&libraries=places"></script>
<script src="{{asset('js/chat.js')}}"></script>

@endsection
