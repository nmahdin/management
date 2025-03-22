<?php

namespace App\Http\Controllers\dashboard;

use App\helper\Cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!Cart::has($product)) {
            Cart::put(
                [
                    'price' => $product->total_price,
                ],
                $product,
            );
        } else {
            if (Cart::count($product) < $product->inventory) {
                Cart::update($product, 1);
            }
        }

        return redirect(route('cart.list'));

//        return 'OK!';

        return $product;
    }

    public function cart_list()
    {
        $n = Cart::all()->count();
        return view('dashboard.cart.list', ['n' => $n]);
    }

    public function cart_delete($id): \Illuminate\Http\RedirectResponse
    {
        $name = Cart::get($id)['Product']->name;
        Cart::delete($id);
        return back()->with('deleted', $name);
    }

    public function enter_order(Request $request)
    {
//        dd($request->all());
        if ($request->customer_id != 0) {
            $customer = Customer::findOrFail($request->customer_id);
        } else {
            $data = $request->validate([
                'name' => ['required', 'max:250'],
                'number' => ['min:8', 'max:12', Rule::unique('customers')],
                'city' => ['required', 'min:1', 'max:255'],
                'address' => ['max:250'],
                'com_ways' => ['required', 'array'],
                'birthday' => ['nullable'],
                'gender' => ['required', 'in:female,male'],
                'category_id' => ['nullable'],
//            'attachment' => ['nullable'],
            ]);

            $customer = Customer::create([
                'name' => $data['name'],
                'number' => $data['number'],
                'city' => $data['city'],
                'address' => $data['address'],
                'com_ways' => json_encode($data['com_ways']),
                'birthday' => $data['birthday'],
                'gender' => $data['gender'],
                'category_id' => $data['category_id'],
//            'attachment' => $data['attachment'],
            ]);
        }

        $cart = Cart::all();

        $totalAmount = 0;
        foreach ($request->all() as $key => $value) {
            // بررسی اینکه آیا کلید، مربوط به آیتم‌ها است (در این مثال ID محصولات)
            if (is_numeric($key)) {
                $totalAmount += $value; // جمع کردن قیمت آیتم‌ها
            }
        }


        $cartItems = $cart;
        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart['Product']->total_price * $cart['qnty'];
            });

            $profit = $cartItems->sum(function ($cart) {
                return $cart['Product']->profit * $cart['qnty'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [ $cart['Product']->id => ['quantity' => $cart['qnty'] , 'total_price' => null , 'unit_price' => $cart['Product']->total_price] ];
            });



            $orderItems = collect($orderItems);

            $orderItems = $orderItems->map(function ($item, $key) use ($request) {
                if ($request->has($key)) {
                    $item['total_price'] = $request->input($key); // مقدار جدید
                }
                return $item;
            });

// بررسی خروجی
//            dd($orderItems);


            $discount = $totalAmount - $price;


            $payments = Accounts::findOrFail($request->payments);
            $order = Customer::findOrFail($customer->id)->orders()->create([
                'price' => $totalAmount,
                'profit' => $profit, // سود
                'date' => date('Y-m-d'),
                'discount' => $discount,
                'type_id' => $request->type_id,
                'user_id' => Auth::user()->id,
                'account_id' => $request->payments,
                'status' => 'unpaid',
                'payments' => $payments->payment_label,
            ]);
            $payments->update([
                'inputs' => $payments->inputs + $totalAmount,
                'count' => $payments->count + 1,
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
        return view('dashboard.users.all', ['users' => $users, 'n' => $n]);
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
