<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .income {
            color: green;
        }

        .expense {
            color: red;
        }

        .insight {
            margin-top: 20px;
            padding: 10px;
            background: #f3f3f3;
        }
    </style>
</head>
<body>

<h2>LAPORAN KEUANGAN</h2>

<div class="summary">
    <p><b>Total Pemasukan:</b> Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    <p><b>Total Pengeluaran:</b> Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    <p><b>Saldo:</b> Rp {{ number_format($balance, 0, ',', '.') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Jumlah</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $t)
        <tr>
            <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
            <td>{{ $t->title }}</td>
            <td>{{ $t->category->name ?? '-' }}</td>
            <td class="{{ $t->type }}">
                {{ ucfirst($t->type) }}
            </td>
            <td>
                Rp {{ number_format($t->amount, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="insight">
    <h3>AI Insight</h3>
    <p>{{ $insight }}</p>
</div>

</body>
</html>