<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Produk - TFD Staff</title>
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
            <a href="{{ route('petugas.kelola-produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-600/10 text-emerald-500 border border-emerald-600/20 transition group">
                <i data-lucide="package" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Kelola Produk</span>
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
            
            <div class="flex items-center gap-4">
                <button onclick="openAddModal()" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 rounded-xl text-white transition shadow-lg shadow-emerald-900/20 font-bold text-sm">
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
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">Total Produk</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalProduk }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Stock -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-emerald-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-emerald-500/70">Total Stok</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalStok }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500">
                            <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-red-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider text-red-500/70">Produk Habis</p>
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
                                    <img src="{{ str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         class="w-12 h-12 rounded object-cover border border-gray-600 shadow-sm">
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
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <button onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->brand) }}', {{ $product->price }}, '{{ $product->kondisi }}', {{ $product->stok }}, '{{ $product->image }}', '{{ addslashes($product->description) }}')" 
                                                class="w-9 h-9 flex items-center justify-center bg-emerald-600/10 text-emerald-500 rounded-lg hover:bg-emerald-600 hover:text-white transition shadow-lg shadow-emerald-900/10" 
                                                title="Edit Produk">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                    </div>
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

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi (Opsional)</label>
                <textarea id="addDescription" placeholder="Masukkan deskripsi produk" rows="3"
                          class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Jaket</label>
                <div class="relative group">
                    <input type="file" id="addImage" accept="image/*" required
                           class="hidden">
                    <label for="addImage" class="flex items-center justify-center gap-2 w-full bg-gray-700 border-2 border-dashed border-gray-600 rounded-xl px-4 py-4 text-gray-400 hover:text-white hover:border-emerald-500 transition-all cursor-pointer group-hover:bg-gray-700/50">
                        <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                        <span id="addFileName" class="text-xs font-medium">Klik untuk pilih foto</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white font-medium transition">
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

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Stok</label>
                <input type="number" id="editStok" placeholder="Masukkan jumlah stok" required min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi (Opsional)</label>
                <textarea id="editDescription" placeholder="Masukkan deskripsi produk" rows="3"
                          class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Jaket (Kosongi jika tidak diubah)</label>
                <div class="relative group">
                    <input type="file" id="editImage" accept="image/*"
                           class="hidden">
                    <label for="editImage" class="flex items-center justify-center gap-2 w-full bg-gray-700 border-2 border-dashed border-gray-600 rounded-xl px-4 py-4 text-gray-400 hover:text-white hover:border-emerald-500 transition-all cursor-pointer group-hover:bg-gray-700/50">
                        <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                        <span id="editFileName" class="text-xs font-medium">Klik untuk ganti foto</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white font-medium transition">
                    Simpan
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-white font-medium transition">
                    Batal
                </button>
            </div>
        </form>
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

    // File selection display
    document.getElementById('addImage').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Klik untuk pilih foto';
        document.getElementById('addFileName').textContent = fileName;
    });

    document.getElementById('editImage').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Klik untuk ganti foto';
        document.getElementById('editFileName').textContent = fileName;
    });

    function submitAddForm(event) {
        event.preventDefault();
        const submitBtn = event.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="flex items-center gap-2 justify-center"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Memproses...</span>';
        lucide.createIcons();

        const formData = new FormData();
        formData.append('name', document.getElementById('addName').value);
        formData.append('brand', document.getElementById('addBrand').value);
        formData.append('price', document.getElementById('addPrice').value);
        formData.append('kondisi', document.getElementById('addKondisi').value);
        formData.append('stok', document.getElementById('addStok').value);
        formData.append('description', document.getElementById('addDescription').value);
        
        const imageFile = document.getElementById('addImage').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        fetch('{{ route("petugas.product.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(async response => {
            const result = await response.json();
            if (response.ok && result.success) {
                alert(result.message);
                location.reload();
            } else {
                let errorMsg = result.message || 'Terjadi kesalahan';
                if (result.errors) {
                    errorMsg += '\n\nDetail:\n' + Object.keys(result.errors).map(f => `- ${result.errors[f].join(', ')}`).join('\n');
                }
                alert(errorMsg);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                lucide.createIcons();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengirim data. Pastikan koneksi stabil dan ukuran file tidak terlalu besar.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            lucide.createIcons();
        });
    }

    // Edit Modal Functions
    function openEditModal(id, name, brand, price, kondisi, stok, image, description) {
        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editBrand').value = brand;
        document.getElementById('editPrice').value = price;
        document.getElementById('editKondisi').value = kondisi;
        document.getElementById('editStok').value = stok;
        document.getElementById('editImage').value = ''; 
        document.getElementById('editFileName').textContent = 'Klik untuk ganti foto';
        document.getElementById('editDescription').value = description || '';
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }

    function submitEditForm(event) {
        event.preventDefault();
        const submitBtn = event.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="flex items-center gap-2 justify-center"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...</span>';
        lucide.createIcons();

        const id = document.getElementById('editId').value;
        const formData = new FormData();
        formData.append('_method', 'PUT'); 
        formData.append('name', document.getElementById('editName').value);
        formData.append('brand', document.getElementById('editBrand').value);
        formData.append('price', document.getElementById('editPrice').value);
        formData.append('kondisi', document.getElementById('editKondisi').value);
        formData.append('stok', document.getElementById('editStok').value);
        formData.append('description', document.getElementById('editDescription').value);
        
        const imageFile = document.getElementById('editImage').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        fetch(`/petugas/product/${id}`, {
            method: 'POST', 
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(async response => {
            const result = await response.json();
            if (response.ok && result.success) {
                alert(result.message);
                location.reload();
            } else {
                let errorMsg = result.message || 'Terjadi kesalahan';
                if (result.errors) {
                    errorMsg += '\n\nDetail:\n' + Object.keys(result.errors).map(f => `- ${result.errors[f].join(', ')}`).join('\n');
                }
                alert(errorMsg);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                lucide.createIcons();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menyimpan data.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            lucide.createIcons();
        });
    }
</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
