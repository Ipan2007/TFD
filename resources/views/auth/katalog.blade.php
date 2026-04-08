<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog | TFD Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #000; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="text-white">

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 px-10 py-6 flex justify-between items-center glass m-4 rounded-3xl">
    <h2 class="font-extrabold text-2xl tracking-tighter">TFD</h2>

    <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.2em] items-center">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-white transition">Beranda</a>
        <a href="{{ route('katalog') }}" class="text-white">Katalog</a>

        @auth
            <a href="{{ route('wishlist') }}" class="text-gray-500 hover:text-white transition flex items-center gap-2">
                Wishlist
                @php $wishlistCount = auth()->user()->wishlistedProducts()->count(); @endphp
                @if($wishlistCount > 0)
                    <span class="bg-emerald-500 text-black text-[9px] px-1.5 py-0.5 rounded-full font-black">{{ $wishlistCount }}</span>
                @endif
            </a>
            <a href="{{ route('keranjang') }}" class="text-gray-500 hover:text-white transition">Keranjang</a>
            <a href="{{ route('pesanan-saya') }}" class="text-gray-500 hover:text-white transition whitespace-nowrap flex items-center gap-2">
                Pesanan Saya
                @php
                    $activeOrders = \App\Models\Order::where('user_id', auth()->id())
                        ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                        ->count();
                @endphp
                @if($activeOrders > 0)
                    <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                @endif
            </a>
            <a href="{{ route('profil') }}" class="flex items-center gap-2 text-gray-500 hover:text-white transition group">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-5 h-5 rounded-full object-cover border border-white/10 group-hover:border-white/30 transition-all">
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
        @else
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-white transition">Login</a>
            <a href="{{ route('register') }}" class="bg-white text-black px-6 py-2 rounded-xl border border-white/5 hover:bg-emerald-500 hover:text-white transition-all ml-4 scale-90">DAFTAR</a>
        @endauth
    </div>
</nav>

<!-- SEARCH & HEADER -->
<div class="px-16 pt-20 pb-10">
    <div class="flex flex-col md:flex-row justify-between items-center gap-10">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter">Semua Produk</h1>
            <p class="text-xs text-gray-500 font-bold mt-2 uppercase tracking-widest">Temukan gaya terbaik Anda di TFD.</p>
        </div>

        <form action="{{ route('katalog') }}" method="GET" class="w-full md:w-1/3 flex border border-white/10 rounded-2xl overflow-hidden focus-within:border-white transition-all">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari produk..." 
                   class="flex-1 bg-white/5 px-6 py-4 text-sm focus:outline-none placeholder-gray-700">
            <button type="submit" class="bg-white text-black px-8 text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition">CARI</button>
        </form>
    </div>
    
    @if(request('search'))
    <p class="mt-8 text-xs text-gray-500 italic">Menampilkan hasil untuk: "<span class="text-white font-bold">{{ request('search') }}</span>"</p>
    @endif
</div>

<!-- GRID PRODUK -->
<div class="px-16 pb-32">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        @forelse($products as $product)
        <div class="relative group bg-[#0a0a0a] border border-white/5 p-4 rounded-[2.5rem] hover:border-white/20 transition-all duration-300">
            @if($product->stok <= 0)
            <div class="absolute inset-0 bg-black/70 z-20 flex items-center justify-center rounded-[2.5rem]">
                <span class="bg-red-600 text-white px-4 py-1 text-[10px] font-black tracking-widest uppercase rounded">STOK HABIS</span>
            </div>
            @endif
            
            <div class="overflow-hidden rounded-[2rem] mb-6">
                <img src="{{ str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image) }}"
                     class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110 {{ $product->stok <= 0 ? 'grayscale' : '' }}">
                
                @auth
                <!-- Wishlist Toggle -->
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-6 right-6 z-30">
                    @csrf
                    @php 
                        $isWishlisted = auth()->user()->wishlistedProducts()->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="submit" class="w-10 h-10 rounded-full {{ $isWishlisted ? 'bg-emerald-500 text-black' : 'bg-black/50 text-white border border-white/20' }} backdrop-blur-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all shadow-xl">
                        <i data-lucide="heart" class="w-5 h-5 {{ $isWishlisted ? 'fill-current' : '' }}"></i>
                    </button>
                </form>
                @endauth
            </div>

            <div class="px-2">
                <h3 class="font-bold text-base tracking-tight mb-1">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm font-bold mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <a href="{{ route('detail', $product->id) }}"
                   class="block text-center border border-white/10 py-4 rounded-3xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">
                   LIHAT DETAIL
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-32 bg-white/5 border border-dashed border-white/10 rounded-[3rem]">
            <p class="text-gray-500 italic text-sm">Produk belum tersedia atau tidak ditemukan.</p>
            @if(request('search'))
            <a href="{{ route('katalog') }}" class="inline-block mt-6 text-xs text-white underline underline-offset-8">Kembali ke Katalog Lengkap</a>
            @endif
        </div>
        @endforelse
    </div>
</div>

<!-- FOOTER -->
<footer class="border-t border-gray-900 px-16 py-16 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. PUSAT STREETWEAR BERKUALITAS.
</footer>

@include('components.chat-widget')

<script>
    lucide.createIcons();
</script>
</body>
</html>