<?php

namespace App\Http\Controllers\dashboard;

use App\helper\Cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class Main extends Controller
{
    public function index()
    {
        dd(Cart::get(2));
        return view('dashboard.dashboards.main');
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
        return view('dashboard.cart.list' , ['n' => $n]);
    }

    public function cart_delete($id): \Illuminate\Http\RedirectResponse
    {
        $name = Cart::get($id)['Product']->name;
        Cart::delete($id);
        return back()->with('deleted' , $name);
    }

    public function enter_order(Request  $request)
    {
//        dd($request->all());
        if ($request->customer_id) {
            $customer = Customer::findOrFail($request->customer_id);
        } else {
            $data = $request->validate([
                'name' => ['required', 'max:250'],
                'number' => ['min:8', 'max:12', Rule::unique('customers')],
            ]);

            $customer = Customer::create([
                'name' => $data['name'],
                'number' => $data['number'],
            ]);
        }

        $cart = Cart::all();
        $cartItems = $cart;
        if($cartItems->count()) {
            $price = $cartItems->sum(function($cart) {
                return $cart['Product']->total_price * $cart['qnty'];
            });

            $profit = $cartItems->sum(function($cart) {
                return $cart['Product']->profit * $cart['qnty'];
            });

            $orderItems = $cartItems->mapWithKeys(function($cart) {
                return [$cart['Product']->id => [ 'quantity' => $cart['qnty']] ];
            });
            $discount = $price - $request->price;

            $order = Customer::findOrFail($customer->id)->orders()->create([
                'price' => $request->price,
                'profit' => $profit, // سود
                'date' => date('Y-m-d'),
                'discount' => $discount,
                'type_id' => $request->type_id,

                'account_id' => '34',
                'status_id' => '34',
                'payments' => $request->payments,


//            $table->string('payments'); // روش پرداخت
//            $table->unsignedBigInteger('account_id'); // حساب مقصد
//            $table->unsignedBigInteger('status_id');

            ]);

            $order->products()->attach($orderItems);

            return 'ok';
        }

        return back();
    }

    // start users
    public function users_all()
    {
        $users = User::all();
        $n = User::count();
        return view('dashboard.management.users.all', ['users' => $users, 'n' => $n]);
    }

    public function users_permissions()
    {
        $permissions = Permission::all();
        $n = Permission::count();
        return view('dashboard.management.users.show-permissions', ['permissions' => $permissions, 'n' => $n]);
    }

    public function users_roles()
    {
        $roles = Group::all();
        $n = Group::count();
        return view('dashboard.management.users.show-roles', ['roles' => $roles, 'n' => $n]);
    }

    public function users_roles_creat()
    {
        return view('dashboard.management.users.creat-role');
    }

    public function users_roles_creat_post(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:' . permission::class],
            'label' => ['required', 'max:255'],
            'permissions' => ['required', 'array'],
        ]);
        $role = Group::create([
            'name' => $data['name'],
            'label' => $data['label'],
            'note' => $request->note,
        ]);
        $role->permissions()->sync($data['permissions']);
        return redirect(route('users.roles'));
    }
    // end users

}
