<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label #TRX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page { size: A6; margin: 0; }
        body { background: white; color: black; font-family: sans-serif; }
        .printable-area { width: 105mm; height: 148mm; margin: 0 auto; padding: 5mm; position: relative; border: 2px solid black; }
        @media print {
            body { background: none; }
            .no-print { display: none; }
            .printable-area { border: 2px solid black; }
        }
    </style>
</head>
<body class="bg-gray-200 py-10">

    <div class="printable-area bg-white shadow-2xl">
        <!-- Header -->
        <div class="flex justify-between items-center border-b-4 border-black pb-3 mb-4">
            <div>
                <h1 class="text-4xl font-black tracking-tighter">TFD</h1>
                <p class="text-[8px] font-black uppercase tracking-widest leading-none mt-1">Trif Factory Depok Originals</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase">Standard Shipping</p>
                <p class="text-lg font-black tracking-widest text-white bg-black px-2 mt-1">#{{ strtoupper($order->metode) }}</p>
            </div>
        </div>

        <!-- Order ID & Date -->
        <div class="flex justify-between mb-6">
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase">Transaction ID</p>
                <p class="text-sm font-black italic">TRX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[8px] font-black text-gray-400 uppercase">Booking Date</p>
                <p class="text-[10px] font-bold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Sender & Recipient -->
        <div class="grid grid-cols-1 gap-6 mb-6">
            <!-- RECIPIENT -->
            <div class="border-2 border-black p-3 relative">
                <span class="absolute -top-3 left-3 bg-white px-2 text-[10px] font-black uppercase italic">To: Penerima</span>
                <p class="text-xl font-black uppercase leading-tight">{{ $order->nama }}</p>
                <p class="text-sm font-bold mt-1 tracking-wider">{{ $order->hp }}</p>
                <p class="text-xs mt-2 leading-relaxed font-medium line-clamp-3 italic">{{ $order->alamat }}</p>
            </div>

            <!-- SENDER -->
            <div class="border border-black border-dashed p-3 relative opacity-80">
                <span class="absolute -top-3 left-3 bg-white px-2 text-[8px] font-bold uppercase tracking-widest">From: Pengirim</span>
                <p class="text-xs font-black uppercase">Trip Factory Depok (Official)</p>
                <p class="text-[10px] font-bold">Jl. Margonda Raya No. 12, Kota Depok</p>
                <p class="text-[10px] font-medium">+62 812-3456-7890</p>
            </div>
        </div>

        <!-- Courier & Resi -->
        <div class="border-4 border-black p-4 mb-4 flex flex-col items-center justify-center text-center">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-1">Kurir: {{ strtoupper($order->kurir) }}</p>
            <div class="w-full bg-black py-2 mb-2">
                <p class="text-white font-black text-xl tracking-[0.2em]">{{ $order->no_resi ?? 'NO RESI AVAILABLE' }}</p>
            </div>
            @if($order->no_resi)
                <div class="text-[10px] font-black flex items-center gap-2">
                    <div class="h-1 lg:w-48 bg-black"></div>
                    <span>SCAN ME</span>
                    <div class="h-1 lg:w-48 bg-black"></div>
                </div>
            @else
                <p class="text-[8px] font-bold uppercase italic text-gray-400">Tempel label resi resmi kurir di atas bagian ini</p>
            @endif
        </div>

        <!-- Order Summary (Small) -->
        <div class="border-t border-black pt-4">
            <p class="text-[8px] font-black text-gray-400 uppercase mb-2">Order Summary (For Warehouse):</p>
            <div class="space-y-1">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-[10px]">
                        <span class="font-bold truncate max-w-[200px]">{{ $item->product_name }}</span>
                        <span class="font-black italic">Qty: {{ $item->quantity }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Print Footer -->
        <div class="absolute bottom-4 left-0 right-0 text-center">
            <p class="text-[8px] font-black uppercase tracking-[0.5em] text-gray-300">Printed via TFD Premium System</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="no-print mt-10 flex justify-center gap-4">
        <button onclick="window.print()" class="bg-black text-white px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition shadow-xl">
            Print Shipping Label
        </button>
        <button onclick="window.close()" class="bg-white text-black border border-black px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 transition">
            Close Window
        </button>
    </div>

</body>
</html>
