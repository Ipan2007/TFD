<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Transaksi - TFD Admin</title>
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
            <a href="{{ route('admin.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-500 border border-blue-600/20 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Kelola Transaksi</span>
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
        <div class="bg-black/50 backdrop-blur-md border-b border-gray-800 px-8 py-4 flex justify-between items-center h-20 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        Kelola Transaksi
                        <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 text-[10px] rounded-full border border-blue-600/30 uppercase tracking-wider font-extrabold">ADMINISTRATOR</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">Monitoring dan update status pesanan pelanggan</p>
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
            <!-- STATS CARDS -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-blue-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Pesanan</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalTransaksi }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-green-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Pendapatan</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500">
                            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-yellow-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Perlu Diproses</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $pendingOrders }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500">
                            <i data-lucide="clock" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
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
                                            'TRANSFER' => 'bg-blue-500 bg-opacity-20 text-blue-400'
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 {{ $metodeColors[$order->metode] ?? 'bg-gray-600 bg-opacity-50 text-gray-400' }} rounded text-xs font-semibold">
                                        {{ strtoupper($order->metode) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @php
                                        $statusColors = [
                                            'Menunggu Verifikasi' => 'bg-blue-500 bg-opacity-20 text-blue-400',
                                            'Diproses' => 'bg-yellow-500 bg-opacity-20 text-yellow-400',
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
                                        <button onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')" 
                                                class="w-9 h-9 flex items-center justify-center bg-blue-600/10 text-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-lg shadow-blue-900/10" 
                                                title="Update Status">
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="deleteOrder({{ $order->id }})" 
                                                class="w-9 h-9 flex items-center justify-center bg-red-600/10 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition shadow-lg shadow-red-900/10" 
                                                title="Hapus Transaksi">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
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
                            <a href="{{ $transaksiList->nextPageUrl() }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 transition">Selanjutnya →</a>
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
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl max-h-96 overflow-y-auto">
        <h3 class="text-xl font-bold text-white mb-6">Detail Transaksi</h3>
        
        <input type="hidden" id="detailId">
        
        <div class="space-y-4">
            <div>
                <p class="text-gray-400 text-sm">ID Transaksi</p>
                <p id="detailTransactionId" class="text-white font-medium"></p>
            </div>
            
            <div>
                <p class="text-gray-400 text-sm">Nama Pelanggan</p>
                <p id="detailNama" class="text-white font-medium"></p>
            </div>
            
            <div>
                <p class="text-gray-400 text-sm">No. Telepon</p>
                <p id="detailHp" class="text-white font-medium"></p>
            </div>
            
            <div>
                <p class="text-gray-400 text-sm">Alamat</p>
                <p id="detailAlamat" class="text-white font-medium"></p>
            </div>
            
            <div>
                <p class="text-gray-400 text-sm">Metode Pembayaran</p>
                <p id="detailMetode" class="text-white font-medium"></p>
            </div>
            
            <div>
                <p class="text-gray-400 text-sm">Total Pembayaran</p>
                <p id="detailTotal" class="text-white font-medium text-lg"></p>
            </div>
            
            <div>
                <p class="text-gray-400 text-sm">Status</p>
                <p id="detailStatus" class="text-white font-medium"></p>
            </div>
        </div>
        
        <button type="button" onclick="closeDetailModal()" class="w-full mt-6 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-medium transition">
            Tutup
        </button>
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
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white font-medium transition">
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
            const transactionId = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const customerName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            
            if (transactionId.includes(searchTerm) || customerName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Detail Modal Functions
    function openDetailModal(id, transactionId, nama, hp, alamat, metode, total, status) {
        document.getElementById('detailId').value = id;
        document.getElementById('detailTransactionId').textContent = transactionId;
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailHp').textContent = hp;
        document.getElementById('detailAlamat').textContent = alamat;
        document.getElementById('detailMetode').textContent = metode;
        document.getElementById('detailTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('detailStatus').textContent = status;
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Status Update Modal Functions
    function openStatusModal(id, currentStatus) {
        updateOrderId = id;
        document.getElementById('statusOrderId').value = id;
        document.getElementById('statusSelect').value = currentStatus;
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        updateOrderId = null;
    }

    function submitStatusUpdate(event) {
        event.preventDefault();

        const newStatus = document.getElementById('statusSelect').value;

        fetch(`/admin/transaksi/${updateOrderId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                closeStatusModal();
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Close modals when clicking outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });

    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
