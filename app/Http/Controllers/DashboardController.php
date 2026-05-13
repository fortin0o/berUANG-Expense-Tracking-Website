<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // =====================
        // TOTAL KEUANGAN
        // =====================
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        // =====================
        // TRANSAKSI TERBARU
        // =====================
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->limit(10)
            ->get();

        // =====================
        // BAR CHART (BULANAN)
        // =====================
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $monthly = Transaction::selectRaw('
            YEAR(date) as year,
            MONTH(date) as month,
            SUM(CASE WHEN type="income" THEN amount ELSE 0 END) as income,
            SUM(CASE WHEN type="expense" THEN amount ELSE 0 END) as expense
        ')
        ->where('user_id', $userId)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        $labels = $monthly->map(fn($m) => $monthNames[$m->month] . ' ' . $m->year);
        $incomeData = $monthly->pluck('income');
        $expenseData = $monthly->pluck('expense');


        // =====================
        // PIE CHART (KATEGORI)
        // =====================
        $categories = Transaction::select(
                'categories.name',
                DB::raw('SUM(amount) as total')
            )
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $userId)
            ->where('transactions.type', 'expense')
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        $categoryLabels = $categories->pluck('name');
        $categoryData = $categories->pluck('total');

        // =====================
        // 🧠 AI INSIGHT ENGINE (FIXED PRIORITY LOGIC)
        // =====================

        $insight = "💡 Keuangan kamu masih stabil, lanjutkan pola ini.";

        // 1. PRIORITAS TERBURUK: DEFISIT
        if ($balance < 0) {
            $insight = "🚨 DEFISIT! Pengeluaran lebih besar dari pemasukan. Segera kurangi pengeluaran.";
        }

        // 2. SALDO SANGAT RENDAH
        elseif ($balance > 0 && $balance < 50000) {
            $insight = "⚠️ Saldo kamu hampir habis. Hati-hati dalam pengeluaran.";
        }

        // 3. BOROS (>70%)
        elseif ($totalIncome > 0 && $totalExpense > $totalIncome * 0.7) {
            $insight = "💸 Kamu sudah menghabiskan lebih dari 70% pemasukan. Waspada boros!";
        }

        // 4. KATEGORI TERBESAR
        elseif ($categories->count() > 0) {
            $top = $categories->first();

            $insight = "🔥 Pengeluaran terbesar kamu ada di kategori "
                . $top->name
                . " (Rp " . number_format($top->total, 0, ',', '.') . ")";
        }

        // =====================
        // RETURN VIEW
        // =====================
        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'recentTransactions',
            'labels',
            'incomeData',
            'expenseData',
            'categoryLabels',
            'categoryData',
            'insight'
        ));
    }
}