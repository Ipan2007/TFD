<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang | TFD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
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
            <a href="{{ route('keranjang') }}" class="text-white">Keranjang</a>
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

<!-- CONTENT -->
<div class="max-w-6xl mx-auto px-6 py-20">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-10 p-6 bg-emerald-500/5 border border-emerald-500/10 text-emerald-400 text-xs font-black tracking-widest rounded-3xl uppercase text-center animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-10 p-6 bg-red-500/5 border border-red-500/10 text-red-500 text-xs font-black tracking-widest rounded-3xl uppercase text-center animate-pulse">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-6xl font-black uppercase tracking-tighter mb-16">Keranjang Belanja</h1>

    @php
        $cart = session('cart', []);
        $grandTotal = 0;
    @endphp

    @if(count($cart) > 0)

        <!-- TABLE HEADER -->
        <div class="grid grid-cols-12 text-[10px] text-gray-600 font-black tracking-[0.4em] border-b border-white/5 pb-6 mb-10 uppercase">
            <div class="col-span-6">PRODUK</div>
            <div class="col-span-2 text-right">HARGA</div>
            <div class="col-span-2 text-center">KUANTITAS</div>
            <div class="col-span-2 text-right">TOTAL</div>
        </div>

        <div class="space-y-12">
        @foreach($cart as $id => $item)

            @php
                $total = $item['price'] * $item['qty'];
                $grandTotal += $total;
            @endphp

            <div class="grid grid-cols-12 items-center group">

                <div class="col-span-6 flex items-center gap-10">
                    <img src="{{ str_starts_with($item['image'], 'images/') ? asset($item['image']) : asset('storage/' . $item['image']) }}"
                         class="w-32 h-40 object-cover rounded-3xl border border-white/5 group-hover:border-white/20 transition-all duration-500">

                    <div>
                        <h3 class="text-xl font-bold tracking-tight mb-2 uppercase">{{ $item['name'] }}</h3>
                        <p class="text-[10px] text-gray-500 font-black tracking-widest mb-6 uppercase italic">Size: {{ $item['size'] ?? 'Universal' }}</p>

                        <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-[10px] font-black text-gray-600 hover:text-red-500 uppercase tracking-widest underline underline-offset-8 transition-colors">
                                HAPUS ITEM
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-span-2 text-right text-gray-400 font-bold">
                    Rp {{ number_format($item['price'],0,',','.') }}
                </div>

                <div class="col-span-2 text-center">
                    <div class="flex items-center justify-center gap-6">
                        <form action="{{ route('keranjang.update', $id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="minus">
                            <button class="w-10 h-10 flex items-center justify-center border border-white/10 rounded-xl hover:bg-white hover:text-black transition-all">-</button>
                        </form>
                        
                        <span class="font-black text-lg w-6 text-center">{{ $item['qty'] }}</span>

                        <form action="{{ route('keranjang.update', $id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="plus">
                            <button class="w-10 h-10 flex items-center justify-center border border-white/10 rounded-xl hover:bg-white hover:text-black transition-all">+</button>
                        </form>
                    </div>
                </div>

                <div class="col-span-2 text-right font-black text-xl tracking-tight">
                    Rp {{ number_format($total,0,',','.') }}
                </div>

            </div>

        @endforeach
        </div>

        <!-- TOTAL -->
        <div class="mt-20 pt-16 border-t border-white/5">

            <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-10">
                <div>
                    <p class="text-[10px] text-gray-600 font-black tracking-[0.4em] uppercase mb-4">Total Pesanan</p>
                    <h2 class="text-6xl font-black tracking-tighter">
                        Rp {{ number_format($grandTotal,0,',','.') }}
                    </h2>
                </div>

                <div class="flex flex-col items-end gap-6">
                    <div class="text-right">
                        <p class="text-[10px] text-gray-500 italic mb-1 uppercase tracking-widest font-black">Refined Streetwear Delivery</p>
                        <p class="text-[9px] text-gray-700 uppercase tracking-[0.3em]">Final cost inc. tax & shipping during checkout.</p>
                    </div>

                    <div class="flex gap-6">
                        <a href="{{ route('katalog') }}"
                           class="border border-white/10 px-10 py-5 rounded-full text-xs font-black tracking-widest hover:border-white transition-all">
                           KONTINU BELANJA
                        </a>

                        <a href="{{ route('checkout') }}"
                           class="bg-white text-black px-12 py-5 rounded-full text-xs font-black tracking-widest hover:bg-emerald-500 hover:text-white transition-all shadow-2xl shadow-white/5 active:scale-95 uppercase">
                           PROSES CHECKOUT
                        </a>
                    </div>
                </div>
            </div>

        </div>

    @else

        <div class="py-32 text-center bg-white/5 border border-dashed border-white/5 rounded-[4rem]">
            <p class="text-gray-600 italic font-medium uppercase tracking-widest mb-10 text-xl">Keranjang Anda masih kosong.</p>
            <a href="{{ route('katalog') }}"
               class="bg-white text-black px-12 py-5 rounded-full text-xs font-black uppercase tracking-[0.3em] hover:bg-emerald-500 hover:text-white transition-all shadow-2xl active:scale-95">
               MULAI BELANJA
            </a>
        </div>

    @endif

</div>

<!-- FOOTER -->
<footer class="border-t border-gray-900 mt-20 px-16 py-12 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. ELITE GEAR ONLY.
</footer>

@include('components.chat-widget')
</body>
</html>