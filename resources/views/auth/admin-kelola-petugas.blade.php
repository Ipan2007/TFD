<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Petugas - TFD Admin</title>
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
            <a href="{{ route('admin.kelola-petugas') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-500 border border-blue-600/20 transition group">
                <i data-lucide="briefcase" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Kelola Petugas</span>
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
        <div class="bg-black/50 backdrop-blur-md border-b border-gray-800 px-8 py-4 flex justify-between items-center h-20 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        Kelola Data Petugas
                        <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 text-[10px] rounded-full border border-blue-600/30 uppercase tracking-wider font-extrabold">ADMINISTRATOR</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">Manajemen akses dan data pengguna toko TFD</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <button onclick="openAddModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl text-white transition shadow-lg shadow-blue-900/20 font-bold text-sm">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Petugas</span>
                </button>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- STATS CARDS -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <!-- Total Staff -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-blue-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Petugas</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalStaff }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                            <i data-lucide="briefcase" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Staff Aktif -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-green-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Petugas Aktif</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $staffAktif }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500">
                            <i data-lucide="user-check" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Staff Non-Aktif -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-red-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Petugas Non-Aktif</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $staffNonAktif }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500">
                            <i data-lucide="user-x" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH BAR -->
            <div class="mb-6">
                <input type="text" id="searchInput" placeholder="Cari petugas berdasarkan nama atau ID..." 
                       class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-3 text-gray-300 placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- STAFF TABLE -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-900">
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">ID PETUGAS</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">PETUGAS</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">JABATAN</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">STATUS</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staffList as $staff)
                            <tr class="border-b border-gray-700 hover:bg-gray-750 transition searchable-row">
                                <td class="px-8 py-4 text-sm font-semibold text-gray-300">{{ $staff->staff_id }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->name) }}&background=random&color=fff" 
                                             class="w-10 h-10 rounded-full">
                                        <div>
                                            <p class="text-gray-300 font-medium">{{ $staff->name }}</p>
                                            <p class="text-gray-500 text-xs">{{ $staff->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @php
                                        $positionColors = [
                                            'Kasir' => 'bg-blue-500 bg-opacity-20 text-blue-400',
                                            'Gudang' => 'bg-yellow-500 bg-opacity-20 text-yellow-400',
                                            'Kurir' => 'bg-purple-500 bg-opacity-20 text-purple-400',
                                            'Manager' => 'bg-green-500 bg-opacity-20 text-green-400'
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 {{ $positionColors[$staff->position] ?? 'bg-gray-600 bg-opacity-50 text-gray-400' }} rounded text-xs font-semibold">
                                        {{ strtoupper($staff->position) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @if($staff->status == 'Aktif')
                                        <span class="inline-block px-3 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded text-xs font-semibold">
                                            AKTIF
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded text-xs font-semibold">
                                            NON-AKTIF
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <button onclick="openEditModal({{ $staff->id }}, '{{ $staff->staff_id }}', '{{ $staff->name }}', '{{ $staff->email }}', '{{ $staff->position }}', '{{ $staff->status }}')" 
                                                class="w-9 h-9 flex items-center justify-center bg-blue-600/10 text-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-lg shadow-blue-900/10" 
                                                title="Edit Petugas">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="deleteStaff({{ $staff->id }})" 
                                                class="w-9 h-9 flex items-center justify-center bg-red-600/10 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition shadow-lg shadow-red-900/10" 
                                                title="Hapus Petugas">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-gray-400">
                                    📭 Tidak ada data petugas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($staffList->hasPages())
                <div class="px-8 py-4 border-t border-gray-700 flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $staffList->firstItem() }} hingga {{ $staffList->lastItem() }} dari {{ $staffList->total() }} petugas
                    </div>
                    <div class="flex gap-2">
                        @if($staffList->onFirstPage())
                            <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">← Sebelumnya</span>
                        @else
                            <a href="{{ $staffList->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 hover:bg-gray-600 transition">← Sebelumnya</a>
                        @endif

                        @if($staffList->hasMorePages())
                            <a href="{{ $staffList->nextPageUrl() }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 transition">Selanjutnya →</a>
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

<!-- ADD STAFF MODAL -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Tambah Petugas Baru</h3>
        
        <form id="addForm" onsubmit="submitAddForm(event)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Petugas</label>
                <input type="text" id="addName" placeholder="Masukkan nama" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" id="addEmail" placeholder="Masukkan email" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Jabatan</label>
                <select id="addPosition" required class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    <option value="Kasir">Kasir</option>
                    <option value="Gudang">Gudang</option>
                    <option value="Kurir">Kurir</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-zinc-400 mb-1.5 uppercase text-[10px] tracking-widest ml-1">Password Baru (Default: TFDpetugas2026)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <input type="password" id="addPassword" placeholder="Biarkan kosong untuk default"
                           class="w-full bg-zinc-900 border border-zinc-800 rounded-xl py-3 pl-10 pr-4 text-white focus:outline-none focus:border-blue-500 transition-all text-sm font-medium">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-zinc-400 mb-1.5 uppercase text-[10px] tracking-widest ml-1">Status</label>
                <select id="addStatus" required class="w-full bg-zinc-900 border border-zinc-800 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-blue-500 transition-all text-sm font-medium appearance-none">
                    <option value="Aktif">Aktif</option>
                    <option value="Non-Aktif">Non-Aktif</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeAddModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                    Tambah Petugas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Edit Petugas</h3>
        
        <form id="editForm" onsubmit="submitEditForm(event)">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Petugas</label>
                <input type="text" id="editName" placeholder="Masukkan nama" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" id="editEmail" placeholder="Masukkan email" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Jabatan</label>
                <select id="editPosition" required class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    <option value="Kasir">Kasir</option>
                    <option value="Gudang">Gudang</option>
                    <option value="Kurir">Kurir</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-zinc-400 mb-1.5 uppercase text-[10px] tracking-widest ml-1">Ganti Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <input type="password" id="editPassword" placeholder="Kosongkan jika tidak diganti"
                           class="w-full bg-zinc-900 border border-zinc-800 rounded-xl py-3 pl-10 pr-4 text-white focus:outline-none focus:border-blue-500 transition-all text-sm font-medium">
                </div>
                <p class="text-[10px] text-zinc-500 mt-2 px-1 leading-relaxed">Isi jika ingin mengganti password akun login petugas ini.</p>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-zinc-400 mb-1.5 uppercase text-[10px] tracking-widest ml-1">Status</label>
                <select id="editStatus" required class="w-full bg-zinc-900 border border-zinc-800 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-blue-500 transition-all text-sm font-medium appearance-none">
                    <option value="Aktif">Aktif</option>
                    <option value="Non-Aktif">Non-Aktif</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-4">⚠️ Hapus Petugas</h3>
        <p class="text-gray-300 mb-6">Apakah Anda yakin ingin menghapus petugas ini? Tindakan ini tidak dapat dibatalkan.</p>
        
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded transition">
                Batal
            </button>
            <button onclick="confirmDeleteStaff()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded transition">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
let currentStaffId = null;

// ADD MODAL FUNCTIONS
function openAddModal() {
    document.getElementById('addForm').reset();
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function submitAddForm(event) {
    event.preventDefault();
    
    const name = document.getElementById('addName').value;
    const email = document.getElementById('addEmail').value;
    const position = document.getElementById('addPosition').value;
    const status = document.getElementById('addStatus').value;
    const password = document.getElementById('addPassword').value;

    if (!name || !email || !position || !status) {
        alert('Semua field harus diisi!');
        return;
    }

    const formData = {
        name: name,
        email: email,
        position: position,
        status: status,
        password: password
    };

    fetch('/admin/staff', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            let errorMsg = data.message || 'Terjadi kesalahan';
            if (data.errors) {
                errorMsg += '\n\n' + Object.entries(data.errors).map(([key, val]) => `${key}: ${val[0]}`).join('\n');
            }
            alert('Error: ' + errorMsg);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    });

    closeAddModal();
}

// EDIT MODAL FUNCTIONS
function openEditModal(staffId, staffIdDisplay, name, email, position, status) {
    currentStaffId = staffId;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPosition').value = position;
    document.getElementById('editStatus').value = status;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    currentStaffId = null;
}

function submitEditForm(event) {
    event.preventDefault();
    
    const formData = {
        name: document.getElementById('editName').value,
        email: document.getElementById('editEmail').value,
        position: document.getElementById('editPosition').value,
        status: document.getElementById('editStatus').value,
        password: document.getElementById('editPassword').value, // Menambahkan field password
        _token: '{{ csrf_token() }}'
    };

    fetch(`/admin/staff/${currentStaffId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Petugas & Akun berhasil diperbarui!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan!');
    });

    closeEditModal();
}

// DELETE FUNCTIONS
function deleteStaff(staffId) {
    currentStaffId = staffId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentStaffId = null;
}

function confirmDeleteStaff() {
    fetch(`/admin/staff/${currentStaffId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Petugas berhasil dihapus!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan!');
    });

    closeDeleteModal();
}

// SEARCH FUNCTIONALITY
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('.searchable-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Close modal ketika click di luar
document.addEventListener('click', function(event) {
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === addModal) {
        closeAddModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});
</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
