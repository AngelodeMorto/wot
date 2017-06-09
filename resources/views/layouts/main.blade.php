<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    @section('includes_css')
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
    @show
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">STAT<i class="fa fa-info" aria-hidden="true"></i>ST</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">


                @section('menu')

                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('WGauth-form').submit();"> WG auth </a></li>
                    <form style="display: none" id="WGauth-form" class="form-horizontal" action="https://api.worldoftanks.ru/wot/auth/login/?application_id=df13c5fa140af811b023333b08201ab5&redirect_uri={{ config('app.url', 'localhost') }}/analiz" method="post" name="form1">

                    </form>
                    <li class="active"><a href="#">menu1</a></li>
                    <li><a href="#">menu2</a></li>
                    <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-cog fa-spin"></i>
                            {{--<span class="sr-only">Loading...</span>--}}</a>
                    </li>

                    {{-- АВТОРИЗАЦИЯ --}}

                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{-- АВТОРИЗАЦИЯ --}}

                @show


            </ul>
        </div>
    </div>
</div>

{{--CONTENET--}}
<div class="container" id="main">
    <div class="{{--flex-center--}}row{{-- full-height--}}">


        <div class="col-lg-3 col-sm-3">

            @section('sidebar')
                <div class="sidebar-block">
                    <h2 class="flex-center">Last</h2>
                    <p>name: text</p>
                    <p>name: text</p>
                    <p><a href="/admin">Adminka</a></p>
                </div>
                <div class="sidebar-block">
                    <h2 class="flex-center">More</h2>
                    <p>name: text</p>
                    <p>name: text</p>
                    <p>name: text</p>
                </div>
            @show

        </div>


        <div class="col-lg-9 col-sm-9{{--col-lg-offset-2--}}">

            @yield('content')

        </div>


    </div>
</div>
</body>

@section('includes_js')
    <script src="{{asset('js/jquery-3.2.0.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
@show
</html>
