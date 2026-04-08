<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use App\Models\Order;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WishlistController;

/* ================= REDIRECT AWAL ================= */

Route::get('/', function () {
    return redirect()->route('dashboard');
});

    /* ================= AREA PUBLIK (Katalog & Detail) ================= */

    Route::get('/dashboard', function (Request $request) {
        $search = $request->query('search');
        $query = Product::latest();
        
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('brand', 'LIKE', "%{$search}%");
        }
        
        $products = $query->withAvg('orderItems', 'rating')->get();
        return view('auth.dashboard', compact('products'));
    })->name('dashboard');

    Route::get('/katalog', function (Request $request) {
        $search = $request->query('search');
        $query = Product::query();
        
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('brand', 'LIKE', "%{$search}%");
        }
        
        $products = $query->withAvg('orderItems', 'rating')->get();
        return view('auth.katalog', compact('products', 'search'));
    })->name('katalog');

    Route::get('/detail/{product}', function (Product $product) {
        $reviews = \App\Models\OrderItem::where('product_id', $product->id)
            ->whereNotNull('rating')
            ->with('order.user')
            ->latest()
            ->get();
        return view('auth.detail', compact('product', 'reviews'));
    })->name('detail');

/* ================= AUTH (Guest Only) ================= */

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

});


/* ================= AREA LOGIN ================= */

