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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    {{-- tom tom CDN --}}
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps.css'>
    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps-web.min.js'></script>
    {{-- BRAINTREE cdn --}}
    <script src="https://js.braintreegateway.com/web/dropin/1.23.0/js/dropin.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand navbar-logo" href="{{ url('/') }}">
                    BoolBnb
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
                            {{-- Bottone dei messaggi, poi lo sposteremo nell'Header(?forse?) --}}
                            <div class="dropdown message-box">
                              @if($unreadMessages['exist'])
                              <div class="circle-notice">
                                <span class="number-notice">{{$unreadMessages['count']}}</span>
                              </div>
                              @endif
                              <button class="btn btn-messages dropdown-toggle" type="button" id="message-box-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-inbox"></i>
                              </button>
                              {{-- Dropdown dei messaggi, poi lo sposteremo nell'Header(?forse?) --}}
                              <div class="dropdown-menu" aria-labelledby="message-box-dropdown">
                                <ul class="list-group list-group-flush">
                                  @forelse($allMessages as $message)
                                  <li class="list-group-item {{$message['is_read'] !==0 ? '' : 'unread-message'}}">
                                    <a class="message-link"href="{{route('admin.messages.index', ['messageClicked'=>$message['id']])}}">
                                      <strong> {{$message['email']}}</strong>
                                      <p>{{$message['content']}}</p>
                                    </a>
                                  </li>
                                  @empty 
                                  <span>Non ci sono messaggi</span>
                                  @endforelse
                                </ul>
                              </div>
                             {{--  ------------fine dropdown-------------- --}}
                            </div>    

                            <li class="nav-item dropdown">
                            
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{route('admin.flats.index')}}" class="dropdown-item">Index</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
</body>
</html>
