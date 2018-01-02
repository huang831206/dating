@extends('layouts.app')

@section('style')
    <style media="screen">
        .pusher {
            height: 100%;
        }

        .main-bg{
            height: 100%;
            background: url("{{asset('images/love2.jpeg')}}") #103d50 !important;
            background-size: cover !important;
            background-position: center !important;
        }

        #app {
            margin-top: 47px !important;
        }
    </style>
@endsection

@section('content')
<div class="container main-bg" style="overflow-y: hidden;">

    <div class="ui text container" \
    style="margin-left:auto !important;margin-right:auto !important;
    text-align:center;margin-top:8em;background:#b19898cf;padding:3em;border-radius:1em;">
        <h1 class="ui inverted header">
            Find Your Soulmate
        </h1>

        <div class="ui grid stackable">
			<div class="ten wide column">
				<div class="ui grid">
					<div class="twelve wide column field ui category search focus">
                        <div class="ui gender selection dropdown">
                            <input type="hidden" name="gender">
                            <i class="dropdown icon"></i>
                            <div class="default text">性別(不指定)</div>
                            <div class="menu">
                                <div class="item" data-value="boy">男</div>
                                <div class="item" data-value="girl">女</div>
                            </div>
                        </div>
	                </div>
            	</div>

				<div class="ui grid">
					<div class="twelve wide column">
                        <div class="ui research-area selection dropdown">
                            <input type="hidden" name="area">
                            <i class="dropdown icon"></i>
                            <div class="default text">研究領域(不指定)</div>
                            <div class="menu">
                                <div class="item">
                                    field
                                </div>
                            </div>
                        </div>
					</div>
				</div>
				<div class="ui grid">
					<div class="twelve wide column">
                        <div class="ui location selection dropdown">
                            <input type="hidden" name="location">
                            <i class="dropdown icon"></i>
                            <div class="default text">所在縣市(不指定)</div>
                            <div class="menu">
                                <div class="item">
                                    city
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
            <div class="six wide column">
                <div id="do-search" class="ui huge primary button"><i class="search icon"></i>Find the one</div>
			</div>
            <div id="search-loader" class="ui centered inverted large inline loader"></div>
		</div>

    </div>

</div>

@endsection

@section('script')
<script>var uid = {{Auth::user()->id}}</script>
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
<script src="{{asset('js/pair.js')}}"></script>

@endsection
