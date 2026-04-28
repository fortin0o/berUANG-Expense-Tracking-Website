<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Total income and expense
        $totalIncome = Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount') ?? 0;
        $totalExpense = Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount') ?? 0;
        $balance = $totalIncome - $totalExpense;
        
        // Recent transactions (untuk ditampilkan di dashboard)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
        
        return view('dashboard', compact(
            'totalIncome',
            'totalExpense', 
            'balance',
            'recentTransactions'
        ));
    }
}