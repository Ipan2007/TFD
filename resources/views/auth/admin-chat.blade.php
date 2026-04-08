<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan Bantuan - TFD Admin</title>
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
                <div class="w-10 h-10 {{ request()->is('*petugas*') ? 'bg-emerald-600 shadow-emerald-900/20' : 'bg-blue-600 shadow-blue-900/20' }} rounded-xl flex items-center justify-center shadow-lg">
                    <i data-lucide="zap" class="text-white w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold text-white tracking-tight">TFD</h1>
            </div>
            <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] mt-3 font-semibold {{ request()->is('*petugas*') ? 'text-emerald-500/80' : '' }}">
                {{ request()->is('*petugas*') ? 'Staff Panel' : 'Admin Panel' }}
            </p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1">
            <a href="{{ request()->is('*petugas*') ? route('petugas.dashboard') : route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            @if(!request()->is('*petugas*'))
            <a href="{{ route('admin.kelola-user') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="users" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Users</span>
            </a>
            <a href="{{ route('admin.kelola-petugas') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="briefcase" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Petugas</span>
            </a>
            @endif
            <a href="{{ request()->is('*petugas*') ? route('petugas.kelola-produk') : route('admin.kelola-produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="package" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Produk</span>
            </a>
            <a href="{{ request()->is('*petugas*') ? route('petugas.kelola-transaksi') : route('admin.kelola-transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Kelola Transaksi</span>
            </a>
            <a href="{{ request()->is('*petugas*') ? route('petugas.laporan') : route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-gray-100 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Laporan</span>
            </a>
            <a href="{{ request()->is('*petugas*') ? route('petugas.chat') : route('admin.chat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('*petugas*') ? 'bg-emerald-600/10 text-emerald-500 border border-emerald-600/20' : 'bg-blue-600/10 text-blue-500 border border-blue-600/20' }} transition group">
                <i data-lucide="message-square" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Pesan Bantuan</span>
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
                    <img src="{{ str_starts_with(Auth::user()->avatar, 'images/') ? asset(Auth::user()->avatar) : asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover shadow-lg border border-white/10 group-hover:border-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-500/50 transition-colors">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-600 to-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-400 flex items-center justify-center text-white font-bold text-lg shadow-inner group-hover:from-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-500 group-hover:to-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-300 transition-all">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        {{ Auth::user()->name }}
                        <span class="px-2 py-0.5 bg-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-600/20 text-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-400 text-[10px] rounded-full border border-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-600/30 uppercase tracking-wider font-extrabold group-hover:bg-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-600 group-hover:text-white transition-colors">
                            {{ request()->is('*petugas*') ? 'PETUGAS CS' : 'ADMINISTRATOR' }}
                        </span>
                    </h2>
                    <p class="text-gray-500 text-[11px] mt-0.5 tracking-wide">📅 {{ date('d M Y') }} • <span class="text-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-500/70 font-bold group-hover:text-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-400 transition-colors uppercase">Edit Profil</span></p>
                </div>
            </a>
            
            <div class="flex items-center gap-4">
                <div class="text-right mr-4 hidden md:block">
                    <p class="text-sm font-bold text-white leading-tight">Pusat Bantuan</p>
                    <p class="text-[10px] text-gray-500 font-medium font-bold text-{{ request()->is('*petugas*') ? 'emerald' : 'blue' }}-500/70 uppercase tracking-widest italic">Live Chat CS</p>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-hidden p-8 flex">
            <!-- CHAT INTERFACE WRAPPER -->
            <div class="w-full h-full bg-black border border-gray-800 rounded-2xl flex overflow-hidden shadow-2xl">
                
                <!-- CONTACT LIST -->
                <div class="w-80 border-r border-gray-800 flex flex-col bg-gray-900/40">
                    <div class="px-6 py-5 border-b border-gray-800 bg-black/40">
                        <h3 class="text-sm font-black text-gray-200 tracking-widest uppercase">Kotak Masuk</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-2">
                        @forelse($users as $user)
                        <button onclick="loadChat({{ $user->id }}, '{{ $user->name }}', '{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}')" class="w-full text-left px-4 py-3 rounded-xl border border-transparent hover:border-gray-700 hover:bg-gray-800/80 transition-all group flex items-center gap-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 font-bold group-hover:bg-blue-600 group-hover:text-white transition">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-200 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ count($user->chats) > 0 ? $user->chats->first()->message : '' }}</p>
                            </div>
                        </button>
                        @empty
                        <div class="text-center py-10">
                            <i data-lucide="message-square-off" class="w-8 h-8 text-gray-700 mx-auto mb-2"></i>
                            <p class="text-xs font-bold text-gray-500">Belum ada pesan</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- CHAT AREA -->
                <div class="flex-1 flex flex-col bg-black/20 relative" id="chatArea" style="display: none;">
                    <div class="px-8 py-5 border-b border-gray-800 bg-black/40 flex items-center gap-4 shadow-sm z-10">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold" id="chatAvatar">U</div>
                        <div>
                            <h3 class="text-sm font-black text-white" id="chatName">User Name</h3>
                            <p class="text-[10px] text-green-500 font-bold tracking-widest uppercase flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Online
                            </p>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-8 space-y-6" id="chatMessages">
                        <!-- Messages via AJAX -->
                    </div>

                    <div class="p-6 border-t border-gray-800 bg-black/60 relative z-10">
                        <form id="chatForm" onsubmit="sendMessage(event)" class="flex gap-4">
                            <input type="hidden" id="activeUserId">
                            <input type="text" id="messageInput" required placeholder="Ketik balasan untuk pelanggan..." class="flex-1 bg-gray-900 border border-gray-700 rounded-xl px-6 py-4 text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-gray-600 shadow-inner">
                            <button type="submit" class="bg-blue-600 px-8 rounded-xl font-bold text-white hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-900/20 active:scale-95">
                                Kirim
                                <i data-lucide="send" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- EMPTY DB STATE -->
                <div class="flex-1 flex flex-col items-center justify-center bg-black/20" id="emptyState">
                    <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center text-gray-700 mb-6 border border-gray-800 shadow-xl">
                        <i data-lucide="headphones" class="w-10 h-10"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-400 tracking-tight">Pusat Layanan Bantuan</h3>
                    <p class="text-sm text-gray-600 mt-2">Pilih obrolan dari kotak masuk untuk mulai membalas</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    const isPetugas = window.location.pathname.includes('/petugas');
    const fetchUrlBase = isPetugas ? '/petugas/chat' : '/admin/chat';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let pollInterval;

    function loadChat(userId, name, avatarUrl) {
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('chatArea').style.display = 'flex';
        document.getElementById('activeUserId').value = userId;
        document.getElementById('chatName').textContent = name;
        
        const avatarEl = document.getElementById('chatAvatar');
        if (avatarUrl) {
            avatarEl.innerHTML = `<img src="${avatarUrl}" class="w-full h-full rounded-full object-cover">`;
            avatarEl.classList.remove('bg-blue-600');
        } else {
            avatarEl.innerHTML = name.substring(0, 1).toUpperCase();
            avatarEl.classList.add('bg-blue-600');
        }
        
        if (pollInterval) clearInterval(pollInterval);
        fetchMessages(userId);
        
        pollInterval = setInterval(() => {
            fetchMessages(document.getElementById('activeUserId').value, false);
        }, 3000);
    }

    function fetchMessages(userId, scroll = true) {
        fetch(`${fetchUrlBase}/${userId}`)
            .then(res => res.json())
            .then(data => {
                const chatBox = document.getElementById('chatMessages');
                
                // Cek scroll position sebelum inject data
                let isBottom = true;
                if(!scroll) {
                    isBottom = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 50;
                }
                
                chatBox.innerHTML = '';
                data.chats.forEach(chat => {
                    const timeObj = new Date(chat.created_at);
                    const time = timeObj.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                    if (chat.is_admin) {
                        chatBox.innerHTML += `
                            <div class="flex justify-end">
                                <div class="bg-blue-600 text-white p-4 rounded-2xl rounded-tr-sm max-w-[70%] shadow-lg shadow-blue-900/20 transform transition-all duration-300">
                                    <p class="text-sm leading-relaxed">${chat.message}</p>
                                    <p class="text-[9px] text-blue-200 mt-2 text-right opacity-70">${time}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        chatBox.innerHTML += `
                            <div class="flex justify-start">
                                <div class="bg-gray-800 text-gray-200 p-4 rounded-2xl rounded-tl-sm max-w-[70%] border border-gray-700 shadow-lg transform transition-all duration-300">
                                    <p class="text-sm leading-relaxed">${chat.message}</p>
                                    <p class="text-[9px] text-gray-500 mt-2">${time}</p>
                                </div>
                            </div>
                        `;
                    }
                });

                if(scroll || isBottom) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            })
            .catch(err => console.error("Error fetching chats", err));
    }

    function sendMessage(e) {
        e.preventDefault();
        const msgInput = document.getElementById('messageInput');
        const userId = document.getElementById('activeUserId').value;
        const msg = msgInput.value;
        if(!msg.trim()) return;

        msgInput.value = '';
        msgInput.focus();

        const chatBox = document.getElementById('chatMessages');
        chatBox.innerHTML += `
            <div class="flex justify-end opacity-50">
                <div class="bg-blue-600 text-white p-4 rounded-2xl rounded-tr-sm max-w-[70%] shadow-lg shadow-blue-900/20">
                    <p class="text-sm leading-relaxed">${msg}</p>
                    <p class="text-[9px] text-blue-200 mt-2 text-right">Mengirim...</p>
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch(`${fetchUrlBase}/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            fetchMessages(userId, true);
        })
        .catch(err => console.error("Error sending message", err));
    }
</script>

</body>
</html>
