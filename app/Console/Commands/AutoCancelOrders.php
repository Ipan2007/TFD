<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoCancelOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-cancel';
    protected $description = 'Membatalkan pesanan yang sudah melewati batas waktu pembayaran';

    public function handle()
    {
        $expiredOrders = \App\Models\Order::where('status', 'Menunggu Pembayaran')
            ->where('expired_at', '<', now())
            ->get();

        foreach ($expiredOrders as $order) {
            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->increment('stok', $item->quantity);
                }
            }
            $order->update(['status' => 'Dibatalkan']);
            $this->info("Order #{$order->id} telah dibatalkan otomatis.");
        }

        $this->info('Proses pembatalan otomatis selesai.');
    }
}
