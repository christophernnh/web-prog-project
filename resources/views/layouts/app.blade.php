<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div id="app">
        <nav class="absolute w-full h-24 bg-white border-b-[1px] px-10 md:px-16 py-6 flex flex-row justify-between font-afacad">
            <a href="/dashboard" class="w-50% text-[24px]">WasteNot</a>


            @auth
                <div class="w-1/2 flex flex-col items-end justify-center text-[20px]">
                    <div class="text-nowrap text-black">
                        Welcome back, {{ Auth::user()->username }}
                    </div>
                    <h1 class="text-cyan font-bold underline hover:text-cyanHover transition-colors ease-in duration-[500]">
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

        <main class="bg-lightBlue pt-32 px-10 md:px-16 min-h-screen font-afacad pb-20 scroll-smooth">
            @yield('content')
        </main>
    </div>
</body>

</html>
