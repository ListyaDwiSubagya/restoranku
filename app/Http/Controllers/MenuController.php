<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function index(Request $request) {
        $tableNumber = $request->query('meja');
        if ($tableNumber) {
            Session::put('tableNumber', $tableNumber);
        }

        $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        $cart = Session::get('cart');
        return view('customer.cart', compact('cart'));
    }

    public function addToCart(Request $request) 
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        // SALAH: if ($menu) { return error... }
        // BENAR: if (!$menu) { return error... }
        
        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ]);
        }

        $cart = Session::get('cart', []); // Default empty array

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += 1;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image' => $menu->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Menu added to cart',
            'cart' => $cart,
            'cart_count' => count($cart) // Optional: jumlah item unik
        ]);
    }

}
