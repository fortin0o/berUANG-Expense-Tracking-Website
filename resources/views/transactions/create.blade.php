@extends('layouts.dashboard')

@section('title', 'Tambah Transaksi')
@section('header', 'Tambah Transaksi')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-6">

    <!-- AI RECEIPT SCANNER -->
    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-blue-800">Scan Struk Otomatis ✨</h3>
            <p class="text-sm text-blue-600">Unggah foto struk, AI akan mengisi form untukmu!</p>
        </div>
        <div>
            <input type="file" id="receiptFile" accept="image/*" class="hidden">
            <button type="button" id="scanBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition-all" onclick="document.getElementById('receiptFile').click()">
                Unggah Struk 📸
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Nama Transaksi
            </label>
            <input type="text" name="title" value="{{ old('title') }}" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('title') border-red-400 @enderror">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Jumlah -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Jumlah (Rp)
            </label>
            <input type="number" name="amount" value="{{ old('amount') }}" required min="1"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('amount') border-red-400 @enderror">
            @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tanggal -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Tanggal
            </label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('date') border-red-400 @enderror">
            @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tipe -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Tipe
            </label>
            <select name="type" id="type-select"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600">
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Kategori (filtered by type) -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Kategori
            </label>
            <select name="category_id" id="category-select" required
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 @error('category_id') border-red-400 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        data-type="{{ $category->type }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="2" maxlength="500"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 resize-none @error('description') border-red-400 @enderror"
                placeholder="Catatan tambahan...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- BUTTON -->
        <div class="flex justify-between items-center">

            <a href="{{ route('transactions.index') }}"
               class="text-gray-500 hover:text-gray-700">
               Batal
            </a>

            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg shadow">
                Simpan Transaksi
            </button>

        </div>

    </form>
</div>

<script>
// Filter categories based on selected type
function filterCategories() {
    const type = document.getElementById('type-select').value;
    const options = document.querySelectorAll('#category-select option');
    let hasVisible = false;

    options.forEach(opt => {
        if (!opt.value) return; // keep placeholder
        if (opt.dataset.type === type) {
            opt.style.display = '';
            hasVisible = true;
        } else {
            opt.style.display = 'none';
            if (opt.selected) {
                opt.selected = false;
                document.getElementById('category-select').value = '';
            }
        }
    });
}

document.getElementById('type-select').addEventListener('change', filterCategories);

// Run on load to set initial state
filterCategories();

// AI Receipt Scanner
document.getElementById('receiptFile').addEventListener('change', async function() {
    if (!this.files.length) return;
    
    const file = this.files[0];
    const btn = document.getElementById('scanBtn');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = 'Menganalisis... ⏳';
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');
    
    const formData = new FormData();
    formData.append('receipt', file);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    
    try {
        const response = await fetch('{{ route("transactions.analyze.receipt") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Gagal menganalisis struk');
        }
        
        // Populate form
        if (data.title) document.querySelector('input[name="title"]').value = data.title;
        if (data.amount) document.querySelector('input[name="amount"]').value = data.amount;
        if (data.date) document.querySelector('input[name="date"]').value = data.date;
        if (data.description) document.querySelector('textarea[name="description"]').value = data.description;
        
        // Always set type to expense for receipts
        document.getElementById('type-select').value = 'expense';
        filterCategories(); // refresh available categories
        
        // Try to find matching category
        if (data.category_name) {
            const select = document.getElementById('category-select');
            const options = Array.from(select.options);
            const keyword = data.category_name.toLowerCase();
            
            // simple substring match
            const match = options.find(opt => {
                if (!opt.value) return false;
                const optText = opt.text.toLowerCase();
                return optText.includes(keyword) || keyword.includes(optText);
            });
            
            if (match && match.dataset.type === 'expense') {
                select.value = match.value;
            }
        }
        
        alert('✨ Struk berhasil dianalisis! Silakan periksa kembali data di bawah.');
        
    } catch (error) {
        alert('Error: ' + error.message);
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
        btn.classList.remove('opacity-70', 'cursor-not-allowed');
        this.value = ''; // Reset input
    }
});
</script>

@endsection