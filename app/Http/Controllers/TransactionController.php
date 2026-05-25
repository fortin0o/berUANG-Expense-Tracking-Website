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
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id())->with('category');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by type
        if ($request->filled('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $transactions = $query->latest('date')->paginate(15)->withQueryString();

        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();

        return view('transactions.index', compact('transactions', 'categories'));
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
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1|max:1000000000',
            'type'        => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        Transaction::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'amount'      => $request->amount,
            'type'        => $request->type,
            'category_id' => $request->category_id,
            'date'        => $request->date,
            'description' => $request->description,
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
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1|max:1000000000',
            'type'        => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $transaction->update([
            'title'       => $request->title,
            'amount'      => $request->amount,
            'type'        => $request->type,
            'category_id' => $request->category_id,
            'date'        => $request->date,
            'description' => $request->description,
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
            ->latest('date')
            ->get();

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $insight = "Insight functionality has been disabled.";

        $pdf = Pdf::loadView('pdf.transactions', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'insight'
        ));

        return $pdf->download('laporan-transaksi.pdf');
    }
}