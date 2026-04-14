<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    // Dashboard + daftar transaksi
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->latest()->get();

        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    // Form tambah transaksi
    public function create()
    {
        return view('transactions.create');
    }

    // Simpan transaksi
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:income,expense',
        ]);

        Auth::user()->transactions()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang sedang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('dashboard')->with('success', 'Transaksi dihapus.');
    }
}