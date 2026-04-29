<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>berUANG - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #4F772D;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: #4F772D;
            width: 240px;
            height: 100vh;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-wrapper {
            width: 80px;
            height: 80px;
            margin-bottom: 40px;
        }

        .logo-inner {
            width: 100%;
            height: 100%;
            background: url('{{ asset("images/berUANG-removebg-preview.png") }}') center/contain no-repeat;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 0 0 6px white;
        }

        .sidebar-menu {
            width: 100%;
        }

        .menu-item {
            width: 100%;
            height: 55px;
            background: #FFFFFF;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: 15px;
            color: #000;
            cursor: pointer;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .menu-item:hover {
            background: #C5E389;
            transform: translateX(4px);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            background: #FFFFFF;
            border-radius: 40px 0 0 40px;
            box-shadow: -10px 10px 4px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            padding: 30px 40px;
        }

        /* Scrollbar */
        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                padding: 20px 10px;
            }

            .logo-wrapper {
                width: 50px;
                height: 50px;
            }

            .menu-item {
                font-size: 10px;
                height: 50px;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="flex">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <div class="logo-wrapper">
            <div class="logo-inner"></div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item" onclick="location.href='{{ route('dashboard') }}'">
                Dashboard
            </div>

            <div class="menu-item" onclick="location.href='{{ route('transactions.index') }}'">
                Transactions
            </div>

            <div class="menu-item" onclick="location.href='{{ route('categories.index') }}'">
                Category
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">@yield('header')</h1>

            <!-- PROFILE DROPDOWN (HOVER) -->
            <div class="relative group">
                <div class="flex items-center gap-2 cursor-pointer">
                    <img 
                        src="{{ auth()->user()->profile_photo 
                            ? asset('storage/' . auth()->user()->profile_photo) 
                            : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}" 
                        class="w-9 h-9 rounded-full object-cover border">

                    <span class="text-gray-700 font-medium">
                        {{ auth()->user()->name }}
                    </span>
                </div>

                <!-- DROPDOWN -->
                <div class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg py-2 
                            opacity-0 invisible 
                            group-hover:opacity-100 group-hover:visible 
                            transition-all duration-200 z-50">

                    <a href="{{ route('profile.edit') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">
                        Edit Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ALERT -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- CONTENT -->
        @yield('content')

    </div>

    @stack('scripts')

</body>
</html>