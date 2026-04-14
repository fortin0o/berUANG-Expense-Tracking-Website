@extends('layouts.app')

@section('header', 'Tambah Transaksi')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-6">
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Nama Transaksi</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Jumlah (Rp)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="1"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipe</label>
            <select name="type" id="type" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan (Income)</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran (Expense)</option>
            </select>
            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Transaksi
            </button>
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
        </div>
    </form>
</div>
@endsection