Route::middleware('auth')->group(function () {

    /* ================= ADMIN DASHBOARD ================= */

    Route::middleware('is_admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            $totalRevenue = Order::sum('total');
            $totalOrders = Order::count();
            $totalProducts = Product::count();
            $recentTransactions = Order::latest()->take(10)->get();
            return view('auth.admin-dashboard', compact('totalRevenue', 'totalOrders', 'totalProducts', 'recentTransactions'));
        })->name('admin.dashboard');

        /* ================= CHAT ADMIN ================= */
        Route::get('/admin/chat', [ChatController::class, 'adminIndex'])->name('admin.chat');
        Route::get('/admin/chat/{userId}', [ChatController::class, 'getAdminChats'])->name('admin.chat.get');
        Route::post('/admin/chat/{userId}', [ChatController::class, 'adminSend'])->name('admin.chat.send');

        /* ================= KELOLA USER ================= */
        Route::get('/admin/kelola-user', function () {
            $totalUser = \App\Models\User::count();
            $userAktif = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'User'); })->count();
            $totalStaff = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'Admin'); })->count();
            $users = \App\Models\User::with('roles')->paginate(10);
            return view('auth.admin-kelola-user', compact('totalUser', 'userAktif', 'totalStaff', 'users'));
        })->name('admin.kelola-user');

        Route::put('/admin/user/{user}', function (\App\Models\User $user, \Illuminate\Http\Request $request) {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'role' => 'required|in:User,Admin'
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $user->roles()->sync([\App\Models\Role::where('name', $request->role)->first()->id]);

            return response()->json(['success' => true, 'message' => 'User berhasil diperbarui']);
        })->name('admin.user.update');

        Route::delete('/admin/user/{user}', function (\App\Models\User $user) {
            if (auth()->id() === $user->id) {
                return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus user sendiri'], 400);
            }

            $user->roles()->detach();
            $user->delete();

            return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
        })->name('admin.user.delete');

        /* ================= KELOLA PETUGAS ================= */
        Route::get('/admin/kelola-petugas', function () {
            $totalStaff = \App\Models\Staff::count();
            $staffAktif = \App\Models\Staff::where('status', 'Aktif')->count();
            $staffNonAktif = \App\Models\Staff::where('status', 'Non-Aktif')->count();
            $staffList = \App\Models\Staff::latest()->paginate(10);
            return view('auth.admin-kelola-petugas', compact('totalStaff', 'staffAktif', 'staffNonAktif', 'staffList'));
        })->name('admin.kelola-petugas');

        Route::put('/admin/staff/{staff}', function (\App\Models\Staff $staff, \Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:staff,email,'.$staff->id,
                'position' => 'required',
                'status' => 'required',
                'password' => 'nullable|string|min:6'
            ]);

            $oldEmail = $staff->email;
            $staff->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'position' => $validated['position'],
                'status' => $validated['status']
            ]);

            // Sync ke akun User
            $user = \App\Models\User::where('email', $oldEmail)->first();
            if ($user) {
                $userUpdate = [
                    'name' => $validated['name'],
                    'email' => $validated['email']
                ];
                
                if (!empty($validated['password'])) {
                    $userUpdate['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
                }
                
                $user->update($userUpdate);
            }

            return response()->json(['success' => true, 'message' => 'Petugas & Akun berhasil diperbarui']);
        })->name('admin.staff.update');

        Route::delete('/admin/staff/{staff}', function (\App\Models\Staff $staff) {
            $email = $staff->email;
            $staff->delete();
            
            // Hapus juga akun User-nya
            \App\Models\User::where('email', $email)->delete();
            
            return response()->json(['success' => true, 'message' => 'Petugas & Akun berhasil dihapus']);
        })->name('admin.staff.delete');

        /* ================= KELOLA PRODUK ================= */
        Route::get('/admin/kelola-produk', function () {
            $totalProduk = \App\Models\Product::count();
            $totalStok = \App\Models\Product::sum('stok');
            $produkHabis = \App\Models\Product::where('stok', '<=', 0)->count();
            $produktList = \App\Models\Product::paginate(10);
            return view('auth.admin-kelola-produk', compact('totalProduk', 'totalStok', 'produkHabis', 'produktList'));
        })->name('admin.kelola-produk');

        Route::put('/admin/product/{product}', function (\App\Models\Product $product, \Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'brand' => 'required|string',
                'kondisi' => 'required',
                'stok' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'brand' => $request->brand,
                'kondisi' => $request->kondisi,
                'stok' => $request->stok,
            ];

            if ($request->hasFile('image')) {
                // Hapus foto lama jika bukan foto default
                if ($product->image && !str_starts_with($product->image, 'images/')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);

            return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui']);
        })->name('admin.product.update');

        Route::delete('/admin/product/{product}', function (\App\Models\Product $product) {
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
        })->name('admin.product.delete');

        Route::post('/admin/product', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'brand' => 'required|string',
                'kondisi' => 'required',
                'stok' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'description' => 'nullable|string'
            ]);

            $imagePath = $request->file('image')->store('products', 'public');

            \App\Models\Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'brand' => $validated['brand'],
                'kondisi' => $validated['kondisi'],
                'stok' => $validated['stok'],
                'image' => $imagePath,
                'description' => $validated['description'] ?? ''
            ]);

            return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan']);
        })->name('admin.product.store');

        Route::post('/admin/staff', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:staff',
                'position' => 'required',
                'status' => 'required',
                'password' => 'nullable|string|min:6'
            ], [
                'email.unique' => 'Email sudah digunakan'
            ]);

            $lastStaff = \App\Models\Staff::orderBy('id', 'desc')->first();
            $nextNumber = $lastStaff ? (int)substr($lastStaff->staff_id, -3) + 1 : 1;
            $staffId = '#TFD-P' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $staff = \App\Models\Staff::create([
                'staff_id' => $staffId,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'position' => $validated['position'],
                'status' => $validated['status']
            ]);

            // Buatkan akun login untuk petugas baru
            $passwordInput = $validated['password'] ?? 'TFDpetugas2026';
            $akunBaru = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($passwordInput)
            ]);
            
            // Assign role Petugas
            $rolePetugas = \App\Models\Role::where('name', 'Petugas')->first();
            if ($rolePetugas) {
                $akunBaru->roles()->attach($rolePetugas->id);
            }

            return response()->json(['success' => true, 'message' => 'Petugas berhasil ditambahkan, password default: TFDpetugas2026']);
        })->name('admin.staff.store');

        /* ================= KELOLA TRANSAKSI ================= */
        Route::get('/admin/kelola-transaksi', function (\Illuminate\Http\Request $request) {
            $status = $request->query('status');
            $query = \App\Models\Order::with('items')->orderBy('created_at', 'desc');
            
            if ($status && $status !== 'Semua') {
                $query->where('status', $status);
            }

            $totalTransaksi = \App\Models\Order::count();
            $totalRevenue = \App\Models\Order::sum('total');
            $pendingOrders = \App\Models\Order::where('status', 'Menunggu Verifikasi')->count();
            $transaksiList = $query->paginate(10)->withQueryString();
            
            return view('auth.admin-kelola-transaksi', compact('totalTransaksi', 'totalRevenue', 'pendingOrders', 'transaksiList'));
        })->name('admin.kelola-transaksi');

        Route::put('/admin/transaksi/{order}', function (\App\Models\Order $order, \Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'status' => 'required|in:Menunggu Pembayaran,Menunggu Verifikasi,Diproses,Dikirim,Selesai,Dibatalkan'
            ]);

            // Kunci jika status sudah Selesai atau Dibatalkan
            if (in_array($order->status, ['Selesai', 'Dibatalkan'])) {
                return response()->json(['success' => false, 'message' => 'Status pesanan yang sudah Selesai atau Dibatalkan tidak dapat diubah lagi.'], 400);
            }

            // Kembalikan stok jika dibatalkan
            if ($validated['status'] === 'Dibatalkan' && $order->status !== 'Dibatalkan') {
                foreach ($order->items as $item) {
                    $product = \App\Models\Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stok', $item->quantity);
                    }
                }
            }

            $order->update($validated);
            return response()->json(['success' => true, 'message' => 'Status transaksi berhasil diperbarui']);
        })->name('admin.transaksi.update');

        /* ================= LAPORAN ================= */
        Route::get('/admin/laporan', function () {
            $totalPendapatan = \App\Models\Order::sum('total');
            $totalProdukTerjual = \App\Models\OrderItem::sum('quantity');
            $laporanPenjualan = \App\Models\OrderItem::with('order')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Get product stock data
            $produkStok = \App\Models\Product::get()->map(function($product) {
                $terjual = \App\Models\OrderItem::where('product_id', $product->id)->sum('quantity');
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stok_tersedia' => $product->stok,
                    'stok_terjual' => $terjual,
                    'status' => $product->stok >= 50 ? 'Aman' : ($product->stok >= 10 ? 'Menipis' : 'Habis')
                ];
            });
            
            // Get transaction data
            $laporanTransaksi = \App\Models\Order::orderBy('created_at', 'desc')->paginate(10);
            
            $totalStok = \App\Models\Product::sum('stok');
            $totalTransaksi = \App\Models\Order::count();
            
            return view('auth.admin-laporan', compact('totalPendapatan', 'totalProdukTerjual', 'laporanPenjualan', 'produkStok', 'laporanTransaksi', 'totalStok', 'totalTransaksi'));
        })->name('admin.laporan');
    });

    /* ================= PETUGAS DASHBOARD ================= */
    Route::middleware('is_petugas')->prefix('petugas')->group(function () {
        Route::get('/dashboard', function () {
            $totalRevenue = \App\Models\Order::sum('total');
            $totalOrders = \App\Models\Order::count();
            $totalProducts = \App\Models\Product::count();
            $recentTransactions = \App\Models\Order::latest()->take(10)->get();
            return view('auth.petugas-dashboard', compact('totalRevenue', 'totalOrders', 'totalProducts', 'recentTransactions'));
        })->name('petugas.dashboard');

        /* ================= CHAT PETUGAS ================= */
        Route::get('/chat', [ChatController::class, 'adminIndex'])->name('petugas.chat');
        Route::get('/chat/{userId}', [ChatController::class, 'getAdminChats'])->name('petugas.chat.get');
        Route::post('/chat/{userId}', [ChatController::class, 'adminSend'])->name('petugas.chat.send');

        Route::get('/kelola-produk', function () {
            $totalProduk = \App\Models\Product::count();
            $totalStok = \App\Models\Product::sum('stok');
            $produkHabis = \App\Models\Product::where('stok', '<=', 0)->count();
            $produktList = \App\Models\Product::paginate(10);
            return view('auth.petugas-kelola-produk', compact('totalProduk', 'totalStok', 'produkHabis', 'produktList'));
        })->name('petugas.kelola-produk');

        Route::post('/product', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string', 
                'price' => 'required|numeric', 
                'brand' => 'required|string',
                'kondisi' => 'required', 
                'stok' => 'required|numeric', 
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
                'description' => 'nullable|string'
            ]);

            $imagePath = $request->file('image')->store('products', 'public');
            
            \App\Models\Product::create(array_merge($validated, ['image' => $imagePath]));
            return response()->json(['success' => true, 'message' => 'Produk ditambahkan']);
        })->name('petugas.product.store');

        Route::put('/product/{product}', function (\App\Models\Product $product, \Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string', 
                'price' => 'required|numeric', 
                'brand' => 'required|string',
                'kondisi' => 'required', 
                'stok' => 'required|numeric', 
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'brand' => $request->brand,
                'kondisi' => $request->kondisi,
                'stok' => $request->stok,
            ];

            if ($request->hasFile('image')) {
                if ($product->image && !str_starts_with($product->image, 'images/')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);
            return response()->json(['success' => true, 'message' => 'Produk diperbarui']);
        })->name('petugas.product.update');

        Route::delete('/product/{product}', function (\App\Models\Product $product) {
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Produk dihapus']);
        })->name('petugas.product.delete');

        Route::get('/kelola-transaksi', function (\Illuminate\Http\Request $request) {
            $status = $request->query('status');
            $query = \App\Models\Order::with('items')->orderBy('created_at', 'desc');
            
            if ($status && $status !== 'Semua') {
                $query->where('status', $status);
            }

            $totalTransaksi = \App\Models\Order::count();
            $totalRevenue = \App\Models\Order::sum('total');
            $transaksiList = $query->paginate(10)->withQueryString();
            return view('auth.petugas-kelola-transaksi', compact('totalTransaksi', 'totalRevenue', 'transaksiList'));
        })->name('petugas.kelola-transaksi');

        Route::put('/transaksi/{order}', function (\App\Models\Order $order, \Illuminate\Http\Request $request) {
            $validated = $request->validate(['status' => 'required|in:Menunggu Verifikasi,Diproses,Selesai,Dibatalkan']);
            $order->update($validated);
            return response()->json(['success' => true, 'message' => 'Status transaksi diperbarui']);
        })->name('petugas.transaksi.update');

        Route::get('/laporan', function () {
            $totalPendapatan = \App\Models\Order::sum('total');
            $totalProdukTerjual = \App\Models\OrderItem::sum('quantity');
            $laporanPenjualan = \App\Models\OrderItem::with('order')->orderBy('created_at', 'desc')->paginate(10);
            $produkStok = \App\Models\Product::get()->map(function($product) {
                return [
                    'id' => $product->id, 'name' => $product->name, 'stok_tersedia' => $product->stok,
                    'stok_terjual' => \App\Models\OrderItem::where('product_id', $product->id)->sum('quantity'), 
                    'status' => $product->stok >= 50 ? 'Aman' : ($product->stok >= 10 ? 'Menipis' : 'Habis')
                ];
            });
            $laporanTransaksi = \App\Models\Order::orderBy('created_at', 'desc')->paginate(10);
            $totalStok = \App\Models\Product::sum('stok');
            $totalTransaksi = \App\Models\Order::count();
            return view('auth.petugas-laporan', compact('totalPendapatan', 'totalProdukTerjual', 'laporanPenjualan', 'produkStok', 'laporanTransaksi', 'totalStok', 'totalTransaksi'));
        })->name('petugas.laporan');
    });


    /* ================= TAMBAH KERANJANG ================= */

    Route::post('/keranjang/tambah/{product}', function (Request $request, Product $product) {

        $request->validate(['size' => 'required']);

        $cart = session()->get('cart', []);

        $key = $product->id . '_' . $request->size;

        if (isset($cart[$key])) {
            $cart[$key]['qty']++;
        } else {
            $cart[$key] = [
                "name"  => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "size"  => $request->size,
                "qty"   => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('keranjang')->with('success', 'Produk ditambahkan!');
    })->name('keranjang.tambah');


    /* ================= KERANJANG ================= */

    Route::get('/keranjang', function () {
        return view('auth.keranjang');
    })->name('keranjang');


    /* ================= HAPUS ================= */

    Route::delete('/keranjang/hapus/{key}', function ($key) {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) unset($cart[$key]);

        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus!');
    })->name('keranjang.hapus');

    Route::post('/keranjang/update/{key}', function ($key, Request $request) {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$key])) {
            if ($request->action === 'plus') {
                $cart[$key]['qty']++;
            } elseif ($request->action === 'minus' && $cart[$key]['qty'] > 1) {
                $cart[$key]['qty']--;
            }
            session()->put('cart', $cart);
        }
        return back();
    })->name('keranjang.update');


    /* ================= CHECKOUT ================= */

    Route::get('/checkout', function () {
        // Ambil alamat dari pesanan terakhir user untuk auto-fill
        $lastOrder = Order::where('user_id', Auth::id())->latest()->first();
        return view('auth.checkout', compact('lastOrder'));
    })->name('checkout');


    /* ================= PROSES CHECKOUT ================= */

    Route::post('/checkout/proses', function (Request $request) {

    $request->validate([
        'nama' => 'required',
        'hp' => 'required',
        'alamat' => 'required',
        'metode' => 'required',
        'kurir' => 'required'
    ]);

    $cart = session('cart', []);
    if (!$cart) return back();

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    $ongkir = 0;
    $kurir = $request->kurir;
    if ($kurir === 'GoSend SameDay - Rp 25.000') $ongkir = 25000;
    elseif ($kurir === 'JNE Reguler - Rp 15.000') $ongkir = 15000;
    elseif ($kurir === 'J&T Express - Rp 15.000') $ongkir = 15000;
    elseif ($kurir === 'SiCepat REG - Rp 12.000') $ongkir = 12000;

    $order = Order::create([
        'user_id' => Auth::id(),
        'nama' => $request->nama,
        'hp' => $request->hp,
        'alamat' => $request->alamat,
        'kurir' => $kurir,
        'ongkir' => $ongkir,
        'metode' => $request->metode,
        'total' => $total + $ongkir,
        'status' => $request->metode === 'COD' ? 'Menunggu Verifikasi' : 'Menunggu Pembayaran'
    ]);

    foreach ($cart as $key => $item) {
        $parts = explode('_', $key);
        $productId = $parts[0];
        $size = $item['size'] ?? '-';

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $productId,
            'product_name' => $item['name'] . ' (Size: ' . $size . ')',
            'quantity' => $item['qty'],
            'price' => $item['price'],
            'subtotal' => $item['price'] * $item['qty']
        ]);

        $product = \App\Models\Product::find($productId);
        if ($product) {
            $product->stok -= $item['qty'];
            $product->save();
        }
    }

    session()->forget('cart');

    return redirect()->route('checkout.sukses')->with('order_id', $order->id);

})->name('checkout.proses');
    /* ================= SUKSES ================= */

    Route::get('/checkout-sukses', function () {
    return view('auth.sukses');
})->name('checkout.sukses');


    /* ================= PESANAN SAYA ================= */

    Route::get('/pesanan-saya', function () {
        $orders = \App\Models\Order::with('items')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('auth.pesanan-saya', compact('orders'));
    })->name('pesanan-saya');

    Route::post('/pesanan/upload-bukti/{order}', function (\App\Models\Order $order, \Illuminate\Http\Request $request) {
        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($order->bukti_pembayaran) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($order->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')->store('payments', 'public');
        $order->update([
            'bukti_pembayaran' => $path,
            'status' => 'Menunggu Verifikasi'
        ]);

        return response()->json(['success' => true, 'message' => 'Bukti pembayaran berhasil diunggah']);
    })->name('user.upload-bukti');

    Route::post('/pesanan/terima/{order}', function (\App\Models\Order $order) {
        if ($order->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        if ($order->status !== 'Dikirim') {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak dalam status pengiriman.'], 400);
        }
        $order->update(['status' => 'Selesai']);
        return response()->json(['success' => true, 'message' => 'Gugugaga! Pesanan berhasil dikonfirmasi diterima. Terima kasih!']);
    })->name('user.pesanan.terima');

    Route::post('/pesanan/review/{item}', function (\App\Models\OrderItem $item, \Illuminate\Http\Request $request) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ]);

        if ($item->order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($item->order->status !== 'Selesai') {
            return response()->json(['success' => false, 'message' => 'Ulasan hanya dapat diberikan untuk pesanan yang sudah Selesai.'], 400);
        }

        $item->update([
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return response()->json(['success' => true, 'message' => 'Terima kasih atas ulasan eksklusif Anda!']);
    })->name('user.pesanan.review');

    Route::post('/pesanan/batalkan/{order}', function (\App\Models\Order $order) {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Batasan: Hanya Menunggu Pembayaran, ATAU Menunggu Verifikasi KHUSUS untuk COD
        $isAllowCancel = ($order->status === 'Menunggu Pembayaran') || ($order->status === 'Menunggu Verifikasi' && $order->metode === 'COD');

        if (!$isAllowCancel) {
            return response()->json(['success' => false, 'message' => 'Hanya pesanan yang belum dibayar atau COD yang belum diverifikasi yang bisa dibatalkan secara mandiri.'], 400);
        }

        // Kembalikan stok saat pembatalan mandiri
        foreach ($order->items as $item) {
            $product = \App\Models\Product::find($item->product_id);
            if ($product) {
                $product->increment('stok', $item->quantity);
            }
        }

        $order->update(['status' => 'Dibatalkan']);
        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan.']);
    })->name('user.pesanan.batalkan');

    /* ================= CHAT PELANGGAN ================= */
    Route::get('/chat/messages', [ChatController::class, 'getUserChats'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'userSend'])->name('chat.send');

    /* ================= PROFIL ================= */
    Route::get('/profil', function () {
        return view('auth.profil');
    })->name('profil');

    Route::put('/profil', function (Request $request) {
        // Gunakan fresh instance dari database agar data (seperti avatar) tidak hilang
        $user = \App\Models\User::find(Auth::id());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:5120',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Simpan path avatar lama sebelum diganti
            $oldAvatar = $user->avatar;

            // Simpan file baru
            $path = $request->file('avatar')->store('avatars', 'public');
            
            if ($path) {
                $user->avatar = $path;
                
                // Hapus avatar lama dari storage disk JIKA sudah berhasil ganti dan BUKAN avatar bawaan (seeder)
                if ($oldAvatar && !str_starts_with($oldAvatar, 'images/')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldAvatar);
                }
            }
        }
        
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        
        // Simpan perubahan ke database
        $user->save();
        
        \Illuminate\Support\Facades\Log::info('User profile updated', ['user_id' => $user->id, 'has_avatar' => $request->hasFile('avatar')]);

        // Refresh Auth user agar perubahan langsung terlihat di session/singleton
        Auth::setUser($user);

        return back()->with('success', 'Gugugaga! Foto & Data Profil TFD Berhasil Disimpan.');
    })->name('profil.update');



    /* ================= WISHLIST ================= */
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    /* ================= LOGOUT ================= */
        
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('katalog');
    })->name('logout');

});