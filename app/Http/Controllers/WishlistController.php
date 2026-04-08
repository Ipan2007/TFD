<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan daftar wishlist pengguna.
     */
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistedProducts;
        return view('auth.wishlist', compact('wishlistItems'));
    }

    /**
     * Menambah atau menghapus produk dari wishlist (toggle).
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();
        
        // Cek apakah sudah ada di wishlist
        if ($user->wishlistedProducts()->where('product_id', $product->id)->exists()) {
            $user->wishlistedProducts()->detach($product->id);
            $status = 'removed';
            $message = 'Produk berhasil dihapus dari daftar keinginan.';
        } else {
            $user->wishlistedProducts()->attach($product->id);
            $status = 'added';
            $message = 'Produk berhasil ditambahkan ke daftar keinginan.';
        }

        return back()->with('success', $message)->with('wishlist_status', $status);
    }
}
