<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link active" href="{{route('main-page')}}">Главная страница</a>

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                   id="navbarDropdownCategories"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    Категории
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
                    <a class="dropdown-item" href="{{ route('categories') }}">Все категории</a>
                    @if(isset($menu))
                        @foreach($menu as $category)
                            <a class="dropdown-item" href="{{route('category', [$category['alias']])}}">{{ $category['name'] }}</a>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <div class="navbar-nav ml-auto position-relative">
            @guest
                <a class="nav-link" href="{{ route('login') }}">
                    Войти
                </a>
                @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">
                        Регистрация
                    </a>
                @endif
            @else
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Профиль
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('articles.index') }}">Статьи</a>
                    <a class="dropdown-item" href="{{ route('categories.index') }}">Категории</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endguest

        </div>

    </div>
</nav>
