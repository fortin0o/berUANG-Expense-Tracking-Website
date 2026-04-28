@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('header', 'Tambah Kategori Baru')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-md mx-auto">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   required>
            @error('name') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tipe</label>
            <select name="type" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            @error('type') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('categories.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>
        </div>
    </form>
</div>
@endsection