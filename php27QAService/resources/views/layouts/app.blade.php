<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ЧаВо</title>
<!--     <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ URL::asset('js/app.js') }}"></script> -->
    <link href="../../../public/css/app.css" rel="stylesheet" type="text/css">
    <script src="../../../public/js/app.js"></script>

</head>
<body>
    <h1>Типичный сервис вопросов и ответов ... :)</h1>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                  <a class="navbar-brand" href="{{ url('/') }}">Вопросы</a>
                  @if (Auth::check())
                    <a class="navbar-brand" href="{{ route('topic.index') }}">Темы вопросов</a>
                    <a class="navbar-brand" href="{{ route('user.index') }}">Админы</a>
                    <a class="navbar-brand" href="{{ url('/home') }}">Home</a>
                  @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Войти в IT</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Exit
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">

        @yield('content')

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
