<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan - TFD Admin</title>
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
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
            <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-500 border border-blue-600/20 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Laporan</span>
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
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        Kelola Laporan
                        <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 text-[10px] rounded-full border border-blue-600/30 uppercase tracking-wider font-extrabold">ADMINISTRATOR</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">Analisis data penjualan dan inventaris toko TFD</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right mr-4 hidden md:block">
                    <p class="text-sm font-bold text-white leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">📅 {{ date('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- TABS -->
            <div class="flex gap-6 mb-8 border-b border-gray-700 pb-4">
                <button onclick="showTab('penjualan')" class="tab-btn text-blue-500 font-semibold border-b-2 border-blue-500 pb-2">
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
                    <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-green-600/50 transition-all shadow-lg group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Pendapatan</p>
                                <h3 class="text-2xl font-black text-white mt-1">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center text-green-500">
                                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Produk Terjual -->
                    <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-blue-600/50 transition-all shadow-lg group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Produk Terjual</p>
                                <h3 class="text-2xl font-black text-white mt-1">
                                    {{ $totalProdukTerjual }} Pcs
                                </h3>
                            </div>
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500">
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
                                <a href="{{ $laporanTransaksi->nextPageUrl() }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 transition">Selanjutnya →</a>
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
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
            btn.classList.add('text-gray-400');
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
