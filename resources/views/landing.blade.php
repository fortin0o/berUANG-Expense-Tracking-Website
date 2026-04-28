<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>berUANG - Kelola Keuanganmu dengan Mudah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .dashboard-preview {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-outline {
            border: 2px solid #667eea;
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">B</span>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">berUANG</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-purple-600 transition font-medium">Beranda</a>
                    <a href="#tentang" class="text-gray-700 hover:text-purple-600 transition font-medium">Tentang Kami</a>
                    <a href="#testimoni" class="text-gray-700 hover:text-purple-600 transition font-medium">Testimoni</a>
                    <a href="#fitur" class="text-gray-700 hover:text-purple-600 transition font-medium">Fitur</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 btn-primary text-white rounded-lg font-semibold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-purple-600 font-semibold hover:text-purple-700 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2 btn-primary text-white rounded-lg font-semibold">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Beranda) -->
    <section id="beranda" class="pt-32 pb-20 px-6">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <!-- Left Content -->
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <div class="inline-block px-4 py-2 bg-purple-100 rounded-full mb-6">
                        <span class="text-purple-600 font-semibold text-sm">✨ Solusi Keuangan Terbaik</span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Sering Bingung
                        <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">UANG</span>
                        <br>Habis ke Mana?
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Solusi praktis untuk lacak setiap pengeluaran, lihat laporan otomatis, 
                        dan mulai kontrol keuangannu dengan mudah.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-8 py-4 btn-primary text-white rounded-xl font-semibold text-center">
                                Go to Dashboard →
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-8 py-4 btn-primary text-white rounded-xl font-semibold text-center">
                                Mulai Sekarang
                            </a>
                            <a href="#preview" class="px-8 py-4 btn-outline text-purple-600 rounded-xl font-semibold text-center">
                                Preview Dashboard
                            </a>
                        @endauth
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex gap-8 mt-12 pt-8 border-t border-gray-200">
                        <div>
                            <div class="text-3xl font-bold text-gray-800">10K+</div>
                            <div class="text-gray-500">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-800">Rp 1M+</div>
                            <div class="text-gray-500">Transaksi Terkelola</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-800">98%</div>
                            <div class="text-gray-500">Puas</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Illustration -->
                <div class="lg:w-1/2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-indigo-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Finance Illustration" class="relative w-full max-w-md mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preview Dashboard Section -->
    <section id="preview" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Preview Dashboard</h2>
                <p class="text-xl text-gray-600">Lihat bagaimana dashboard kami membantu Anda mengelola keuangan</p>
            </div>
            
            <div class="dashboard-preview rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-4 bg-gray-800">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Dashboard Mockup -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-gray-400 text-sm">Total Income</div>
                            <div class="text-2xl font-bold text-green-400">Rp 5.500.000</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-gray-400 text-sm">Total Expense</div>
                            <div class="text-2xl font-bold text-red-400">Rp 3.200.000</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-gray-400 text-sm">Balance</div>
                            <div class="text-2xl font-bold text-blue-400">Rp 2.300.000</div>
                        </div>
                    </div>
                    
                    <!-- Chart Mockup -->
                    <div class="bg-white/5 rounded-xl p-4 mb-6">
                        <div class="flex justify-between mb-4">
                            <div class="h-32 flex items-end space-x-2">
                                <div class="w-12 bg-green-400 rounded-t" style="height: 80px"></div>
                                <div class="w-12 bg-green-400 rounded-t" style="height: 100px"></div>
                                <div class="w-12 bg-green-400 rounded-t" style="height: 60px"></div>
                                <div class="w-12 bg-red-400 rounded-t" style="height: 70px"></div>
                                <div class="w-12 bg-red-400 rounded-t" style="height: 90px"></div>
                                <div class="w-12 bg-red-400 rounded-t" style="height: 50px"></div>
                            </div>
                        </div>
                        <div class="flex justify-between text-gray-400 text-sm">
                            <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-gray-300">✨ Dashboard lengkap dengan grafik, filter kategori, dan laporan otomatis</p>
                    </div>
                </div>
            </div>
            
            @guest
            <div class="text-center mt-8">
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 btn-primary text-white rounded-xl font-semibold">
                    Mulai Sekarang, Gratis!
                </a>
            </div>
            @endguest
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="py-20 px-6 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Semua yang Anda butuhkan untuk mengontrol keuangan</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card-hover bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">💰</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">CRUD Transaksi</h3>
                    <p class="text-gray-600">Tambah, edit, dan hapus income & expense dengan mudah</p>
                </div>
                
                <div class="card-hover bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">📊</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Grafik & Statistik</h3>
                    <p class="text-gray-600">Visualisasi data keuangan dalam grafik yang mudah dipahami</p>
                </div>
                
                <div class="card-hover bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">🏷️</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Filter Kategori</h3>
                    <p class="text-gray-600">Filter transaksi berdasarkan kategori, tipe, dan tanggal</p>
                </div>
                
                <div class="card-hover bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">🤖</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">AI Insight</h3>
                    <p class="text-gray-600">Rekomendasi pintar berdasarkan kebiasaan pengeluaran Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-20 px-6 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <img src="https://cdn-icons-png.flaticon.com/512/2942/2942792.png" alt="About Us" class="w-full max-w-md mx-auto">
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Tentang berUANG</h2>
                    <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                        berUANG hadir sebagai solusi bagi Anda yang ingin mengelola keuangan dengan lebih baik. 
                        Kami percaya bahwa setiap orang berhak untuk memiliki kontrol penuh atas keuangannya.
                    </p>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Dengan antarmuka yang sederhana namun powerful, berUANG membantu Anda melacak setiap 
                        pemasukan dan pengeluaran, menganalisis kebiasaan finansial, dan mencapai tujuan keuangan.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="flex -space-x-2">
                            <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center">👤</div>
                            <div class="w-10 h-10 bg-indigo-200 rounded-full flex items-center justify-center">👤</div>
                            <div class="w-10 h-10 bg-pink-200 rounded-full flex items-center justify-center">👤</div>
                        </div>
                        <div>
                            <p class="font-semibold">10,000+ pengguna percaya</p>
                            <p class="text-sm text-gray-500">Bergabung dengan mereka sekarang!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section id="testimoni" class="py-20 px-6 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Apa Kata Mereka?</h2>
                <p class="text-xl text-gray-600">Dengan berUANG, keuangan lebih teratur</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-hover bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center text-2xl">
                            👩
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold">Sarah Dewi</h4>
                            <div class="flex text-yellow-400">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-700">"Aplikasi ini benar-benar membantu saya melacak pengeluaran. Sekarang saya tahu kemana uang saya pergi!"</p>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center text-2xl">
                            👨
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold">Budi Santoso</h4>
                            <div class="flex text-yellow-400">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-700">"Fitur grafiknya sangat membantu. Saya bisa melihat tren pengeluaran bulanan dengan jelas."</p>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center text-2xl">
                            👩
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold">Rina Wijaya</h4>
                            <div class="flex text-yellow-400">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-700">"Antarmuka yang sederhana dan mudah digunakan. Sangat recommended untuk finansial pribadi!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6 gradient-bg">
        <div class="container mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Siap Kendalikan Keuanganmu?</h2>
            <p class="text-xl mb-8 opacity-90">Mulai sekarang dan lihat perbedaannya!</p>
            @auth
                <a href="{{ route('dashboard') }}" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-xl font-bold hover:shadow-lg transition">
                    Go to Dashboard →
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-xl font-bold hover:shadow-lg transition">
                    Daftar Sekarang Gratis!
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-6">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">B</span>
                        </div>
                        <span class="text-xl font-bold">berUANG</span>
                    </div>
                    <p class="text-gray-400">Kelola keuangan dengan mudah dan cerdas.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Menu</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#beranda" class="hover:text-white">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#testimoni" class="hover:text-white">Testimoni</a></li>
                        <li><a href="#fitur" class="hover:text-white">Fitur</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Kontak</a></li>
                        <li><a href="#" class="hover:text-white">Privasi</a></li>
                        <li><a href="#" class="hover:text-white">Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">📘</a>
                        <a href="#" class="text-gray-400 hover:text-white">📷</a>
                        <a href="#" class="text-gray-400 hover:text-white">🐦</a>
                        <a href="#" class="text-gray-400 hover:text-white">💼</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 berUANG. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>