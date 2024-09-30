@extends('layouts.app')

@section('content')
    <div class="mx-10 pt-48">
        @auth
            @if (!Auth::user()->is_admin)
                <a href="/additem" class="block w-fit px-4 py-4 border-[0.1px] border-black mb-4 cursor-pointer">
                    Register food item
                </a>

                <h1>Donated Food List</h1>
                <div class="h-full w-full flex flex-col">
                    @if ($fooditems->isEmpty())
                        <p>No food items available.</p>
                    @else
                        @foreach ($fooditems as $fooditem)
                            <div class="border rounded-lg shadow-lg p-4 mb-4">
                                <h2 class="text-lg font-bold">{{ $fooditem->name }}</h2>
                                <p><strong>Amount:</strong> {{ $fooditem->amount }}</p>
                                <p><strong>Description:</strong> {{ $fooditem->description }}</p>
                                <p><strong>Type:</strong> {{ $fooditem->itemType->name ?? 'N/A' }}</p>
                                <p><strong>Status:</strong> {{ $fooditem->statusType->name }}</p>
                                <p><strong>Registered By:</strong> {{ $fooditem->user->username }}</p>
                                <p><strong>Registered at:</strong> {{ $fooditem->created_at }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            @elseif(Auth::user()->is_admin == true)
                <div class="h-full w-full flex flex-row">
                    <div class="w-1/2 flex flex-col bg-stone-100">
                        <h2 class="pl-4 pt-4">User List</h2>
                        @if ($users->isEmpty())
                            <div class="ml-4">No users yet.</div>
                        @else
                            @foreach ($users as $user)
                                @if (!$user->is_admin)
                                    <a href="{{ route('user.fooditems', ['id' => $user->id]) }}"
                                        class="block p-4 border-[0.1px] border-black cursor-pointer">
                                        <h2 class="text-lg font-bold">{{ $user->username }}</h2>
                                        <p class="text-md">{{ $user->email }}</p>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div class="w-1/2 bg-stone-200">
                        @isset($fooditems)
                            <h2 class="pl-4 pt-4">Donated Food List for: {{ $user->username }}</h2>
                            @if ($fooditems->isEmpty())
                                <div class="pl-4">No food items for this user.</div>
                            @else
                                @foreach ($fooditems as $fooditem)
                                    <div class="border-[0.1px] border-black p-4">
                                        <a href="{{ route('fooditem.details', ['id' => $fooditem->id]) }}" class="block">
                                            <h2 class="text-lg font-bold">{{ $fooditem->name }}</h2>
                                            <p><strong>Amount:</strong> {{ $fooditem->amount }}</p>
                                            <p><strong>Type:</strong> {{ $fooditem->itemType->name ?? 'N/A' }}</p>
                                            <p><strong>Status:</strong> {{ $fooditem->statusType->name }}</p>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        @endisset
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection
