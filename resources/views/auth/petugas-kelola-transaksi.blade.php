<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Transaksi - TFD Staff</title>
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
            <a href="{{ route('petugas.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-600/10 text-emerald-500 border border-emerald-600/20 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Kelola Transaksi</span>
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
            
            <div class="flex items-center gap-4">
                <div class="text-right mr-4 hidden md:block">
                    <p class="text-sm font-bold text-white leading-tight">Kelola Transaksi</p>
                    <p class="text-[10px] text-gray-500 font-medium font-bold text-emerald-500/70 uppercase tracking-widest italic">Monitoring Pesanan</p>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- STATS CARDS -->
            <div class="grid grid-cols-2 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all shadow-lg group focus:outline-none">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">Total Transaksi</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalTransaksi }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500">
                            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all shadow-lg group focus:outline-none">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">Total Revenue</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500">
                            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATUS FILTER -->
            <div class="flex gap-2 mb-8 overflow-x-auto pb-2 scrollbar-hide">
                @php
                    $currentStatus = request('status', 'Semua');
                    $statuses = ['Semua', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
                @endphp
                @foreach($statuses as $status)
                    <a href="{{ route('petugas.kelola-transaksi', ['status' => $status]) }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 whitespace-nowrap {{ $currentStatus == $status ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/40 transform scale-105' : 'bg-black text-gray-500 hover:bg-gray-800 border border-gray-800' }}">
                        {{ $status }}
                    </a>
                @endforeach
            </div>

            <!-- SEARCH & TABLE SECTION -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                <!-- Search Bar -->
                <div class="px-8 py-4 border-b border-gray-700">
                    <input type="text" id="searchInput" placeholder="Nama pelanggan dan ID..." 
                           class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-900 border-b border-gray-700">
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">No</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">ID TRANSAKSI</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">TANGGAL</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">NAMA PELANGGAN</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">TOTAL</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">METODE</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">STATUS</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiList as $index => $order)
                            <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                <td class="px-8 py-4 text-sm text-gray-300">{{ $transaksiList->firstItem() + $index }}</td>
                                <td class="px-8 py-4 text-sm text-gray-300">{{ $order->transaction_id ?? '#TRX-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-8 py-4 text-sm text-gray-300">
                                    {{ $order->created_at->format('d-m-Y') }}
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <div>
                                        <p class="text-gray-300 font-medium">{{ strtoupper($order->nama) }}</p>
                                        <p class="text-gray-500 text-xs">{{ $order->alamat }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-300">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @php
                                        $metodeColors = [
                                            'COD' => 'bg-orange-500 bg-opacity-20 text-orange-400',
                                            'QRIS' => 'bg-purple-500 bg-opacity-20 text-purple-400',
                                            'TRANSFER' => 'bg-emerald-500 bg-opacity-20 text-emerald-400'
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 {{ $metodeColors[$order->metode] ?? 'bg-gray-600 bg-opacity-50 text-gray-400' }} rounded text-xs font-semibold">
                                        {{ strtoupper($order->metode) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @php
                                        $statusColors = [
                                            'Menunggu Pembayaran' => 'bg-orange-500 bg-opacity-20 text-orange-400',
                                            'Menunggu Verifikasi' => 'bg-emerald-500 bg-opacity-20 text-emerald-400',
                                            'Diproses' => 'bg-yellow-500 bg-opacity-20 text-yellow-400',
                                            'Dikirim' => 'bg-purple-500 bg-opacity-20 text-purple-400',
                                            'Selesai' => 'bg-green-500 bg-opacity-20 text-green-400',
                                            'Dibatalkan' => 'bg-red-500 bg-opacity-20 text-red-400'
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 {{ $statusColors[$order->status] ?? 'bg-gray-600 bg-opacity-50 text-gray-400' }} rounded text-xs font-semibold">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewDetail(this)" 
                                                data-order-id="{{ $order->id }}"
                                                data-transaction-id="{{ $order->transaction_id ?? '#TRX-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}"
                                                data-nama="{{ $order->nama }}"
                                                data-hp="{{ $order->hp }}"
                                                data-alamat="{{ $order->alamat }}"
                                                data-metode="{{ $order->metode }}"
                                                data-total="{{ $order->total }}"
                                                data-status="{{ $order->status }}"
                                                data-bukti="{{ $order->bukti_pembayaran }}"
                                                data-items="{{ json_encode($order->items) }}"
                                                class="w-9 h-9 flex items-center justify-center bg-gray-600/10 text-gray-400 rounded-lg hover:bg-gray-600 hover:text-white transition shadow-lg shadow-gray-900/10" 
                                                title="Detail Transaksi">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}', '{{ $order->no_resi }}')" 
                                                class="w-9 h-9 flex items-center justify-center bg-emerald-600/10 text-emerald-500 rounded-lg hover:bg-emerald-600 hover:text-white transition shadow-lg shadow-emerald-900/10" 
                                                title="Update Status">
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        </button>
                                        <a href="{{ route('petugas.cetak-label', $order->id) }}" target="_blank"
                                                class="w-9 h-9 flex items-center justify-center bg-blue-600/10 text-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-lg shadow-blue-900/10" 
                                                title="Cetak Label Pengiriman">
                                            <i data-lucide="printer" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-8 py-12 text-center text-gray-400">
                                    📭 Tidak ada data transaksi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($transaksiList->hasPages())
                <div class="px-8 py-4 border-t border-gray-700 flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $transaksiList->firstItem() }} hingga {{ $transaksiList->lastItem() }} dari {{ $transaksiList->total() }} transaksi
                    </div>
                    <div class="flex gap-2">
                        @if($transaksiList->onFirstPage())
                            <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">← Sebelumnya</span>
                        @else
                            <a href="{{ $transaksiList->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 hover:bg-gray-600 transition">← Sebelumnya</a>
                        @endif

                        @if($transaksiList->hasMorePages())
                            <a href="{{ $transaksiList->nextPageUrl() }}" class="px-3 py-2 rounded bg-emerald-600 hover:bg-emerald-700 transition">Selanjutnya →</a>
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

<!-- DETAIL MODAL -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 w-full max-w-4xl shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-800">
            <h3 class="text-2xl font-black text-white tracking-tight">Detail Pesanan</h3>
            <span id="detailStatusBadge" class="px-3 py-1 bg-emerald-600/20 text-emerald-400 text-[10px] rounded-full border border-emerald-600/30 uppercase tracking-wider font-extrabold">STATUS</span>
        </div>
        
        <input type="hidden" id="detailId">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Left: Customer & Payment Info -->
            <div class="space-y-8">
                <section>
                    <h4 class="text-xs font-black text-emerald-500 uppercase tracking-[0.2em] mb-4">Informasi Pengiriman</h4>
                    <div class="bg-black/40 p-6 rounded-2xl border border-gray-800 space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">ID Transaksi</p>
                            <p id="detailTransactionId" class="text-white font-bold text-sm"></p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">Pelanggan</p>
                            <p id="detailNama" class="text-white font-bold"></p>
                            <p id="detailHp" class="text-emerald-500/70 text-xs font-medium"></p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">Alamat Lengkap</p>
                            <p id="detailAlamat" class="text-gray-300 text-xs leading-relaxed"></p>
                        </div>
                        <div class="pt-2 border-t border-gray-800/50">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">Metode Pembayaran</p>
                            <p id="detailMetode" class="text-white font-bold text-xs"></p>
                        </div>
                    </div>
                </section>

                <section>
                    <h4 class="text-xs font-black text-emerald-500 uppercase tracking-[0.2em] mb-4">Bukti Pembayaran</h4>
                    <div id="buktiContainer" class="hidden">
                        <div class="relative group bg-black rounded-2xl overflow-hidden border border-gray-800 aspect-video flex items-center justify-center">
                            <img id="detailBukti" src="" alt="Bukti Pembayaran" class="max-h-full transition duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-emerald-600/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                <button onclick="window.open(document.getElementById('detailBukti').src, '_blank')" class="bg-white text-black px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Fullscreen</button>
                            </div>
                        </div>
                    </div>
                    <div id="noBuktiContainer" class="py-10 bg-black/20 rounded-2xl border-2 border-dashed border-gray-800 flex flex-col items-center justify-center gap-3">
                        <i data-lucide="image-off" class="w-8 h-8 text-gray-700"></i>
                        <p class="text-gray-600 text-[10px] uppercase font-bold tracking-widest">Belum ada bukti pembayaran</p>
                    </div>
                </section>
            </div>

            <!-- Right: Order Items -->
            <div class="flex flex-col">
                <h4 class="text-xs font-black text-emerald-500 uppercase tracking-[0.2em] mb-4">Ringkasan Pesanan</h4>
                <div class="flex-1 bg-black/40 rounded-2xl border border-gray-800 overflow-hidden flex flex-col">
                    <div class="flex-1 overflow-y-auto max-h-[400px]">
                        <table class="w-full text-left">
                            <thead class="sticky top-0 bg-black">
                                <tr class="border-b border-gray-800">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Item</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Qty</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailItemsBody" class="divide-y divide-gray-800/50">
                                <!-- JS injected content -->
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 bg-black/60 border-t border-gray-800">
                        <div class="flex justify-between items-end">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-[0.2em]">Total Pembayaran</p>
                            <p id="detailTotal" class="text-2xl font-black text-emerald-400 tracking-tighter"></p>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-4 mt-8">
                    <button type="button" onclick="closeDetailModal()" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] transition-all shadow-lg active:scale-95">
                        Tutup Detail
                    </button>
                    <a id="detailCetakLabel" href="#" target="_blank" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="w-3 h-3"></i> Cetak Label
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATUS UPDATE MODAL -->
<div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Ubah Status Transaksi</h3>
        
        <form id="statusForm" onsubmit="submitStatusUpdate(event)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="statusOrderId">
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select id="statusSelect" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Dikirim">Dikirim</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nomor Resi (Opsional)</label>
                <div class="relative group">
                    <input type="text" id="resiInput" placeholder="Masukkan nomor resi pengiriman..."
                           oninput="handleResiInput(this)"
                           class="w-full bg-gray-700 border border-gray-600 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-all pr-12">
                    <button type="button" onclick="generateSimulatedResi()" 
                            class="absolute right-2 top-1.5 p-2 text-gray-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition-all"
                            title="Simulasi Generate Resi (Untuk Demo)">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </button>
                </div>
                <p id="resiHint" class="text-[10px] text-gray-500 mt-2 uppercase italic transition-all">Diperlukan jika status diubah menjadi 'Dikirim'</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white font-medium transition">
                    Simpan
                </button>
                <button type="button" onclick="closeStatusModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-medium transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let updateOrderId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) {
                const transactionId = cells[1].textContent.toLowerCase();
                const customerName = cells[3].textContent.toLowerCase();
                
                if (transactionId.includes(searchTerm) || customerName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Detail Modal Functions
    function viewDetail(button) {
        const id = button.getAttribute('data-order-id');
        const transactionId = button.getAttribute('data-transaction-id');
        const nama = button.getAttribute('data-nama');
        const hp = button.getAttribute('data-hp');
        const alamat = button.getAttribute('data-alamat');
        const metode = button.getAttribute('data-metode');
        const total = button.getAttribute('data-total');
        const status = button.getAttribute('data-status');
        const bukti = button.getAttribute('data-bukti');
        const items = JSON.parse(button.getAttribute('data-items'));

        openDetailModal(id, transactionId, nama, hp, alamat, metode, total, status, bukti, items);
    }

    function openDetailModal(id, transactionId, nama, hp, alamat, metode, total, status, bukti, items) {
        document.getElementById('detailId').value = id;
        document.getElementById('detailTransactionId').textContent = transactionId;
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailHp').textContent = hp;
        document.getElementById('detailAlamat').textContent = alamat;
        document.getElementById('detailMetode').textContent = metode;
        document.getElementById('detailTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        
        const statusBadge = document.getElementById('detailStatusBadge');
        document.getElementById('detailCetakLabel').href = `/petugas/cetak-label/${id}`;

        if (statusBadge) {
            statusBadge.textContent = status.toUpperCase();
            const statusColors = {
                'Menunggu Pembayaran': 'bg-orange-500/20 text-orange-400 border-orange-600/30',
                'Menunggu Verifikasi': 'bg-blue-500/20 text-blue-400 border-blue-600/30',
                'Diproses': 'bg-yellow-500/20 text-yellow-400 border-yellow-600/30',
                'Selesai': 'bg-green-500/20 text-green-400 border-green-600/30',
                'Dibatalkan': 'bg-red-500/20 text-red-400 border-red-600/30'
            };
            statusBadge.className = `px-3 py-1 ${statusColors[status] || 'bg-gray-600/20 text-gray-400 border-gray-600/30'} text-[10px] rounded-full border uppercase tracking-wider font-extrabold`;
        }

        const buktiContainer = document.getElementById('buktiContainer');
        const noBuktiContainer = document.getElementById('noBuktiContainer');
        const detailBukti = document.getElementById('detailBukti');
        
        if (bukti && bukti !== 'null' && bukti !== '') {
            detailBukti.src = "{{ asset('storage') }}/" + bukti;
            buktiContainer.classList.remove('hidden');
            noBuktiContainer.classList.add('hidden');
        } else {
            buktiContainer.classList.add('hidden');
            noBuktiContainer.classList.remove('hidden');
        }

        const itemsBody = document.getElementById('detailItemsBody');
        itemsBody.innerHTML = '';
        items.forEach(item => {
            itemsBody.innerHTML += `
                <tr>
                    <td class="px-6 py-4">
                        <p class="text-white font-bold text-xs">${item.product_name}</p>
                        <p class="text-gray-500 text-[9px] uppercase tracking-widest font-black mt-0.5">ID Product: #${item.product_id}</p>
                        <p class="text-emerald-500/60 text-[9px] font-bold mt-0.5">Price: Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                    </td>
                    <td class="px-6 py-4 text-center text-gray-300 font-bold text-xs">${item.quantity}</td>
                    <td class="px-6 py-4 text-right text-white font-black text-xs">Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</td>
                </tr>
            `;
        });

        document.getElementById('detailModal').classList.remove('hidden');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    function openStatusModal(id, currentStatus, currentResi = '') {
        updateOrderId = id;
        document.getElementById('statusOrderId').value = id;
        document.getElementById('statusSelect').value = currentStatus;
        document.getElementById('resiInput').value = currentResi && currentResi !== 'null' ? currentResi : '';
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function handleResiInput(input) {
        const statusSelect = document.getElementById('statusSelect');
        const hint = document.getElementById('resiHint');
        
        if (input.value.trim() !== '' && statusSelect.value === 'Diproses') {
            statusSelect.value = 'Dikirim';
            hint.textContent = 'Smart Mode: Status otomatis diubah ke DIKIRIM';
            hint.classList.remove('text-gray-500');
            hint.classList.add('text-blue-400', 'font-bold');
        } else if (input.value.trim() === '') {
            hint.textContent = "Diperlukan jika status diubah menjadi 'Dikirim'";
            hint.classList.remove('text-blue-400', 'font-bold');
            hint.classList.add('text-gray-500');
        }
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        updateOrderId = null;
    }

    function generateSimulatedResi() {
        const input = document.getElementById('resiInput');
        const randomStr = Math.random().toString(36).substring(2, 10).toUpperCase();
        const prefixes = ['TFD-JNE-', 'TFD-JNT-', 'TFD-SCP-', 'TFD-EXP-'];
        const randomPrefix = prefixes[Math.floor(Math.random() * prefixes.length)];
        
        input.value = randomPrefix + randomStr;
        handleResiInput(input);
        
        // Visual feedback
        input.classList.add('ring-2', 'ring-emerald-500');
        setTimeout(() => input.classList.remove('ring-2', 'ring-emerald-500'), 1000);
    }

    function submitStatusUpdate(event) {
        event.preventDefault();
        const newStatus = document.getElementById('statusSelect').value;
        const noResi = document.getElementById('resiInput').value;

        fetch(`/petugas/transaksi/${updateOrderId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus, no_resi: noResi })
        })
        .then(async response => {
            const result = await response.json();
            if (response.ok) {
                alert(result.message || 'Status berhasil diperbarui');
                location.reload();
            } else {
                const errorMessage = result.message || (result.errors ? Object.values(result.errors).flat().join('\n') : 'Terjadi kesalahan sistem');
                alert('Gagal: ' + errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: Koneksi bermasalah atau server error');
        });
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('detailModal')) closeDetailModal();
        if (event.target == document.getElementById('statusModal')) closeStatusModal();
    }

    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
</body>
</html>
