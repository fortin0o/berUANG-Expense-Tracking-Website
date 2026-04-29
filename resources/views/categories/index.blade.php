@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori')
@section('header', 'Kategori')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('categories.create') }}" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition">
        + Tambah Kategori
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Kategori Pemasukan -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-green-100 px-6 py-4 border-b border-green-200">
            <h3 class="text-lg font-semibold text-green-800">Kategori Pemasukan</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($incomeCategories as $cat)
            <div class="flex justify-between items-center px-6 py-4 hover:bg-gray-50 transition">
                <span class="text-gray-800 font-medium">{{ $cat->name }}</span>
                <div class="flex gap-3">
                    <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500">Belum ada kategori pemasukan. <a href="{{ route('categories.create') }}" class="text-green-600">Buat sekarang</a></div>
            @endforelse
        </div>
    </div>

    <!-- Kategori Pengeluaran -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-red-100 px-6 py-4 border-b border-red-200">
            <h3 class="text-lg font-semibold text-red-800"> Kategori Pengeluaran</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($expenseCategories as $cat)
            <div class="flex justify-between items-center px-6 py-4 hover:bg-gray-50 transition">
                <span class="text-gray-800 font-medium">{{ $cat->name }}</span>
                <div class="flex gap-3">
                    <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500">Belum ada kategori pengeluaran. <a href="{{ route('categories.create') }}" class="text-green-600">Buat sekarang</a></div>
            @endforelse
        </div>
    </div>
</div>
@endsection