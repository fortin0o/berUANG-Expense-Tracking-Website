@extends('layouts.dashboard')

@section('title', 'Edit Transaksi')
@section('header', 'Edit Transaksi')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nama Transaksi</label>
            <input type="text" name="title"
                   value="{{ old('title', $transaction->title) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <!-- Amount -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Jumlah</label>
            <input type="number" name="amount"
                   value="{{ old('amount', $transaction->amount) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <!-- Type -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tipe</label>
            <select name="type"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>
                    Income
                </option>
                <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>
                    Expense
                </option>
            </select>
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="category_id"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        {{ $transaction->category_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-between items-center">

            <a href="{{ route('transactions.index') }}"
               class="text-gray-500 hover:underline">
                Batal
            </a>

            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-lg shadow">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection