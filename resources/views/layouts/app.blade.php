<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>berUANG - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #4F772D;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            background: #4F772D;
            width: 240px;
            height: 100%;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-inner {
            width: 80px;
            height: 80px;
            background: url('{{ asset("images/berUANG-removebg-preview.png") }}') center/contain no-repeat;
            background-color: white;
            border-radius: 50%;
        }

        .menu-item {
            width: 100%;
            height: 55px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .main-content {
            flex: 1;
            background: white;
            border-radius: 40px 0 0 40px;
            padding: 30px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="flex">

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo-inner mb-10"></div>

    <div class="w-full">
        <div class="menu-item" onclick="location.href='{{ route('dashboard') }}'">Dashboard</div>
        <div class="menu-item" onclick="location.href='{{ route('transactions.index') }}'">Transactions</div>
        <div class="menu-item" onclick="location.href='{{ route('categories.index') }}'">Category</div>

    </div>

</div>

<!-- CONTENT -->
<div class="main-content">

    <!-- TOP RIGHT PROFILE -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">@yield('header')</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2">

                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                         class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                @endif

                <span>{{ auth()->user()->name }}</span>
            </a>
        </div>
    </div>

    @yield('content')

</div>

</body>
</html>