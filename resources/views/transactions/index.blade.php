@extends('layouts.dashboard')

@section('title', 'Transaksi')
@section('header', 'Daftar Transaksi')

@section('content')

<!-- ===== HEADER + ACTION BUTTONS ===== -->
<div class="flex justify-between items-center mb-5 flex-wrap gap-3">

    <h2 class="text-lg font-semibold text-gray-700">
        Semua Transaksi
    </h2>

    <div class="flex gap-2">

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

<!-- ===== AI INSIGHT ===== -->
@if(isset($insight))
<div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200">
    <p class="text-sm text-green-800 font-medium">AI Insight</p>
    <p class="text-sm text-green-700">{{ $insight }}</p>
</div>
@endif

<!-- ===== TABLE ===== -->
<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-left">Tanggal</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-right">Jumlah</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">

        @forelse($transactions as $t)

            <tr class="hover:bg-gray-50 transition">

                <td class="p-4 text-gray-700">
                    {{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}
                </td>

                <td class="p-4">
                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                        {{ $t->category->name ?? '-' }}
                    </span>
                </td>

                <td class="p-4 font-medium text-gray-800">
                    {{ $t->title }}
                </td>

                <td class="p-4 text-right font-semibold
                    {{ $t->type == 'income' ? 'text-green-600' : 'text-red-600' }}">

                    {{ $t->type == 'income' ? '+' : '-' }}
                    Rp {{ number_format($t->amount, 0, ',', '.') }}
                </td>

                <!-- ===== ACTION ===== -->
                <td class="p-4 text-center space-x-3">

                    <!-- DETAIL BUTTON -->
                    <button
                        onclick="openModal(
                            '{{ $t->title }}',
                            '{{ $t->category->name ?? '-' }}',
                            '{{ $t->type }}',
                            '{{ number_format($t->amount, 0, ',', '.') }}',
                            '{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}'
                        )"
                        class="text-gray-700 hover:text-black font-medium">
                        Detail
                    </button>

                    <!-- EDIT -->
                    <a href="{{ route('transactions.edit', $t) }}"
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Edit
                    </a>

                    <!-- DELETE -->
                    <form action="{{ route('transactions.destroy', $t) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Yakin hapus transaksi ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="text-red-600 hover:text-red-800 font-medium">
                            Hapus
                        </button>
                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" class="text-center p-10 text-gray-500">
                    <div class="flex flex-col items-center gap-2">
                        <span class="text-lg">Belum ada transaksi</span>
                        <a href="{{ route('transactions.create') }}"
                           class="text-green-600 hover:underline">
                            + Tambah sekarang
                        </a>
                    </div>
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
</div>

<!-- =========================
     MODAL DETAIL TRANSAKSI
========================= -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-96 rounded-xl shadow-lg p-6 relative">

        <h2 class="text-lg font-bold mb-4">Detail Transaksi</h2>

        <div class="space-y-2 text-sm text-gray-700">

            <p><b>Nama:</b> <span id="m-title"></span></p>
            <p><b>Kategori:</b> <span id="m-category"></span></p>
            <p><b>Jenis:</b> <span id="m-type"></span></p>
            <p><b>Jumlah:</b> Rp <span id="m-amount"></span></p>
            <p><b>Tanggal:</b> <span id="m-date"></span></p>

        </div>

        <button onclick="closeModal()"
            class="absolute top-2 right-3 text-gray-500 hover:text-red-600 text-xl">
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
function openModal(title, category, type, amount, date) {
    document.getElementById('modal').classList.remove('hidden');

    document.getElementById('m-title').innerText = title;
    document.getElementById('m-category').innerText = category;
    document.getElementById('m-type').innerText = type;
    document.getElementById('m-amount').innerText = amount;
    document.getElementById('m-date').innerText = date;
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>

@endsection