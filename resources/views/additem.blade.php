@extends('layouts.app')

@section('content')
    <div class="h-full w-full flex justify-center items-center relative">
        <a href="/dashboard" class="hidden lg:flex absolute top-0 left-0 font-medium text-[18px] h-12 w-fit px-4  items-center  mb-4 cursor-pointer rounded-md  bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
            Back to dashboard
        </a>
        <div class=" min-h-[400px] w-[90%] xl:w-[35%] flex flex-col justify-content-start items-center bg-whiteDarker shadow-lg rounded-xl pb-12 pt-8 px-10 md:px-20">
            <div class="w-full h-full flex flex-col justify-start items-center relative">

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

                <form action="{{ url('/additem') }}" method="POST" class="w-full md:w-[90%] flex flex-col justify-start items-center">
                    @csrf

                    {{-- Name --}}
                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label for="name" class="mb-2 text-[18px]">Name</label>
                        <input type="text" name="name" id="name" class="h-10 rounded-md shadow-md w-full"
                            value="{{ old('name') }}" required>
                    </div>

                    {{-- Amount --}}
                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label for="amount" class="mb-2 text-[18px]">Amount</label>
                        <input type="text" name="amount" id="amount" class="h-10 rounded-md shadow-md w-full"
                            value="{{ old('amount') }}" required>
                    </div>

                    {{-- Description --}}
                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label for="description" class="mb-2 text-[18px]">Description</label>
                        <textarea name="description" id="description" class="h-10 rounded-md shadow-md w-full" required>{{ old('description') }}</textarea>
                    </div>

                    {{-- Food Item Type (Spinner) --}}
                    <div class="w-full form-group mb-4 flex flex-col justify-start items-start">
                        <label for="item_type_id" class="mb-2 text-[18px]">Item Type</label>
                        <select name="item_type_id" id="item_type_id" class="px-3 h-10 rounded-md shadow-md w-full"
                            required>
                            <option value="" disabled selected>Select Item Type</option>
                            @foreach ($fooditemtypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <div class="mb-4 mt-8">
                        <button type="submit" class="shadow-md bg-blue-500 hover:bg-blue-700 text-white font-medium text-[18px] py-2 px-4 rounded w-32">
                            Add Item
                        </button>
                    </div>
                    <a href="/dashboard" class="flex lg:hidden font-medium text-[18px] w-32 py-2 px-4 justify-center items-center  mb-4 cursor-pointer rounded-md  bg-cyan hover:bg-cyanHover transition-colors ease-in duration-[500] shadow-md text-white">
                        Back
                    </a>
                </form>
            </div>


        </div>
    </div>
@endsection
