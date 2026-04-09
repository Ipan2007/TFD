<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #TRX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; color: black; }
        }
    </style>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white p-10 shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="flex justify-between items-start border-b pb-8 mb-8">
            <div>
                <h1 class="text-4xl font-black tracking-tighter text-blue-600 mb-2">TFD</h1>
                <p class="text-xs text-gray-500 uppercase font-bold">Trif Factory Depok Originals</p>
                <p class="text-[10px] text-gray-400 mt-1 italic">Est. 2026 - Premium E-Commerce</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-black uppercase tracking-widest text-gray-800">INVOICE</h2>
                <p class="text-sm font-mono text-blue-500 font-bold">#TRX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[10px] text-gray-500 mt-2 uppercase">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-10 mb-10">
            <div>
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Ditagih Kepada:</h3>
                <p class="font-bold text-gray-800 uppercase">{{ $order->nama }}</p>
                <p class="text-xs text-gray-600 mt-1 italic">{{ $order->hp }}</p>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">{{ $order->alamat }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Metode & Pengiriman:</h3>
                <p class="text-sm font-bold text-gray-800 uppercase">{{ $order->metode }}</p>
                <p class="text-xs text-gray-600 mt-1 uppercase">{{ $order->kurir ?? 'TFD Logistics' }}</p>
                @if($order->no_resi)
                    @php
                        $courier = strtoupper($order->kurir);
                        $trackingUrl = "https://www.cekresi.com/?noresi=" . $order->no_resi;
                        
                        if(str_contains($courier, 'JNE')) $trackingUrl = "https://www.jne.co.id/en/tracking/trace";
                        elseif(str_contains($courier, 'J&T')) $trackingUrl = "https://www.jet.co.id/track";
                        elseif(str_contains($courier, 'SICEPAT')) $trackingUrl = "https://www.sicepat.com/checkresi";
                    @endphp
                    <p class="text-[10px] text-blue-500 font-black mt-2 uppercase">
                        RESI: <a href="{{ $trackingUrl }}" target="_blank" class="underline">{{ $order->no_resi }}</a>
                    </p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-10">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-y text-[10px] font-black uppercase tracking-widest">
                        <th class="py-4 px-2">Barang</th>
                        <th class="py-4 px-2 text-center">Qty</th>
                        <th class="py-4 px-2 text-right">Harga</th>
                        <th class="py-4 px-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="py-4 px-2">
                            <p class="font-bold text-gray-800 uppercase tracking-tight">{{ $item->product_name }}</p>
                            <p class="text-[9px] text-gray-400 italic">{{ $item->product->brand ?? 'TFD Collective' }}</p>
                        </td>
                        <td class="py-4 px-2 text-center text-gray-600">{{ $item->quantity }}</td>
                        <td class="py-4 px-2 text-right text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="py-4 px-2 text-right font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="flex justify-end">
            <div class="w-64 space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 font-bold uppercase">Subtotal:</span>
                    <span class="text-gray-800 font-bold">Rp {{ number_format($order->total - $order->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 font-bold uppercase">Ongkos Kirim:</span>
                    <span class="text-gray-800 font-bold">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t-2 border-gray-100">
                    <span class="text-sm font-black text-gray-800 uppercase">Total:</span>
                    <span class="text-xl font-black text-blue-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-20 pt-10 border-t border-dashed text-center">
            <p class="text-[10px] text-gray-400 italic">"Terima kasih telah mempercayakan gaya Anda pada TFD Originals."</p>
            <p class="text-[9px] font-black text-gray-600 mt-2 uppercase tracking-[0.2em]">Dokumen ini adalah bukti transaksi resmi yang dihasilkan secara otomatis oleh sistem TFD.</p>
        </div>

        <!-- Print Button -->
        <div class="mt-10 flex justify-center no-print">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-full text-xs font-black uppercase tracking-widest transition shadow-xl shadow-blue-500/20 flex items-center gap-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                CETAK INVOICE
            </button>
        </div>
    </div>
</body>
</html>
