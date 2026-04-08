<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Produk - TFD Admin</title>
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
            <a href="{{ route('admin.kelola-produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-500 border border-blue-600/20 transition group">
                <i data-lucide="package" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Kelola Produk</span>
            </a>
            <a href="{{ route('admin.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Transaksi</span>
            </a>
            <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Laporan</span>
            </a>
            <a href="{{ route('admin.chat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
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
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        Kelola Stok Produk
                        <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 text-[10px] rounded-full border border-blue-600/30 uppercase tracking-wider font-extrabold">ADMINISTRATOR</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">Manajemen stok dan data produk jaket TFD</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <button onclick="openAddModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl text-white transition shadow-lg shadow-blue-900/20 font-bold text-sm">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Produk</span>
                </button>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- STATS CARDS -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-blue-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Produk</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalProduk }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Stock -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-green-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Stok</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalStok }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500">
                            <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-red-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Produk Habis</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $produkHabis }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH & TABLE SECTION -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                <!-- Search Bar -->
                <div class="px-8 py-4 border-b border-gray-700">
                    <input type="text" id="searchInput" placeholder="Cari jaket berdasarkan nama atau brand..." 
                           class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-900 border-b border-gray-700">
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">No</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Foto Jaket</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Nama Jaket</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Brand</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Harga</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Kondisi</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Stok</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produktList as $index => $product)
                            <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                <td class="px-8 py-4 text-sm text-gray-300">{{ $produktList->firstItem() + $index }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                         class="w-12 h-12 rounded object-cover border border-gray-600">
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-300">{{ $product->name }}</td>
                                <td class="px-8 py-4 text-sm text-gray-300">{{ $product->brand }}</td>
                                <td class="px-8 py-4 text-sm text-gray-300">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <span class="inline-block px-3 py-1 bg-purple-500 bg-opacity-20 text-purple-400 rounded text-xs font-semibold">
                                        {{ $product->kondisi }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @if($product->stok > 0)
                                        <span class="inline-block px-3 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded text-xs font-semibold">
                                            {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded text-xs font-semibold">
                                            0
                                        </span>
                                    @endif                                 <td class="px-8 py-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <button onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->brand) }}', {{ $product->price }}, '{{ $product->kondisi }}', {{ $product->stok }}, '{{ $product->image }}')" 
                                                class="w-9 h-9 flex items-center justify-center bg-blue-600/10 text-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-lg shadow-blue-900/10" 
                                                title="Edit Produk">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="deleteProduct({{ $product->id }})" 
                                                class="w-9 h-9 flex items-center justify-center bg-red-600/10 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition shadow-lg shadow-red-900/10" 
                                                title="Hapus Produk">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>     </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-8 py-12 text-center text-gray-400">
                                    📭 Tidak ada data produk
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($produktList->hasPages())
                <div class="px-8 py-4 border-t border-gray-700 flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $produktList->firstItem() }} hingga {{ $produktList->lastItem() }} dari {{ $produktList->total() }} produk
                    </div>
                    <div class="flex gap-2">
                        @if($produktList->onFirstPage())
                            <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">← Sebelumnya</span>
                        @else
                            <a href="{{ $produktList->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 hover:bg-gray-600 transition">← Sebelumnya</a>
                        @endif

                        @if($produktList->hasMorePages())
                            <a href="{{ $produktList->nextPageUrl() }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 transition">Selanjutnya →</a>
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

<!-- ADD PRODUCT MODAL -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Tambah Produk Baru</h3>
        
        <form id="addForm" onsubmit="submitAddForm(event)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Jaket</label>
                <input type="text" id="addName" placeholder="Masukkan nama jaket" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Brand</label>
                <input type="text" id="addBrand" placeholder="Masukkan brand" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Harga (Rp)</label>
                <input type="number" id="addPrice" placeholder="Masukkan harga" required min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Kondisi</label>
                <input type="text" id="addKondisi" placeholder="Contoh: 9/10" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Stok</label>
                <input type="number" id="addStok" placeholder="Masukkan jumlah stok" required min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Jaket</label>
                <select id="addImage" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Gambar...</option>
                    <option value="images/jaket1.jpg">Jaket 1</option>
                    <option value="images/jaket2.jpg">Jaket 2</option>
                    <option value="images/jaket3.jpg">Jaket 3</option>
                    <option value="images/jaket4.jpg">Jaket 4</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white font-medium transition">
                    Tambah
                </button>
                <button type="button" onclick="closeAddModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-medium transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT PRODUCT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Edit Produk</h3>
        
        <form id="editForm" onsubmit="submitEditForm(event)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="editId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Jaket</label>
                <input type="text" id="editName" placeholder="Masukkan nama jaket" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Brand</label>
                <input type="text" id="editBrand" placeholder="Masukkan brand" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Harga (Rp)</label>
                <input type="number" id="editPrice" placeholder="Masukkan harga" required min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Kondisi</label>
                <input type="text" id="editKondisi" placeholder="Contoh: 9/10" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Stok</label>
                <input type="number" id="editStok" placeholder="Masukkan jumlah stok" required min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Jaket</label>
                <select id="editImage" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Gambar...</option>
                    <option value="images/jaket1.jpg">Jaket 1</option>
                    <option value="images/jaket2.jpg">Jaket 2</option>
                    <option value="images/jaket3.jpg">Jaket 3</option>
                    <option value="images/jaket4.jpg">Jaket 4</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white font-medium transition">
                    Simpan
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-medium transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE PRODUCT MODAL -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-4">Hapus Produk</h3>
        <p class="text-gray-400 mb-6">Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.</p>
        
        <div class="flex gap-3">
            <button onclick="confirmDelete()" class="flex-1 bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white font-medium transition">
                Hapus
            </button>
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-medium transition">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
    let deleteProductId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const brand = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || brand.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Add Modal Functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addForm').reset();
    }

    function submitAddForm(event) {
        event.preventDefault();

        const data = {
            name: document.getElementById('addName').value,
            brand: document.getElementById('addBrand').value,
            price: document.getElementById('addPrice').value,
            kondisi: document.getElementById('addKondisi').value,
            stok: document.getElementById('addStok').value,
            image: document.getElementById('addImage').value
        };

        fetch('{{ route("admin.product.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                closeAddModal();
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Edit Modal Functions
    function openEditModal(id, name, brand, price, kondisi, stok, image) {
        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editBrand').value = brand;
        document.getElementById('editPrice').value = price;
        document.getElementById('editKondisi').value = kondisi;
        document.getElementById('editStok').value = stok;
        document.getElementById('editImage').value = image;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }

    function submitEditForm(event) {
        event.preventDefault();

        const id = document.getElementById('editId').value;
        const data = {
            name: document.getElementById('editName').value,
            brand: document.getElementById('editBrand').value,
            price: document.getElementById('editPrice').value,
            kondisi: document.getElementById('editKondisi').value,
            stok: document.getElementById('editStok').value,
            image: document.getElementById('editImage').value
        };

        fetch(`/admin/product/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                closeEditModal();
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete Modal Functions
    function deleteProduct(id) {
        deleteProductId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteProductId = null;
    }

    function confirmDelete() {
        if (!deleteProductId) return;

        fetch(`/admin/product/${deleteProductId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                closeDeleteModal();
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Close modals when clicking outside
    document.getElementById('addModal').addEventListener('click', function(e) {
        if (e.target === this) closeAddModal();
    });

    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
