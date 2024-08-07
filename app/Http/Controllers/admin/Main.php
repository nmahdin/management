<?php

namespace App\Http\Controllers\admin;

use App\helper\Cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;


class Main extends Controller
{
    public function index()
    {
        dd(Cart::get(2));
        return view('admin.dashboards.main');
    }

    public function add_to_cart(Product $product)
    {
        if (! Cart::has($product)) {
            Cart::put(
                [
                    'price' => $product->total_price,
                ],
                $product,
            );
        } else {
            if (Cart::count($product) < $product->inventory) {
                Cart::update($product , 1);
            }
        }

        return redirect(route('cart.list'));

//        return 'OK!';

        return $product;
    }

    public function cart_list()
    {
        $n = Cart::all()->count();
        return view('admin.cart.list' , ['n' => $n]);
    }

    public function cart_delete($id): \Illuminate\Http\RedirectResponse
    {
        $name = Cart::get($id)['Product']->name;
        Cart::delete($id);
        return back()->with('deleted' , $name);
    }
}
