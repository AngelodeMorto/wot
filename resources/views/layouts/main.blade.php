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

                    @if(Auth::user() && Auth::user()->role == "admin")
                        <li><a href="/admin">Adminka</a></li>
                    @endif

                    <li class="@if(\Illuminate\Support\Facades\Request::is('analiz*')) active @endif"><a href="#" onclick="event.preventDefault(); document.getElementById('WGauth-form').submit();"><i class="fa fa-eye" aria-hidden="true"></i> WG авторизация </a></li>
                    <form style="display: none" id="WGauth-form" class="form-horizontal" action="https://api.worldoftanks.ru/wot/auth/login/?application_id=df13c5fa140af811b023333b08201ab5&redirect_uri={{ config('app.url', 'localhost') }}/analiz" method="post" name="form1">

                    </form>

                    {{-- АВТОРИЗАЦИЯ --}}

                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}"><i class="fa fa-user" aria-hidden="true"></i> Login</a></li>
                        <li><a href="{{ route('register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
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
                <h2>Last</h2>

                @foreach($last_articles as $article)
                    <div class="sidebar-block">
                        <h2 class="flex-center">{{ $article->title }}</h2>
                        <p><img src="img/{{ $article->image }}" class="img-thumbnail"></p>
                        <p>{!! $article->description !!}</p>
                    </div>
                @endforeach
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
