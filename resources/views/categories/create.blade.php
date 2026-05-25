@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')
@section('header', 'Buat Kategori Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required autofocus>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Tipe</label>
            <select name="type" class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('categories.index') }}" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-semibold py-2 px-5 rounded-lg transition">Batal</a>
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-5 rounded-lg shadow transition">Simpan Kategori</button>
        </div>
    </form>
</div>
@endsection