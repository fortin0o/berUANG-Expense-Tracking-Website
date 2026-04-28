<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>berUANG - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 text-white flex flex-col">
            <div class="p-5 font-bold text-xl border-b border-indigo-700">berUANG</div>
            <nav class="flex-1 mt-5">
                <a href="{{ route('dashboard') }}" class="block py-2.5 px-5 hover:bg-indigo-700">
                    📊 Dashboard
                </a>
                <a href="{{ route('transactions.index') }}" class="block py-2.5 px-5 hover:bg-indigo-700">
                    💰 Transaksi
                </a>
                <a href="{{ route('categories.index') }}" class="block py-2.5 px-5 hover:bg-indigo-700">
                    🏷️ Kategori
                </a>
            </nav>
            <div class="p-5 border-t border-indigo-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-white hover:text-gray-200">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="bg-white shadow-md p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-semibold">@yield('header')</h1>
                    <div class="text-gray-600">{{ auth()->user()->name }}</div>
                </div>
            </div>
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>