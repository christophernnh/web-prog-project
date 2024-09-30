<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app">
        <nav class="absolute w-full bg-stone-300 px-10 py-10 flex flex-row justify-between">
            Waste Not
            @auth
                <div>
                    <h1 class="">
                        Welcome back, {{ Auth::user()->username }}
                    </h1>
                    <h1 class="font-bold underline">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </h1>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                @if (!Auth::user()->is_admin)

                @endif
            @endauth
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
