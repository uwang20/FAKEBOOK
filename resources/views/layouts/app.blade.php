<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .navbar{
          background-color: #3F5D9B;
          padding: 10px 0;
        }

        .photos{
            position: relative;
            margin-bottom: 10px;
        }

        .photos .cover-photo{
            height: 300px;
            width: 100%;
            background-color: pink;
        }

        .photos .profile-photo{
            position: absolute;
            left: 25px;
            bottom: 0;
            transform: translateY(50%);
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background-color: #000000;
        }

        .photos .profile-photo img{
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .main-details{
            height: 100px;
            width: 100%;
            /* background-color: gray; */
            margin-bottom: 50px;

            display: flex;
        }

        .main-details .left-space{
            flex: 1;
        }

        .main-details .right-space{
            flex: 4;
            /* background-color: red; */
        }

        .profile-feed{
            display: flex;
            /* background-color: yellow; */
        }

        .profile-feed .details{
            flex: 1;
        }

        .profile-feed .feed{
            flex: 2;
            /* background-color: orange; */
            margin-left: 10px;
        }

        .profile-feed .feed .post-container{
            width: 100%;
            padding: 10px;
            background-color: #E2E2E2;
        }

        /* .profile-feed .feed .post-container form{
            display: flex;
            flex-direction: column;
            padding: 0 20px;
        }

        .profile-feed .feed .post-container form textarea{
            height: 5.5rem;
            outline: none;
            border: none;
            resize: none;
            padding: 6px;
        }

        .profile-feed .feed .post-container form button{
            align-self: flex-end;
            margin-top: 10px;
        } */

        .exit-modal{
            position: absolute;
            top: 0;
            left: 0;
            margin-left: 10px;
            color: white;
            z-index: 5;
            text-decoration: none;
        }

        .exit-modal:hover{
            text-decoration: none;
            color: white;
        }

        .details-container{
          display: flex;
          justify-content: space-between;
          align-items: center;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    Fakebook
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item"><a href="/user/{{Auth::user()->id}}" class="nav-link" style="border-radius: 50%; background-image: url('/storage/{{Auth::user()->profileIcon()}}'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 40px; width: 40px;"></a></li>
                            <li class="nav-item"><a class="nav-link text-white font-bold" href="/user/{{Auth::user()->id}}"> {{ Auth::user()->first_name }}</a></li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/swiper.min.js') }}"></script>
    @yield('script')
</body>
</html>
