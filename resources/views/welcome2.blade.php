<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>論友</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{-- TODO:import min required assest only --}}
    <!-- Styles -->
    <style>
        .hidden.menu {
            display: none;
        }

        .masthead.segment {
            min-height: 700px;
            padding: 0em 0em;
        }

        .masthead .logo.item img {
            margin-right: 1em;
        }

        .masthead .ui.menu .ui.button {
            margin-left: 0.5em;
        }

        .masthead h1.ui.header {
            margin-top: 3em;
            margin-bottom: 0em;
            font-size: 4em;
            font-weight: normal;
        }

        .masthead h2 {
            font-size: 1.7em;
            font-weight: normal;
        }

        .ui.vertical.stripe {
            padding: 8em 0em;
        }

        .ui.vertical.stripe h3 {
            font-size: 2em;
        }

        .ui.vertical.stripe .button+h3,
        .ui.vertical.stripe p+h3 {
            margin-top: 3em;
        }

        .ui.vertical.stripe .floated.image {
            clear: both;
        }

        .ui.vertical.stripe p {
            font-size: 1.33em;
        }

        .ui.vertical.stripe .horizontal.divider {
            margin: 3em 0em;
        }

        .quote.stripe.segment {
            padding: 0em;
        }

        .quote.stripe.segment .grid .column {
            padding-top: 5em;
            padding-bottom: 5em;
        }

        .footer.segment {
            padding: 5em 0em;
        }

        .secondary.pointing.menu .toc.item {
            display: none;
        }

        .header-dimmer {
            padding-top: 1em;
            background-color: rgba(0,0,0,0.5);
        }

        @media only screen and (max-width: 700px) {
            .ui.fixed.menu {
                display: none !important;
            }
            .secondary.pointing.menu .item,
            .secondary.pointing.menu .menu {
                display: none;
            }
            .secondary.pointing.menu .toc.item {
                display: block;
            }
            .masthead.segment {
                min-height: 350px;
            }
            .masthead h1.ui.header {
                font-size: 2em;
                margin-top: 1.5em;
            }
            .masthead h2 {
                margin-top: 0.5em;
                font-size: 1.5em;
            }
        }

        .landing {
            background: url('{{asset('images/love4.jpeg')}}') #103d50 70% 30% no-repeat !important;
            background-size: cover !important;
        }

        .ladning-dimmer {
            width: 100%;
            min-height: inherit;
            z-index:  10;
            background-color: rgba(0,0,0,0.3);
        }

        .name-lbl {
            color: white !important;
        }

    </style>
    <script src="{{ asset('/js/manifest.js') }}"></script>
    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script src="{{ asset('js/landing.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // fix menu when passed
            $('.masthead').visibility({
                once: false,
                onBottomPassed: function() {
                    $('.fixed.menu').transition('fade in');
                },
                onBottomPassedReverse: function() {
                    $('.fixed.menu').transition('fade out');
                }
            });

            // create sidebar and attach to menu open
            $('.ui.sidebar').sidebar('attach events', '.toc.item');
            $('.ui.dropdown').dropdown();
            $('#main-go').click(function () {
                location.href = '/pair';
            })
        });
    </script>
</head>

