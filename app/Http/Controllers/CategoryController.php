<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories()->orderBy('type')->orderBy('name')->get();
        $incomeCategories = $categories->where('type', 'income');
        $expenseCategories = $categories->where('type', 'expense');
        
        return view('categories.index', compact('categories', 'incomeCategories', 'expenseCategories'));
    }
    
    public function create()
    {
        return view('categories.create');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        auth()->user()->categories()->create([
            'name' => $request->name,
            'type' => $request->type
        ]);
        
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function edit(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $category->update([
            'name' => $request->name,
            'type' => $request->type
        ]);
        
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate');
    }
    
    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if category has transactions
        if ($category->transactions()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki transaksi. Hapus transaksi terlebih dahulu.');
        }
        
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}