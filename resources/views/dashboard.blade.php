@extends('layouts.app')

@section('content')
    <div class="h-full">
        @auth
            @if (!Auth::user()->is_admin)
                <a href="/additem" class="font-medium text-[18px] h-12 w-fit px-4 flex items-center  mb-4 cursor-pointer rounded-md  bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                    Register food item
                </a>
                @php
                        $currentUserId = auth()->id();
                        $userFoodItems = $fooditems->where('user_id', $currentUserId);
                        $foodTypeAmounts = $userFoodItems->groupBy('itemType.name')
                            ->map(function ($items) {
                                return $items->sum('amount');
                            });
                        $totalAmount = $foodTypeAmounts->sum();
                        $foodTypePercentages = $foodTypeAmounts->map(function ($amount) use ($totalAmount) {
                            return $totalAmount > 0 ? ($amount / $totalAmount) * 100 : 0;
                        });
                        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
                    @endphp

                <div class="container mx-auto px-4">
                    <h1 class="text-2xl font-bold mb-4">Your Donated Food Percentage List</h1>

                    <div class="rounded-lg mb-4">
                        @if($foodTypePercentages->isEmpty())
                            <p class="text-gray-600">You haven't made any donations yet.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($foodTypePercentages as $type => $percentage)
                                    <div class="bg-white p-3 rounded-lg shadow">
                                        <h3 class="font-bold">{{ $type }}</h3>
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ number_format($percentage, 1) }}%</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Amount: {{ $foodTypeAmounts[$type] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>


                    <div class="container mx-auto">
                        <h1 class="text-2xl font-bold mb-4">Your Donated Food Percentage Chart</h1>

                        <div class="py-5 bg-white rounded-lg shadow mb-4">
                            @if($foodTypePercentages->isEmpty())
                                <p class="text-gray-600">You haven't made any donations yet.</p>
                            @else
                                <div class="flex flex-wrap items-center">
                                    <div class="w-full md:w-1/2 mb-4 md:mb-0">
                                        <div class="w-64 h-64 mx-auto">
                                            @include('php-blade-pie-chart', ['foodTypePercentages' => $foodTypePercentages])
                                        </div>
                                    </div>
                                    <div class="w-full md:w-1/2">
                                        <ul class="space-y-2">
                                            @foreach($foodTypePercentages as $type => $percentage)
                                                <li class="flex items-center">
                                                    <span class="w-4 h-4 mr-2 inline-block" style="background-color: {{ $colors[$loop->index % count($colors)] }}"></span>
                                                    <span class="font-medium">{{ $type }}:</span>
                                                    <span class="ml-2">{{ number_format($percentage, 1) }}% ({{ $foodTypeAmounts[$type] }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <h2 class="text-2xl font-bold mb-4">Donated Food List Details</h2>
                        <form action="{{ route('notify.pickup') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse ($fooditems as $fooditem)
                                    <div class="border rounded-lg shadow-lg p-4 bg-white">
                                        <h2 class="text-lg font-bold">{{ $fooditem->name }}</h2>
                                        <p><strong>Amount:</strong> {{ $fooditem->amount }}</p>
                                        <p><strong>Description:</strong> {{ $fooditem->description }}</p>
                                        <p><strong>Type:</strong> {{ $fooditem->itemType->name ?? 'N/A' }}</p>
                                        <p><strong>Status:</strong> {{ $fooditem->statusType->name }}</p>
                                        <p><strong>Registered By:</strong> {{ $fooditem->user->username }}</p>
                                        <p><strong>Registered at:</strong> {{ $fooditem->created_at->format('Y-m-d H:i:s') }}</p>

                                        @if($fooditem->status_type_id == 1)
                                            <div>
                                                <input type="checkbox" name="food_ids[]" value="{{ $fooditem->id }}">
                                                <label for="food_{{ $fooditem->id }}">Select for Pickup</label>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="col-span-full text-center text-gray-500">No food items available.</p>
                                @endforelse
                            </div>
                            <button type="submit" class="font-medium text-[18px] mt-2 h-12 w-fit px-4 flex items-center  mb-4 cursor-pointer rounded-md  bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                                Notify Pickup
                            </button>
                        </form>
                </div>
                </div>

    {{-- PAGE ADMIN DARI SINI!! --}}

            @elseif(Auth::user()->is_admin == true)
                <div class="flex space-x-4">
                    <a href="/register" class="font-medium text-[18px] h-12 w-fit px-4 flex items-center cursor-pointer rounded-md bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                        Register User
                    </a>
                    <a href="{{ route('admin.pickups') }}" id="openPickupModal" class="font-medium text-[18px] h-12 w-fit px-4 flex items-center cursor-pointer rounded-md bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                        View PickUp Notifications
                    </a>
                </div>

                <div id="pickupModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 justify-center items-center hidden z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                        <h2 class="text-xl font-bold mb-4">Pick-Up Notifications</h2>
                        <div id="notifList" class="mb-4">

                        </div>
                        <div class="flex justify-end space-x-4">
                            <button id="closeModal" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Close</button>
                            <form method="POST" action="{{ route('admin.confirm.pickup') }}">
                                @csrf
                                <input type="hidden" name="food_ids" id="selectedFoodIds">
                                <button type="submit" class="px-4 py-2 bg-cyan text-white rounded-md hover:bg-cyanHover">
                                    Confirm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class=" pt-3 w-full flex flex-col md:flex-row gap-y-8 md:gap-y-0 md:gap-x-8 ">
                    <div class="pb-8 min-h-[270px] w-full md:w-1/2 flex flex-col bg-white shadow-md rounded-2xl px-6">
                        <div class="w-full h-[65px] border-b-[1px] border-black  py-[12px] flex flex-row justify-between items-center">
                            <div class="text-[20px] font-bold">User List</div>
                            <form action="{{ route('dashboard.search') }}" method="GET" class="w-1/2 h-full relative">
                                <input
                                    name="username"
                                    class="w-full bg-whiteDarker h-full rounded-xl shadow-sm px-4"
                                    type="text"
                                    placeholder="search"
                                    value="{{ request('username') }}"
                                />
                                <span class="absolute top-2 right-2 material-symbols-outlined">manage_search</span>
                            </form>

                        </div>

                        <div class="pt-4 flex flex-col items-center justify-start gap-y-2">
                            @if (request('username'))
                                @if ($searchedUsers->isEmpty())
                                <div>No users found.</div>
                                @else
                                    @foreach ($searchedUsers as $user)
                                        @if (!$user->is_admin)
                                            <a href="{{ route('user.fooditems', ['id' => $user->id]) }}"
                                                class="cursor-pointer w-full md:h-[70px] rounded-xl border-[0.1px] border-black bg-whiteDarker px-4 py-2 hover:shadow-md">
                                                <div class="relative flex flex-row justify-between items-center w-full h-full">
                                                    <div class="">
                                                        <h2 class="text-lg font-medium ">{{ $user->username }}</h2>
                                                        <p class="text-md font-normal">{{ $user->email }}</p>
                                                    </div>
                                                    <span class="material-symbols-outlined h-[20px]">
                                                        arrow_forward_ios
                                                    </span>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                @foreach ($users as $user)
                                    @if (!$user->is_admin)
                                        <a href="{{ route('user.fooditems', ['id' => $user->id]) }}"
                                        class="cursor-pointer w-full md:h-[70px] rounded-xl border-[0.1px] border-black bg-whiteDarker px-4 py-2 hover:shadow-md">
                                        <div class="relative flex flex-row justify-between items-center w-full h-full">
                                            <div class="">
                                                <h2 class="text-lg font-medium ">{{ $user->username }}</h2>
                                                <p class="text-md font-normal">{{ $user->email }}</p>
                                            </div>
                                            <span class="material-symbols-outlined h-[20px]">
                                            arrow_forward_ios
                                            </span>
                                        </div>

                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="pb-8 min-h-[270px] w-full md:w-1/2 flex flex-col bg-white shadow-md rounded-2xl px-6">

                        @isset($clickeduser)
                                <div class="w-full h-[65px] border-b-[1px] border-black  py-[12px] flex flex-row justify-between items-center">
                                    <div class="text-[20px] font-bold">Donated Food List for: {{ $clickeduser->username }}</div>
                                </div>
                                @if ($fooditems->isEmpty())
                                        <div class="">No food items for this user.</div>
                                    @else
                                        <div class="w-full h-full flex flex-col justify-start items-center gap-y-2 pt-4">
                                            @foreach ($fooditems as $fooditem)

                                                <a href="{{ route('fooditem.edit', ['id' => $fooditem->id]) }}" class="cursor-pointer w-full  rounded-xl border-[0.1px] border-black bg-whiteDarker px-4 py-2 hover:shadow-md">
                                                    <h2 class="text-lg font-bold">{{ $fooditem->name }}</h2>
                                                    <p><strong>Amount:</strong> {{ $fooditem->amount }}</p>
                                                    <p><strong>Status:</strong> {{ $fooditem->statusType->name }}</p>
                                                    <p>Click to edit</p>
                                                </a>
                                            @endforeach
                                        </div>

                                    @endif

                        @else
                            <div class="w-full h-[65px] border-b-[1px] border-black  py-[12px] flex flex-row justify-between items-center">
                                    <div class="text-[20px] font-bold">Empty</div>
                                </div>
                        @endisset

                    </div>
                </div>

            @endif
        @endauth
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded and parsed');

    const modal = document.getElementById('pickupModal');
    const openModalBtn = document.getElementById('openPickupModal');
    const closeModalBtn = document.getElementById('closeModal');
    const notifList = document.getElementById('notifList');
    const confirmForm = document.querySelector('form[action="{{ route('admin.confirm.pickup') }}"]');
    const selectedFoodIdsInput = document.getElementById('selectedFoodIds');

    openModalBtn.addEventListener('click', (e) => {
    console.log('Open modal button clicked');
    e.preventDefault();

    // Show the modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // Fetch pick-up data via AJAX
    fetch('{{ route('admin.pickups') }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(foods => {
        // Populate the notification list
        notifList.innerHTML = foods.length > 0
            ? foods.map(food => `
                <div class="flex justify-between items-center border-b py-2">
                    <div>
                        <span class="block font-semibold">${food.name}</span>
                        <span class="block text-sm text-gray-500">
                            Registered by: ${food.user ? food.user.username : 'Unknown'}
                        </span>
                    </div>
                    <input type="checkbox" value="${food.id}" class="food-checkbox">
                </div>
              `).join('')
            : '<p class="text-gray-500">No pick-up notifications available.</p>';
    })
    .catch(error => {
        console.error('Error fetching pick-up notifications:', error);

        // Display an error message in the modal
        notifList.innerHTML = `
            <p class="text-red-500">
                Failed to load notifications. Please try again later.
            </p>`;
    });
});



    closeModalBtn.addEventListener('click', () => {
        console.log('Close modal button clicked');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    confirmForm.addEventListener('submit', (e) => {
        const selectedIds = Array.from(document.querySelectorAll('.food-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one item to confirm.');
        } else {
            selectedFoodIdsInput.value = selectedIds.join(',');
        }
    });
});
    </script>
@endsection
