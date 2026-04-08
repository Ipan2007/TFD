<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | TFD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #000; }
        .glass { background: rgba(20, 20, 20, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="text-white min-h-screen flex items-center justify-center p-4">

    @php
        $order = \App\Models\Order::find(session('order_id'));
    @endphp

    <div class="max-w-2xl w-full">
        <!-- SUCCESS HEADER -->
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-emerald-500/30 shadow-[0_0_40px_rgba(16,185,129,0.2)]">
                <i data-lucide="check-circle-2" class="w-10 h-10 text-emerald-500"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tight mb-2 uppercase">Pesanan Diterima!</h1>
            <p class="text-gray-500 text-sm tracking-widest font-bold uppercase">ID Order: #TRX-{{ str_pad($order->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        @if($order)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <!-- LEFT: ORDER DETAILS -->
                <div class="glass p-8 rounded-3xl space-y-6">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">Total Tagihan</p>
                        <h2 class="text-3xl font-black text-emerald-400">Rp {{ number_format($order->total, 0, ',', '.') }}</h2>
                    </div>

                    <div class="pt-6 border-t border-white/5 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Estimasi Tiba</span>
                            <span class="text-[10px] font-black text-amber-500 bg-amber-500/10 border border-amber-500/20 px-2 py-1 rounded uppercase tracking-widest flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i> {{ $order->created_at->addDays(2)->format('d M') }} - {{ $order->created_at->addDays(4)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Metode</span>
                            <span class="text-xs font-bold uppercase tracking-wider">{{ $order->metode }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">Nama</span>
                            <span class="text-xs font-bold">{{ $order->nama }}</span>
                        </div>
                    </div>

                    @if($order->metode == 'COD')
                        <div class="p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl mt-6">
                            <div class="flex gap-3">
                                <i data-lucide="truck" class="w-5 h-5 text-blue-400"></i>
                                <p class="text-[10px] text-blue-300 leading-relaxed font-bold">Pesanan COD akan langsung diproses. Silakan siapkan uang tunai saat kurir tiba.</p>
                            </div>
                        </div>
                    @else
                        <!-- PAYMENT STEPS MINI -->
                        <div class="space-y-3 pt-6 border-t border-white/5">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-[0.2em] mb-2">Instruksi Pembayaran</p>
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 bg-gray-800 rounded-full flex items-center justify-center text-[9px] font-black italic">1</span>
                                <p class="text-[10px] text-gray-300">Scan QRIS / Screenshot QR Code.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 bg-gray-800 rounded-full flex items-center justify-center text-[9px] font-black italic">2</span>
                                <p class="text-[10px] text-gray-300">Bayar nominal <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 bg-gray-800 rounded-full flex items-center justify-center text-[9px] font-black italic">3</span>
                                <p class="text-[10px] text-gray-300">Unggah bukti bayar di tombol bawah.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- RIGHT: QRIS ACTION -->
                @if($order->metode !== 'COD')
                    <div class="glass p-8 rounded-3xl flex flex-col items-center justify-center text-center">
                        <div class="bg-white p-4 rounded-2xl shadow-2xl mb-4 max-w-[200px]">
                            <img src="{{ asset('images/qris.jpg') }}" alt="Scan QRIS" class="w-full h-auto rounded-lg">
                        </div>
                        <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-6">Scan to Pay via QRIS</p>
                        
                        <a href="{{ route('pesanan-saya') }}" 
                           class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] transition-all shadow-lg shadow-emerald-900/30 group active:scale-95 flex items-center justify-center gap-2">
                            <span>Konfirmasi Bayar</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                @else
                    <div class="glass p-8 rounded-3xl flex flex-col items-center justify-center text-center space-y-6">
                        <div class="w-20 h-20 bg-blue-500/10 rounded-full flex items-center justify-center border border-blue-500/20">
                            <i data-lucide="package-check" class="w-10 h-10 text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black uppercase tracking-tight">Siap Dikirim</h3>
                            <p class="text-xs text-gray-500 font-bold mt-2 leading-relaxed">Admin akan segera menghubungi Anda untuk konfirmasi pesanan.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" 
                           class="w-full bg-white text-black py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] transition-all hover:bg-gray-200 active:scale-95">
                            Belanja Lagi
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="glass p-12 rounded-3xl text-center">
                <p class="text-gray-400 font-bold">Gugugaga! Data pesanan tidak ditemukan.</p>
                <a href="{{ route('dashboard') }}" class="mt-6 inline-block text-emerald-500 font-black uppercase tracking-widest text-xs border-b border-emerald-500 pb-1">Kembali ke Beranda</a>
            </div>
        @endif

        @if($order && $order->metode !== 'COD')
        <div class="text-center">
             <a href="{{ route('profil') }}" class="flex items-center justify-center gap-2 text-gray-500 hover:text-white transition group text-[10px] font-black uppercase tracking-[0.3em]">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-5 h-5 rounded-full object-cover border border-white/10 group-hover:border-white/30 transition-all">
                @else
                    <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center text-[8px] font-black group-hover:bg-white/20 transition-all">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                Profil
            </a>
        </div>
        @endif
    </div>

    <script>
        lucide.createIcons();
    </script>
@include('components.chat-widget')
</body>
</html>