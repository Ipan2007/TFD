<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | TFD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #000; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .profile-avatar-container:hover .avatar-overlay { opacity: 1; }
    </style>
</head>
<body class="text-white min-h-screen">

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 px-10 py-6 flex justify-between items-center glass m-4 rounded-3xl">
    <h2 class="font-extrabold text-2xl tracking-tighter">TFD</h2>

    <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.2em] items-center">
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-white transition">Dashboard</a>
            <a href="{{ route('admin.kelola-user') }}" class="text-gray-500 hover:text-white transition">Kelola User</a>
            <a href="{{ route('admin.kelola-produk') }}" class="text-gray-500 hover:text-white transition">Kelola Produk</a>
            <a href="{{ route('admin.kelola-transaksi') }}" class="text-gray-500 hover:text-white transition">Kelola Transaksi</a>
            <a href="{{ route('admin.laporan') }}" class="text-gray-500 hover:text-white transition">Laporan</a>
            <a href="{{ route('admin.chat') }}" class="text-gray-500 hover:text-white transition">Chat Bantuan</a>
        @elseif(Auth::user()->isPetugas())
            <a href="{{ route('petugas.dashboard') }}" class="text-gray-500 hover:text-white transition">Dashboard</a>
            <a href="{{ route('petugas.kelola-produk') }}" class="text-gray-500 hover:text-white transition">Kelola Produk</a>
            <a href="{{ route('petugas.kelola-transaksi') }}" class="text-gray-500 hover:text-white transition">Kelola Transaksi</a>
            <a href="{{ route('petugas.laporan') }}" class="text-gray-500 hover:text-white transition">Laporan</a>
            <a href="{{ route('petugas.chat') }}" class="text-gray-500 hover:text-white transition">Chat Bantuan</a>
        @else
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-white transition">Beranda</a>
            <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-white transition">Katalog</a>
            <a href="{{ route('wishlist') }}" class="text-gray-500 hover:text-white transition flex items-center gap-2">
                Wishlist
                @php $wishlistCount = auth()->user()->wishlistedProducts()->count(); @endphp
                @if($wishlistCount > 0)
                    <span class="bg-emerald-500 text-black text-[9px] px-1.5 py-0.5 rounded-full font-black">{{ $wishlistCount }}</span>
                @endif
            </a>
            <a href="{{ route('keranjang') }}" class="text-gray-500 hover:text-white transition">Keranjang</a>
            <a href="{{ route('pesanan-saya') }}" class="text-gray-500 hover:text-white transition whitespace-nowrap">Pesanan Saya</a>
        @endif
        
        <a href="{{ route('profil') }}" class="flex items-center gap-2 text-white font-black tracking-widest border-b-2 border-white pb-1 group">
            @if(Auth::user()->avatar)
                <img src="{{ str_starts_with(Auth::user()->avatar, 'images/') ? asset(Auth::user()->avatar) : asset('storage/' . Auth::user()->avatar) }}" class="w-5 h-5 rounded-full object-cover border border-white/10 group-hover:border-white/30 transition-all">
            @else
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center text-[8px] font-black group-hover:bg-white/20 transition-all">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            Profil
        </a>

        <form action="{{ route('logout') }}" method="POST" class="ml-4">
            @csrf
            <button class="bg-white/5 hover:bg-red-500/10 hover:text-red-500 px-4 py-2 rounded-xl border border-white/5 transition">LOGOUT</button>
        </form>
    </div>
</nav>

