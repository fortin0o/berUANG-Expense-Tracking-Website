@extends('layouts.dashboard')

@section('title', 'Edit Transaksi')
@section('header', 'Edit Transaksi')

@section('content')

<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow">

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Nama Transaksi</label>
            <input type="text" name="title"
                   value="{{ old('title', $transaction->title) }}" required
                   class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 @error('title') border-red-400 @enderror">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Amount -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Jumlah (Rp)</label>
            <input type="text" inputmode="decimal" pattern="[0-9.,]*" name="amount"
                   value="{{ old('amount', $transaction->amount) }}" required min="1"
                   class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 @error('amount') border-red-400 @enderror"
                   placeholder="100000000">
            @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tanggal -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Tanggal</label>
            <input type="date" name="date"
                   value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required
                   class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 @error('date') border-red-400 @enderror">
            @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Type -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Tipe</label>
            <select name="type" id="type-select"
                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500">
                <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>
                    Pemasukan
                </option>
                <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>
                    Pengeluaran
                </option>
            </select>
            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Kategori</label>
            <select name="category_id" id="category-select" required
                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 @error('category_id') border-red-400 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        data-type="{{ $c->type }}"
                        {{ old('category_id', $transaction->category_id) == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">
                Deskripsi <span class="text-gray-400 dark:text-gray-500 font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="2" maxlength="500"
                class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500 resize-none @error('description') border-red-400 @enderror"
                placeholder="Catatan tambahan...">{{ old('description', $transaction->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- BUTTON -->
        <div class="flex justify-between items-center">

            <a href="{{ route('transactions.index') }}"
               class="text-gray-500 hover:underline dark:text-gray-400 dark:hover:text-gray-200">
                Batal
            </a>

            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-lg shadow">
                Simpan Perubahan
            </button>

        </div>

    </form>
</div>

<script>
function filterCategories() {
    const type = document.getElementById('type-select').value;
    const select = document.getElementById('category-select');
    const options = select.querySelectorAll('option');

    options.forEach(opt => {
        if (!opt.value) return;
        if (opt.dataset.type === type) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
            if (opt.selected) {
                opt.selected = false;
                select.value = '';
            }
        }
    });
}

document.getElementById('type-select').addEventListener('change', filterCategories);
filterCategories();
</script>

@endsection