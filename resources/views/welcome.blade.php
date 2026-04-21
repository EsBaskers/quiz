@guest
    <h1>Welcome to the Quiz App!</h1>
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
@endguest
@auth
    <h1>Welcome, {{auth()->user()->name}}!</h1>
    <a href="{{ route('quiz') }}">Go to the quiz</a>
    <a href="{{ route('logout') }}">Logout</a>
@endauth