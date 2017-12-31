@extends('layouts.app')

@section('style')
    <style media="screen">
        .ui.inverted.pointing.menu .active.item:after {
            background-color: #00B5AD !important
        }

        .user-info.form .required.field h3:after{
            margin: -0.2em 0em 0em 0.2em;
            content: '*';
            color: #DB2828;
        }
    </style>
@endsection

@section('content')
<div class="container">
    {{-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-success">
                            {{session('error')}}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Top steps --}}
    @unless ( Auth::user()->is_profile_complete )
    <div class="ui centered grid stackable container">
        <div class="sixteen wide column">
            <div class="ui three stackable steps">
                <div class="completed step">
                    <i class="icon"></i>
                    <div class="content">
                        <div class="title">註冊</div>
                        <div class="description">You are already our member</div>
                    </div>
                </div>
                <div class="active step">
                    <i class="id card outline icon"></i>
                    <div class="content">
                        <div class="title">填寫基本資料</div>
                        <div class="description">Let people get to know you more</div>
                    </div>
                </div>
                <div class="disabled step">
                    <i class="wechat icon"></i>
                    <div class="content">
                        <div class="title">開始配對聊天!</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Hint message --}}
        <div class="ui compact success message">
            <i class="close icon"></i>
            <div class="header">
                Your are almost there!
            </div>
            <p>Just one more thing before you start. Fill your basic so people can get to know you more.</p>
        </div>
    </div>
    @endunless

    {{-- Main content --}}
    <div class="ui grid stackable container main-content" style="margin-top:3em; padding-bottom:4em;">

        {{-- Left menu --}}
        <div class="four wide column">
            <div class="ui vertical pointing menu side-menu">
                <a class="active item" data-tab="first">基本資料
                    <div class="ui teal left pointing label">&nbsp;</div>
                </a>
                <a class="item" data-tab="second">配對紀錄
                    <div class="ui label">51</div>
                </a>
                <a class="item" data-tab="third">VIP
                    <div class="ui label">no</div>
                </a>
            </div>
        </div>

        <div class="one wide column">
            {{-- gap --}}
        </div>

        {{-- First tab --}}
        {{-- Right info form --}}
        <div id="info-tab" class="eight wide column tab-content" data-tab="first">

            <div class="ui grid stackable container">
                <div class="ten wide column">
                    <h1>{{ Auth::user()->name }}</h1>
                </div>
                <div class="six wide column">
                    <div class="ui secondary fluid basic button">
                        <div style="position: relative; top: -16px; background: #fff; height: 6px; left: -10px; width: 80px;">vip Level</div>
                        <p class="force-select">普通會員</p>
                    </div>
                </div>
            </div>

            <div class="ui section divider"></div>

            <div class="ui stackable container">

                <form action="/user/profile" method="POST" class="ui user-info form">
                    {{ csrf_field() }}

                    {{-- Gender --}}
                    <div class="inline fields">
                        <div class="six required wide field">
                            {{-- <label>性別</label> --}}
                            <h3>性別</h3>
                            <i class="help circle icon activating element" data-content="Your gender"></i>
                        </div>
                        <div class="ten wide field">
                            <div class="ui gender selection dropdown">
                                <input type="hidden" name="gender">
                                <i class="dropdown icon"></i>
                                <div class="default text">性別</div>
                                <div class="menu">
                                    <div class="item" data-value="boy">男</div>
                                    <div class="item" data-value="girl">女</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Hobby --}}
                    <div class="inline fields">
                        <div class="six required wide field">
                            {{-- <label>興趣</label> --}}
                            <h3>興趣</h3>
                            <i class="help circle icon activating element" data-content="Topics that you're interested in. Let people know what to talk about to you."></i>
                        </div>
                        <div class="ten wide field">
                            <input type="text" placeholder="興趣..." name="hobby">
                        </div>
                    </div>

                    {{-- Research Area --}}
                    <div class="inline fields">
                        <div class="six required wide field">
                            {{-- <label>研究領域</label> --}}
                            <h3>研究領域</h3>
                            <i class="help circle icon activating element" data-content="What's your research field/area?"></i>
                        </div>
                        <div class="ten wide field">
                            <div class="ui research-area selection dropdown">
                                <input type="hidden" name="area">
                                <i class="dropdown icon"></i>
                                <div class="default text">研究領域</div>
                                <div class="menu">
                                    <div class="item">
                                        field
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="inline fields">
                        <div class="six required wide field">
                            {{-- <label>所在縣市</label> --}}
                            <h3>所在縣市</h3>
                            <i class="help circle icon activating element" data-content="Select your location"></i>
                        </div>
                        <div class="ten wide field">
                            <div class="ui location selection dropdown">
                                <input type="hidden" name="location">
                                <i class="dropdown icon"></i>
                                <div class="default text">所在縣市</div>
                                <div class="menu">
                                    <div class="item">
                                        city
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Introduction --}}
                    <div class="inline fields">
                        <div class="six required wide field">
                            {{-- <label>關於我</label> --}}
                            <h3>關於我</h3>
                            <i class="help circle icon activating element" data-content="Talk anything else about yourself EXCEPT your realworld identifying information. You'll chat first then decide whether to date or not."></i>
                        </div>
                        <div class="ten wide field">
                            <textarea placeholder="Hi, I'm ..." name="introduction"></textarea>
                        </div>
                    </div>

                    <div class="ui hidden divider"></div>

                    <div class="inline fields">
                        <button class="large ui teal submit button right floated" style="margin: 0px;" type="button">
                            <i class="checkmark icon"></i>
                                Save
                        </button>
                    </div>

                    <div class="ui error message"></div>

                </form>
            </div>
        </div>

        {{-- second tab --}}
        <div id="match-record-tab" class="ten wide column tab-content" data-tab="second" style="display:none;">
            <div class="ui grid stackable container">
                <div class="ten wide column">
                    <h1>{{ Auth::user()->name }}</h1>
                </div>
                <div class="six wide column">

                </div>
            </div>

            <div class="ui section divider"></div>

            <div class="ui stackable container">
                <div class="ui three special cards">
                    <div class="card match-card" data-hash="">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <div class="ui inverted button">對話紀錄</div>
                                    </div>
                                </div>
                            </div>
                            <img src="http://fakeimg.pl/300/">
                        </div>

                        <div class="content">
                            <div class="header">Matt Giampietro</div>
                            <div class="meta">
                                <span class="date">Create in Sep 2014</span>
                            </div>
                            <div class="description">
                                Matthew is an interior designer living in New York.
                            </div>
                        </div>
                        <div class="extra">
                            Rating:
                            <div class="ui star rating" data-rating="4"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Third tab --}}
        <div class="eight wide column tab-content" data-tab="third" style="display:none;">
            <div class="ui grid stackable container">
                <div class="ten wide column">
                    <h1></h1>
                </div>
                <div class="six wide column">

                </div>
            </div>

            <div class="ui section divider"></div>

            <div class="ui stackable container">
                <p>Sorry. The VIP system is currently unavailable.</p>
                <p>We'll leave this feature to the future</p>
            </div>
        </div>
    </div>
</div>

@include('partials/_match-card-template')
@include('partials/_chat-history-modal')
@include('partials/_my-message')
@include('partials/_other-message')

@endsection

@section('script')

<script src="{{asset('js/home.js')}}"></script>

@endsection
