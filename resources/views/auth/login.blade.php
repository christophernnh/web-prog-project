<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-[100dvh] bg-lightBlue flex items-center justify-center">
        <div class="flex flex-col py-8 px-6 bg-white w-80 md:w-[350px] h-auto rounded-xl shadow-xl">
            <!-- Title -->
            <h1 class="text-2xl font-bold mb-4">Sign In</h1>

            <!-- Check for Session Error Message -->
            @if (session('error'))
                <div class="bg-red-200 text-red-600 p-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-200 text-red-600 p-2 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="">
                @csrf
                <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="mb-2 px-3 py-2 w-full  rounded-lg shadow-md outline-none"
                    placeholder="Enter your email" required>

                <label for="password" class="block mb-2 text-sm font-medium">Password</label>
                <input type="password" name="password"
                    class="mb-4 px-3 py-2 w-full  rounded-lg shadow-md outline-none"
                    placeholder="Enter your password" required>

                <div class="flex items-center mb-4">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-sm">Remember me</label>
                </div>

                <button class="bg-black text-white px-2 py-2 w-full hover:bg-zinc-700 transition-all duration-300 ease-out">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</body>

</html>
