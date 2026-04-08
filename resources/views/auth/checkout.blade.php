<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | TFD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #000; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="text-white min-h-screen">

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 px-10 py-6 flex justify-between items-center glass m-4 rounded-3xl">
    <h2 class="font-extrabold text-2xl tracking-tighter">TFD</h2>

    <div class="flex gap-8 text-[11px] font-black uppercase tracking-[0.2em] items-center">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-white transition">Beranda</a>
        <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-white transition">Katalog</a>
        <a href="{{ route('keranjang') }}" class="text-gray-500 hover:text-white transition">Keranjang</a>
        <a href="{{ route('pesanan-saya') }}" class="text-gray-500 hover:text-white transition whitespace-nowrap">Pesanan Saya</a>
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
    </div>
</nav>

<div class="max-w-xl mx-auto py-32 px-10">

    <h1 class="text-6xl font-black uppercase tracking-tighter leading-none mb-16 underline decoration-white/5 underline-offset-[20px]">Final Checkout</h1>

    @php
        $cart = session('cart', []);
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['qty'];
        }
    @endphp

    <!-- Total Tagihan -->
    <div class="bg-zinc-950 border border-white/5 p-12 rounded-[3.5rem] mb-12 shadow-2xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 blur-3xl -mr-24 -mt-24 transition-transform duration-700 group-hover:scale-125"></div>
        <p class="text-[10px] text-gray-700 uppercase font-black tracking-[0.4em] mb-4 relative z-10 font-bold">Total Pembayaran Anda</p>
        <h2 id="totalText" class="text-5xl font-black text-white relative z-10 tracking-tighter">Rp {{ number_format($total,0,',','.') }}</h2>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/5 border border-red-500/10 p-6 mb-10 text-[10px] text-red-500 rounded-3xl font-black uppercase tracking-widest text-center animate-pulse italic">
            ⚠ {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('checkout.proses') }}" method="POST" class="space-y-10">
        @csrf

        <div class="bg-zinc-950/50 border border-white/5 rounded-[3rem] p-10 space-y-10">
            <div>
                <label class="block text-[10px] font-black text-gray-700 uppercase tracking-widest mb-4">Nama Lengkap Penerima</label>
                <input name="nama" required value="{{ old('nama', $lastOrder->nama ?? Auth::user()->name) }}"
                       placeholder="Misal: John Doe" 
                       class="w-full bg-black border border-white/10 rounded-2xl p-5 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-700 uppercase tracking-widest mb-4">Nomor WhatsApp Aktif</label>
                <input name="hp" required value="{{ old('hp', Auth::user()->phone ?? ($lastOrder->hp ?? '')) }}"
                       placeholder="Contoh: 0812XXXXXXXX"
                       class="w-full bg-black border border-white/10 rounded-2xl p-5 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-700 uppercase tracking-widest mb-4">Alamat Tujuan Pengiriman</label>
                <textarea name="alamat" required placeholder="Jalan, Blok, Nomor, Kota..." rows="3"
                          class="w-full bg-black border border-white/10 rounded-2xl p-5 text-sm font-bold focus:outline-none focus:border-white transition-all placeholder-gray-800">{{ old('alamat', Auth::user()->address ?? ($lastOrder->alamat ?? '')) }}</textarea>
                @if(Auth::user()->address || isset($lastOrder))
                    <p class="text-[9px] text-emerald-500 mt-4 italic font-black uppercase tracking-widest">✓ Data terisi otomatis dari profil/pesanan terakhir Anda.</p>
                @endif
            </div>
        </div>

        <div class="pt-6">
            <p class="mb-4 text-[10px] font-black text-gray-700 uppercase tracking-[0.4em] text-center pb-2">Layanan Pengiriman Kargo</p>

            <div class="grid grid-cols-2 gap-4 mb-10">
                <label class="flex flex-col items-center gap-2 border border-white/5 p-6 rounded-3xl cursor-pointer hover:border-white transition-all group has-[:checked]:bg-emerald-500 has-[:checked]:text-black">
                    <input type="radio" name="kurir" value="GoSend SameDay - Rp 25.000" onchange="updateTotal(25000)" required class="sr-only">
                    <span class="text-[10px] font-black uppercase tracking-widest group-has-[:checked]:text-black">GoSend</span>
                    <span class="text-[9px] text-gray-500 group-has-[:checked]:text-white font-bold">Rp 25.000</span>
                </label>

                <label class="flex flex-col items-center gap-2 border border-white/5 p-6 rounded-3xl cursor-pointer hover:border-white transition-all group has-[:checked]:bg-emerald-500 has-[:checked]:text-black">
                    <input type="radio" name="kurir" value="JNE Reguler - Rp 15.000" onchange="updateTotal(15000)" class="sr-only">
                    <span class="text-[10px] font-black uppercase tracking-widest group-has-[:checked]:text-black">JNE</span>
                    <span class="text-[9px] text-gray-500 group-has-[:checked]:text-white font-bold">Rp 15.000</span>
                </label>

                <label class="flex flex-col items-center gap-2 border border-white/5 p-6 rounded-3xl cursor-pointer hover:border-white transition-all group has-[:checked]:bg-emerald-500 has-[:checked]:text-black">
                    <input type="radio" name="kurir" value="J&T Express - Rp 15.000" onchange="updateTotal(15000)" class="sr-only">
                    <span class="text-[10px] font-black uppercase tracking-widest group-has-[:checked]:text-black">J&T</span>
                    <span class="text-[9px] text-gray-500 group-has-[:checked]:text-white font-bold">Rp 15.000</span>
                </label>
                
                <label class="flex flex-col items-center gap-2 border border-white/5 p-6 rounded-3xl cursor-pointer hover:border-white transition-all group has-[:checked]:bg-emerald-500 has-[:checked]:text-black">
                    <input type="radio" name="kurir" value="SiCepat REG - Rp 12.000" onchange="updateTotal(12000)" class="sr-only">
                    <span class="text-[10px] font-black uppercase tracking-widest group-has-[:checked]:text-black">SiCepat</span>
                    <span class="text-[9px] text-gray-500 group-has-[:checked]:text-white font-bold">Rp 12.000</span>
                </label>
            </div>

            <p class="mb-4 text-[10px] font-black text-gray-700 uppercase tracking-[0.4em] text-center border-t border-white/10 pt-6 pb-2">Metode Pembayaran</p>
            <p class="mb-8 text-[10px] font-black text-gray-700 uppercase tracking-[0.4em] text-center border-b border-gray-900 pb-6">Metode Pembayaran</p>

            <div class="grid grid-cols-2 gap-8">
                <label class="flex flex-col items-center gap-4 border border-white/5 p-10 rounded-[2.5rem] cursor-pointer hover:border-white transition-all group has-[:checked]:bg-white has-[:checked]:text-black">
                    <input type="radio" name="metode" value="COD" required onchange="hideQR()" class="sr-only">
                    <span class="text-xs font-black uppercase tracking-[0.2em] group-has-[:checked]:text-black">C.O.D</span>
                    <span class="text-[9px] text-gray-700 group-has-[:checked]:text-black/60 italic lowercase font-bold">bayar di kurir</span>
                </label>

                <label class="flex flex-col items-center gap-4 border border-white/5 p-10 rounded-[2.5rem] cursor-pointer hover:border-white transition-all group has-[:checked]:bg-white has-[:checked]:text-black">
                    <input type="radio" name="metode" value="QRIS" onchange="showQR()" class="sr-only">
                    <span class="text-xs font-black uppercase tracking-[0.2em] group-has-[:checked]:text-black">QRIS / TRANSFER</span>
                    <span class="text-[9px] text-gray-700 group-has-[:checked]:text-black/60 italic lowercase font-bold">verifikasi manual</span>
                </label>
            </div>
        </div>

        <div id="qrisBox" class="hidden text-center bg-zinc-950 border border-white/5 p-10 rounded-[3rem] animate-pulse">
            <p class="text-[10px] mb-6 text-gray-500 font-black uppercase tracking-[0.3em]">Scan Barcode Pembayaran</p>
            <div class="bg-white p-4 rounded-3xl shadow-2xl inline-block mb-6">
                <img src="{{ asset('images/qris.jpg') }}" class="w-48 h-auto rounded-xl">
            </div>
            <p class="text-[9px] text-gray-700 italic font-black uppercase tracking-widest leading-relaxed">"Gugugaga! Pastikan nominal transfer sesuai dengan total tagihan."</p>
        </div>

        <button type="submit" 
                class="w-full bg-white text-black py-6 rounded-[2rem] font-black text-xs uppercase tracking-[0.5em] hover:bg-emerald-500 hover:text-white transition-all shadow-2xl active:scale-95 mt-10">
            KLIMAKS TRANSAKSI
        </button>

    </form>

</div>

<script>
    const subtotal = {{ $total }};

    function updateTotal(ongkir) {
        const totalBaru = subtotal + ongkir;
        document.getElementById('totalText').innerText = 'Rp ' + totalBaru.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function showQR(){
        document.getElementById('qrisBox').classList.remove('hidden')
    }
    function hideQR(){
        document.getElementById('qrisBox').classList.add('hidden')
    }
</script>

<!-- FOOTER -->
<footer class="border-t border-gray-900 mt-28 px-16 py-12 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. SECURE CHECKOUT LAYER.
</footer>

@include('components.chat-widget')
</body>
</html>