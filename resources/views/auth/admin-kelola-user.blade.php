<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - TFD Admin</title>
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
            <a href="{{ route('admin.kelola-user') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/10 text-blue-500 border border-blue-600/20 transition group">
                <i data-lucide="users" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Kelola Users</span>
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
                        Kelola Data User
                        <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 text-[10px] rounded-full border border-blue-600/30 uppercase tracking-wider font-extrabold">ADMINISTRATOR</span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">Manajemen seluruh data pengguna terdaftar di TFD</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right mr-4 hidden md:block">
                    <p class="text-sm font-bold text-white leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">📅 {{ date('d M Y') }}</p>
                </div>
                <button class="w-10 h-10 rounded-xl bg-gray-800/50 border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white transition">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- STATS CARDS -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <!-- Total User -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-blue-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total User</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalUser }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- User Aktif -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-green-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">User Aktif</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $userAktif }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500">
                            <i data-lucide="check-circle" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Staff -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 hover:border-purple-600/50 transition-all shadow-lg group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">Total Staff</p>
                            <h3 class="text-3xl font-black text-white mt-2">
                                {{ $totalStaff }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USERS TABLE -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-900">
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">No</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">FOTO</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">NAMA LENGKAP</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">EMAIL</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">PERAN</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                <td class="px-8 py-4 text-sm text-gray-300">{{ str_pad(($users->currentPage() - 1) * $users->perPage() + $index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" 
                                         class="w-10 h-10 rounded-full">
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-300">{{ $user->name }}</td>
                                <td class="px-8 py-4 text-sm text-gray-400">{{ $user->email }}</td>
                                <td class="px-8 py-4 text-sm">
                                    @if($user->isAdmin())
                                        <span class="inline-block px-3 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded text-xs font-semibold">
                                            ADMIN
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded text-xs font-semibold">
                                            USER
                                        </span>
                                    @endif
                                </td>
                                 <td class="px-8 py-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->isAdmin() ? 'Admin' : 'User' }}')" 
                                                class="w-9 h-9 flex items-center justify-center bg-blue-600/10 text-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-lg shadow-blue-900/10" 
                                                title="Edit User">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="deleteUser({{ $user->id }})" 
                                                class="w-9 h-9 flex items-center justify-center bg-red-600/10 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition shadow-lg shadow-red-900/10" 
                                                title="Hapus User">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-gray-400">
                                    📭 Tidak ada data user
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-8 py-4 border-t border-gray-700 flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $users->firstItem() }} hingga {{ $users->lastItem() }} dari {{ $users->total() }} user
                    </div>
                    <div class="flex gap-2">
                        @if($users->onFirstPage())
                            <span class="px-3 py-2 rounded bg-gray-700 text-gray-500 cursor-not-allowed">← Sebelumnya</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 hover:bg-gray-600 transition">← Sebelumnya</a>
                        @endif

                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 transition">Selanjutnya →</a>
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

<!-- EDIT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-8 w-96 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Edit User</h3>
        
        <form id="editForm" onsubmit="submitEditForm(event)">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                <input type="text" id="editName" placeholder="Masukkan nama" 
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" id="editEmail" placeholder="Masukkan email" 
                       class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Peran</label>
                <select id="editRole" class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
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
        <h3 class="text-xl font-bold text-white mb-4">⚠️ Hapus User</h3>
        <p class="text-gray-300 mb-6">Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>
        
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded transition">
                Batal
            </button>
            <button onclick="confirmDeleteUser()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded transition">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
let currentUserId = null;

// EDIT USER FUNCTIONS
function openEditModal(userId, name, email, role) {
    currentUserId = userId;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    currentUserId = null;
}

function submitEditForm(event) {
    event.preventDefault();
    
    const formData = {
        name: document.getElementById('editName').value,
        email: document.getElementById('editEmail').value,
        role: document.getElementById('editRole').value,
        _token: '{{ csrf_token() }}'
    };

    fetch(`/admin/user/${currentUserId}`, {
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
            alert('User berhasil diperbarui!');
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

function deleteUser(userId) {
    currentUserId = userId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentUserId = null;
}

function confirmDeleteUser() {
    fetch(`/admin/user/${currentUserId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User berhasil dihapus!');
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

// Close modal ketika click di luar
document.addEventListener('click', function(event) {
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    
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
