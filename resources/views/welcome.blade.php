<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kat-WO</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 24px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                  神戸学園都市吹奏楽団<br>
                    出欠登録
                </div>


                @if (Auth::guard('user')->user())
                  <div class="links m-b-md">
                    <a href="{{ url('/home') }}">団員専用のHomeへ</a>
                  </div>
                  <div class="links m-b-md">
                      <a href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          管理者モードで利用するには一旦ログアウトしてください
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  </div>
                @elseif (Auth::guard('admin')->user())
                  <div class="links m-b-md">
                    <a href="{{ url('/admin/home') }}">管理者のホームへ</a>
                  </div>
                  <div class="links m-b-md">
                    <a href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('admin-logout-form').submit();">
                        団員モードで利用するには一旦ログアウトしてください
                    </a>
                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </div>
                @else
                  <div class="links m-b-md">
                    <a href="{{ url('/login') }}">団員ログイン</a>
                  </div>
                  <div class="links m-b-md">
                    <a href="{{ url('/admin/login') }}">管理者ログイン</a>
                  </div>
                  <div class="links m-b-md">
                    <a href="https://kat-wind.com/">神戸学園都市吹奏楽団</a>
                  </div>
                @endif

            </div>
        </div>
    </body>
</html>
