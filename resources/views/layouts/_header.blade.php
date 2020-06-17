<nav class="navbar navbar-expand-lg navbar-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            命紙
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">基本性格</li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- 登錄註冊鏈接開始 -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登錄</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">註冊</a></li>
                @else
                <li class="nav-item">
                    <a class="nav-link mt-1" href="#"><i class="我的命盤"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="" class="img-responsive img-circle" width="30px" height="30px">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="logout" href="#"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出登錄</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                @endguest
                <!-- 登錄註冊鏈接結束 -->
            </ul>
        </div>
    </div>
</nav>