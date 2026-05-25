@extends('layouts.dashboard')

@section('title', 'Dashboard Keuangan')
@section('header', 'Ringkasan Finansial')

@section('content')

<!-- ===== DATE RANGE FILTER ===== -->
<div class="mb-6 p-4 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-between">
    <div>
        <h3 class="font-semibold text-gray-700">Filter Tanggal</h3>
    </div>
    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-3">
        <input type="date" name="start_date" value="{{ $startDate }}" class="text-sm border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
        <span class="text-gray-500">-</span>
        <input type="date" name="end_date" value="{{ $endDate }}" class="text-sm border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm rounded-md transition duration-150">Terapkan</button>
        @if($startDate || $endDate)
            <a href="{{ route('dashboard') }}" class="text-xs text-gray-500 hover:text-gray-700 underline">Reset</a>
        @endif
    </form>
</div>

<!-- ===== AI INSIGHT ===== -->
<div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-50 to-green-100 border border-green-200">
    <h3 class="font-semibold text-green-800 mb-1">AI Financial Insight</h3>
    <p class="text-sm text-green-700">{{ $insight }}</p>
</div>

<!-- ===== CARDS ===== -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="rounded-xl shadow-lg p-6 text-white"
         style="background: linear-gradient(135deg, #4F772D, #2a4a1a);">
        <div class="text-sm opacity-90">Total Saldo</div>
        <div class="text-3xl font-bold mt-2">
            Rp {{ number_format($balance, 0, ',', '.') }}
        </div>
    </div>

    <div class="rounded-xl shadow-lg p-6 text-white"
         style="background: linear-gradient(135deg, #2b5e2b, #1e3a1e);">
        <div class="text-sm opacity-90">Pemasukan</div>
        <div class="text-3xl font-bold mt-2">
            Rp {{ number_format($totalIncome, 0, ',', '.') }}
        </div>
    </div>

    <div class="rounded-xl shadow-lg p-6 text-white"
         style="background: linear-gradient(135deg, #8b4513, #5c2e0e);">
        <div class="text-sm opacity-90">Pengeluaran</div>
        <div class="text-3xl font-bold mt-2">
            Rp {{ number_format($totalExpense, 0, ',', '.') }}
        </div>
    </div>

</div>

<!-- ===== CHARTS ===== -->
<div class="grid md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold mb-4">Grafik Bulanan</h2>
        <canvas id="financeChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold mb-4">Kategori Pengeluaran</h2>
        <canvas id="categoryChart"></canvas>
    </div>

</div>

<!-- ===== TABLE ===== -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-xs uppercase">
            <tr>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Kategori</th>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-right">Jumlah</th>
            </tr>
        </thead>

        <tbody>
        @forelse($recentTransactions as $t)
            <tr class="border-t">
                <td class="p-3">{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                <td class="p-3">{{ $t->category->name ?? '-' }}</td>
                <td class="p-3">{{ $t->title }}</td>

                <td class="p-3 text-right font-semibold
                    {{ $t->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $t->type == 'income' ? '+' : '-' }}
                    Rp {{ number_format($t->amount, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center p-6 text-gray-500">
                    Belum ada transaksi
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<!-- ===== CHART JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('financeChart'), {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Income',
                data: @json($incomeData),
                backgroundColor: '#4F772D'
            },
            {
                label: 'Expense',
                data: @json($expenseData),
                backgroundColor: '#b91c1c'
            }
        ]
    }
});

new Chart(document.getElementById('categoryChart'), {
    type: 'pie',
    data: {
        labels: @json($categoryLabels),
        datasets: [{
            data: @json($categoryData),
            backgroundColor: [
                '#4F772D', '#84cc16', '#22c55e',
                '#eab308', '#f97316', '#ef4444', '#3b82f6'
            ]
        }]
    }
});
</script>

@endsection