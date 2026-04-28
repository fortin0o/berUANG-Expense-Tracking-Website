@extends('layouts.app')

@section('title', 'Kategori')

@section('header', 'Manajemen Kategori')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        + Tambah Kategori
    </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <!-- Income Categories -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-lg mb-4 text-green-600">Kategori Pemasukan</h3>
        <div class="space-y-2">
            @forelse($incomeCategories as $cat)
            <div class="flex justify-between items-center p-3 border rounded-lg">
                <span>{{ $cat->name }}</span>
                <div>
                    <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada kategori pemasukan</p>
            @endforelse
        </div>
    </div>
    
    <!-- Expense Categories -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-lg mb-4 text-red-600">Kategori Pengeluaran</h3>
        <div class="space-y-2">
            @forelse($expenseCategories as $cat)
            <div class="flex justify-between items-center p-3 border rounded-lg">
                <span>{{ $cat->name }}</span>
                <div>
                    <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada kategori pengeluaran</p>
            @endforelse
        </div>
    </div>
</div>
@endsection