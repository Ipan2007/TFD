<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | TFD</title>
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
<nav class="fixed top-0 left-0 right-0 z-50 px-10 py-6 flex justify-between items-center glass m-4 rounded-3xl">
    <h2 class="font-extrabold text-2xl tracking-tighter">TFD</h2>

    <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.2em] items-center">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-white transition">Beranda</a>
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
        @else
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-white transition">Login</a>
            <a href="{{ route('register') }}" class="bg-white text-black px-6 py-2 rounded-xl border border-white/5 hover:bg-emerald-500 hover:text-white transition-all ml-4 scale-90">DAFTAR</a>
        @endauth
    </div>
</nav>

<!-- DETAIL CONTENT -->
<div class="px-16 py-20 grid grid-cols-1 md:grid-cols-2 gap-24 max-w-7xl mx-auto">

    <!-- GAMBAR -->
    <div class="relative group">
        <div class="bg-zinc-950 rounded-[3rem] overflow-hidden border border-white/5 shadow-2xl">
            <img src="{{ str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image) }}"
                 class="w-full h-[700px] object-cover transition-transform duration-700 group-hover:scale-105">
        </div>
    </div>

    <!-- INFO -->
    <div class="flex flex-col justify-center">

        <p class="text-[10px] text-gray-600 font-black uppercase tracking-[0.4em] mb-4">
            Katalog Produk / {{ $product->brand ?? 'TFD Originals' }}
        </p>

        <h1 class="text-6xl font-black uppercase tracking-tighter mb-6 leading-none">
            {{ $product->name }}
        </h1>

        <p class="text-3xl font-light text-gray-400 mb-10 tracking-tight">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>

        <p class="text-xs text-gray-500 mb-10 uppercase tracking-widest font-black flex items-center gap-3">
            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full {{ $product->stok <= 0 ? 'bg-red-500 animate-pulse' : '' }}"></span>
            Status Stok: <span class="{{ $product->stok <= 0 ? 'text-red-500' : 'text-white' }}">{{ $product->stok > 0 ? $product->stok . ' Tersedia' : 'HABIS' }}</span>
        </p>

        @if($product->stok > 0)
        <!-- FORM TAMBAH KERANJANG -->
        <form action="{{ route('keranjang.tambah', $product->id) }}" method="POST" class="space-y-10">
            @csrf

            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Pilih Ukuran Utama</label>
                <div class="flex gap-4">
                    @foreach(['S', 'M', 'L', 'XL'] as $size)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="size" value="{{ $size }}" class="peer sr-only" {{ $size == 'L' ? 'checked' : '' }} required>
                            <span class="w-16 h-16 flex items-center justify-center border border-white/10 rounded-2xl text-xs font-black peer-checked:bg-white peer-checked:text-black hover:border-white transition-all">
                                {{ $size }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-white text-black py-6 rounded-3xl text-xs font-black uppercase tracking-[0.4em] hover:bg-emerald-500 hover:text-white transition-all shadow-2xl active:scale-95">
                    TAMBAH KE KERANJANG
                </button>
                
                @auth
                    @php 
                        $isWishlisted = auth()->user()->wishlistedProducts()->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="button" 
                            onclick="event.preventDefault(); document.getElementById('wishlist-form').submit();"
                            class="w-20 h-20 rounded-3xl {{ $isWishlisted ? 'bg-emerald-500 text-black' : 'border border-white/10 text-white' }} flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-xl">
                        <i data-lucide="heart" class="w-6 h-6 {{ $isWishlisted ? 'fill-current' : '' }}"></i>
                    </button>
                    <form id="wishlist-form" action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endauth
            </div>
        </form>
        @else
        <div class="bg-red-600/5 border border-red-600/20 p-8 rounded-[2rem] text-center">
            <p class="text-red-500 font-black tracking-widest uppercase text-sm mb-2">Item Terjual Habis</p>
            <p class="text-[10px] text-gray-600 italic">"Kami sedang bekerja keras untuk restok koleksi ini."</p>
        </div>
        @endif

        <div class="mt-16 pt-10 border-t border-white/5">
            <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Deskripsi Produk</h4>
            <p class="text-sm text-gray-500 leading-loose italic max-w-lg">
                "{{ $product->description }}"
            </p>
        </div>

    </div>
</div>

<!-- REVIEWS SECTION -->
<div class="max-w-7xl mx-auto px-6 py-24 border-t border-white/5">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
        <div>
            <h2 class="text-4xl font-black uppercase tracking-tighter mb-4 italic underline decoration-amber-500/20 underline-offset-8">Testimoni Eksklusif</h2>
            <p class="text-[10px] text-gray-600 font-black uppercase tracking-[0.3em] pl-1 border-l-2 border-emerald-500 ml-1">Suara dari mereka yang sudah mengenakan TFD.</p>
        </div>
        <div class="text-right">
            <p class="text-6xl font-black text-white tracking-tighter">{{ number_format($reviews->avg('rating'), 1) }}</p>
            <div class="flex justify-end gap-1 mt-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-3 h-3 {{ $i <= round($reviews->avg('rating')) ? 'text-amber-400' : 'text-gray-800' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
            </div>
            <p class="text-[10px] text-gray-700 font-black uppercase tracking-widest mt-2">{{ $reviews->count() }} ULASAN MASUK</p>
        </div>
    </div>

    @if($reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($reviews as $review)
                <div class="bg-white/5 border border-white/5 p-10 rounded-[3rem] hover:border-white/10 transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 blur-3xl -mr-12 -mt-12 group-hover:bg-amber-400/5 transition-colors"></div>
                    
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-[10px] text-emerald-500 font-black uppercase tracking-widest mb-1">{{ substr($review->order->user->name, 0, 1) }}***{{ substr($review->order->user->name, -1) }}</p>
                            <p class="text-[9px] text-gray-700 italic uppercase">{{ $review->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-2 h-2 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-800' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-400 leading-relaxed italic">
                        "{{ $review->review }}"
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-20 text-center bg-white/5 border border-dashed border-white/5 rounded-[3rem]">
            <p class="text-[10px] text-gray-700 font-black uppercase tracking-[0.4em]">Belum ada ulasan untuk produk ini.</p>
        </div>
    @endif
</div>

<!-- FOOTER -->
<footer class="border-t border-gray-900 mt-20 px-16 py-12 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. QUALITY ENSURED.
</footer>

@include('components.chat-widget')

<script>
    lucide.createIcons();
</script>
</body>
</html>