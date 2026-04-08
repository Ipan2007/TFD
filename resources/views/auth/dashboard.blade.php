<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TFD | Trip Factory Depok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #000; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .hero-text { line-height: 0.85; letter-spacing: -0.05em; }
        .glow { filter: blur(100px); opacity: 0.15; position: absolute; border-radius: 50%; z-index: 0; }
    </style>
</head>
<body class="text-white overflow-x-hidden">

<!-- BG DECORATION -->
<div class="glow w-[500px] h-[500px] bg-white -top-40 -left-20"></div>
<div class="glow w-[600px] h-[600px] bg-white bottom-0 -right-40"></div>

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 z-50 px-10 py-6 flex justify-between items-center glass m-4 rounded-3xl">
    <h2 class="font-extrabold text-2xl tracking-tighter">TFD</h2>

    <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.2em] items-center">
        <a href="{{ route('dashboard') }}" class="text-white">Beranda</a>
        <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-white transition">Katalog</a>
        
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

<!-- HERO SECTION -->
<header class="relative min-h-screen flex flex-col items-center justify-center pt-20 px-6">
    <div class="text-center relative z-10 max-w-5xl">
        <p class="text-[10px] font-black tracking-[0.5em] text-gray-500 mb-6 uppercase">Indonesian Streetwear Essentials</p>
        <h1 class="hero-text text-[100px] md:text-[180px] font-extrabold uppercase mb-10 select-none">
            TRIP FACTORY <br> <span class="text-transparent" style="-webkit-text-stroke: 1px rgba(255,255,255,0.3);">DEPOK</span>
        </h1>
        <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
            <a href="{{ route('katalog') }}" 
               class="bg-white text-black px-12 py-5 rounded-full font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition-all shadow-2xl shadow-white/10 active:scale-95">
               JELAJAHI KOLEKSI
            </a>
            <p class="text-xs text-gray-500 max-w-xs text-left normal-case italic border-l border-gray-800 pl-4 py-1">
                "Kurasi pakaian vintage dan streetwear terbaik dengan estetika minimalis."
            </p>
        </div>
    </div>
</header>

<!-- BRAND VALUES -->
<section class="py-32 px-16 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
        <div>
            <h3 class="text-xs font-black tracking-[0.3em] uppercase mb-4 text-white/40">01. Kurasi</h3>
            <p class="text-sm leading-relaxed text-gray-400">Setiap barang dipilih secara manual untuk memastikan kualitas standar TFD.</p>
        </div>
        <div>
            <h3 class="text-xs font-black tracking-[0.3em] uppercase mb-4 text-white/40">02. Estetika</h3>
            <p class="text-sm leading-relaxed text-gray-400">Desain minimalis yang cocok untuk segala suasana, dari jalanan hingga gaya kasual.</p>
        </div>
        <div>
            <h3 class="text-xs font-black tracking-[0.3em] uppercase mb-4 text-white/40">03. Komunitas</h3>
            <p class="text-sm leading-relaxed text-gray-400">Berakar di Depok, membawa pengaruh lokal ke panggung streetwear yang lebih luas.</p>
        </div>
    </div>
</section>

<!-- NEW ARRIVALS (FEATURED) -->
<section class="px-16 pb-32 relative z-10">
    <div class="flex justify-between items-end mb-16 px-2">
        <div>
            <h2 class="text-3xl font-black uppercase tracking-tighter">New Arrivals</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-2 font-bold">Rilis Terbaru Pekan Ini</p>
        </div>
        <a href="{{ route('katalog') }}" class="text-[10px] font-black uppercase tracking-widest border-b-2 border-white pb-1 hover:text-gray-400 hover:border-gray-400 transition">Lihat Semua</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        @forelse($products->take(3) as $product)
        <div class="relative group">
            <div class="bg-[#111] overflow-hidden rounded-3xl border border-white/5 transition-all duration-500 group-hover:border-white/20">
                @if($product->stok <= 0)
                <div class="absolute inset-0 bg-black/60 z-20 flex items-center justify-center">
                    <span class="bg-red-600 text-white px-4 py-1 text-[10px] font-black tracking-widest uppercase">SOLD OUT</span>
                </div>
                @endif
                <img src="{{ str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image) }}"
                     class="w-full h-[450px] object-cover transition-transform duration-700 group-hover:scale-110 {{ $product->stok <= 0 ? 'grayscale' : '' }}">
                
                <div class="p-8">
                    <h3 class="text-lg font-bold tracking-tight mb-2">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-2 font-bold italic">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @if($product->order_items_avg_rating)
                        <div class="flex items-center gap-2 mb-6">
                            <span class="text-amber-400 text-[10px] font-black tracking-widest">{{ number_format($product->order_items_avg_rating, 1) }} ★</span>
                            <span class="text-[9px] text-gray-700 uppercase font-bold tracking-widest">({{ $product->order_items_count }} ulasan)</span>
                        </div>
                    @else
                         <div class="h-[26px]"></div>
                    @endif
                    <a href="{{ route('detail', $product->id) }}"
                       class="inline-block text-[10px] font-black uppercase tracking-[0.2em] border border-white/10 px-8 py-3 rounded-full hover:bg-white hover:text-black transition-all">
                       DETAIL PRODUK
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20 border border-dashed border-white/5 rounded-3xl">
            <p class="text-gray-500 text-sm italic">Belum ada rilisan terbaru.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- FOOTER -->
<footer class="border-t border-gray-900 px-16 py-20 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-20">
        <div class="col-span-2">
            <h2 class="text-2xl font-black mb-6 tracking-tighter">TFD.</h2>
            <p class="text-gray-500 text-sm max-w-sm leading-relaxed italic">"Membawa kultur streetwear Depok ke level berikutnya melalui kurasi barang pilihan dan estetika yang terjaga."</p>
        </div>
        <div>
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/50 mb-6">Navigasi</h4>
            <ul class="space-y-3 text-xs text-gray-400 font-bold">
                <li><a href="{{ route('katalog') }}" class="hover:text-white transition">Katalog Produk</a></li>
                <li><a href="{{ route('keranjang') }}" class="hover:text-white transition">Keranjang</a></li>
                <li><a href="{{ route('pesanan-saya') }}" class="hover:text-white transition">History Pesanan</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/50 mb-6">Sosial</h4>
            <ul class="space-y-3 text-xs text-gray-400 font-bold">
                <li><a href="#" class="hover:text-white transition uppercase">Instagram</a></li>
                <li><a href="#" class="hover:text-white transition uppercase">Tiktok</a></li>
                <li><a href="#" class="hover:text-white transition uppercase">Youtube</a></li>
            </ul>
        </div>
    </div>
    <div class="mt-32 pt-10 border-t border-gray-900 flex justify-between items-center text-[10px] text-gray-600 font-black uppercase tracking-widest">
        <p>© 2026 TRIP FACTORY DEPOK INDONESIA.</p>
        <p>REFINED STREETWEAR CURATION.</p>
    </div>
</footer>

@include('components.chat-widget')
</body>
</html>