<!-- CONTENT -->
<div class="max-w-2xl mx-auto py-32 px-10">
    
    <div class="mb-16 flex flex-col items-center text-center">
        @php
            $roleLabel = 'USER';
            $roleColor = 'text-blue-400 bg-blue-500/10 border-blue-500/20';
            if(Auth::user()->isAdmin()) {
                $roleLabel = 'ADMIN SECURITY';
                $roleColor = 'text-rose-500 bg-rose-500/10 border-rose-500/20';
            } elseif(Auth::user()->isPetugas()) {
                $roleLabel = 'LOGISTICS PETUGAS';
                $roleColor = 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20';
            }
        @endphp
        <span class="inline-block px-4 py-1.5 rounded-full border {{ $roleColor }} text-[9px] font-black tracking-[0.3em] uppercase mb-6 shadow-lg shadow-black/20">
            {{ $roleLabel }}
        </span>
        <h1 class="text-6xl font-black uppercase tracking-tighter leading-none mb-6">Identitas Akun</h1>
        <p class="text-[10px] text-gray-700 font-black uppercase tracking-[0.4em] italic border-l-2 border-gray-800 pl-4">"Sesuaikan akses eksklusif Anda di platform TFD."</p>
    </div>

    @if(session('success'))
        <div class="mb-10 p-6 bg-emerald-500/5 border border-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-[2rem] flex items-center justify-center gap-4 animate-pulse">
            <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center italic">!</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-zinc-950 border border-white/5 rounded-[3rem] p-12 shadow-2xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 blur-3xl -mr-32 -mt-32 transition-transform duration-700 group-hover:scale-125"></div>
        
        <!-- Form Errors (Global) -->
        @if($errors->any())
        <div class="mb-10 bg-rose-500/10 border border-rose-500/20 p-6 rounded-2xl animate-shake">
            <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mb-4">Gagal Memperbarui Profil:</p>
            <ul class="space-y-2">
                @foreach($errors->all() as $error)
                    <li class="text-white text-[10px] font-bold list-disc ml-5 uppercase tracking-wide">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative z-10" id="profileForm">
            @csrf
            @method('PUT')

            <!-- AVATAR SECTION -->
            <div class="flex flex-col items-center mb-16 px-6">
                <div class="relative w-40 h-40 group cursor-pointer">
                    <!-- The ACTUAL File Input (Visible but transparent for a 100% reliable click) -->
                    <input type="file" name="avatar" id="avatarInput" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" 
                           accept="image/*" onchange="previewImage(this)">
                    
                    <!-- Visual Avatar Display -->
                    <div class="w-40 h-40 rounded-[2.5rem] bg-black border-2 border-dashed border-white/10 overflow-hidden shadow-2xl transition-all group-hover:border-emerald-500/50 relative z-10">
                        @if(Auth::user()->avatar)
                            <img id="avatarPreview" src="{{ str_starts_with(Auth::user()->avatar, 'images/') ? asset(Auth::user()->avatar) : asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img id="avatarPreview" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=000&color=fff&bold=true" class="w-full h-full object-cover">
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="avatar-overlay absolute inset-0 bg-black/70 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-[2.5rem] pointer-events-none">
                            <i data-lucide="camera" class="text-white w-8 h-8 mb-2"></i>
                            <p class="text-[8px] font-black uppercase tracking-widest text-white text-center">KLIK UNTUK<br>GANTI FOTO</p>
                        </div>
                    </div>

                    <!-- Floating edit icon decoration -->
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-xl border-4 border-zinc-950 z-20 group-hover:scale-110 transition-transform pointer-events-none">
                        <i data-lucide="pencil" class="w-4 h-4 text-white"></i>
                    </div>
                </div>
                
                @error('avatar') <p class="text-red-500 text-[9px] mt-6 font-black tracking-widest uppercase italic bg-red-500/5 px-4 py-2 rounded-lg border border-red-500/10">⚠ {{ $message }}</p> @enderror
                <p class="mt-4 text-[9px] text-gray-500 font-bold uppercase tracking-[0.3em]">Besar file maks. 5MB</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- NAMA -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-gray-700 uppercase tracking-[0.3em] ml-2 font-bold">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                           placeholder="Nama Anda"
                           class="w-full bg-black border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">
                    @error('name') <p class="text-red-500 text-[9px] mt-2 font-black tracking-widest uppercase italic">⚠ {{ $message }}</p> @enderror
                </div>

                <!-- NOMOR HP -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-gray-700 uppercase tracking-[0.3em] ml-2 font-bold">Nomor WhatsApp Aktif</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                           placeholder="08xxxxxxxx"
                           class="w-full bg-black border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">
                    @error('phone') <p class="text-red-500 text-[9px] mt-2 font-black tracking-widest uppercase italic">⚠ {{ $message }}</p> @enderror
                </div>
            </div>

            <!-- EMAIL (ReadOnly) -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-700 uppercase tracking-[0.3em] ml-2 font-bold">Alamat E-mail (Terverifikasi)</label>
                <div class="relative group/mail">
                    <input type="email" value="{{ Auth::user()->email }}" disabled
                           class="w-full bg-white/5 border border-white/5 rounded-2xl px-6 py-4 text-sm text-gray-600 cursor-not-allowed font-medium italic">
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover/mail:opacity-100 transition-opacity">
                         <i data-lucide="lock" class="w-4 h-4 text-gray-700"></i>
                    </div>
                </div>
            </div>

            <!-- ALAMAT (Hanya untuk User) -->
            @if(!Auth::user()->isAdmin() && !Auth::user()->isPetugas())
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-700 uppercase tracking-[0.3em] ml-2 font-bold">Alamat Lengkap Pengiriman</label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap (Jalan, No, Blok, Kota...)"
                          class="w-full bg-black border border-white/10 rounded-2xl px-6 py-5 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800 min-h-[120px]">{{ old('address', Auth::user()->address) }}</textarea>
                @error('address') <p class="text-red-500 text-[9px] mt-2 font-black tracking-widest uppercase italic">⚠ {{ $message }}</p> @enderror
            </div>
            @endif

            <!-- PASSWORD FIELDS -->
            <div class="pt-10 border-t border-white/5">
                <p class="text-[10px] font-black text-white uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-pulse"></span> Ganti Password Keamanan (Opsional)
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-700 uppercase tracking-widest ml-2 font-bold">Password Baru (KOSONGKAN jika tidak diganti)</label>
                        <input type="password" name="password" autocomplete="new-password" placeholder="Biarkan kosong agar password tidak berubah"
                               class="w-full bg-black border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">
                    </div>
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-700 uppercase tracking-widest ml-2 font-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi untuk konfirmasi"
                               class="w-full bg-black border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">
                    </div>
                </div>
                @error('password') <p class="text-red-500 text-[9px] mt-3 font-black tracking-widest uppercase italic text-center">⚠ {{ $message }}</p> @enderror
                <p class="mt-6 text-[9px] text-gray-800 font-bold uppercase tracking-widest italic leading-relaxed text-center">Biarkan kosong jika tetap menggunakan password saat ini.</p>
            </div>

            <button type="submit"
                    class="w-full bg-white text-black py-6 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.5em] hover:bg-emerald-500 hover:text-white transition-all shadow-2xl active:scale-95 group font-bold">
                SIMPAN PERUBAHAN EKSKLUSIF <span class="group-hover:translate-x-2 transition-transform inline-block">→</span>
            </button>
        </form>
    </div>

</div>

<!-- FOOTER -->
<footer class="border-t border-gray-900 px-16 py-12 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. ACCOUNT SERVICES PROTECTED.
</footer>

<script>
    lucide.createIcons();

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@include('components.chat-widget')
</body>
</html>
