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
        $request->merge(['amount' => $this->normalizeAmount($request->amount)]);

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

        $request->merge(['amount' => $this->normalizeAmount($request->amount)]);

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

    // =========================
    // EXPORT CSV
    // =========================
    public function exportCsv()
    {
        $userId = Auth::id();

        $transactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();

        $fileName = 'laporan-transaksi-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal', 'Bulan', 'Tahun', 'Judul', 'Kategori', 'Tipe', 'Nominal (Rp)', 'Deskripsi'];

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $t) {
                $row['Tanggal']  = date('Y-m-d', strtotime($t->date));
                $row['Bulan']    = date('m', strtotime($t->date));
                $row['Tahun']    = date('Y', strtotime($t->date));
                $row['Judul']    = $t->title;
                $row['Kategori'] = $t->category->name ?? '-';
                $row['Tipe']     = ucfirst($t->type);
                $row['Nominal']  = $t->amount;
                $row['Deskripsi'] = $t->description ?? '-';

                fputcsv($file, array($row['Tanggal'], $row['Bulan'], $row['Tahun'], $row['Judul'], $row['Kategori'], $row['Tipe'], $row['Nominal'], $row['Deskripsi']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Normalize formatted amount input so users can enter thousands separators.
     */
    private function normalizeAmount($amount)
    {
        if (is_numeric($amount)) {
            return $amount;
        }

        $sanitized = preg_replace('/[^\d\.,-]/u', '', trim($amount));

        if (strpos($sanitized, ',') !== false && strpos($sanitized, '.') !== false) {
            // Indonesian-style grouping: 1.234.567,89
            $sanitized = str_replace('.', '', $sanitized);
            $sanitized = str_replace(',', '.', $sanitized);
        } elseif (substr_count($sanitized, '.') > 1 && strpos($sanitized, ',') === false) {
            // Grouped with dots: 1.234.567
            $sanitized = str_replace('.', '', $sanitized);
        } elseif (substr_count($sanitized, ',') > 1 && strpos($sanitized, '.') === false) {
            // Grouped with commas: 1,234,567
            $sanitized = str_replace(',', '', $sanitized);
        } elseif (strpos($sanitized, ',') !== false) {
            // Decimal comma
            $sanitized = str_replace(',', '.', $sanitized);
        }

        return $sanitized;
    }
}