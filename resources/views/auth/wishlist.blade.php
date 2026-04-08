<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist | TFD Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #000; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .glow { position: absolute; border-radius: 50%; filter: blur(120px); z-index: -1; opacity: 0.15; transition: all 1s ease; }
    </style>
</head>
<body class="text-white overflow-x-hidden">

<!-- BG DECORATION -->
<div class="glow w-[500px] h-[500px] bg-white -top-40 -left-20"></div>
<div class="glow w-[600px] h-[600px] bg-white bottom-0 -right-40"></div>

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 px-10 py-6 flex justify-between items-center glass m-4 rounded-3xl">
    <h2 class="font-extrabold text-2xl tracking-tighter">TFD</h2>

    <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.2em] items-center">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-white transition">Beranda</a>
        <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-white transition">Katalog</a>
        <a href="{{ route('wishlist') }}" class="text-white flex items-center gap-2">
            Wishlist
            @php $wishlistCount = auth()->user()->wishlistedProducts()->count(); @endphp
            @if($wishlistCount > 0)
                <span class="bg-emerald-500 text-black text-[9px] px-1.5 py-0.5 rounded-full font-black">{{ $wishlistCount }}</span>
            @endif
        </a>
        <a href="{{ route('keranjang') }}" class="text-gray-500 hover:text-white transition">Keranjang</a>
        <a href="{{ route('pesanan-saya') }}" class="text-gray-500 hover:text-white transition whitespace-nowrap">Pesanan Saya</a>
        <a href="{{ route('profil') }}" class="flex items-center gap-2 text-gray-500 hover:text-white transition group">
            @if(Auth::user()->avatar)
                <img src="{{ str_starts_with(Auth::user()->avatar, 'images/') ? asset(Auth::user()->avatar) : asset('storage/' . Auth::user()->avatar) }}" class="w-5 h-5 rounded-full object-cover border border-white/10 group-hover:border-white/30 transition-all">
            @else
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center text-[8px] font-black group-hover:bg-white/20 transition-all">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            Profil
        </a>
    </div>
</nav>

<!-- CONTENT -->
<div class="px-16 py-20 max-w-7xl mx-auto">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-10 p-6 bg-emerald-500/5 border border-emerald-500/10 text-emerald-400 text-xs font-black tracking-widest rounded-3xl uppercase text-center animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-20">
        <h1 class="text-6xl font-black uppercase tracking-tighter leading-none italic">Wishlist Anda</h1>
        <p class="text-xs text-gray-600 font-bold mt-4 uppercase tracking-[0.4em]">Produk eksklusif yang Anda simpan untuk nanti.</p>
    </div>

    @if($wishlistItems->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($wishlistItems as $product)
        <div class="relative group bg-[#0a0a0a] border border-white/5 p-4 rounded-[2.5rem] hover:border-white/20 transition-all duration-300">
            <div class="overflow-hidden rounded-[2rem] mb-6 relative">
                <img src="{{ str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image) }}"
                     class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                
                <!-- Remove from Wishlist Toggle -->
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-6 right-6 z-30">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-full bg-emerald-500 text-black backdrop-blur-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all shadow-xl">
                        <i data-lucide="heart" class="w-5 h-5 fill-current"></i>
                    </button>
                </form>
            </div>

            <div class="px-2">
                <p class="text-[9px] text-gray-700 font-bold uppercase tracking-[0.3em] mb-2">{{ $product->brand ?? 'TFD Originals' }}</p>
                <h3 class="text-base font-bold tracking-tight mb-2 uppercase group-hover:text-emerald-400 transition-colors">{{ $product->name }}</h3>
                <p class="text-sm font-light text-gray-400 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <a href="{{ route('detail', $product->id) }}" 
                   class="block w-full text-center bg-white/5 border border-white/5 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">
                   LIHAT DETAIL
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="py-32 text-center bg-white/5 border border-dashed border-white/5 rounded-[4rem]">
        <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-8">
            <i data-lucide="heart" class="text-gray-700 w-8 h-8"></i>
        </div>
        <p class="text-gray-600 italic font-medium uppercase tracking-widest mb-10 text-xl">Wishlist Anda masih kosong.</p>
        <a href="{{ route('katalog') }}"
           class="bg-white text-black px-12 py-5 rounded-full text-xs font-black uppercase tracking-[0.3em] hover:bg-emerald-500 hover:text-white transition-all shadow-2xl active:scale-95">
           TELUSURI KATALOG
        </a>
    </div>
    @endif
</div>

<!-- FOOTER -->
<footer class="border-t border-gray-900 mt-20 px-16 py-12 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. ELITE GEAR ONLY.
</footer>

@include('components.chat-widget')

<script>
    lucide.createIcons();
</script>
</body>
</html>
