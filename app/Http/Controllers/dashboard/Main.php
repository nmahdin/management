<?php

namespace App\Http\Controllers\dashboard;

use App\helper\Cart\Cart;
use App\helper\services\Custom;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Order;
use App\Models\PartnerTransaction;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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

        $date = Custom::changDate($request->date);

        $cartItems = $cart;
        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart['Product']->total_price * $cart['qnty'];
            });

            $profit = $cartItems->sum(function ($cart) {
                return $cart['Product']->profit * $cart['qnty'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [$cart['Product']->id => ['quantity' => $cart['qnty'], 'total_price' => null, 'unit_price' => $cart['Product']->total_price]];
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


            $order = Customer::findOrFail($customer->id)->orders()->create([
                'amount' => $totalAmount,
                'profit' => $profit, // سود
                'date' => $date,
                'discount' => $discount,
                'type_id' => $request->type_id,
                'user_id' => Auth::user()->id,
                'status' => 'unpaid',
            ]);


            $order->products()->attach($orderItems);

            foreach ($orderItems as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $product->inventory -= $item['quantity'];
                    $product->save();

                    // ثبت بدهی به شریک بابت این محصول
                    Settlement::create([
                        'partner_id'  => $product->partner_id,
                        'order_id'    => $order->id,
                        'amount'      => $this->calculatePartnerDebt($product, $item['quantity']),
                        'type'        => 'debt',
                        'description' => 'بدهی بابت سفارش #' . $order->id . ' و محصول ' . $product->name,
                        'user_id'     => \Illuminate\Support\Facades\Auth::id(),
                    ]);
                }
            }


            Cart::clear();

            if ($request->input('action') === 'pay') {
                return redirect(route('payments.create', ['order_id' => $order->id, 'amount' => $order->amount]))->with('success', '.سفارش با موفقیت ثبت شد');
            } elseif ($request->input('action') === 'no_pay') {
                return redirect(route('cart.list'))->with('success', '.سفارش با موفقیت ثبت شد');
            }
        }

        return back();
    }

    private function calculatePartnerDebt($product, $quantity)
    {
        // فرض: مجموع هزینه مواد اولیه + سود مواد اولیه + دستمزد + سود (یا هر فیلدی که مدنظر داری)
        $debtPerItem = ($product->price_materials ?? 0)
            + ($product->materials_profit ?? 0)
            + ($product->salary ?? 0)
            + ($product->profit ?? 0);

        return $debtPerItem * $quantity;
    }

    // start payments
    public function payments_list()
    {
        $payments = Accounts::all();
        $n = Accounts::count();
        return view('dashboard.payments.list', ['payments' => $payments, 'n' => $n]);
    }

    public function payments_create(Request $request)
    {
        $accounts = Accounts::all();
        if ($request->has('order_id')) {
            $order = Order::findOrFail($request->order_id);
            if ($request->has('amount')) {
                $amount = $request->amount;
                return view('dashboard.payments.create', compact('order', 'amount', 'accounts'));
            }

            return view('dashboard.payments.create', compact('order', 'accounts'));
        } else {
            $orders = Order::all();
            if ($request->has('amount')) {
                $amount = $request->amount;
                return view('dashboard.payments.create', compact('orders', 'amount', 'accounts'));
            }
            return view('dashboard.payments.create', compact('orders', 'accounts'));
        }
    }

    public function payments_store(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'max:255'],
            'status' => ['required', 'in:paid,unpaid'],
            'label_id' => ['required', 'exists:transactions_labels,id'],
            'account_payment_way' => ['required'],
            'tracking_number' => ['nullable', 'max:255'],
            'note' => ['nullable'],
        ]);

        // اطلاعات حساب و روش پرداخت را از رشته جدا کنید
        [$accountId, $paymentWay] = explode('_', $data['account_payment_way']);

        if (!Accounts::find($accountId)) {
            return back()->withErrors(['account_payment_way' => 'حساب انتخاب شده معتبر نیست.']);
        }

        if (!Order::find($data['order_id'])) {
            return back()->withErrors(['order_id' => 'سفارش انتخاب شده معتبر نیست.']);
        }


        $data['date'] = Custom::changDate($request->date);
        $data['customer_id'] = Order::findOrFail($request->order_id)->customer_id;

        $account = Accounts::find($accountId);
        $account->update([
            'inputs' => $account->inputs = +$data['amount'],
            'count' => $account->count = +1,
        ]);

        Transaction::create([
            'name' => 'پرداخت مبلغ سفارش',
            'type' => 'input',
            'date' => $data['date'],
            'amount' => $data['amount'],
            'user_id' => Auth::user()->id,
            'tracking_number' => $data['tracking_number'],
            'payer_type' => \App\Models\Customer::class,
            'payer_id' => $data['customer_id'],
            'account_id' => $accountId,
            'payment_way' => $paymentWay,
            'label_id' => $data['label_id'],
            'category' => 'orders',
            'status' => $data['status'],
            'source_type' => 'orders',
            'source_id' => $data['order_id'],
            'notes' => $data['note'],
        ]);


        $order = Order::find($data['order_id']);

        $sumTransactions = $order->transactions()->where('status', 'paid')->sum('amount');
        if ($order->amount <= $sumTransactions) {
            Order::find($data['order_id'])
                ->update([
                    'status' => 'paid',
                ]);
        } else {
            Order::find($data['order_id'])
                ->update([
                    'status' => 'unpaid',
                ]);
        }


        return redirect(route('orders.detail', $data['order_id']))->with('success', 'پرداخت با موفقیت ثبت شد');
    }

    public function payments_paid($id)
    {
        $trasaction = Transaction::findOrFail($id);
        $trasaction->update([
            'status' => 'paid',
        ]);

        $price = number_format($trasaction->amount, 0, '') . ' ' . 'تومان';

        if ($trasaction->where('source_type', 'orders')) {
            if ($order = Order::find($trasaction->source_id)) {
                $sumTransactions = $order->transactions()->where('status', 'paid')->sum('amount');
                if ($order->amount <= $sumTransactions) {
                    Order::find($trasaction->source_id)
                        ->update([
                            'status' => 'paid',
                        ]);
                } else {
                    Order::find($trasaction->source_id)
                        ->update([
                            'status' => 'unpaid',
                        ]);
                }

            }

        }
        return back()->with('success', "تراکنش مربوطه به عنوان پرداخت شده علامت گذاری شد. مبلغ: $price");
    }

    public function payments_delete($id)
    {
        $trasaction = Transaction::find($id);
        $trasaction->delete();
        if ($trasaction->where('source_type', 'orders')) {
            if ($order = Order::find($trasaction->source_id)) {
                $sumTransactions = $order->transactions()->sum('amount');
                if ($order->amount > $sumTransactions) {
                    Order::find($trasaction->source_id)
                        ->update([
                            'status' => 'unpaid',
                        ]);
                }

            }

        }

        $massage = 'تراکنش مروبطه با موفقیت حذف شد.';
        return back()->with('warning', $massage);
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
