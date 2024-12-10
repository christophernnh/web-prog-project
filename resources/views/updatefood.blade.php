@extends('layouts.app')

@section('content')
    <div>
        <h1 class="text-2xl font-bold">Update Food Item</h1>

        <form action="{{ route('fooditem.update', $fooditem->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="my-4">
                <label for="name" class="block font-semibold">Name:</label>
                <input type="text" id="name" name="name" value="{{ $fooditem->name }}" class="block w-full border border-gray-300 px-3 py-2" disabled>
            </div>

            <div class="my-4">
                <label for="amount" class="block font-semibold">Amount:</label>
                <input type="text" id="amount" name="amount" value="{{ $fooditem->amount }}" class="block w-full border border-gray-300 px-3 py-2" disabled>
            </div>

            <div class="my-4">
                <label for="description" class="block font-semibold">Description:</label>
                <textarea id="description" name="description" class="block w-full border border-gray-300 px-3 py-2" disabled>{{ $fooditem->description }}</textarea>
            </div>

            <div class="my-4">
                <label for="status" class="block font-semibold">Status:</label>
                <select id="status" name="status_type_id" class="block w-full border border-gray-300 px-3 py-2">
                    @foreach($status_types as $status)
                        <option value="{{ $status->id }}" {{ $fooditem->status_type_id == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update Status</button>
            </div>
        </form>
    </div>
@endsection
