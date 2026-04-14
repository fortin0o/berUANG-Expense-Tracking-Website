@extends('layouts.app')

@section('header', 'Dashboard Keuangan')

@section('content')
<div class="py-4">
    <!-- 3 Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-500 text-sm">Total Saldo</div>
            <div class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-500 text-sm">Total Pemasukan</div>
            <div class="text-2xl font-bold text-green-600">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-500 text-sm">Total Pengeluaran</div>
            <div class="text-2xl font-bold text-red-600">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Tombol Tambah Transaksi -->
    <div class="mb-4 flex justify-end">
        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Transaksi
        </a>
    </div>

    <!-- Daftar Transaksi -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4">{{ $transaction->title }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($transaction->type == 'income')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pemasukan</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi. Tambahkan sekarang!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection