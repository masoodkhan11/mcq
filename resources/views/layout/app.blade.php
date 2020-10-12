<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    <title>@yield('title') - {{ config('app.name') }}</title>

    <style>
      .top-right {
        text-align: right;
      }

      .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="wrapper mt-3">
        @if (Route::has('login'))
          <div class="top-right links">
            @auth
              <a href="{{ route('home') }}">Home</a>
              <a href="javascript:void(0)" onclick="$('#logout-form').submit();">Logout</a>
              <form action="{{ route('logout') }}" method="post" id="logout-form">
                @csrf
              </form>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
              <a href="{{ route('register') }}">Register</a>
            @endif
              @endauth
          </div>
        @endif
        <div class="content">
          @yield('content')
        </div>
      </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>