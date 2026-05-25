<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $userId = auth()->id();

        // Check if date filters were provided
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query for reuse
        $baseQuery = function() use ($userId, $startDate, $endDate) {
            $query = Transaction::where('transactions.user_id', $userId);
            if ($startDate) {
                $query->whereDate('transactions.date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('transactions.date', '<=', $endDate);
            }
            return $query;
        };

        // =====================
        // TOTAL KEUANGAN
        // =====================
        $totalIncome = (clone $baseQuery())
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = (clone $baseQuery())
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        // =====================
        // TRANSAKSI TERBARU
        // =====================
        $recentTransactions = (clone $baseQuery())
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

        $monthly = (clone $baseQuery())->selectRaw('
            YEAR(transactions.date) as year,
            MONTH(transactions.date) as month,
            SUM(CASE WHEN transactions.type="income" THEN transactions.amount ELSE 0 END) as income,
            SUM(CASE WHEN transactions.type="expense" THEN transactions.amount ELSE 0 END) as expense
        ')
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
        $categoriesQuery = (clone $baseQuery())->getQuery() // Get the base builder
            ->select(
                'categories.name',
                DB::raw('SUM(amount) as total')
            )
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'expense')
            ->groupBy('categories.name')
            ->orderByDesc('total');
            
        $categories = $categoriesQuery->get();

        $categoryLabels = $categories->pluck('name');
        $categoryData = $categories->pluck('total');

        // =====================
        // AI INSIGHT (Logic Based)
        // =====================
        $insight = "Belum ada cukup data untuk memberikan insight. Mari mulai mencatat transaksimu!";
        if ($totalIncome > 0 || $totalExpense > 0) {
            if ($totalExpense > $totalIncome) {
                $insight = "Perhatian: Pengeluaranmu melebihi pemasukan. Sebaiknya segera evaluasi pengeluaranmu bulan ini agar tidak defisit. ";
            } elseif ($totalIncome > 0 && $totalExpense > ($totalIncome * 0.8)) {
                $insight = "Hati-hati: Kamu sudah membelanjakan lebih dari 80% pemasukanmu. Tolong kurangi pengeluaran sekunder. ";
            } elseif ($totalIncome > 0 && $totalExpense <= ($totalIncome * 0.5)) {
                $insight = "Bagus sekali! Pengeluaranmu sangat terkendali. Ini adalah waktu yang tepat untuk mulai berinvestasi atau menambah tabungan. ";
            } else {
                $insight = "Kondisi keuanganmu cukup stabil. ";
            }
            
            if ($categories->isNotEmpty()) {
                $biggestExpense = $categories->first();
                $insight .= "Perlu dicatat, pengeluaran terbesarmu saat ini ada pada kategori '" . $biggestExpense->name . "' sebesar Rp " . number_format($biggestExpense->total, 0, ',', '.') . ". Coba cari cara untuk menghemat di kategori ini.";
            }
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
            'insight',
            'startDate',
            'endDate'
        ));
    }
}