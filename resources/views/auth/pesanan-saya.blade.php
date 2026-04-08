<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | TFD</title>
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
        <a href="{{ route('wishlist') }}" class="text-gray-500 hover:text-white transition flex items-center gap-2">
            Wishlist
            @php $wishlistCount = auth()->user()->wishlistedProducts()->count(); @endphp
            @if($wishlistCount > 0)
                <span class="bg-emerald-500 text-black text-[9px] px-1.5 py-0.5 rounded-full font-black">{{ $wishlistCount }}</span>
            @endif
        </a>
        <a href="{{ route('keranjang') }}" class="text-gray-500 hover:text-white transition">Keranjang</a>
        <a href="{{ route('pesanan-saya') }}" class="text-white font-black whitespace-nowrap flex items-center gap-2">
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
    </div>
</nav>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 py-20">
    <h1 class="text-6xl font-black uppercase tracking-tighter mb-16 underline decoration-white/5 underline-offset-[20px]">Riwayat Pesanan</h1>

    @if($orders->count() > 0)
        <div class="space-y-16">
            @foreach($orders as $order)
                <div class="bg-zinc-950 border border-white/5 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 blur-3xl -mr-32 -mt-32 transition-transform duration-700 group-hover:scale-150"></div>
                    
                    <!-- Order Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-white/5 pb-10 mb-10 gap-6">
                        <div class="relative z-10">
                            <div class="flex items-center gap-6 mb-4">
                                <h3 class="text-2xl font-black text-white tracking-widest uppercase">#TRX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                @php
                                    $rawStatus = $order->status ?? 'Menunggu Pembayaran';
                                    if ($rawStatus == 'Selesai') {
                                        $statusColor = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                                        $statusText = 'BERHASIL SELESAI';
                                    } elseif ($rawStatus == 'Dikirim') {
                                        $statusColor = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                                        $statusText = 'DALAM PERJALANAN';
                                    } elseif ($rawStatus == 'Diproses') {
                                        $statusColor = 'bg-indigo-500/10 text-indigo-400 border-indigo-600/20';
                                        $statusText = 'SEDANG DIPROSES';
                                    } elseif ($rawStatus == 'Menunggu Verifikasi') {
                                        $statusColor = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                                        $statusText = 'MENUNGGU VERIFIKASI';
                                    } elseif ($rawStatus == 'Dibatalkan') {
                                        $statusColor = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
                                        $statusText = 'PESANAN DIBATALKAN';
                                    } else {
                                        $statusColor = 'bg-sky-500/10 text-sky-400 border-sky-500/20';
                                        $statusText = 'MENUNGGU PEMBAYARAN';
                                    }
                                @endphp
                                <span class="px-4 py-1 text-[10px] font-black rounded-full border {{ $statusColor }} tracking-[0.2em] uppercase">
                                    {{ $statusText }}
                                </span>
                            </div>
                            <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest italic">Tanggal Transaksi: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        
                        <div class="text-right relative z-10">
                            <p class="text-[10px] text-gray-600 tracking-[0.4em] mb-4 uppercase font-black font-bold">Total Pembayaran</p>
                            <p class="text-4xl font-black text-white tracking-tighter">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Order Details Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 mb-10 relative z-10">
                        <!-- ITEMS -->
                        <div class="lg:col-span-2">
                            <h4 class="text-[10px] text-gray-700 font-black tracking-[0.3em] mb-8 uppercase border-l-2 border-gray-800 pl-4">Daftar Barang</h4>
                            <div class="space-y-6">
                                @forelse($order->items as $item)
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white/5 p-8 rounded-[2rem] border border-white/5 hover:border-white/10 transition-all gap-6">
                                        <div class="flex-1">
                                            <p class="text-lg font-bold text-gray-200 uppercase tracking-tight mb-1">{{ $item->product_name }}</p>
                                            <p class="text-[10px] text-gray-600 font-black tracking-widest">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            
                                            @if($rawStatus == 'Selesai')
                                                <div class="mt-4 pt-4 border-t border-white/5">
                                                    @if($item->rating)
                                                        <div class="flex items-center gap-2 mb-2">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <svg class="w-3 h-3 {{ $i <= $item->rating ? 'text-amber-400' : 'text-gray-800' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                        <p class="text-[10px] text-gray-400 italic tracking-wide leading-relaxed">"{{ $item->review }}"</p>
                                                    @else
                                                        <div class="mt-2">
                                                            <button onclick="openReviewModal({{ $item->id }}, '{{ addslashes($item->product_name) }}')" class="px-6 py-2 bg-rose-500 text-white text-[9px] font-black tracking-[0.2em] uppercase rounded-full shadow-lg shadow-rose-500/30 hover:bg-rose-600 hover:scale-105 transition-all animate-pulse">
                                                                ! BELUM DIULAS - KLIK DISINI
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-xl font-black text-white italic tracking-tighter sm:text-right">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-700 italic">"Tidak ada detail barang."</p>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- SHIPPING -->
                        <div>
                            <h4 class="text-[10px] text-gray-700 font-black tracking-[0.3em] mb-8 uppercase border-l-2 border-gray-800 pl-4">Lacak Pengiriman</h4>
                            <div class="bg-white/5 p-8 rounded-3xl border border-white/5 space-y-6">
                                <div>
                                    <p class="text-[10px] text-gray-600 uppercase font-black tracking-widest mb-2">Penerima Utama</p>
                                    <p class="text-sm text-gray-200 font-bold uppercase tracking-tight">{{ $order->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-600 uppercase font-black tracking-widest mb-2">Informasi Kontak</p>
                                    <p class="text-sm text-gray-200 font-bold italic tracking-wider">{{ $order->hp }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-600 uppercase font-black tracking-widest mb-2">Alamat Tujuan</p>
                                    <p class="text-xs text-gray-400 leading-relaxed italic">{{ $order->alamat }}</p>
                                </div>
                                <div class="pt-6 border-t border-white/5 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] text-gray-600 uppercase font-black tracking-widest mb-2">Layanan Pengiriman</p>
                                        <p class="text-[10px] text-emerald-500 font-black tracking-widest uppercase">{{ $order->kurir ?? 'Standard TFD Logistics' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-600 uppercase font-black tracking-widest mb-2">Estimasi Tiba</p>
                                        <p class="text-[10px] text-amber-500 font-black tracking-widest uppercase">{{ $order->created_at->addDays(2)->format('d M') }} - {{ $order->created_at->addDays(4)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION SECTION -->
                    <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-10 relative z-10">
                        @if($order->metode !== 'COD' && $rawStatus == 'Menunggu Pembayaran')
                            <div class="flex-1">
                                <h4 class="text-[10px] text-emerald-500 font-black tracking-[0.3em] mb-4 uppercase">Instruksi Pembayaran Digital</h4>
                                <div class="flex flex-col sm:flex-row gap-8 items-start sm:items-center">
                                    <div class="bg-white p-3 rounded-2xl shadow-2xl max-w-[120px]">
                                        <img src="{{ asset('images/qris.jpg') }}" class="w-full h-auto rounded-lg">
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-4">
                                            <span class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-[10px] font-black italic text-emerald-500">1</span>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Scan QRIS TFD Originals.</p>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-[10px] font-black italic text-emerald-500">2</span>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Screenshot bukti bayar Anda.</p>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-[10px] font-black italic text-emerald-500">3</span>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Unggah segera melalui tombol "UP-BUKTI".</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex-1">
                                <p class="text-[10px] text-gray-700 font-black tracking-[0.2em] italic uppercase">"Konfirmasi pesanan telah tercatat di sistem TFD."</p>
                            </div>
                        @endif

                        <div class="flex gap-4 items-center">
                            @if(($order->status === 'Menunggu Pembayaran') || ($order->status === 'Menunggu Verifikasi' && $order->metode === 'COD'))
                                <button onclick="cancelOrder({{ $order->id }})" class="px-8 py-3 rounded-full text-[10px] font-black tracking-widest border border-rose-500/20 text-red-500 hover:bg-red-500/10 transition-all uppercase">
                                    Batalkan Pesanan
                                </button>
                            @endif

                            @if($order->metode !== 'COD' && $rawStatus == 'Menunggu Pembayaran')
                                <button onclick="openUploadModal({{ $order->id }})" class="bg-white text-black px-10 py-4 rounded-full text-[10px] font-black tracking-[0.2em] hover:bg-emerald-500 hover:text-white transition-all shadow-xl active:scale-95 uppercase">
                                    Upload Bukti Bayar
                                </button>
                            @endif

                            @if($rawStatus == 'Dikirim')
                                <button onclick="receiveOrder({{ $order->id }})" class="bg-emerald-500 text-black px-10 py-4 rounded-full text-[10px] font-black tracking-[0.2em] hover:bg-white hover:text-black transition-all shadow-xl shadow-emerald-500/20 active:scale-95 uppercase animate-bounce mt-4 sm:mt-0">
                                    <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> PESANAN DITERIMA</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-40 text-center glass rounded-[4rem] border-dashed border-white/5">
            <p class="text-gray-600 font-black uppercase tracking-[0.3em] mb-12 italic text-xl">"Anda belum pernah melakukan transaksi."</p>
            <a href="{{ route('katalog') }}" class="bg-white text-black px-16 py-6 rounded-full font-black text-xs uppercase tracking-[0.4em] hover:bg-emerald-500 hover:text-white transition-all shadow-2xl active:scale-95">
                MULAI BELANJA
            </a>
        </div>
    @endif
</div>

<!-- FOOTER -->
<footer class="border-t border-gray-900 mt-20 px-16 py-10 text-[10px] text-gray-700 font-black tracking-[0.4em] text-center uppercase">
    © 2026 TRIP FACTORY DEPOK. TRANSACTION HISTORY RESERVED.
</footer>

<!-- MODAL UPLOAD BUKTI -->
<div id="modalUpload" class="fixed inset-0 z-[60] hidden bg-black/90 backdrop-blur-3xl flex items-center justify-center p-6">
    <div class="bg-zinc-950 border border-white/5 w-full max-w-lg rounded-[3rem] p-12 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-32 h-32 bg-emerald-500/5 blur-3xl -ml-16 -mt-16"></div>
        <h2 class="text-3xl font-black uppercase tracking-tighter mb-4">Verifikasi Bayar</h2>
        <p class="text-[10px] text-gray-600 font-black uppercase tracking-widest italic mb-10 border-l-2 border-emerald-500 pl-4">Gugugaga! Lampirkan bukti transfer eksklusif Anda.</p>

        <form id="formUpload" method="POST" enctype="multipart/form-data" class="space-y-8" onsubmit="handleUpload(event)">
            @csrf
            
            <div class="relative">
                <input type="file" name="bukti_pembayaran" id="buktiInput" class="hidden" accept="image/*" required 
                       onchange="document.getElementById('fileName').innerText = this.files[0].name ? this.files[0].name : 'Pilih File Bukti'">
                <div onclick="document.getElementById('buktiInput').click()" 
                     class="w-full h-48 border-2 border-dashed border-white/5 rounded-3xl flex flex-col items-center justify-center cursor-pointer hover:border-emerald-500 group transition-all">
                    <p id="fileName" class="text-[10px] text-gray-500 font-black uppercase tracking-widest group-hover:text-emerald-500">Pilih File Bukti</p>
                    <p class="text-[9px] text-gray-700 mt-2 italic">(JPG, PNG, atau WEBP)</p>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 border border-white/10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">
                    BATAL
                </button>
                <button type="submit" class="flex-1 bg-white text-black py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all shadow-xl">
                    KIRIM VERIFIKASI
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL REVIEW -->
<div id="modalReview" class="fixed inset-0 z-[60] hidden bg-black/90 backdrop-blur-3xl flex items-center justify-center p-6">
    <div class="bg-zinc-950 border border-white/5 w-full max-w-lg rounded-[3rem] p-12 shadow-2xl relative overflow-hidden text-center">
        <div class="absolute top-0 left-0 w-32 h-32 bg-amber-500/5 blur-3xl -ml-16 -mt-16"></div>
        <h2 class="text-3xl font-black uppercase tracking-tighter mb-4 italic">Beri Ulasan</h2>
        <p id="reviewProductName" class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-10">Product Name</p>

        <!-- Stars -->
        <div class="flex justify-center gap-4 mb-10">
            @for($i = 1; $i <= 5; $i++)
                <button onclick="setRating({{ $i }})" class="star-btn p-1 group transition-transform hover:scale-125" data-value="{{ $i }}">
                    <svg class="w-10 h-10 text-gray-800 transition-colors pointer-events-none" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
            @endfor
        </div>

        <form id="formReview" onsubmit="handleReviewSubmit(event)" class="space-y-8 text-left">
            @csrf
            <input type="hidden" name="item_id" id="reviewItemId">
            <input type="hidden" name="rating" id="ratingInput" value="0">
            
            <div class="space-y-4">
                <label class="text-[10px] text-gray-600 font-black uppercase tracking-[0.2em] ml-4">Testimoni Eksklusif</label>
                <textarea name="review" class="w-full bg-white/5 border border-white/5 rounded-3xl p-6 text-sm text-gray-200 focus:outline-none focus:border-amber-500/50 transition-all min-h-[120px] placeholder:text-gray-800" placeholder="Ceritakan pengalaman Anda menggunakan produk TFD..."></textarea>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeReviewModal()" class="flex-1 border border-white/10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">
                    BATAL
                </button>
                <button type="submit" class="flex-1 bg-amber-400 text-black py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-white transition-all shadow-xl shadow-amber-500/10">
                    KIRIM TESTIMONI
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUploadModal(id) {
        const form = document.getElementById('formUpload');
        form.action = `/pesanan/upload-bukti/${id}`;
        document.getElementById('modalUpload').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalUpload').classList.add('hidden');
    }

    function handleUpload(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        
        submitBtn.disabled = true;
        submitBtn.innerText = 'MENGIRIM...';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => {
            if(res.success) {
                alert('Gugugaga! Bukti berhasil diunggah. Menunggu verifikasi tim TFD.');
                window.location.reload();
            } else {
                alert('Error: ' + res.message);
                submitBtn.disabled = false;
                submitBtn.innerText = 'KIRIM VERIFIKASI';
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan koneksi.');
            submitBtn.disabled = false;
            submitBtn.innerText = 'KIRIM VERIFIKASI';
        });
    }

    function cancelOrder(id) {
        if (confirm('Gugugaga! Yakin ingin membatalkan pesanan eksklusif ini?')) {
            fetch(`/pesanan/batalkan/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            }).then(r => r.json()).then(res => {
                alert(res.message);
                if(res.success) window.location.reload();
            });
        }
    }

    function receiveOrder(id) {
        if (confirm('Konfirmasi bahwa Anda telah menerima pesanan ini dengan baik?')) {
            fetch(`/pesanan/terima/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            }).then(r => r.json()).then(res => {
                alert(res.message);
                if(res.success) window.location.reload();
            });
        }
    }

    // REVIEW LOGIC
    function openReviewModal(itemId, productName) {
        document.getElementById('reviewItemId').value = itemId;
        document.getElementById('reviewProductName').innerText = productName;
        document.getElementById('modalReview').classList.remove('hidden');
        setRating(0);
    }

    function closeReviewModal() {
        document.getElementById('modalReview').classList.add('hidden');
    }

    function setRating(val) {
        document.getElementById('ratingInput').value = val;
        const stars = document.querySelectorAll('.star-btn svg');
        stars.forEach((star, index) => {
            if (index < val) {
                star.classList.remove('text-gray-800');
                star.classList.add('text-amber-400');
            } else {
                star.classList.remove('text-amber-400');
                star.classList.add('text-gray-800');
            }
        });
    }

    function handleReviewSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const itemId = document.getElementById('reviewItemId').value;
        const rating = document.getElementById('ratingInput').value;
        
        if (rating == 0) {
            alert('Gugugaga! Pilih rating bintang terlebih dahulu.');
            return;
        }

        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerText = 'MENYIMPAN...';

        fetch(`/pesanan/review/${itemId}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => {
            if(res.success) {
                alert(res.message);
                window.location.reload();
            } else {
                alert('Error: ' + res.message);
                submitBtn.disabled = false;
                submitBtn.innerText = 'KIRIM TESTIMONI';
            }
        });
    }
</script>

@include('components.chat-widget')
</body>
</html>
