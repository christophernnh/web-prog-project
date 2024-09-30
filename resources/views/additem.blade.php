@extends('layouts.app')

@section('content')
    <div class="mx-10 pt-48">
        <a href="/dashboard" class="block w-fit px-4 py-4 border-[0.1px] border-black mb-4 cursor-pointer">
            Back to dashboard
        </a>
        <h1 class="text-2xl mb-5">Add New Food Item</h1>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Display Success Message --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ url('/additem') }}" method="POST">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="border-[0.1px] border-black mt-1 block w-full"
                    value="{{ old('name') }}" required>
            </div>

            {{-- Amount --}}
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="text" name="amount" id="amount" class="border-[0.1px] border-black mt-1 block w-full"
                    value="{{ old('amount') }}" required>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="border-[0.1px] border-black mt-1 block w-full" required>{{ old('description') }}</textarea>
            </div>

            {{-- Food Item Type (Spinner) --}}
            <div class="mb-4">
                <label for="item_type_id" class="block text-sm font-medium text-gray-700">Item Type</label>
                <select name="item_type_id" id="item_type_id" class="mt-1 block w-full border-[0.1px] border-black"
                    required>
                    <option value="" disabled selected>Select Item Type</option>
                    @foreach ($fooditemtypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Submit Button --}}
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Item
                </button>
            </div>
        </form>
    </div>
@endsection
