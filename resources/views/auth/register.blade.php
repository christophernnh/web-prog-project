@extends('layouts.app')

@section('content')
    <div class="h-full w-full flex justify-center items-center">
        <div class=" min-h-[400px] w-[90%] xl:w-[35%] flex flex-col justify-content-start items-center bg-whiteDarker shadow-lg rounded-xl pb-12 pt-8 px-10 md:px-20">
            <div class=" text-center text-[24px] mb-8 font-bold">{{ __('Register') }} a user</div>

            <div class="w-full h-full flex flex-col justify-start items-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="w-full md:w-[90%] flex flex-col justify-start items-center">
                    @csrf

                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label class="mb-2 text-[18px]" for="username">{{ __('Username') }}</label>
                        <input id="username" type="text"
                            class="form-control @error('username') is-invalid @enderror h-10 rounded-md shadow-md w-full" name="username"
                            value="{{ old('username') }}" required autocomplete="username" autofocus>
                    </div>

                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label class="mb-2 text-[18px]" for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                            class=" form-control @error('email') is-invalid @enderror h-10 rounded-md shadow-md w-full" name="email"
                            value="{{ old('email') }}" required autocomplete="email">
                    </div>

                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label class="mb-2 text-[18px]" for="password">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class=" form-control @error('password') is-invalid @enderror h-10 rounded-md shadow-md w-full" name="password"
                            required autocomplete="new-password">
                    </div>

                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label class="mb-2 text-[18px]" for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class=" form-control h-10 rounded-md shadow-md w-full"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="mt-8 w-full form-group mb-4 flex flex-col justify-center items-center">
                        <button type="submit" class="bg-cyan w-32 h-12 rounded-md shadow-md font-bold text-[18px] text-white hover:bg-cyanHover transition-colors duration-[400]">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection
