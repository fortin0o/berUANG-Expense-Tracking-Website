@extends('layouts.app')

@section('header', 'Edit Profile')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow">

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- FOTO -->
        <div class="text-center mb-6">
            <img 
                src="{{ $user->profile_photo 
                    ? asset('storage/' . $user->profile_photo) 
                    : 'https://via.placeholder.com/100' }}"
                class="w-24 h-24 rounded-full mx-auto mb-3 object-cover"
            >

            <input type="file" name="photo" class="text-sm">
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}"
                class="w-full border rounded-lg px-4 py-2">
        </div>

        <!-- EMAIL -->
        <div class="mb-6">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                class="w-full border rounded-lg px-4 py-2">
        </div>

    <div class="flex items-center justify-end gap-3 mt-8">

    <!-- Simpan -->
    <button type="submit"
        class="px-6 py-2 rounded-lg font-semibold
               bg-[#4F772D] hover:bg-[#3f6123] text-white
               shadow-md hover:shadow-lg
               transition duration-200">
        Simpan Perubahan
    </button>
    </div>
    </form>
    
    <div class="flex items-center justify-end gap-3 mt-4">
    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="px-5 py-2 rounded-lg text-sm font-medium
                   bg-red-500 hover:bg-red-600 text-white
                   transition duration-200">
            Logout
        </button>
    </form>

</div>
</div>
@endsection