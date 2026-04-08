<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TFD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-950 text-gray-100">

<div class="flex h-screen">
    <!-- SIDEBAR -->
    <div class="w-64 bg-black border-r border-gray-800 p-6 flex flex-col">
        <!-- Logo -->
        <div class="mb-10 px-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                    <i data-lucide="zap" class="text-white w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold text-white tracking-tight">TFD</h1>
            </div>
            <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] mt-3 font-semibold">Admin Panel</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-500 border border-blue-600/20 transition group">
                <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('admin.kelola-user') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="users" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Users</span>
            </a>
            <a href="{{ route('admin.kelola-petugas') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="briefcase" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Petugas</span>
            </a>
            <a href="{{ route('admin.kelola-produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="package" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Produk</span>
            </a>
            <a href="{{ route('admin.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Transaksi</span>
            </a>
            <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Laporan</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="pt-6 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-red-600 hover:text-white transition group">
                    <i data-lucide="log-out" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden bg-[#0a0a0a]">
        <!-- TOP BAR -->
        <div class="bg-black/50 backdrop-blur-md border-b border-gray-800 px-8 py-4 flex justify-between items-center h-20">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        {{ Auth::user()->name }}
                        <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 text-[10px] rounded-full border border-blue-600/30 uppercase tracking-wider font-extrabold">ADMINISTRATOR</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">📅 {{ date('d M Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="w-10 h-10 rounded-xl bg-gray-800/50 border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                </button>
                <button class="w-10 h-10 rounded-xl bg-gray-800/50 border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- STATS CARDS -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <!-- Revenue Card -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 hover:border-gray-600 transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">TOTAL REVENUE</p>
                            <h3 class="text-2xl font-black text-white mt-1">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center text-green-500">
                            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="flex items-center gap-0.5 text-green-400 text-[11px] font-bold">
                            <i data-lucide="trending-up" class="w-3 h-3"></i>
                            +12.5%
                        </span>
                        <span class="text-gray-500 text-[11px]">vs bulan lalu</span>
                    </div>
                </div>

                <!-- Orders Card -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-blue-600/50 transition-all duration-300 shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">TOTAL PESANAN</p>
                            <h3 class="text-3xl font-black text-white mt-1">
                                {{ $totalOrders }}
                            </h3>
                        </div>
                        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500">
                            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-blue-400 text-[11px] font-bold">+8</span>
                        <span class="text-gray-500 text-[11px]">hari ini</span>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-purple-600/50 transition-all duration-300 shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">TOTAL PRODUK</p>
                            <h3 class="text-3xl font-black text-white mt-1">
                                {{ $totalProducts }}
                            </h3>
                        </div>
                        <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-500">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-gray-500 text-[11px] font-medium flex items-center gap-1">
                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                            Stok Tersedia
                        </span>
                    </div>
                </div>
            </div>

            <!-- TRANSACTIONS TABLE -->
            <div class="bg-black border border-gray-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="px-8 py-6 border-b border-gray-800 flex justify-between items-center bg-gray-900/20">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600/10 rounded-lg flex items-center justify-center text-blue-500">
                            <i data-lucide="history" class="w-4 h-4"></i>
                        </div>
                        <h3 class="text-base font-bold text-white tracking-tight">Transaksi Terbaru</h3>
                    </div>
                    <button class="text-[11px] font-bold text-blue-400 hover:text-blue-300 transition uppercase tracking-widest">Lihat Semua</button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-800 bg-black/40">
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">NOMOR</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">NAMA PELANGGAN</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">METODE</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">TOTAL HARGA</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">STATUS</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                            <tr class="border-b border-gray-800/50 hover:bg-gray-800/20 transition-colors">
                                <td class="px-8 py-4 text-sm font-mono text-blue-400 font-bold">#{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-8 py-4">
                                    <div class="text-sm font-bold text-gray-200">{{ $transaction->nama }}</div>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ $transaction->metode }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm font-black text-white">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-4">
                                    @php
                                        $statusLower = strtolower($transaction->status);
                                        $statusClass = "bg-gray-600/10 text-gray-400 border-gray-600/20";
                                        if(strpos($statusLower, 'menunggu') !== false) $statusClass = "bg-yellow-500/10 text-yellow-500 border-yellow-500/20";
                                        elseif(strpos($statusLower, 'selesai') !== false) $statusClass = "bg-green-500/10 text-green-500 border-green-500/20";
                                        elseif(strpos($statusLower, 'batal') !== false) $statusClass = "bg-red-500/10 text-red-500 border-red-500/20";
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $statusClass }} uppercase tracking-wider">
                                        {{ $transaction->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-xs font-medium text-gray-500">
                                    {{ $transaction->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-800/30 rounded-full flex items-center justify-center text-gray-600">
                                            <i data-lucide="inbox" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm font-medium">Tidak ada transaksi</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
    </div>
</div>

</body>
</html>
