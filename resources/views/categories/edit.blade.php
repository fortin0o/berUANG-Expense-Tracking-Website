@extends('layouts.dashboard')

@section('title', 'Edit Kategori')
@section('header', 'Ubah Kategori')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-6">
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Tipe</label>
            <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('categories.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-5 rounded-lg transition">Batal</a>
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-5 rounded-lg shadow transition">Update Kategori</button>
        </div>
    </form>
</div>
@endsection