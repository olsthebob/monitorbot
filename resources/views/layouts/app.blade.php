<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link type="text/css" href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
   <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>Monitor</strong>Bot
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
                        <li class="nav-item">
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        </li>
                    @else
                        <li class="nav-item dropdown right mr-0">
                            <a class="nav-link dropdown-toggle pr-0" id="dropdown_user_account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="avatar avatar-sm bg-light mr-1">OB</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_user_account">
                                <h6 class="dropdown-header">User menu</h6>
                                <a class="dropdown-item" href="#">
                                    <span class="float-right badge badge-primary">4</span>
                                    <i class="fas fa-envelope text-primary"></i>Messages
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog text-primary"></i>Settings
                                </a>
                                <div class="dropdown-divider" role="presentation"></div>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-sign-out-alt text-primary"></i>Sign out
                                </a>
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

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- FontAwesome 5 -->
<script src="{{ asset('vendor/fontawesome/js/fontawesome-all.min.js') }}" defer></script>

<!-- Theme JS -->
<script src="{{ asset('js/theme.js') }}"></script>

<script>
    $(function(){
        $("#selectSite").change(function(){
            alert($(this).val());
        });
    });
</script>
</body>
</html>