<body class="pushable">
{{-- TODO:change menus --}}
    <!-- Following Menu -->
    <div class="ui inverted large top fixed menu transition hidden">
        <div class="ui container">
            <a class="active item" href="/">Home</a>
            <a class="item">About</a>
            <a class="item">Company</a>
            <a class="item">Careers</a>
            <div class="right menu">
                <div class="item">
                    <a class="ui button">Log in</a>
                </div>
                <div class="item">
                    <a class="ui primary button">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="ui vertical inverted sidebar menu left" style="">
        <a class="active item" href="/">Home</a>
        <a class="item">About</a>
        <a class="item">Company</a>
        <a class="item">Careers</a>
        <a class="item">Login</a>
        <a class="item">Signup</a>
    </div>


    <!-- Page Contents -->
    <div class="pusher">
        <div class="ui landing vertical masthead center aligned segment" style="background-color: #8e6f6f;">
            <div class="ladning-dimmer">
                <div class="header-dimmer">
                    <div class="ui container">
                        <div class="ui large secondary inverted pointing menu"  style="border-width:0">
                            <a class="toc item">
                                <i class="sidebar icon"></i>
                            </a>
                            <a class="active item" href="/">Home</a>
                            <a class="item">Work</a>
                            <a class="item">Company</a>
                            <a class="item">Careers</a>
                            <div class="right item">
                                @auth
                                    {{-- <a class="ui inverted button" href="{{ url('/home') }}">Settings</a> --}}
                                    <div class="ui inline dropdown item">
                                        <div class="text">
                                            <img class="ui avatar image" src="http://fakeimg.pl/50/">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <i class="dropdown icon"></i>
                                        <div class="menu">
                                            {{-- logout button --}}
                                            <a class="item" href="{{ route('home') }}" style="color: #000000;">Dashboard</a>
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
                                @else
                                    <a class="ui inverted button" href="{{ route('login') }}">Login</a>
                                    <a class="ui inverted blue button" href="{{ route('register') }}">Register</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                {{-- center text --}}
                <div class="ui text container">
                    <h1 class="ui inverted header">
                            Find Your Soulmate
                        </h1>
                    <h2 style="color:white;">讓學術之路不再孤單.</h2>
                    <div id="main-go" class="ui huge primary button">Get Started <i class="right arrow icon"></i></div>
                </div>
            </div>

        </div>

        <div class="ui vertical stripe segment">
            <div class="ui middle aligned stackable grid container">
                <div class="row">
                    <div class="eight wide column">
                        <h3 class="ui header">We Help Single Boys and Girls</h3>
                        <p>Find someone to talk to. If you're lucky enough, maybe you will have a nice dage!</p>
                        <h3 class="ui header">We Make Bananas That Can Dance</h3>
                        <p>Yes that's right, you thought it was the stuff of dreams, but even bananas can be bioengineered.</p>
                    </div>
                    <div class="six wide right floated column">
                        <img src="{{asset('images/love.jpeg')}}" class="ui large bordered rounded image">
                    </div>
                </div>
                <div class="row">
                    <div class="center aligned column">
                        <a class="ui huge button">Check Them Out</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="ui vertical stripe quote segment">
            <div class="ui equal width stackable internally celled grid">
                <div class="center aligned row">
                    <div class="column">
                        <h3>"What a Company"</h3>
                        <p>That is what they all say about us</p>
                    </div>
                    <div class="column">
                        <h3>"That's exactly what I need!"</h3>
                        <p>
                            <img src="{{asset('images/avatar-small.jpg')}}" class="ui avatar image"> <b>Ben</b> nerd
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui inverted vertical stripe segment">
            <h4 class="ui horizontal divider header">
                <i class="users icon"></i>
                Team
            </h4>
            <div class="ui five column center aligned stackable grid container">
                <div class="column">
                    <img class="ui centered small circular image" src="{{asset('images/1.jpg')}}">
                    <h1 class="ui header name-lbl">黃琮閔</h1>
                    <p></p>
                    <div class="ui basic button">View details »</div>
                </div>
                <div class="column">
                    <img class="ui centered small circular image" src="{{asset('images/2.jpg')}}">
                    <h1 class="ui header name-lbl">顏子明</h1>
                    <p></p>
                    <div class="ui basic button">View details »</div>
                </div>
                <div class="column">
                    <img class="ui centered small circular image" src="{{asset('images/3.jpg')}}">
                    <h1 class="ui header name-lbl">曾博彥</h1>
                    <p></p>
                    <div class="ui basic button">View details »</div>
                </div>
                <div class="column">
                    <img class="ui centered small circular image" src="{{asset('images/4.jpg')}}">
                    <h1 class="ui header name-lbl">謝映蓉</h1>
                    <p></p>
                    <div class="ui basic button">View details »</div>
                </div>
                <div class="column">
                    <img class="ui centered small circular image" src="{{asset('images/5.jpg')}}">
                    <h1 class="ui header name-lbl">鍾幸軒</h1>
                    <p></p>
                    <div class="ui basic button">View details »</div>
                </div>
            </div>
        </div>

        <div class="ui vertical stripe segment">
            <div class="ui text container">
                <h3 class="ui header">Breaking The Grid, Grabs Your Attention</h3>
                <p>Instead of focusing on content creation and hard work, we have learned how to master the art of doing nothing by providing massive amounts of whitespace and generic content that can seem massive, monolithic and worth your attention.</p>
                <a class="ui large button">Read More</a>
                <h4 class="ui horizontal header divider">
                        <a href="#">Case Studies</a>
                    </h4>
                <h3 class="ui header">Did We Tell You About Our Bananas?</h3>
                <p>Yes I know you probably disregarded the earlier boasts as non-sequitur filler content, but its really true. It took years of gene splicing and combinatory DNA research, but our bananas can really dance.</p>
                <a class="ui large button">I'm Still Quite Interested</a>
            </div>
        </div>


        <div class="ui inverted vertical footer segment">
            <div class="ui container">
                <div class="ui stackable inverted divided equal height stackable grid">
                    <div class="three wide column">
                        <h4 class="ui inverted header">About</h4>
                        <div class="ui inverted link list">
                            <a href="#" class="item">Sitemap</a>
                            <a href="#" class="item">Contact Us</a>
                            <a href="#" class="item">Religious Ceremonies</a>
                            <a href="#" class="item">Gazebo Plans</a>
                        </div>
                    </div>
                    <div class="three wide column">
                        <h4 class="ui inverted header">Services</h4>
                        <div class="ui inverted link list">
                            <a href="#" class="item">Banana Pre-Order</a>
                            <a href="#" class="item">DNA FAQ</a>
                            <a href="#" class="item">How To Access</a>
                            <a href="#" class="item">Favorite X-Men</a>
                        </div>
                    </div>
                    <div class="seven wide column">
                        <h4 class="ui inverted header">Footer Header</h4>
                        <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div id="lo-engage-ext-container">
        <div data-reactroot=""></div>
    </div>

</body>

</html>
