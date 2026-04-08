<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan - TFD Staff</title>
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
            <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('petugas.kelola-produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="package" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Produk</span>
            </a>
            <a href="{{ route('petugas.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Transaksi</span>
            </a>
            <a href="{{ route('petugas.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-600/10 text-emerald-500 border border-emerald-600/20 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Laporan</span>
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
            
            <div class="flex items-center gap-4">
                <div class="text-right mr-4 hidden md:block">
                    <p class="text-sm font-bold text-white leading-tight">Laporan Toko</p>
                    <p class="text-[10px] text-gray-500 font-medium font-bold text-emerald-500/70 uppercase tracking-widest italic">Statistik Penjualan</p>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- TABS -->
            <div class="flex gap-6 mb-8 border-b border-gray-700 pb-4">
                <button onclick="showTab('penjualan')" class="tab-btn text-emerald-500 font-semibold border-b-2 border-emerald-500 pb-2">
                    Laporan Penjualan
                </button>
                <button onclick="showTab('stok')" class="tab-btn text-gray-400 font-semibold pb-2 hover:text-white">
                    Laporan Stok
                </button>
                <button onclick="showTab('transaksi')" class="tab-btn text-gray-400 font-semibold pb-2 hover:text-white">
                    Laporan Transaksi
                </button>
            </div>

            <!-- TAB CONTENT -->
            <div id="tab-penjualan" class="tab-content">
                <!-- STATS CARDS -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <!-- Total Pendapatan -->
                    <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all shadow-lg group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">Total Pendapatan</p>
                                <h3 class="text-2xl font-black text-white mt-1">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-500">
                                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Produk Terjual -->
                    <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all shadow-lg group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">Total Produk Terjual</p>
                                <h3 class="text-2xl font-black text-white mt-1">
                                    {{ $totalProdukTerjual }} Pcs
                                </h3>
                            </div>
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-500">
                                <i data-lucide="check-circle" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DAFTAR PENJUALAN TABLE -->
                <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="px-8 py-4 border-b border-gray-700 bg-gray-900">
                        <h4 class="text-lg font-bold text-blue-400">DAFTAR PENJUALAN</h4>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-900 border-b border-gray-700">
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Tanggal</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">ID Pesanan</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Nama Produk</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanPenjualan as $item)
                                <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                    <td class="px-8 py-4 text-sm text-gray-300">
                                        {{ $item->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-300">
                                        #TFD-{{ str_pad($item->order_id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-300 font-medium">
                                        {{ $item->product_name }}
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-300">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-gray-400">
                                        📭 Tidak ada data penjualan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($laporanPenjualan->hasPages())
                    <div class="px-8 py-4 border-t border-gray-700 flex justify-between items-center">
                        <div class="text-sm text-gray-400">
                            Menampilkan {{ $laporanPenjualan->firstItem() }} hingga {{ $laporanPenjualan->lastItem() }} dari {{ $laporanPenjualan->total() }} penjualan
                        </div>
                        <div class="flex gap-2">
                            @if($laporanPenjualan->onFirstPage())
                                <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">← Sebelumnya</span>
                            @else
                                <a href="{{ $laporanPenjualan->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 hover:bg-gray-600 transition">← Sebelumnya</a>
                            @endif

                            @if($laporanPenjualan->hasMorePages())
                                <a href="{{ $laporanPenjualan->nextPageUrl() }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 transition">Selanjutnya →</a>
                            @else
                                <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">Selanjutnya →</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- TAB STOK -->
            <div id="tab-stok" class="tab-content hidden">
                <!-- LAPORAN STOK TABLE -->
                <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="px-8 py-4 border-b border-gray-700 bg-gray-900">
                        <h4 class="text-lg font-bold text-blue-400">LAPORAN STOK</h4>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-900 border-b border-gray-700">
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Nama Produk</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Stok Tersedia</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Stok Terjual</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkStok as $product)
                                <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                    <td class="px-8 py-4 text-sm text-gray-300 font-medium">
                                        {{ $product['name'] }}
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-300">
                                        {{ $product['stok_tersedia'] }}
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-300">
                                        {{ $product['stok_terjual'] }}
                                    </td>
                                    <td class="px-8 py-4 text-sm">
                                        @php
                                            $statusColors = [
                                                'Aman' => 'bg-green-500 bg-opacity-20 text-green-400',
                                                'Menipis' => 'bg-yellow-500 bg-opacity-20 text-yellow-400',
                                                'Habis' => 'bg-red-500 bg-opacity-20 text-red-400'
                                            ];
                                        @endphp
                                        <span class="inline-block px-3 py-1 {{ $statusColors[$product['status']] ?? 'bg-gray-600 bg-opacity-50 text-gray-400' }} rounded text-xs font-semibold">
                                            {{ strtoupper($product['status']) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-gray-400">
                                        📭 Tidak ada data produk
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB TRANSAKSI -->
            <div id="tab-transaksi" class="tab-content hidden">
                <!-- DETAIL TRANSAKSI MASUK TABLE -->
                <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="px-8 py-5 border-b border-gray-700">
                        <h4 class="text-lg font-bold text-white uppercase tracking-wider">DETAIL TRANSAKSI MASUK</h4>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="px-8 py-5 text-left text-sm font-bold text-white uppercase tracking-wide">ID Transaksi</th>
                                    <th class="px-8 py-5 text-center text-sm font-bold text-white uppercase tracking-wide">Nama Pelanggan</th>
                                    <th class="px-8 py-5 text-center text-sm font-bold text-white uppercase tracking-wide">Metode Pembayaran</th>
                                    <th class="px-8 py-5 text-right text-sm font-bold text-white uppercase tracking-wide">Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanTransaksi as $transaksi)
                                <tr class="border-b border-gray-700 hover:bg-gray-750 transition duration-150">
                                    <td class="px-8 py-6 text-sm text-gray-300 font-medium whitespace-nowrap">
                                        #TRX-{{ str_pad($transaksi->id, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-8 py-6 text-sm text-gray-300 text-center whitespace-nowrap uppercase">
                                        {{ $transaksi->nama }}
                                    </td>
                                    <td class="px-8 py-6 text-sm text-gray-300 text-center whitespace-nowrap uppercase">
                                        {{ $transaksi->metode }}
                                    </td>
                                    <td class="px-8 py-6 text-sm font-bold text-right whitespace-nowrap uppercase">
                                        @php
                                            $rawStatus = $transaksi->status ?? 'Menunggu Verifikasi';
                                            if (in_array($rawStatus, ['Selesai', 'Diproses'])) {
                                                $statusColor = 'text-green-500';
                                                $statusText = 'BERHASIL';
                                            } elseif ($rawStatus == 'Dibatalkan') {
                                                $statusColor = 'text-red-500';
                                                $statusText = 'DIBATALKAN';
                                            } else {
                                                $statusColor = 'text-yellow-500';
                                                $statusText = 'MENUNGGU';
                                            }
                                        @endphp
                                        <span class="{{ $statusColor }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-gray-400">
                                        📭 Tidak ada data transaksi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($laporanTransaksi->hasPages())
                    <div class="px-8 py-4 border-t border-gray-700 flex justify-between items-center bg-gray-800">
                        <div class="text-sm text-gray-400">
                            Menampilkan {{ $laporanTransaksi->firstItem() }} hingga {{ $laporanTransaksi->lastItem() }} dari {{ $laporanTransaksi->total() }} transaksi
                        </div>
                        <div class="flex gap-2">
                            @if($laporanTransaksi->onFirstPage())
                                <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">← Sebelumnya</span>
                            @else
                                <a href="{{ $laporanTransaksi->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 hover:bg-gray-600 transition">← Sebelumnya</a>
                            @endif

                            @if($laporanTransaksi->hasMorePages())
                                <a href="{{ $laporanTransaksi->nextPageUrl() }}" class="px-3 py-2 rounded bg-emerald-600 hover:bg-emerald-700 transition">Selanjutnya →</a>
                            @else
                                <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">Selanjutnya →</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remove active state from all buttons
        const btn = document.querySelector(`button[onclick="showTab('${tabId}')"]`);
        btn.classList.add('text-emerald-500', 'border-b-2', 'border-emerald-500');
        btn.classList.remove('text-gray-400');
        });

        // Show selected tab
        document.getElementById(`tab-${tabName}`).classList.remove('hidden');

        // Set active state on clicked button
        event.target.classList.remove('text-gray-400');
        event.target.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
    }
</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
