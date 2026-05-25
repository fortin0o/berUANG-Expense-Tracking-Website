@extends('layouts.dashboard')

@section('title', 'Tambah Transaksi')
@section('header', 'Tambah Transaksi')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-6">

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Nama Transaksi
            </label>
            <input type="text" name="title" value="{{ old('title') }}" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('title') border-red-400 @enderror">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Jumlah -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Jumlah (Rp)
            </label>
            <input type="number" name="amount" value="{{ old('amount') }}" required min="1"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('amount') border-red-400 @enderror">
            @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tanggal -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Tanggal
            </label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('date') border-red-400 @enderror">
            @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tipe -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Tipe
            </label>
            <select name="type" id="type-select"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600">
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Kategori (filtered by type) -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Kategori
            </label>
            <select name="category_id" id="category-select" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('category_id') border-red-400 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        data-type="{{ $category->type }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="2" maxlength="500"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 resize-none @error('description') border-red-400 @enderror"
                placeholder="Catatan tambahan...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

<script>
// Filter categories based on selected type
function filterCategories() {
    const type = document.getElementById('type-select').value;
    const options = document.querySelectorAll('#category-select option');
    let hasVisible = false;

    options.forEach(opt => {
        if (!opt.value) return; // keep placeholder
        if (opt.dataset.type === type) {
            opt.style.display = '';
            hasVisible = true;
        } else {
            opt.style.display = 'none';
            if (opt.selected) {
                opt.selected = false;
                document.getElementById('category-select').value = '';
            }
        }
    });
}

document.getElementById('type-select').addEventListener('change', filterCategories);

// Run on load to set initial state
filterCategories();
</script>

@endsection