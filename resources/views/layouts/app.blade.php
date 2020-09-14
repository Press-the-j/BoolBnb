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
        <nav class="navbar navbar-expand-md navbar-light bg-white fixed-top">
            <div class="container">
                <a class="navbar-brand navbar-logo" href="{{ url('/') }}">
                    BoolBnb
                </a>
                <div class="d-flex">
                  @auth
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
                  @endauth
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-navbar dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i><img src="{{asset('img/default.jpeg')}}" alt="">
                    </button>
                    <div class="dropdown-menu cta-dropdown-header" aria-labelledby="dropdownMenuButton">
                      @guest
                      <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if(Route::has("register"))
                        <a class="dropdown-item" href="{{route("register")}}">{{__("Register")}}</a>
                        @endif
                      @else
                      <a class="dropdown-item" href="{{route("admin.home")}}" >Profilo</a>
                      <a class="dropdown-item" href="{{route("admin.flats.index")}}" >Tutti i tuoi appartamenti</a>
                      <a class="dropdown-item" href="{{route("admin.messages.index", ["messageClicked"=>1])}}">Tutti i messaggi</a>
                      <hr>
                      {{-- logout form --}}
                      <a class="dropdown-item " href="{{ route('logout') }}"                                 onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                      <span class="btn btn-danger btn-logout">{{ __('Logout') }}</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                      @endguest
                    </div>
                  </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
