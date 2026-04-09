<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Dashboard - TFD</title>
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
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-900/20">
                    <i data-lucide="zap" class="text-white w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold text-white tracking-tight">TFD</h1>
            </div>
            <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] mt-3 font-semibold text-emerald-500/80">Staff Panel</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1">
            <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-600/10 text-emerald-500 border border-emerald-600/20 transition group">
                <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('petugas.kelola-produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="package" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Produk</span>
            </a>
            <a href="{{ route('petugas.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Transaksi</span>
            </a>
            <a href="{{ route('petugas.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Laporan</span>
            </a>
            <a href="{{ route('petugas.chat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="message-square" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Pesan Bantuan</span>
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
        <div class="bg-black/50 backdrop-blur-md border-b border-gray-800 px-8 py-4 flex justify-between items-center h-20 shadow-lg">
            <a href="{{ route('profil') }}" class="flex items-center gap-4 hover:bg-white/5 p-2 rounded-2xl transition group">
                @if(Auth::user()->avatar)
                    <img src="{{ str_starts_with(Auth::user()->avatar, 'images/') ? asset(Auth::user()->avatar) : asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover shadow-lg border border-white/10 group-hover:border-emerald-500/50 transition-colors">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-400 flex items-center justify-center text-white font-bold text-lg shadow-inner group-hover:from-emerald-500 group-hover:to-emerald-300 transition-all">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        {{ Auth::user()->name }}
                        <span class="px-2 py-0.5 bg-emerald-600/20 text-emerald-400 text-[10px] rounded-full border border-emerald-600/30 uppercase tracking-wider font-extrabold group-hover:bg-emerald-600 group-hover:text-white transition-colors">PETUGAS TOKO</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">📅 {{ date('d M Y') }} • <span class="text-emerald-500/70 font-bold group-hover:text-emerald-400 transition-colors uppercase">Edit Profil</span></p>
                </div>
            </a>
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
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all duration-300 shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">TOTAL REVENUE</p>
                            <h3 class="text-2xl font-black text-white mt-1">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-500">
                            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="flex items-center gap-0.5 text-emerald-400 text-[11px] font-bold">
                            <i data-lucide="trending-up" class="w-3 h-3"></i>
                            +12.5%
                        </span>
                        <span class="text-gray-500 text-[11px]">vs bulan lalu</span>
                    </div>
                </div>

                <!-- Orders Card -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all duration-300 shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">TOTAL PESANAN</p>
                            <h3 class="text-3xl font-black text-white mt-1">
                                {{ $totalOrders }}
                            </h3>
                        </div>
                        <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-500">
                            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-emerald-400 text-[11px] font-bold">+5</span>
                        <span class="text-gray-500 text-[11px]">hari ini</span>
                    </div>
                </div>

                </div>
            </div>

            <!-- LOW STOCK ALERT (PETUGAS) -->
            @if($lowStockProducts->count() > 0)
            <div class="mb-8 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 blur-3xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-500">
                            <i data-lucide="alert-circle" class="w-6 h-6 animate-pulse"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-white uppercase tracking-tight">Perlu Restock</h3>
                            <p class="text-[11px] text-gray-400 mt-0.5">Ada {{ $lowStockProducts->count() }} barang dengan stok menipis.</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                    @foreach($lowStockProducts as $p)
                    <div class="bg-black/40 border border-emerald-500/10 rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-800 overflow-hidden">
                                <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-200 uppercase truncate w-32">{{ $p->name }}</p>
                                <p class="text-[10px] text-emerald-500 font-black tracking-widest uppercase">Stok: {{ $p->stok }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- TRANSACTIONS TABLE -->
            <div class="bg-black border border-gray-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="px-8 py-6 border-b border-gray-800 flex justify-between items-center bg-emerald-950/20">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-600/10 rounded-lg flex items-center justify-center text-emerald-500">
                            <i data-lucide="history" class="w-4 h-4"></i>
                        </div>
                        <h3 class="text-base font-bold text-white tracking-tight">Transaksi Terbaru</h3>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-800 bg-black/40">
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">NOMOR</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">NAMA</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">TOTAL</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">STATUS</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse($recentTransactions as $transaction)
                                @php $statusLower = strtolower($transaction->status); @endphp
                                <tr class="border-b border-gray-800 hover:bg-emerald-600/5 transition duration-300">
                                    <td class="px-8 py-4 text-sm font-black text-gray-400 italic font-mono uppercase tracking-widest">#{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-8 py-4">
                                        <p class="text-sm font-bold text-white tracking-tight">{{ $transaction->user->name ?? 'Guest' }}</p>
                                        <p class="text-[10px] text-gray-500 font-medium">TFD Elite Customer</p>
                                    </td>
                                    <td class="px-8 py-4 text-sm font-black text-white tracking-widest">
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-4">
                                        @if(strpos($statusLower, 'pending') !== false || strpos($statusLower, 'menunggu') !== false)
                                            <span class="inline-block px-3 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded text-xs font-semibold">
                                                PENDING
                                            </span>
                                        @elseif(strpos($statusLower, 'selesai') !== false || strpos($statusLower, 'completed') !== false)
                                            <span class="inline-block px-3 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded text-xs font-semibold">
                                                SELESAI
                                            </span>
                                        @elseif(strpos($statusLower, 'batal') !== false || strpos($statusLower, 'cancelled') !== false)
                                            <span class="inline-block px-3 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded text-xs font-semibold">
                                                BATAL
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 bg-gray-600 bg-opacity-50 text-gray-400 rounded text-xs font-semibold">
                                                {{ strtoupper(substr($transaction->status, 0, 3)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-400">
                                        {{ $transaction->created_at->format('d/m/Y - H:i') }}
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-gray-400">
                                    📭 Tidak ada transaksi
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
