@extends('layouts.dashboard')

@section('title', 'Tambah Transaksi')
@section('header', 'Tambah Transaksi')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-6">

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Nama Transaksi
            </label>
            <input type="text" name="title" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600">
        </div>

        <!-- Jumlah -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Jumlah (Rp)
            </label>
            <input type="number" name="amount" required min="1"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600">
        </div>

        <!-- Tipe -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Tipe
            </label>
            <select name="type"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600">
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>
        </div>

        <!-- KATEGORI (INI FIX ERROR KAMU) -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Kategori
            </label>
            <select name="category_id" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600">

                <option value="">-- Pilih Kategori --</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-between items-center">

            <a href="{{ route('transactions.index') }}"
               class="text-gray-500 hover:text-gray-700">
               Batal
            </a>

            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg shadow">
                Simpan Transaksi
            </button>

        </div>

    </form>
</div>

@endsection