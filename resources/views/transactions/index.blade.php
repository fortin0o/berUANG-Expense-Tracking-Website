@extends('layouts.dashboard')

@section('title', 'Transaksi')
@section('header', 'Daftar Transaksi')

@section('content')

<!-- ===== HEADER + ACTION BUTTONS ===== -->
<div class="flex justify-between items-center mb-5 flex-wrap gap-3">

    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
        Semua Transaksi
    </h2>

    <div class="flex gap-2">

        <!-- EXPORT CSV -->
        <a href="{{ route('transactions.export.csv') }}"
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg shadow transition">
            Export CSV
        </a>

        <!-- EXPORT PDF -->
        <a href="{{ route('transactions.export.pdf') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow transition">
            Export PDF
        </a>

        <!-- TAMBAH -->
        <a href="{{ route('transactions.create') }}"
           class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-lg shadow transition">
            + Tambah
        </a>

    </div>
</div>

<!-- ===== FLASH MESSAGES ===== -->
@if(session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg">
        {{ session('error') }}
    </div>
@endif

<!-- ===== SEARCH & FILTER BAR ===== -->
<form method="GET" action="{{ route('transactions.index') }}"
      class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-5 flex flex-wrap gap-3 items-end">

    <!-- Search -->
    <div class="flex-1 min-w-[160px]">
        <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Cari</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Nama transaksi..."
               class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500">
    </div>

    <!-- Type Filter -->
    <div class="min-w-[130px]">
        <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tipe</label>
        <select name="type" class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500">
            <option value="">Semua</option>
            <option value="income"  {{ request('type') == 'income'  ? 'selected' : '' }}>Pemasukan</option>
            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
        </select>
    </div>

    <!-- Category Filter -->
    <div class="min-w-[150px]">
        <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kategori</label>
        <select name="category_id" class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Date From -->
    <div class="min-w-[140px]">
        <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Dari Tanggal</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500">
    </div>

    <!-- Date To -->
    <div class="min-w-[140px]">
        <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Sampai Tanggal</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-600 dark:focus:ring-green-500">
    </div>

    <!-- Buttons -->
    <div class="flex gap-2">
        <button type="submit"
            class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm shadow transition">
            Filter
        </button>
        <a href="{{ route('transactions.index') }}"
           class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg text-sm transition">
            Reset
        </a>
    </div>

</form>

<!-- ===== TABLE ===== -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs">
            <tr>
                <th class="p-4 text-left">Tanggal</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Deskripsi</th>
                <th class="p-4 text-right">Jumlah</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

        @forelse($transactions as $t)

            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                <td class="p-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}
                </td>

                <td class="p-4">
                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded text-xs">
                        {{ $t->category->name ?? '-' }}
                    </span>
                </td>

                <td class="p-4 font-medium text-gray-800 dark:text-gray-200">
                    {{ $t->title }}
                </td>

                <td class="p-4 text-gray-500 dark:text-gray-400 text-xs max-w-[200px] truncate">
                    {{ $t->description ?? '-' }}
                </td>

                <td class="p-4 text-right font-semibold
                    {{ $t->type == 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">

                    {{ $t->type == 'income' ? '+' : '-' }}
                    Rp {{ number_format($t->amount, 0, ',', '.') }}
                </td>

                <!-- ===== ACTION ===== -->
                <td class="p-4 text-center space-x-3 whitespace-nowrap">

                    <!-- DETAIL BUTTON -->
                    <button
                        onclick="openModal(
                            '{{ addslashes($t->title) }}',
                            '{{ addslashes($t->category->name ?? '-') }}',
                            '{{ $t->type }}',
                            '{{ number_format($t->amount, 0, ',', '.') }}',
                            '{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}',
                            '{{ addslashes($t->description ?? '') }}'
                        )"
                        class="text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white font-medium">
                        Detail
                    </button>

                    <!-- EDIT -->
                    <a href="{{ route('transactions.edit', $t) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                        Edit
                    </a>

                    <!-- DELETE -->
                    <form action="{{ route('transactions.destroy', $t) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Yakin hapus transaksi ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">
                            Hapus
                        </button>
                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6" class="text-center p-10 text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center gap-2">
                        <span class="text-lg">Belum ada transaksi</span>
                        <a href="{{ route('transactions.create') }}"
                           class="text-green-600 dark:text-green-400 hover:underline">
                            + Tambah sekarang
                        </a>
                    </div>
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
</div>

<!-- ===== PAGINATION ===== -->
@if($transactions->hasPages())
<div class="mt-4">
    {{ $transactions->links() }}
</div>
@endif

<!-- =========================
     MODAL DETAIL TRANSAKSI
========================= -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-800 w-96 rounded-xl shadow-lg p-6 relative">

        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Detail Transaksi</h2>

        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">

            <p><b>Nama:</b> <span id="m-title"></span></p>
            <p><b>Kategori:</b> <span id="m-category"></span></p>
            <p><b>Jenis:</b> <span id="m-type"></span></p>
            <p><b>Jumlah:</b> Rp <span id="m-amount"></span></p>
            <p><b>Tanggal:</b> <span id="m-date"></span></p>
            <p><b>Deskripsi:</b> <span id="m-desc" class="text-gray-500 dark:text-gray-400">-</span></p>

        </div>

        <button onclick="closeModal()"
            class="absolute top-2 right-3 text-gray-500 hover:text-red-600 dark:hover:text-red-400 text-xl">
            &times;
        </button>

        <button onclick="closeModal()"
            class="mt-5 w-full bg-green-700 hover:bg-green-800 text-white py-2 rounded-lg">
            Tutup
        </button>

    </div>

</div>

<!-- =========================
     SCRIPT MODAL
========================= -->
<script>
function openModal(title, category, type, amount, date, desc) {
    document.getElementById('modal').classList.remove('hidden');

    document.getElementById('m-title').innerText    = title;
    document.getElementById('m-category').innerText = category;
    document.getElementById('m-type').innerText     = type === 'income' ? 'Pemasukan' : 'Pengeluaran';
    document.getElementById('m-amount').innerText   = amount;
    document.getElementById('m-date').innerText     = date;
    document.getElementById('m-desc').innerText     = desc || '-';
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

// Close modal on backdrop click
document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

@endsection