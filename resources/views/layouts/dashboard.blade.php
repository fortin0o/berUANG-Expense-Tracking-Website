<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>berUANG - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Dark Mode Initializer -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #4F772D;
            height: 100vh;
            overflow: hidden;
        }

        .dark body {
            background: #111827;
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

        .dark .sidebar {
            background: #1f2937; /* Tailwind gray-800 */
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

        .dark .menu-item {
            background: #374151; /* gray-700 */
            color: #f3f4f6;
        }

        .menu-item:hover {
            background: #C5E389;
            transform: translateX(4px);
        }

        .dark .menu-item:hover {
            background: #4F772D;
            color: white;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            background: #FFFFFF;
            border-radius: 40px 0 0 40px;
            box-shadow: -10px 10px 4px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            padding: 30px 40px;
            transition: background-color 0.3s;
        }

        .dark .main-content {
            background: #111827;
            color: #f3f4f6;
        }

        /* Scrollbar */
        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .dark .main-content::-webkit-scrollbar-thumb {
            background: #4b5563;
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
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">@yield('header')</h1>

            <div class="flex items-center gap-4">
                <!-- DARK MODE TOGGLE -->
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                <!-- PROFILE DROPDOWN (HOVER) -->
                <div class="relative group">
                    <div class="flex items-center gap-2 cursor-pointer">
                        <img 
                            src="{{ auth()->user()->profile_photo 
                                ? asset('storage/' . auth()->user()->profile_photo) 
                                : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}" 
                            class="w-9 h-9 rounded-full object-cover border dark:border-gray-600">

                        <span class="text-gray-700 dark:text-gray-200 font-medium">
                            {{ auth()->user()->name }}
                        </span>
                    </div>

                    <!-- DROPDOWN -->
                    <div class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 
                                opacity-0 invisible 
                                group-hover:opacity-100 group-hover:visible 
                                transition-all duration-200 z-50">

                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700">
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700">
                                Logout
                            </button>
                        </form>
                    </div>
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

    <!-- Theme Toggle Script -->
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            } else {
                // if NOT set via local storage previously
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        });
    </script>
    
    @stack('scripts')

</body>
</html>