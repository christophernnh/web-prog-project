@extends('layouts.app')

@section('content')
    <div class="container pt-32">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">{{ __('Register') }}</div>

                    <div class="card-body">
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

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="username">{{ __('Username') }}</label>
                                <input id="username" type="text"
                                    class="outline form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="outline form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="outline form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="outline form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
