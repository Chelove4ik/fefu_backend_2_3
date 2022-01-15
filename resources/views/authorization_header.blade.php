<header>
    @if(Auth::check())
        <div>
            <a href="{{ route('profile') }}">Профиль</a>
            <a href="{{ route('logout') }}">Выход</a>
        </div>
    @else
        <div>
            <a href="{{ route('registration') }}">Регистрация</a>
            <a href="{{ route('login') }}">Вход</a>
        </div>
    @endif
</header>
