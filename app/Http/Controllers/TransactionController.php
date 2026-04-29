<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // =========================
    // LIST TRANSAKSI
    // =========================
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('categories'));
    }

    // =========================
    // STORE TRANSAKSI
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1|max:1000000000',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->amount > 1000000000) {
            return back()->with('error', 'Jumlah terlalu besar!')->withInput();
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'date' => now(),
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    // =========================
    // UPDATE TRANSAKSI
    // =========================
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1|max:1000000000',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
        ]);

        $transaction->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus');
    }

    // =========================
    // EXPORT PDF + AI INSIGHT
    // =========================
    public function exportPdf()
    {
        $userId = Auth::id();

        $transactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->get();

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $insight = $this->generateInsight($balance, $totalIncome, $totalExpense);

        $pdf = Pdf::loadView('pdf.transactions', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'insight'
        ));

        return $pdf->download('laporan-transaksi.pdf');
    }

    // =========================
    // AI INSIGHT ENGINE
    // =========================
    private function generateInsight($balance, $income, $expense)
    {
        if ($balance < 0) {
            return "⚠️ Defisit: pengeluaran lebih besar dari pemasukan.";
        }

        if ($expense > $income * 0.8) {
            return "⚠️ Kamu terlalu boros (lebih dari 80% income).";
        }

        if ($balance < 50000) {
            return "💡 Saldo hampir habis, kurangi pengeluaran.";
        }

        return "✅ Keuangan stabil. Pertahankan pola ini.";
    }
}